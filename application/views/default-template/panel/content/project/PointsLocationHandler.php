<script id="point-location-info-window" type="text/x-handlebars-template">
    <h4 class="mb-1 text-center">Punto {{point.label_bpo}}</h4>
    <dl class="mb-0 dl-horizontal" id="map-description-list" style="max-width:242px"> 
        <a href="https://wa.me/?text=https://maps.google.com/maps/?q={{point.latitude_bpo}},{{point.longitude_bpo}}" target="_blank" class="btn btn-whatsapp mt-1 btn-block btn-sm" role="button">
            <img src='<?=assets_url("images/whatsapp-icon.png")?>' style="height: 17px;"> COMPARTIR UBICACION
        </a>
    </dl>
</script>
