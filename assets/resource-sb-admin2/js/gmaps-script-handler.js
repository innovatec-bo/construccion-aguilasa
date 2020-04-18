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
                draggable: true,
                infoWindow: {
                  content: '<a target="_blank" href="https://wa.me/?text=https://www.google.com/maps/search/?q='+latitude+','+longitude+'">Share Whatsapp</a>'
                },
                dragend: function(event) {
                    let latitude = event.latLng.lat();
                    let longitude = event.latLng.lng();
                    updateFormInput(latitude, longitude);
                }
            });
        }
        else
        {
            map.markers[0].setPosition(new google.maps.LatLng(latitude, longitude));
            map.markers[0].setInfoWindow({
                              content: '<a target="_blank" href="https://wa.me/?text=https://www.google.com/maps/search/?q='+latitude+','+longitude+'">Share Whatsapp</a>'
                            });
            updateFormInput(latitude, longitude);
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
        updateFormInput(marker.getPosition().lat(), marker.getPosition().lng());
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

    $(document).on('click','.search-coordinate-button',function(e){
        e.preventDefault();
        let latitude = $("input[name=latitude]").val();
        let longitude = $("input[name=longitude]").val();
        addMarker(latitude, longitude);
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
                            draggable: true,
                            infoWindow: {
                              content: '<a target="_blank" href="https://wa.me/?text=https://www.google.com/maps/search/?q='+latitude+','+longitude+'">Share Whatsapp</a>'
                            },
                            dragend: function(event) {
                                let latitude = event.latLng.lat();
                                let longitude = event.latLng.lng();
                                updateFormInput(latitude, longitude);
                            }
                        });
                    }
                    else
                    {
                        map.markers[0].setPosition(new google.maps.LatLng(latitude, longitude));
                        updateFormInput(latitude, longitude);
                    }
                }
                else
                {
                    $(".map-search-message").text("No se encontro la ubicacion...");
                }
            }
        });
    }

    function addMarker(latitude, longitude)
    {
        if(latitude!="")
        {
            var index = map.markers.length;
            if(index == 0)
            {
                let markerImage = timbthumbImage(base_url+'assets/images/google-maps-marker.png', 35);
                map.addMarker({
                    lat: latitude,
                    lng: longitude,
                    icon: markerImage,
                    draggable: true,
                    infoWindow: {
                      content: '<a target="_blank" href="https://wa.me/?text=https://www.google.com/maps/search/?q='+latitude+','+longitude+'">Share Whatsapp</a>'
                    },
                    dragend: function(event) {
                        let latitude = event.latLng.lat();
                        let longitude = event.latLng.lng();
                        updateFormInput(latitude, longitude);
                    }
                });
            }
            else
            {
                map.markers[0].setPosition(new google.maps.LatLng(latitude, longitude));
                
                updateFormInput(latitude, longitude);
            }
            map.setCenter(latitude, longitude);
        }
    }

    function addMarkerOnGlobalMap(project)
    {
        let markerImage = timbthumbImage(base_url+'assets/images/google-maps-marker.png',35);
        map.addMarker({
            lat: project.latitude,
            lng: project.longitude,
            icon: markerImage,
            infoWindow: {
              content: '<dl><dt>CODIGO</dt><dd>'+project.code+'</dd><dt>STATUS</dt><dd>'+project.statusName+'</dd><dt>DETALLE</dt><dd>'+project.detail+'</dd></dl>'
            }
        });
    }

    function addInitialMarker()
    {
        let latitude = $("input[name=latitude]").val();
        let longitude = $("input[name=longitude]").val();
        if(latitude!="" && latitude !== undefined)
        {
            let markerImage = timbthumbImage(base_url+'assets/images/google-maps-marker.png',35);
            map.setCenter(latitude, longitude);
            map.addMarker({
                lat: latitude,
                lng: longitude,
                icon: markerImage,
                draggable: true,
                infoWindow: {
                  content: '<a target="_blank" href="https://wa.me/?text=https://www.google.com/maps/search/?q='+latitude+','+longitude+'">Share Whatsapp</a>'
                },
                dragend: function(event) {
                    let latitude = event.latLng.lat();
                    let longitude = event.latLng.lng();
                    updateFormInput(latitude, longitude);
                }
            });
        }
    }

    function updateFormInput(latitude, longitude)
    {
        $("input[name=latitude]").val(latitude);
        $("input[name=longitude]").val(longitude);
    }
    /*############################################## END - GOOGLE MAPS */