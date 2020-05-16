// export {};
declare let toastr: any;
declare let Date: any;
declare let Handlebars: any;
declare let FullCalendar: any;
declare let blockArea: any;
declare let base_url: any;
declare let $: any;
declare let swal: any;
declare let window: any;
declare let moment: any;
declare let google: any;
declare let timbthumbImage : any;
declare let DTAdditionalParameterHandler : any;
declare let MarkerClusterer : any;
class PointsLocationHandler
{
    private _mapContent : string;
    private _map : any;
    private _currentMarkers : any;
    private _bounds : any;
    private _markerCluster : any;
    private _projectId : number;
    
    constructor(private divContent: string, private projectId: number)
    {
        moment.locale('es');
        this._mapContent = divContent;
        this._currentMarkers = [];
        this._bounds = new google.maps.LatLngBounds();
        this._markerCluster = new MarkerClusterer(this._map, this._currentMarkers,
                    {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
        this._projectId = projectId;
    }

    public startPaginationJs(additionalParameter?)
    {
        let _this = this;

        $('#pagination-content').pagination({
            dataSource: base_url + 'panel/AjaxBuildingPoint/paginationJs',
            locator: 'resultArray',
            totalNumberLocator: function(response) {
                // you can return totalNumber by analyzing response content
                let text = "Se encontraron "+response.recordsFiltered+" puntos";
                if(response.recordsFiltered == 1)
                    text = "Se encontro 1 punto";
                else if(response.recordsFiltered == 0)
                    text = "No se encontraron puntos";
                $("#total-projects-found").text(text);
                return response.recordsFiltered;
            },
            pageSize: 20,
            ajax: {
                type: 'POST',
                data:{number:(Math.floor(Math.random() * (1000 - 100)) + 100)},
                beforeSend: function(jqXHR) {
                    blockArea($("#"+_this._mapContent));
                    this.data += '&' + $.param({
                                                    // additionalParameters: additionalParameter.getList(),
													projectId:_this.projectId,
                                                    textToSearch: $("#text-to-search").val()
                                                });
                    return true;
                }
            },
            callback: function(data, pagination) {
                // template method of yourself
                $.each(_this._currentMarkers, function(index, marker){
                    marker.setMap(null);
                });
                _this._bounds = new google.maps.LatLngBounds();
                _this._currentMarkers = [];
                // _this._markerCluster.clearMarkers();
                let marker : any = {};
                $.each(data, function(index, point){
                        let loc = new google.maps.LatLng(parseFloat(point.latitude_bpo.replace(/(\d)(?=(\d\d\d)+(?!\d))/, "$1.")), parseFloat(point.longitude_bpo.replace(/(\d)(?=(\d\d\d)+(?!\d))/, "$1.")));
                        _this._bounds.extend(loc);
                        marker = _this.addMarker(point);
                        _this._currentMarkers.push(marker);
                    
                });
                // _this._markerCluster.setMap(_this._map);
                // _this._markerCluster.addMarkers(_this._currentMarkers);
                
                if(data.length == 1) 
                {
                    let coordinate = data[0];
                    _this._map.setZoom(15);
                    _this._map.panTo(marker.getPosition());
                }
                else
                {
                    _this._map.fitBounds(_this._bounds);
                    _this._map.panToBounds(_this._bounds);    
                }

                $("#"+_this._mapContent).unblock();
            }
        });
    }

    public startMap()
    {
        this._map = new google.maps.Map(document.getElementById(this._mapContent), {
          	center: {lat: -17.784146, lng: -63.181738},
          	zoom: 12,
			mapTypeId: 'satellite'
        });
    }

    public addMarker(point)
    {
        let _this : PointsLocationHandler = this;
        let latitude = parseFloat(point.latitude_bpo.replace(/(\d)(?=(\d\d\d)+(?!\d))/, "$1."));
        let longitude = parseFloat(point.longitude_bpo.replace(/(\d)(?=(\d\d\d)+(?!\d))/, "$1."));
        let position = {lat: latitude, lng: longitude};
        let markerImage = timbthumbImage(base_url+'assets/images/flaticon/electric-pole-2.png', 30);
        let marker = new google.maps.Marker({
            position: position,
            map: _this._map,
            // animation: google.maps.Animation.DROP,
            icon: markerImage
          });

        let htmlSource = $("#point-location-info-window").html();
        let template = Handlebars.compile(htmlSource);
        let html = template({point:point});

        let infoWindow = new google.maps.InfoWindow({
            content: html
        });
        
        marker.addListener('click', function() {
            infoWindow.open(_this._map, marker);
        });
        return marker;
    }

    private _delay(callback, ms) 
    {
        let timer = 0;
        return function() 
        {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
              callback.apply(context, args);
            }, ms || 0);
        };
    }

    public loadEventHandlers()
    {
        let _this    = this;

        $(document).on("click","#search-text-on-map", function(){
            if($('#pagination-content').length > 0)
                $('#pagination-content').pagination('go', 1);
        });

        $('#text-to-search').keyup(this._delay(function (e) {
            if($('#pagination-content').length > 0)
                $('#pagination-content').pagination('go', 1);
        }, 2000));
    }
}
