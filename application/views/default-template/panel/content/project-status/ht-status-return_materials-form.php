<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 13/06/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-status-return_materials-form" type="text/x-handlebars-template">
    <div class="tab-pane active" role="tabpanel" id="step_{{statusKeyword}}">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Formulario de Devolucion de materiales a CRE
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
                        <button type="button" class="btn btn-primary save-status" data-status-id="26" data-status-keyword="{{statusKeyword}}">Guardar</button>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</script>

<script id="ht-status-return_materials-form-completed" type="text/x-handlebars-template">
    <div class="well">
        <h4>Ya se definio una fecha de devolucion de materiales a CRE!</h4>
        <p>Para ingresar nueva informacion haga clic <a href="javascript:void(0)" onclick="loadStatusForm('{{statusKeyword}}',1)">aqui</a></p>
    </div>
</script>