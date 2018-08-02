<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 13/06/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-status-stakes-form" type="text/x-handlebars-template">
    <div class="tab-pane active" role="tabpanel" id="step_stakes">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Formulario de Estaqueado
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 status-content">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha de asignacion</label>
                                    <div class="input-group date date-time-picker">
                                        <input name="stakes-team-entry-date" readonly="" required="" class="form-control" data-parsley-group="stakes" data-parsley-errors-container="#error-stakes-team-entry-date">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <div id="error-stakes-team-entry-date"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <label>Estaqueador(es) <a href="#" class="check-stakes-team"><i class="fa fa-question-circle"></i></a></label>
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
                    </div>
                </div>
                <div class="form-group">
                    <label>Observaciones</label>
                    <textarea class="form-control" name="stakes-detail" rows="2"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary save-status" data-status-id="2" data-status-keyword="stakes">Guardar</button>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</script>

<script id="ht-status-stakes-form-completed" type="text/x-handlebars-template">
    <div class="well">
        <h4>Ya se definieron responsables de estaqueado para este proyecto!</h4>
        <p>Para ingresar nueva informacion haga clic <a href="javascript:void(0)" onclick="loadStatusForm('{{statusKeyword}}',1)">aqui</a></p>
    </div>
</script>