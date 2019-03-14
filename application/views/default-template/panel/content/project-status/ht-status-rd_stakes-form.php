<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 13/06/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-status-rd_stakes-form" type="text/x-handlebars-template">
    <div class="tab-pane active" role="tabpanel" id="step_{{statusKeyword}}">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Estaqueado por rectificacion de diseño
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 status-content">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha de asignacion</label>
                                    <div class="input-group date date-time-picker">
                                        <input name="{{statusKeyword}}-entry-date" readonly="" required="" class="form-control" data-parsley-group="{{statusKeyword}}" data-parsley-errors-container="#error-{{statusKeyword}}-team-entry-date">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <div id="error-{{statusKeyword}}-team-entry-date"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <label>Estaqueador(es) <a href="#" class="check-{{statusKeyword}}-team"><i class="fa fa-question-circle"></i></a></label>
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
                    <textarea class="form-control" name="{{statusKeyword}}-detail" rows="2"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary save-status" data-status-id="15" data-status-keyword="{{statusKeyword}}">Guardar</button>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</script>

<script id="ht-status-rd_stakes-form-completed" type="text/x-handlebars-template">
    <div class="well">
        <h4>Ya se definieron responsables de estaqueado(rectificacion de diseño) para este proyecto!</h4>
        <p>Para ingresar nueva informacion haga clic <a href="#" class="load-status-form-new-info" data-keyword="{{statusKeyword}}">aqui</a></p>
    </div>
</script>