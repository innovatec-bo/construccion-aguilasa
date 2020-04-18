var ProjectsLocationHandler = /** @class */ (function () {
    function ProjectsLocationHandler(divContent) {
        this.divContent = divContent;
        moment.locale('es');
        this._mapContent = divContent;
        this._currentMarkers = [];
        this._bounds = new google.maps.LatLngBounds();
    }
    ProjectsLocationHandler.prototype.startPaginationJs = function () {
        var _this = this;
        var additionalParameter = new DTAdditionalParameterHandler("#extra-request-data", "#project-index");
        additionalParameter.addParameterObject('status', 'text');
        additionalParameter.addParameterObject('work-area', 'select');
        additionalParameter.addParameterObject('fiscal-responsible-id', 'select');
        additionalParameter.addParameterObject('builder-responsible-id', 'select');
        additionalParameter.addParameterObject('manpower-uploaded', 'select');
        additionalParameter.setButtonFilter('#send-filters');
        additionalParameter.setButtonRest('#remove-additional-parameters');
        additionalParameter.loadEventHandlers();
        $('#pagination-content').pagination({
            dataSource: base_url + 'panel/AjaxProject/paginationJs',
            locator: 'resultArray',
            totalNumberLocator: function (response) {
                // you can return totalNumber by analyzing response content
                return response.recordsTotal;
            },
            pageSize: 20,
            ajax: {
                type: 'POST',
                data: { additionalParameters: additionalParameter.getList() },
                beforeSend: function () {
                    blockArea($("#" + _this._mapContent));
                }
            },
            callback: function (data, pagination) {
                // template method of yourself
                $.each(_this._currentMarkers, function (index, marker) {
                    marker.setMap(null);
                });
                _this._bounds = new google.maps.LatLngBounds();
                _this._currentMarkers = [];
                $.each(data, function (index, project) {
                    var loc = new google.maps.LatLng(parseFloat(project.latitude_pro), parseFloat(project.longitude_pro));
                    _this._bounds.extend(loc);
                    var marker = _this.addMarker(project);
                    _this._currentMarkers.push(marker);
                });
                _this._map.fitBounds(_this._bounds);
                _this._map.panToBounds(_this._bounds);
                $("#" + _this._mapContent).unblock();
            }
        });
    };
    ProjectsLocationHandler.prototype.startMap = function () {
        this._map = new google.maps.Map(document.getElementById(this._mapContent), {
            center: { lat: -17.784146, lng: -63.181738 },
            zoom: 12
        });
    };
    ProjectsLocationHandler.prototype.addMarker = function (project) {
        var _this = this;
        var latitude = parseFloat(project.latitude_pro);
        var longitude = parseFloat(project.longitude_pro);
        var position = { lat: latitude, lng: longitude };
        var markerImage = timbthumbImage(base_url + 'assets/images/google-maps-marker.png', 35);
        var marker = new google.maps.Marker({
            position: position,
            map: _this._map,
            animation: google.maps.Animation.DROP,
            icon: markerImage
        });
        var htmlSource = $("#location-info-window").html();
        var template = Handlebars.compile(htmlSource);
        var html = template({ project: project });
        var infoWindow = new google.maps.InfoWindow({
            // content: '<a target="_blank" href="https://wa.me/?text=https://www.google.com/maps/search/?q='+latitude+','+longitude+'">Enviar por Whatsapp</a>'
            content: html
        });
        marker.addListener('click', function () {
            infoWindow.open(_this._map, marker);
        });
        return marker;
    };
    ProjectsLocationHandler.prototype.loadEventHandlers = function () {
        var _this = this;
    };
    return ProjectsLocationHandler;
}());
