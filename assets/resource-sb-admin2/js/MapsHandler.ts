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

class MapsHandler
{
    private _mapContent : string;
    private _map : any;
    private _uniqueMarker : any;
    private _uniqueInfoWindow : any;
    
    constructor(private divContent: string)
    {
        moment.locale('es');
        this._mapContent = divContent;
        this._uniqueMarker = null;
        this._uniqueInfoWindow = null;
    }

    public startMap()
    {
        this._map = new google.maps.Map(document.getElementById(this._mapContent), {
          center: {lat: -17.784146, lng: -63.181738},
          zoom: 12
        });
    }

    public addUniqueMarker(latitude, longitude, centerMarker = false)
    {
        let _this : MapsHandler = this;
        let position = {lat: latitude, lng: longitude};
        let markerImage = timbthumbImage(base_url+'assets/images/google-maps-marker.png',35);
        this._uniqueMarker = new google.maps.Marker({
            position: position,
            map: _this._map,
            animation: google.maps.Animation.DROP,
            icon: markerImage,
            draggable:true
          });
        if(this._uniqueInfoWindow === null)
        {
            this._uniqueInfoWindow = new google.maps.InfoWindow({
                content: '<a target="_blank" href="https://wa.me/?text=https://www.google.com/maps/search/?q='+latitude+','+longitude+'">Enviar por Whatsapp</a>'
            });    
        }
        else
        {
            _this._updateUniqueInfoWindow(latitude, longitude);
        }
        
        this._uniqueMarker.addListener('click', function() {
            _this._uniqueInfoWindow.open(_this._map, _this._uniqueMarker);
        });

        this._uniqueMarker.addListener('dragend', function(e){
            _this._updateFormInput(e.latLng.lat(), e.latLng.lng());
            _this._updateUniqueInfoWindow(e.latLng.lat(), e.latLng.lng());
        });
        
        
        if(centerMarker)
        {
            _this._map.setZoom(15);
            _this._map.panTo(position);
            // _this._map.setCenter(position);
        }
    }

    private _updateUniqueInfoWindow(latitude, longitude)
    {
        this._uniqueInfoWindow.setContent('<a target="_blank" href="https://wa.me/?text=https://www.google.com/maps/search/?q='+latitude+','+longitude+'">Enviar por Whatsapp</a>');
    }

    private _updateFormInput(latitude, longitude)
    {
        $("input[name=latitude]").val(latitude);
        $("input[name=longitude]").val(longitude);
    }

    public loadEventHandlers()
    {
        let _this    = this;
        this._map.addListener('click', function(e) {
            let position = {lat: e.latLng.lat(), lng: e.latLng.lng()};
            if(_this._uniqueMarker === null)
            {
                _this.addUniqueMarker(e.latLng.lat(), e.latLng.lng(), true);
            }
            else
            {
                _this._uniqueMarker.setPosition(position);
                _this._map.setZoom(15);
                _this._map.panTo(_this._uniqueMarker.getPosition());
                _this._updateUniqueInfoWindow(e.latLng.lat(), e.latLng.lng());
            }
            _this._updateFormInput(e.latLng.lat(), e.latLng.lng());
        });
        
        $(document).on('click','.search-coordinate-button',function(e){
            e.preventDefault();
            let latitude = parseFloat($("input[name=latitude]").val());
            let longitude = parseFloat($("input[name=longitude]").val());
            if(_this._uniqueMarker === null)
            {
                _this.addUniqueMarker(latitude, longitude, true);
            }
            else
            {
                let position = {lat: latitude, lng: longitude};
                _this._uniqueMarker.setPosition(position);
                _this._map.setZoom(15);
                _this._map.panTo(_this._uniqueMarker.getPosition());
                _this._updateUniqueInfoWindow(latitude, longitude);
                // _this._map.setCenter(_this._uniqueMarker.getPosition());
            }
        });
    }
}