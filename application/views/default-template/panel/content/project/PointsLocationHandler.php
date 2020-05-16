<script id="point-location-info-window" type="text/x-handlebars-template">
    <h4 class="mb-1 text-center">Punto {{point.point_label}}</h4>
    <dl class="mb-0 dl-horizontal" id="map-description-list" style="max-width:242px"> 
        <a href="https://wa.me/?text=https://maps.google.com/maps/?q={{point.point_latitude}},{{point.point_longitude}}" target="_blank" class="btn btn-whatsapp mt-1 btn-block btn-sm" role="button">
            <?php
            $timthumbUrl = base_url("timthumb/timthumb.php");
            $imageUrl = assets_url("images/whatsapp-icon.png");
            ?>
            <img src='<?=$timthumbUrl."?src=".$imageUrl."&h=17"?>'> COMPARTIR UBICACION
        </a>
    </dl>
</script>
