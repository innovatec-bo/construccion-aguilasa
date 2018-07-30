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
                Formulario de Dibujo new
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 status-content">
                        <div class="row">
                            <div class="col-md-12">
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
                                <div class="row form-inline">
                                    <div class="col-md-6">
                                        <label>Presupuesto</label><br>
                                        <div class="form-group">
                                            <em>Diseño</em><br>
                                            <input class="form-control" value="{{design_budget}}" name="design-budget" placeholder="Diseño" required="" data-parsley-type="number" data-parsley-group="{{statusKeyword}}">
                                        </div>
                                        <div class="form-group">
                                            <em>Construccion</em><br>
                                            <input class="form-control" value="{{building_budget}}" name="building-budget" placeholder="Construccion" data-parsley-type="number" required="" data-parsley-group="{{statusKeyword}}">
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
                                    <textarea class="form-control" name="{{statusKeyword}}-detail" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{var "sendToApprovement" "0"}}
                    {{var "buttonTitle" "Guardar"}}
                    {{#ifCond statusSet "==" "rectify_design"}}
                        {{var "sendToApprovement" "1"}}
                        {{var "buttonTitle" "Guardar y enviar a aprobacion"}}
                    {{/ifCond}}
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary save-status" data-status-id="5" data-status-keyword="{{statusKeyword}}" data-send-to-approvement="{{sendToApprovement}}">{{buttonTitle}}</button>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</script>

<script id="ht-status-approved-form-completed" type="text/x-handlebars-template">
    <div class="well">
        <h4>Ya se definio un responsable de dibujo para este proyecto!</h4>
        <p>Para ingresar nueva informacion haga clic <a href="javascript:void(0)" onclick="loadStatusForm('{{statusKeyword}}',1)">aqui</a></p>
    </div>
</script>