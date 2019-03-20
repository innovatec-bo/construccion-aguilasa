<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 22:33
 */
?>
<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Agregar orden de pago</h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Agregue la informacion de la orden de pago
                </div>

                <div class="panel-body" id="payment-order-form-content">
                    <form name="payment-order-add" method="post" data-parsley-validate>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Numero de orden</label>
                                    <input class="form-control input-masked" required name="order-number" placeholder="Ingrese el numero de orden de pago de CRE" value="" data-inputmask="'alias': 'integer'">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha de recepcion de numero de orden</label>
                                    <div class="input-group date date-time-picker">
                                        <input name="entry-date" readonly="" class="form-control" required="" data-parsley-errors-container="#error-entry-date">
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
                            <textarea class="form-control" name="detail" rows="2" placeholder=""></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary add-payment-order-project"><i class="fa fa-plus"></i> Incluir proyecto</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="table-payment-orders-projects">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary save-payment-order-project">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<?php
$this->load->view("default-template/panel/content/payment-management/ht-payment-orders-projects");
$this->load->view("default-template/panel/content/payment-management/ht-select2-project-response");
?>