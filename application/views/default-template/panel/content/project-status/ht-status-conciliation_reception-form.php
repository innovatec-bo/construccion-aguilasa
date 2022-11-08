<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 20/08/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-status-conciliation_reception-form" type="text/x-handlebars-template">
    <div class="tab-pane active" role="tabpanel" id="step_{{statusKeyword}}">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Registrar recepcion de conciliacion
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 status-content">
                        <div class="row">
                            <div class='col-md-5'>
                                <div class='row'>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Fecha de recepcion</label>
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
                                        <div class="row hide">
                                            <div class="col-md-6">
                                                <fieldset>
                                                    <label>Responsable(s) <a href="#" class="check-stakes-team"><i class="fa fa-question-circle"></i></a></label>
                                                    <div class="form-group">
                                                        <select class="form-control" multiple="multiple" data-parsley-required="" parsley-trigger="change" id="ajax-get-responsible-list">
                                                            {{#each assignmentResponsible}}
                                                            <option value="{{id}}" selected>{{name}}</option>
                                                            {{/each}}
                                                        </select>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <fieldset>
                                                    <label>Responsables de construccion</label><br>
                                                    {{#each assignmentResponsible}}
                                                    {{name}}<br>
                                                    {{/each}}
                                                </fieldset>
                                            </div>
                                        </div>
                                        <!-- Begin manpower load -->
                                        {{#ifCond previousEntry.manpower_file_id_prb "==" null}}
                                            {{var "buttonText" "Cargar mano de obra"}}
                                            {{var "buttonTextPointToPoint" "Cargar punto a punto"}}
                                            {{#ifCond previousEntry.id_prb "==" null}}
                                                {{var "buttonText" "Revisar mano de obra"}}
                                                {{var "buttonTextPointToPoint" "Revisar punto a punto"}}
                                            {{/ifCond}}
                                            <div class="form-group input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary extract-construction-approved-budgets btn-xs" data-form-name="status-management" data-save-in-system="0" type="button">{{buttonText}}
                                                    </button>
                                                </span>
                                                <input type="file" name="manpower-file" accept=".xlsx, .xls, .csv">
                                            </div>
                                        {{/ifCond}}
                                        <input type="hidden" name="project-construction-budget-id" value="{{previousEntry.id_prb}}">
                                        <input type="hidden" name="manpower-construction-file-id" value="{{previousEntry.manpower_file_id_prb}}">
                                        <div class="row form-inline">
                                            <div class="col-md-12">
                                                <label>Importe (<span id="total-project-amount">0.00</span>)</label><br>
                                                <div class="form-group">
                                                    <em>Diseño</em><br>
                                                    <input class="form-control input-masked" readonly value="{{previousEntry.design_reb}}" name="design-budget" placeholder="Diseño" required="" data-parsley-group="{{statusKeyword}}" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                                </div>
                                                <div class="form-group">
                                                    <em>Construccion</em><br>
                                                    <input class="form-control input-masked" readonly value="{{previousEntry.building_reb}}" name="building-budget" placeholder="Construccion" required="" data-parsley-group="{{statusKeyword}}" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                                </div>
                                                <div class="form-group">
                                                    <em>Transporte</em><br>
                                                    <input class="form-control input-masked" readonly value="{{previousEntry.transportation_reb}}" name="transportation-budget" placeholder="Transporte" required="" data-parsley-group="{{statusKeyword}}" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                                </div>
                                                <div class="form-group">
                                                    <em>Linea viva</em><br>
                                                    <input class="form-control input-masked" readonly value="{{previousEntry.live_line_reb}}" name="live-line-budget" placeholder="Linea viva" required="" data-parsley-group="{{statusKeyword}}" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                                </div>
                                                <div class="form-group">
                                                    <em>Derecho de via</em><br>
                                                    <input class="form-control input-masked" readonly value="{{previousEntry.right_of_way_reb}}" name="right-of-way-budget" placeholder="Derecho de via" required="" data-parsley-group="{{statusKeyword}}" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End manpower load -->
                                        <div class="form-group">
                                            <label>Observaciones</label>
                                            <textarea class="form-control" name="{{statusKeyword}}-detail" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-7'>
                                <div class="alert alert-info">                                    
                                    <strong>Imagenes:</strong> Dimensiones maximas 5000X5000 pixeles y peso maximo 5MB.<br>
                                    <strong>Documentos:</strong> Peso maximo 5MB.
                                </div>
                                <div class="well dropzone" id='dropzone'>
                                    <!-- <h4 class='text-center'>Arrastre archivos aqui<br>o<br>haga clic para cargarlos</h4> -->
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary save-status" data-status-id="34" data-status-keyword="{{statusKeyword}}">Guardar</button>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</script>

<script id="ht-status-conciliation_reception-form-completed" type="text/x-handlebars-template">
    <div class="well">
        <h4>Se registro la recepcion de conciliacion de CRE!</h4>
        <p>Para ingresar nueva informacion haga clic <a href="#" class="load-status-form-new-info" data-keyword="{{statusKeyword}}">aqui</a></p>
    </div>
</script>