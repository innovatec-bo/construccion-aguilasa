<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 13/06/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-status-drawing-form" type="text/x-handlebars-template">
    <div class="tab-pane active" role="tabpanel" id="step_drawing">
        <div class="panel panel-default">
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
                                                <input name="drawing-entry-date" readonly="" class="form-control" required="" data-parsley-group="drawing" data-parsley-errors-container="#error-drawing-entry-date">
                                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                            </div>
                                            <div id="error-drawing-entry-date"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea class="form-control" name="drawing-detail" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <button type="button" class="btn btn-primary save-status" data-status-id="5" data-status-keyword="drawing">Guardar</button>

                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</script>