var ProjectsLocationHandler = /** @class */ (function () {
    function ProjectsLocationHandler(divContent) {
        this.divContent = divContent;
        moment.locale('es');
        this._mapContent = divContent;
        this._currentMarkers = [];
        this._bounds = new google.maps.LatLngBounds();
        this._markerCluster = new MarkerClusterer(this._map, this._currentMarkers, { imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m' });
    }
    ProjectsLocationHandler.prototype.startPaginationJs = function (additionalParameter) {
        var _this = this;
        $('#pagination-content').pagination({
            dataSource: base_url + 'panel/AjaxProject/paginationJs',
            locator: 'resultArray',
            totalNumberLocator: function (response) {
                // you can return totalNumber by analyzing response content
                var text = "Se encontraron " + response.recordsFiltered + " proyectos";
                if (response.recordsFiltered == 1)
                    text = "Se encontro 1 proyecto";
                else if (response.recordsFiltered == 0)
                    text = "No se encontraron proyectos";
                $("#total-projects-found").text(text);
                return response.recordsFiltered;
            },
            pageSize: 20,
            ajax: {
                type: 'POST',
                data: { number: (Math.floor(Math.random() * (1000 - 100)) + 100) },
                beforeSend: function (jqXHR) {
                    blockArea($("#" + _this._mapContent));
                    this.data += '&' + $.param({
                        additionalParameters: additionalParameter.getList(),
                        textToSearch: $("#text-to-search").val()
                    });
                    return true;
                }
            },
            callback: function (data, pagination) {
                // template method of yourself
                $.each(_this._currentMarkers, function (index, marker) {
                    marker.setMap(null);
                });
                _this._bounds = new google.maps.LatLngBounds();
                _this._currentMarkers = [];
                _this._markerCluster.clearMarkers();
                var marker = {};
                $.each(data, function (index, project) {
                    console.log(parseFloat(project.project_latitude), parseFloat(project.project_longitude));
                    var loc = new google.maps.LatLng(parseFloat(project.project_latitude), parseFloat(project.project_longitude));
                    _this._bounds.extend(loc);
                    marker = _this.addMarker(project);
                    _this._currentMarkers.push(marker);
                });
                _this._markerCluster.setMap(_this._map);
                _this._markerCluster.addMarkers(_this._currentMarkers);
                if (data.length == 1) {
                    var coordinate = data[0];
                    _this._map.setZoom(15);
                    _this._map.panTo(marker.getPosition());
                }
                else {
                    _this._map.fitBounds(_this._bounds);
                    _this._map.panToBounds(_this._bounds);
                }
                // _this._markerCluster.repaint();
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
        var latitude = parseFloat(project.project_latitude);
        var longitude = parseFloat(project.project_longitude);
        var position = { lat: latitude, lng: longitude };
        var markerImage = timbthumbImage(base_url + 'assets/images/google-maps-marker.png', 35);
        var marker = new google.maps.Marker({
            position: position,
            map: _this._map,
            // animation: google.maps.Animation.DROP,
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
    ProjectsLocationHandler.prototype._delay = function (callback, ms) {
        var timer = 0;
        return function () {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    };
    ProjectsLocationHandler.prototype.loadEventHandlers = function () {
        var _this = this;
        $(document).on("click", "#search-text-on-map", function () {
            if ($('#pagination-content').length > 0)
                $('#pagination-content').pagination('go', 1);
        });
        $('#text-to-search').keyup(this._delay(function (e) {
            if ($('#pagination-content').length > 0)
                $('#pagination-content').pagination('go', 1);
        }, 2000));
    };
    return ProjectsLocationHandler;
}());
