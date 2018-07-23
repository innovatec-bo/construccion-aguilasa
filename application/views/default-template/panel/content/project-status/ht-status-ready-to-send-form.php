<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 13/06/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-status-ready-to-send-form" type="text/x-handlebars-template">
    <div class="tab-pane active" role="tabpanel" id="step_ready_to_send">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Declarar envio de proyecto
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
                                                <input name="ready-to-send-entry-date" readonly="" class="form-control" required="" data-parsley-group="ready-to-send" data-parsley-errors-container="#error-ready-to-send-entry-date">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                            <div id="error-ready-to-send-entry-date"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea class="form-control" name="ready-to-send-detail" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary save-status" data-status-id="9" data-status-keyword="ready-to-send">Declara proyecto como enviado a CREE</button>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</script>