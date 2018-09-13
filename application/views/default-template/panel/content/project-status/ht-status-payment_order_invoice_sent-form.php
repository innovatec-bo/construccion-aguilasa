<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 13/09/2018
 * Time: 12:15 PM
 */
?>
<script id="ht-status-payment_order_invoice_sent-form" type="text/x-handlebars-template">
    <div class="tab-pane active" role="tabpanel" id="step_schedule">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Formulario de Cronograma
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 status-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha de envio a CRE</label>
                                            <div class="input-group date date-time-picker">
                                                <input name="schedule-entry-date" readonly="" class="form-control" required="" data-parsley-group="schedule" data-parsley-errors-container="#error-schedule-entry-date">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                            <div id="error-schedule-entry-date"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha de facturacion</label>
                                            <div class="input-group date date-time-picker">
                                                <input name="project-start" readonly="" class="form-control" required="" data-parsley-group="schedule" data-parsley-errors-container="#error-project-start">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                            <div id="error-project-start"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea class="form-control" name="schedule-detail" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary save-status" data-status-id="43" data-status-keyword="schedule">Guardar y enviar a aprobacion</button>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</script>

<script id="ht-status-payment_order_invoice_sent-form-completed" type="text/x-handlebars-template">
    <div class="well">
        <h4>Esta orden de pago se ha asociado a un numero de factura que ya ha sido enviado a CRE!</h4>
    </div>
</script>