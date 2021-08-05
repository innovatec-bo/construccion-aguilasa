<script id="location-info-window" type="text/x-handlebars-template">
    <h4 class="mb-1 text-center">{{project.code_pro}}</h4>
    <dl class="mb-0 dl-horizontal" id="map-description-list" style="max-width:242px"> 
        <dt>ESTADO</dt> 
        <dd class="">{{project.status_name_pst}}</dd>
        <dt>DIRECCION</dt> 
        <dd class="">{{project.address_pro}}</dd>
        {{#ifCond project.fiscal_responsible_id "==" null}}
            <dt>RESPONSABLE</dt> 
            <dd class="">{{project.responsible}}</dd>
        {{/ifCond}} 
        {{#ifCond project.fiscal_responsible_id "!=" null}}
            <dt>FISCAL</dt> 
            <dd class="">{{project.fiscal_responsible}}</dd> 
        {{/ifCond}}
        {{#ifCond project.builder_responsible_ids "!=" null}}
            <dt>CONSTRUCTOR</dt> 
            <dd class="">{{project.builder_responsible}}</dd> 
        {{/ifCond}}
        <dt>DETALLE</dt> 
            <dd class="">{{project.detail_pro}}</dd> 
        <a href="https://wa.me/?text=https://maps.google.com/maps/?q={{project.project_latitude}},{{project.project_longitude}}" target="_blank" class="btn btn-whatsapp mt-1 btn-block btn-sm" role="button">
            <?php
            $timthumbUrl = base_url("timthumb/timthumb.php");
            $imageUrl = assets_url("images/whatsapp-icon.png");
            ?>
            <img src='<?=$timthumbUrl."?src=".$imageUrl."&h=17"?>'> COMPARTIR UBICACION
        </a>
    </dl>
</script>