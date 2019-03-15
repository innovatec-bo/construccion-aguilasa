<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 20/08/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-status-as_built-form" type="text/x-handlebars-template">
    <div class="tab-pane active" role="tabpanel" id="step_{{statusKeyword}}">
        <div class="panel panel-primary">
            <div class="panel-heading">
                As built
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 status-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha de inicio de as built</label>
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
                                        <label>Area del proyecto</label><br>
                                        <div class="form-group">
                                            <em>Puntos</em><br>
                                            <input class="form-control" value="{{points}}" name="project-points" placeholder="Puntos" required="" data-parsley-type="integer" data-parsley-group="{{statusKeyword}}">
                                        </div>
                                        <div class="form-group">
                                            <em>Distancia Km</em><br>
                                            <input class="form-control" value="{{distance}}" name="project-meters-distance" placeholder="Distancia" data-parsley-type="number" required="" data-parsley-group="{{statusKeyword}}">
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
                        <button type="button" class="btn btn-primary save-status" data-status-id="33" data-status-keyword="{{statusKeyword}}">Guardar</button>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</script>

<script id="ht-status-as_built-form-completed" type="text/x-handlebars-template">
    <div class="well">
        <h4>Se esta realizando el As built!</h4>
        <p>Para ingresar nueva informacion haga clic <a href="#" class="load-status-form-new-info" data-keyword="{{statusKeyword}}">aqui</a></p>
    </div>
</script>