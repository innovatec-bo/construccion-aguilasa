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
        {{#ifCond keyword_pst "!=" "approvement"}}
            {{#ifCond keyword_pst "!=" "schedule"}}
                <h6 class="quick-log-status-name">{{status_name_pst}} <span class="pull-right">{{formatDate manual_entry_date_psl "short"}}</span></h6>
                <blockquote>
                    <dl>
                        <dt>Responsable(s)</dt>
                        <dd>{{responsible_user}}</dd>
                        {{#ifCond keyword_pst "==" "digitization"}}
                            <dt>Area del proyecto</dt>
                            <dd>{{points_quantity_prp}}p / {{distance_prp}}Km - <span class="original-area">{{points_pro}}p / {{distance_pro}}Km</span></dd>
                        {{/ifCond}}
                        {{#ifCond keyword_pst "==" "rd_digitization"}}
                            <dt>Area del proyecto</dt>
                            <dd>{{points_quantity_prp}}p / {{distance_prp}}Km - <span class="original-area">{{points_pro}}p / {{distance_pro}}Km</span></dd>
                        {{/ifCond}}
                        {{#ifCond keyword_pst "==" "ri_digitization"}}
                            <dt>Area del proyecto</dt>
                            <dd>{{points_quantity_prp}}p / {{distance_prp}}Km - <span class="original-area">{{points_pro}}p / {{distance_pro}}Km</span></dd>
                        {{/ifCond}}
                        {{#ifCond keyword_pst "==" "approved"}}
                            <dt>Costos diseño/construccion</dt>
                            <dd>{{design_prb}}/{{building_prb}}</dd>
                            <dt>Numero de grafo</dt>
                            <dd>{{graph_number_prb}}</dd>
                            <dt>Numero de reserva</dt>
                            <dd>{{reservation_number_prb}}</dd>
                        {{/ifCond}}
                        {{#ifCond keyword_pst "==" "canceled"}}
                            <dt>Costos de diseño</dt>
                            <dd>{{design_prb}}</dd>
                        {{/ifCond}}
                        {{#ifCond log_detail_psl "!=" ""}}
                            <dt>Observaciones</dt>
                            <dd>{{log_detail_psl}}</dd>
                        {{/ifCond}}
                    </dl>
                </blockquote>
            {{/ifCond}}
        {{/ifCond}}
    {{/each}}
</script>