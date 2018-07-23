<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 13/06/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-status-project-log-quick-view" type="text/x-handlebars-template">
    {{#each projectLog}}
        <h6 class="quick-log-status-name">{{status_name_pst}} <span class="pull-right">{{formatDate createdon_psl "short"}}</span></h6>
        <blockquote>
            <dl>
                <dt>Responsable(s)</dt>
                <dd>{{responsible_user}}</dd>
                {{#ifCond keyword_pst "==" "digitization"}}
                    <dt>Area del proyecto</dt>
                    <dd>{{points_quantity_prp}}p / {{distance_prp}}Km - <span class="original-area">{{points_pro}}p / {{distance_pro}}Km</span></dd>
                {{/ifCond}}
                {{#ifCond log_detail_psl "!=" ""}}
                    <dt>Observaciones</dt>
                    <dd>{{log_detail_psl}}</dd>
                {{/ifCond}}
            </dl>
        </blockquote>
    {{/each}}
</script>