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
                {{var "className" ""}}
                {{#ifCond ../allowUpdateHistory "==" 1}}
                    {{var "className" "edit-date"}}
                {{/ifCond}}
                <h6 class="quick-log-status-name">{{status_name_pst}} <span class="pull-right {{className}}" data-log-id="{{id_psl}}" data-status-name="{{status_name_pst}}">{{formatDate manual_entry_date_psl "short"}}</span></h6>
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
                            <dt>Importe de diseño</dt>
                            <dd>{{design_prb}}</dd>
                            <dt>Importe de construccion</dt>
                            <dd>{{building_prb}}</dd>
                            <dt>Importe de transporte</dt>
                            <dd>{{transportation_prb}}</dd>
                            <dt>Importe de linea viva</dt>
                            <dd>{{live_line_prb}}</dd>
                            <dt>Numero de grafo</dt>
                            <dd>{{graph_number_prb}}</dd>
                            <dt>Numero de reserva</dt>
                            <dd>{{reservation_number_prb}}</dd>
                        {{/ifCond}}

                        {{#ifCond keyword_pst "==" "assign_to"}}
                            <dt>Fecha de inicio</dt>
                            <dd>{{formatDate start_date_cas "short"}}</dd>
                            <dt>Fecha de fin</dt>
                            <dd>{{formatDate end_date_cas "short"}}</dd>
                            <dt>Tiempo estimado</dt>
                            <dd>{{estimated_time_cas}} dia(s)</dd>
                            <dt>Adicionales</dt>
                            {{#ifCond live_line_cas "==" 1}}<dd>Linea viva</dd>{{/ifCond}}
                            {{#ifCond power_down_cas "==" 1}}<dd>Corte</dd>{{/ifCond}}
                            {{#ifCond maneuver_cas "==" 1}}<dd>Maniobra</dd>{{/ifCond}}
                        {{/ifCond}}

                        {{#ifCond keyword_pst "==" "canceled"}}
                            <dt>Importe de diseño</dt>
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