<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 13/06/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-stakes-project" type="text/x-handlebars-template">
    {{#each stakesProject}}
        <div class="col-md-12">
            <div class="tags sortable-list" data-leader-id="{{teamLeaderId}}">
                <span class="success" style="">{{teamLeader}}</span>
                {{> ht-stakes-project-item}}
            </div>
        </div>
    {{/each}}
</script>
<script id="ht-stakes-project-item" type="text/x-handlebars-template">
    {{#each projectList}}
        <span class="info sortable-item" data-project-id="{{id_pro}}"><a href="#" data-toggle="tooltip" data-placement="top" title="{{address_pro}}">Direccion</a><br>8p/2Km</span>
    {{/each}}
</script>
