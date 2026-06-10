"use strict";
var MapsHandler = /** @class */ (function () {
    function MapsHandler(divContent) {
        this.divContent = divContent;
        moment.locale('es');
        this._mapContent = divContent;
        this._uniqueMarker = null;
        this._uniqueInfoWindow = null;
    }
    MapsHandler.prototype.startMap = function () {
        this._map = new google.maps.Map(document.getElementById(this._mapContent), {
            center: { lat: -17.784146, lng: -63.181738 },
            zoom: 12
        });
    };
    MapsHandler.prototype.addUniqueMarker = function (latitude, longitude, centerMarker) {
        if (centerMarker === void 0) { centerMarker = false; }
        var _this = this;
        var position = { lat: latitude, lng: longitude };
        var markerImage = base_url + 'assets/images/google-maps-marker.png';
        this._uniqueMarker = new google.maps.Marker({
            position: position,
            map: _this._map,
            animation: google.maps.Animation.DROP,
            icon: markerImage,
            draggable: true
        });
        if (this._uniqueInfoWindow === null) {
            this._uniqueInfoWindow = new google.maps.InfoWindow({
                content: '<a target="_blank" href="https://wa.me/?text=https://www.google.com/maps/search/?q=' + latitude + ',' + longitude + '">Enviar por Whatsapp</a>'
            });
        }
        else {
            _this._updateUniqueInfoWindow(latitude, longitude);
        }
        this._uniqueMarker.addListener('click', function () {
            _this._uniqueInfoWindow.open(_this._map, _this._uniqueMarker);
        });
        this._uniqueMarker.addListener('dragend', function (e) {
            _this._updateFormInput(e.latLng.lat(), e.latLng.lng());
            _this._updateUniqueInfoWindow(e.latLng.lat(), e.latLng.lng());
        });
        if (centerMarker) {
            _this._map.setZoom(15);
            _this._map.panTo(position);
            // _this._map.setCenter(position);
        }
    };
    MapsHandler.prototype._updateUniqueInfoWindow = function (latitude, longitude) {
        this._uniqueInfoWindow.setContent('<a target="_blank" href="https://wa.me/?text=https://www.google.com/maps/search/?q=' + latitude + ',' + longitude + '">Enviar por Whatsapp</a>');
    };
    MapsHandler.prototype._updateFormInput = function (latitude, longitude) {
        $("input[name=latitude]").val(latitude);
        $("input[name=longitude]").val(longitude);
    };
    MapsHandler.prototype.loadEventHandlers = function () {
        var _this = this;
        this._map.addListener('click', function (e) {
            var position = { lat: e.latLng.lat(), lng: e.latLng.lng() };
            if (_this._uniqueMarker === null) {
                _this.addUniqueMarker(e.latLng.lat(), e.latLng.lng(), true);
            }
            else {
                _this._uniqueMarker.setPosition(position);
                _this._map.setZoom(15);
                _this._map.panTo(_this._uniqueMarker.getPosition());
                _this._updateUniqueInfoWindow(e.latLng.lat(), e.latLng.lng());
            }
            _this._updateFormInput(e.latLng.lat(), e.latLng.lng());
        });
        $(document).on('click', '.search-coordinate-button', function (e) {
            e.preventDefault();
            var latitude = parseFloat($("input[name=latitude]").val());
            var longitude = parseFloat($("input[name=longitude]").val());
            if (_this._uniqueMarker === null) {
                _this.addUniqueMarker(latitude, longitude, true);
            }
            else {
                var position = { lat: latitude, lng: longitude };
                _this._uniqueMarker.setPosition(position);
                _this._map.setZoom(15);
                _this._map.panTo(_this._uniqueMarker.getPosition());
                _this._updateUniqueInfoWindow(latitude, longitude);
                // _this._map.setCenter(_this._uniqueMarker.getPosition());
            }
        });
    };
    return MapsHandler;
}());
