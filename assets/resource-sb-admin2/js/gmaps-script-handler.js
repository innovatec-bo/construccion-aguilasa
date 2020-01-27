/*############################################## BEGIN - GOOGLE MAPS */
    var map = new GMaps({
        div: '#maps',
        lat: -17.784146,
        lng: -63.181738,

        enableNewStyle: true
    });
    addInitialMarker();
    //Add marker manually
    GMaps.on('click', map.map, function(event) {
        var index = map.markers.length;
        var latitude = event.latLng.lat();
        var longitude = event.latLng.lng();
        if(index == 0)
        {
            let markerImage = timbthumbImage(base_url+'assets/images/google-maps-marker.png',35);
            map.addMarker({
                lat: latitude,
                lng: longitude,
                icon: markerImage,
                title: 'Hello map'
            });
        }
        else
        {
            map.markers[0].setPosition(new google.maps.LatLng(latitude, longitude));
            $("input[name=latitude]").val(latitude);
            $("input[name=longitude]").val(longitude);
        }
    });
    //Add marker by search result
    $(".search-address-button").on("click",function(e){
        e.preventDefault();
        var addressData = $.trim($(".search-address-data").val());
        var addressState = $.trim($(".search-address-data-state").text())!=""?", "+$.trim($(".search-address-data-state").text()):"";
        var addressCity = $.trim($(".search-address-data-city").text())!=""?", "+$.trim($(".search-address-data-city").text()):"";
        addressData += addressCity + addressState +", Bolivia";
        if(addressData != "")
        {
            addMarkerBySearchResult(addressData);
        }
    });
    //When a marker is added performance this
    GMaps.on('marker_added', map, function(marker) {
        $("input[name=latitude]").val(marker.getPosition().lat());
        $("input[name=longitude]").val(marker.getPosition().lng());
    });
    $(".search-address-data").on("keypress",function(e){
        $(".map-search-message").text("");
        if (e.which == 13)
        {
            e.preventDefault();
            $(".map-search-message").text("Buscando...");
            var addressData = $.trim($(this).val());
            var addressState = $.trim($(".search-address-data-state").text())!=""?", "+$.trim($(".search-address-data-state").text()):"";
            var addressCity = $.trim($(".search-address-data-city").text())!=""?", "+$.trim($(".search-address-data-city").text()):"";
            addressData += addressCity + addressState +", Bolivia";
            if (addressData != "") {
                addMarkerBySearchResult(addressData);
            }
            return false;
        }
    });
    function addMarkerBySearchResult(data)
    {
        var addressData = data;
        GMaps.geocode({
            address: addressData,
            callback: function(results, status) {
                if (status == 'OK')
                {
                    $(".map-search-message").text("");
                    var Coordinates = results[0].geometry.location;
                    var latitude = Coordinates.lat();
                    var longitude = Coordinates.lng();
                    var index = map.markers.length;
                    map.setCenter(latitude, longitude);
                    if(index == 0)
                    {
                        let markerImage = timbthumbImage(base_url+'assets/images/google-maps-marker.png',35);
                        map.addMarker({
                            lat: latitude,
                            lng: longitude,
                            icon: markerImage,
                            title: 'Hello map'
                        });
                    }
                    else
                    {
                        map.markers[0].setPosition(new google.maps.LatLng(latitude, longitude));
                        $("input[name=latitude]").val(latitude);
                        $("input[name=longitude]").val(longitude);
                    }
                }
                else
                {
                    $(".map-search-message").text("No se encontro la ubicacion...");
                }
            }
        });
    }

    function addInitialMarker()
    {
        var latitude = $("input[name=latitude]").val();
        var longitude = $("input[name=longitude]").val();
        if(latitude!="")
        {
            let markerImage = timbthumbImage(base_url+'assets/images/google-maps-marker.png',35);
            map.setCenter(latitude, longitude);
            map.addMarker({
                lat: latitude,
                lng: longitude,
                icon: markerImage
            });
        }
    }
    /*############################################## END - GOOGLE MAPS */