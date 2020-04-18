<script id="location-info-window" type="text/x-handlebars-template">
    <dl class="mb-0"> 
        <dt>CODIGO</dt> 
        <dd class="pl-1">{{project.code_pro}}</dd> 
        <dt>ESTADO</dt> 
        <dd class="pl-1">{{project.status_name_pst}}</dd>
        {{#ifCond project.fiscal_responsible_id "==" null}}
            <dt>RESPONSABLE</dt> 
            <dd class="pl-1">{{project.responsible}}</dd>
        {{/ifCond}} 
        {{#ifCond project.fiscal_responsible_id "!=" null}}
            <dt>FISCAL</dt> 
            <dd class="pl-1">{{project.fiscal_responsible}}</dd> 
        {{/ifCond}}
        {{#ifCond project.builder_responsible_ids "!=" null}}
            <dt>CONSTRUCTOR</dt> 
            <dd class="pl-1">{{project.builder_responsible}}</dd> 
        {{/ifCond}}
        <a href="https://wa.me/?text=https://maps.google.com/maps/?q={{project.latitude_pro}},{{project.longitude_pro}}" target="_blank" class="btn btn-default p-0 mt-1" role="button">
            <?php
            $timthumbUrl = base_url("timthumb/timthumb.php");
            $imageUrl = assets_url("images/whatsapp-share-button.jpg");
            ?>
            <img src='<?=$timthumbUrl."?src=".$imageUrl."&h=25"?>'>
        </a>
    </dl>
</script>