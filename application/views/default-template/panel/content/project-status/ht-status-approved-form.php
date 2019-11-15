<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 13/06/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-status-approved-form" type="text/x-handlebars-template">
    <div class="tab-pane active" role="tabpanel" id="step_{{statusKeyword}}">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Detalles de aprobacion
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 status-content">
                        <div class="row">
                            <div class="col-md-12">
                                {{#ifCond previousEntry.manpower_file_id_prb "!=" null}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group pull-right">
                                            <a class="btn btn-info" href="<?=base_url('panel/Project/downloadManPowerFile/')?>{{previousEntry.file_hash}}"><i class="fa fa-download fa-fw"></i></a>
                                            <a class="btn btn-info" href="<?=base_url('panel/Project/manpower/')?>{{previousEntry.project_id_psl}}" target="_blank"><i class="fa fa-table fa-fw"></i></a>
                                        </div>
                                    </div>
                                </div>
                                {{/ifCond}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha de ingreso</label>
                                            <div class="input-group date date-time-picker">
                                                <input name="{{statusKeyword}}-entry-date" readonly="" class="form-control" required="" data-parsley-group="{{statusKeyword}}" data-parsley-errors-container="#error-{{statusKeyword}}-entry-date">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                            <div id="error-{{statusKeyword}}-entry-date"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Codigo secundario</label>
                                        <div class="form-group">
                                            {{var "secondaryCode" viewData.project.code_pro}}
                                            {{#ifCond previousEntry.secondary_code_pro "!=" undefined}}
                                                {{var "secondaryCode" previousEntry.secondary_code_pro}}
                                            {{/ifCond}}
                                            <input class="form-control" value="{{secondaryCode}}" name="secondary-code" placeholder="Codigo secundario" required="" data-parsley-group="{{statusKeyword}}">
                                        </div>
                                    </div>
                                </div>
                                {{#ifCond previousEntry.manpower_file_id_prb "==" null}}
                                    {{var "buttonText" "Cargar mano de obra"}}
                                    {{var "buttonTextPointToPoint" "Cargar punto a punto"}}
                                    {{#ifCond previousEntry.id_prb "==" null}}
                                        {{var "buttonText" "Revisar mano de obra"}}
                                        {{var "buttonTextPointToPoint" "Revisar punto a punto"}}
                                    {{/ifCond}}
                                    <div class="form-group input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary extract-approved-budgets btn-xs" data-form-name="status-management" data-save-in-system="0" type="button">{{buttonText}}
                                            </button>
                                        </span>
                                        <input type="file" name="manpower-file" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                    </div>
                                {{/ifCond}}
                                {{#ifCond previousEntry.manpower_file_id_prb "==" null}}
                                    {{var "buttonTextPointToPoint" "Cargar punto a punto"}}
                                    {{#ifCond previousEntry.building_structure_file_id_prb "==" null}}
                                        {{var "buttonTextPointToPoint" "Revisar punto a punto"}}
                                    {{/ifCond}}
                                    <div class="form-group input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary extract-building-budgets btn-xs" data-form-name="status-management" data-save-in-system="0" type="button">{{buttonTextPointToPoint}}
                                            </button>
                                        </span>
                                        <input type="file" name="point-to-point-file" accept=".csv">
                                    </div>
                                {{/ifCond}}
                                <input type="hidden" name="project-budget-id" value="{{previousEntry.id_prb}}">
                                <input type="hidden" name="manpower-file-id" value="{{previousEntry.manpower_file_id_prb}}">
                                <input type="hidden" name="point-to-point-file-id" value="{{previousEntry.building_structure_file_id_prb}}">
                                {{var "readonly" "Cargar mano de obra"}}
                                {{#ifCond previousEntry.id_prb "==" null}}
                                    {{var "buttonText" "Revisar mano de obra"}}
                                {{/ifCond}}
                                <div class="row form-inline">
                                    <div class="col-md-6">
                                        <label>Importe (<span id="total-project-amount">0.00</span>)</label><br>
                                        <div class="form-group">
                                            <em>Diseño</em><br>
                                            <input class="form-control input-masked" value="{{previousEntry.design_prb}}" name="design-budget" placeholder="Diseño" required="" data-parsley-group="{{statusKeyword}}" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                        </div>
                                        <div class="form-group">
                                            <em>Construccion</em><br>
                                            <input class="form-control input-masked" value="{{previousEntry.building_prb}}" name="building-budget" placeholder="Construccion" required="" data-parsley-group="{{statusKeyword}}" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                        </div>
                                        <div class="form-group">
                                            <em>Transporte</em><br>
                                            <input class="form-control input-masked" value="{{previousEntry.transportation_prb}}" name="transportation-budget" placeholder="Transporte" required="" data-parsley-group="{{statusKeyword}}" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                        </div>
                                        <div class="form-group">
                                            <em>Linea viva</em><br>
                                            <input class="form-control input-masked" value="{{previousEntry.live_line_prb}}" name="live-line-budget" placeholder="Linea viva" required="" data-parsley-group="{{statusKeyword}}" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                        </div>
                                        <div class="form-group">
                                            <em>Derecho de via</em><br>
                                            <input class="form-control input-masked" value="{{previousEntry.right_of_way_prb}}" name="right-of-way-budget" placeholder="Derecho de via" required="" data-parsley-group="{{statusKeyword}}" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Nro. de grafo</label>
                                        <div class="form-group">
                                            <input class="form-control" value="{{previousEntry.graph_number_prb}}" name="graph-number-budget" placeholder="Grafo" data-parsley-type="number" required="" data-parsley-group="{{statusKeyword}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Nro. de reserva</label>
                                        <div class="form-group">
                                            <input class="form-control" value="{{previousEntry.reservation_number_prb}}" name="reservation-number-budget" placeholder="Reservacion" data-parsley-type="number" required="" data-parsley-group="{{statusKeyword}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row hide">
                                    <div class="col-md-6">
                                        <fieldset>
                                            <label>Responsable(s) <a href="#" class="check-stakes-team"><i class="fa fa-question-circle"></i></a></label>
                                            <div class="form-group">
                                                <select class="form-control" multiple="multiple" data-parsley-required="" parsley-trigger="change" id="ajax-get-responsible-list">
                                                    {{#each statusResponsible}}
                                                        {{var "selected" ""}}
                                                        {{#ifCond ../responsibleListLength "===" 1}}
                                                            {{var "selected" "selected"}}
                                                        {{/ifCond}}
                                                        <option value="{{id_sre}}" {{selected}}>{{firstname_usr}} {{lastname_usr}}</option>
                                                    {{/each}}
                                                </select>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea class="form-control" name="{{statusKeyword}}-detail" rows="2">{{previousEntry.log_detail_psl}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary save-status" data-status-id="11" data-status-keyword="{{statusKeyword}}" data-send-to-approvement="0">Guardar</button>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</script>

<script id="ht-status-approved-form-completed" type="text/x-handlebars-template">
    <div class="well">
        <h4>Este proyecto ha sido aprobado!</h4>
        <p>Para ingresar nueva informacion haga clic <a href="#" class="load-status-form-new-info" data-keyword="{{statusKeyword}}">aqui</a></p>
    </div>
</script>