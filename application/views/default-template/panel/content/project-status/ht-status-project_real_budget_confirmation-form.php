<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 20/08/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-status-project_real_budget_confirmation-form" type="text/x-handlebars-template">
    <div class="well">
        <h3>En espera a ser asignado a una orden de pago!</h3>
    </div>
</script>

<script id="ht-status-project_real_budget_confirmation-form-completed" type="text/x-handlebars-template">
    <div class="well">
        <h3>Este proyecto esta asignado a una orden de pago!</h3>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-slack fa-3x"></i>
                            </div>
                            <div class="col-md-9 text-right">
                                <div>Nro. Orden</div>
                                <div>{{previousEntry.order_number_pao}}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-qrcode fa-3x"></i>
                            </div>
                            <div class="col-md-9 text-right">
                                <div>Nro. Factura</div>
                                {{var "invoiceNumber" previousEntry.invoice_number_pao}}
                                {{#ifCond previousEntry.invoice_number_pao "==" null}}
                                    {{var "invoiceNumber" "Sin Definir"}}
                                {{/ifCond}}
                                <div>{{invoiceNumber}}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-calendar fa-3x"></i>
                            </div>
                            <div class="col-md-9 text-right">
                                <div>Fecha de Factura</div>
                                {{var "invoiceDate" previousEntry.invoice_date_pao}}
                                {{#ifCond previousEntry.invoice_date_pao "==" null}}
                                {{var "invoiceDate" "Sin Definir"}}
                                {{/ifCond}}
                                <div>{{invoiceDate}}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</script>