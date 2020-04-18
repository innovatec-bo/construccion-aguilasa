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

    public startPaginationJs()
    {
        let _this = this;

        let additionalParameter = new DTAdditionalParameterHandler("#extra-request-data","#project-index");
        additionalParameter.addParameterObject('status','text');
        additionalParameter.addParameterObject('work-area','select');
        additionalParameter.addParameterObject('fiscal-responsible-id','select');
        additionalParameter.addParameterObject('builder-responsible-id','select');
        additionalParameter.addParameterObject('manpower-uploaded','select');
        additionalParameter.setButtonFilter('#send-filters');
        additionalParameter.setButtonRest('#remove-additional-parameters');
        additionalParameter.loadEventHandlers();

        $('#pagination-content').pagination({
            dataSource: base_url + 'panel/AjaxProject/paginationJs',
            locator: 'resultArray',
            totalNumberLocator: function(response) {
                // you can return totalNumber by analyzing response content
                return response.recordsTotal;
            },
            pageSize: 20,
            ajax: {
                type: 'POST',
                data:{additionalParameters:additionalParameter.getList()},
                beforeSend: function() {
                    blockArea($("#"+_this._mapContent));
                }
            },
            callback: function(data, pagination) {
                // template method of yourself
                $.each(_this._currentMarkers, function(index, marker){
                    marker.setMap(null);
                });
                _this._bounds = new google.maps.LatLngBounds();
                _this._currentMarkers = [];
                $.each(data, function(index, project){
                        let loc = new google.maps.LatLng(parseFloat(project.latitude_pro), parseFloat(project.longitude_pro));
                        _this._bounds.extend(loc);
                        let marker = _this.addMarker(project);
                        _this._currentMarkers.push(marker);
                    
                });
                _this._map.fitBounds(_this._bounds);
                _this._map.panToBounds(_this._bounds);
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

    public loadEventHandlers()
    {
        let _this    = this;
    }
}