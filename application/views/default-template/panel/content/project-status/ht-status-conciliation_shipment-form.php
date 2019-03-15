<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 20/08/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-status-conciliation_shipment-form" type="text/x-handlebars-template">
    <div class="tab-pane active" role="tabpanel" id="step_{{statusKeyword}}">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Registrar envio de conciliacion a CRE
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 status-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha de envio</label>
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset>
                                            <label>Responsables de construccion</label><br>
                                            {{#each assignmentResponsible}}
                                            {{name}}<br>
                                            {{/each}}
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row form-inline">
                                    <div class="col-md-6">
                                        <label>Importe (<span id="total-project-amount">0.00</span>)</label><br>
                                        <div class="form-group">
                                            <em>Diseño</em><br>
                                            <input class="form-control input-masked" value="{{previousEntry.design_reb}}" name="design-budget" placeholder="Diseño" required="" data-parsley-group="{{statusKeyword}}" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                        </div>
                                        <div class="form-group">
                                            <em>Construccion</em><br>
                                            <input class="form-control input-masked" value="{{previousEntry.building_reb}}" name="building-budget" placeholder="Construccion" required="" data-parsley-group="{{statusKeyword}}" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                        </div>
                                        <div class="form-group">
                                            <em>Transporte</em><br>
                                            <input class="form-control input-masked" value="{{previousEntry.transportation_reb}}" name="transportation-budget" placeholder="Transporte" required="" data-parsley-group="{{statusKeyword}}" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                        </div>
                                        <div class="form-group">
                                            <em>Linea viva</em><br>
                                            <input class="form-control input-masked" value="{{previousEntry.live_line_reb}}" name="live-line-budget" placeholder="Linea viva" required="" data-parsley-group="{{statusKeyword}}" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                        </div>
                                        <div class="form-group">
                                            <em>Derecho de via</em><br>
                                            <input class="form-control input-masked" value="{{previousEntry.right_of_way_reb}}" name="right-of-way-budget" placeholder="Derecho de via" required="" data-parsley-group="{{statusKeyword}}" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea class="form-control" name="{{statusKeyword}}-detail" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary save-status" data-status-id="35" data-status-keyword="{{statusKeyword}}">Guardar</button>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</script>

<script id="ht-status-conciliation_shipment-form-completed" type="text/x-handlebars-template">
    <div class="well">
        <h4>Se registro envio de la conciliacion a CRE!</h4>
        <p>Para ingresar nueva informacion haga clic <a href="#" class="load-status-form-new-info" data-keyword="{{statusKeyword}}">aqui</a></p>
    </div>
</script>