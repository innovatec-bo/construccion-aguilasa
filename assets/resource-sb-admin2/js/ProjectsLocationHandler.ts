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
class ProjectsLocationHandler
{
    private _mapContent : string;
    private _map : any;
    private _currentMarkers : any;
    private _bounds : any;
    
    constructor(private divContent: string)
    {
        moment.locale('es');
        this._mapContent = divContent;
        this._currentMarkers = [];
        this._bounds = new google.maps.LatLngBounds();
    }

    public startPaginationJs(additionalParameter)
    {
        let _this = this;

        $('#pagination-content').pagination({
            dataSource: base_url + 'panel/AjaxProject/paginationJs',
            locator: 'resultArray',
            totalNumberLocator: function(response) {
                // you can return totalNumber by analyzing response content
                let text = "Se encontraron "+response.recordsFiltered+" proyectos";
                if(response.recordsFiltered == 1)
                    text = "Se encontro 1 proyecto";
                else if(response.recordsFiltered == 0)
                    text = "No se encontraron proyectos";
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
                                                    additionalParameters: additionalParameter.getList(),
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
                let marker = {};
                $.each(data, function(index, project){
                        let loc = new google.maps.LatLng(parseFloat(project.latitude_pro), parseFloat(project.longitude_pro));
                        _this._bounds.extend(loc);
                        marker = _this.addMarker(project);
                        _this._currentMarkers.push(marker);
                    
                });
                
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
                let markerCluster = new MarkerClusterer(_this._map, _this._currentMarkers,
                {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
                $("#"+_this._mapContent).unblock();
            }
        });
    }

    public startMap()
    {
        this._map = new google.maps.Map(document.getElementById(this._mapContent), {
          center: {lat: -17.784146, lng: -63.181738},
          zoom: 12
        });
    }

    public addMarker(project)
    {
        let _this : ProjectsLocationHandler = this;
        let latitude = parseFloat(project.latitude_pro);
        let longitude = parseFloat(project.longitude_pro);
        let position = {lat: latitude, lng: longitude};
        let markerImage = timbthumbImage(base_url+'assets/images/google-maps-marker.png', 35);
        let marker = new google.maps.Marker({
            position: position,
            map: _this._map,
            animation: google.maps.Animation.DROP,
            icon: markerImage
          });

        let htmlSource = $("#location-info-window").html();
        let template = Handlebars.compile(htmlSource);
        let html = template({project:project});

        let infoWindow = new google.maps.InfoWindow({
            // content: '<a target="_blank" href="https://wa.me/?text=https://www.google.com/maps/search/?q='+latitude+','+longitude+'">Enviar por Whatsapp</a>'
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