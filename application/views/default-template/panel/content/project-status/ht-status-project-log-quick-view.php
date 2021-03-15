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
                {{var "className2" ""}}
                {{#ifCond ../allowUpdateHistory "==" 1}}
                    {{var "className" "edit-date"}}
                    {{var "className2" "edit-points-distance"}}
                {{/ifCond}}
                <h6 class="quick-log-status-name">{{status_name_pst}} <span class="pull-right {{className}}" data-log-id="{{id_psl}}" data-status-name="{{status_name_pst}}">{{formatDate manual_entry_date_psl "short"}}</span></h6>
                <blockquote>
					{{#ifCond ../allowDeleteStatusLog "==" 1}}
						{{#ifCond keyword_pst "!=" "approved"}}
							<button type="button" class="btn btn-danger btn-xs delete-status-from-log" data-log-id="{{id_psl}}" style="position: absolute;left: 0px;padding: 0px 5px;"><i class="fa fa-times"></i></button>
						{{/ifCond}}
					{{/ifCond}}

                    <dl>
                        <dt>Responsable(s)</dt>
                        <dd>{{responsible_user}}</dd>
                        {{#ifCond keyword_pst "==" "digitization"}}
                            <dt>Area del proyecto</dt>
                            <dd data-log-id="{{id_psl}}" data-status-name="{{status_name_pst}}" class="{{className2}}">{{points_quantity_prp}}p / {{distance_prp}}Km - <span class="original-area">{{points_pro}}p / {{distance_pro}}Km</span></dd>
                        {{/ifCond}}
                        {{#ifCond keyword_pst "==" "rd_digitization"}}
                            <dt>Area del proyecto</dt>
                            <dd data-log-id="{{id_psl}}" data-status-name="{{status_name_pst}}" class="{{className2}}">{{points_quantity_prp}}p / {{distance_prp}}Km - <span class="original-area">{{points_pro}}p / {{distance_pro}}Km</span></dd>
                        {{/ifCond}}
                        {{#ifCond keyword_pst "==" "ri_digitization"}}
                            <dt>Area del proyecto</dt>
                            <dd data-log-id="{{id_psl}}" data-status-name="{{status_name_pst}}" class="{{className2}}">{{points_quantity_prp}}p / {{distance_prp}}Km - <span class="original-area">{{points_pro}}p / {{distance_pro}}Km</span></dd>
                        {{/ifCond}}
                        {{#ifCond keyword_pst "==" "as_built"}}
                            <dt>Area del proyecto</dt>
                            <dd data-log-id="{{id_psl}}" data-status-name="{{status_name_pst}}" class="{{className2}}">{{points_quantity_prp}}p / {{distance_prp}}Km - <span class="original-area">{{points_pro}}p / {{distance_pro}}Km</span></dd>
                        {{/ifCond}}
                        {{#ifCond keyword_pst "==" "approved"}}
                            {{#ifCond manpower_file_id_prb "!=" null}}
                                <dt>Revisar Mano de obra</dt>
                                <dd>
                                    <a href="<?=base_url('panel/Project/downloadManPowerFile/')?>{{file_hash}}"><i class="fa fa-download fa-fw"></i></a>
                                    <a href="<?=base_url('panel/Project/manpower/')?>{{project_id_psl}}" target="_blank"><i class="fa fa-table fa-fw"></i></a>
                                </dd>
                            {{/ifCond}}
                            {{#ifCond manpower_file_id_prb "==" null}}
                                <dt>Cargar Mano de obra</dt>
                                <dd>
                                    <form name="manpower-upload-file" enctype="multipart/form-data">
                                        <input type="hidden" value="{{project_id_psl}}" name="project-id">
                                        <input type="hidden" value="{{project_budget_id}}" name="project-budget-id">
                                        <div class="form-group input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary extract-approved-budgets btn-xs" data-form-name="manpower-upload-file" data-save-in-system="1" type="button" style="font-size: 11px"><i class="fa fa-upload fa-fw"></i>
                                                    </button>
                                                </span>
                                            <input type="file" name="manpower-file">
                                        </div>
                                    </form>
                                </dd>
                            {{/ifCond}}
                            {{#ifCond manpower_file_id_prb "!=" null}}
<!--                                <dt>Cargar Materiales</dt>-->
<!--                                <dd>-->
<!--                                    <form name="manpower-upload-file" enctype="multipart/form-data">-->
<!--                                        <input type="hidden" value="{{project_id_psl}}" name="project-id">-->
<!--                                        <input type="hidden" value="{{project_budget_id}}" name="project-budget-id">-->
<!--											<div class="form-group input-group hide">-->
<!--											<span class="input-group-btn">-->
<!--												<button class="btn btn-primary extract-approved-materials btn-xs" data-form-name="status-management" data-save-in-system="0" type="button">{{buttonText}}-->
<!--												</button>-->
<!--											</span>-->
<!--											<input type="file" name="materials-file" accept=".xlsx, .xls, .csv">-->
<!--										</div>-->
<!--                                    </form>-->
<!--                                </dd>-->
                            {{/ifCond}}
                            <dt>Total Importe</dt>
                            <dd><span class="label label-primary" style="font-size: 80%;">{{numberFormat total_budget}}</span></dd>
                            <dt>Importe de diseño</dt>
                            <dd>{{numberFormat design_prb}}</dd>
                            <dt>Importe de construccion</dt>
                            <dd>{{numberFormat building_prb}}</dd>
                            <dt>Importe de transporte</dt>
                            <dd>{{numberFormat transportation_prb}}</dd>
                            <dt>Importe de linea viva</dt>
                            <dd>{{numberFormat live_line_prb}}</dd>
                            <dt>Importe Derecho de via</dt>
                            <dd>{{numberFormat right_of_way_prb}}</dd>                            
                            <dt>Numero de grafo</dt>
                            <dd>{{graph_number_prb}}</dd>
                            <dt>Numero de reserva</dt>
                            <dd>{{reservation_number_prb}}</dd>
                        {{/ifCond}}

                        {{#ifCond keyword_pst "==" "conciliation_shipment"}}
                        	<dt>Total Importe real</dt>
                            <dd><span class="label label-primary" style="font-size: 80%;">{{numberFormat total_real_budget}}</span></dd>
                            <dt>Importe real diseño</dt>
                            <dd>{{design_reb}}</dd>
                            <dt>Importe real construccion</dt>
                            <dd>{{building_reb}}</dd>
                            <dt>Importe real transporte</dt>
                            <dd>{{transportation_reb}}</dd>
                            <dt>Importe real linea viva</dt>
                            <dd>{{live_line_reb}}</dd>
                            <dt>Importe real Derecho de via</dt>
                            <dd>{{right_of_way_reb}}</dd>
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
                        {{#ifCond images_list "!=" null}}
                            <dt>Imagenes</dt>
                            <dd>
                                <div class="my-gallery" itemscope itemtype="http://schema.org/ImageGallery">
                                    {{{slides images_list}}}
                                </div>
                            </dd>
                        {{/ifCond}}
                        {{#ifCond documents_list "!=" null}}
                            <dt>Documentos</dt>
                            <dd>
                                <div class="my-document-list" itemscope itemtype="http://schema.org/ImageGallery">
                                    {{{document_list documents_list}}}
                                </div>
                            </dd>
                        {{/ifCond}}
                    </dl>
                </blockquote>
            {{/ifCond}}
        {{/ifCond}}
    {{/each}}
</script>

