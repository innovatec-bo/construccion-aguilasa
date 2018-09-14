<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 13/09/2018
 * Time: 12:15 PM
 */
?>
<script id="ht-status-payment_order_has_been_settled-form" type="text/x-handlebars-template">
    <div class="tab-pane active" role="tabpanel" id="step_payment_order_has_been_settled">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Confirmacion de pago
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 status-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha de confirmacion de pago</label>
                                            <div class="input-group date date-time-picker">
                                                <input name="entry-date" readonly="" class="form-control" required="" data-parsley-group="payment_order_has_been_settled" data-parsley-errors-container="#error-entry-date">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                            <div id="error-entry-date"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea class="form-control" name="detail" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary save-status" data-status-id="44" data-status-keyword="payment_order_has_been_settled">Guardar</button>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</script>

<script id="ht-status-payment_order_has_been_settled-form-completed" type="text/x-handlebars-template">
    <div class="well">
        <h4>Esta orden de pago ha sido liquidada!</h4>
    </div>
</script>