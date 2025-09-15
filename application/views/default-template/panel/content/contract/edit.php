<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Editar contrato</h1>
        </div>
        <div class="col-md-12">
            <?php

use Carbon\Carbon;

            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Editar la informaci&oacute;n del contrato
                </div>

                <div class="panel-body">
                    <div class="row">
                        <form role="form" method="post" name="user-add-form" data-parsley-validate>
                            <div class="col-lg-12">
                                <input type="hidden" name="number" value="">
                                <div class="form-group">
                                    <label>N&uacute;mero</label>
                                    <input class="form-control" required name="number" value="<?=set_value("number",$contract['contract_number_con'])?>" placeholder="N&uacute;mero de contrato">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Monto</label>
                                    <input class="form-control" required name="amount" value="<?=set_value("amount",$contract['amount_con'])?>" data-parsley-type="number" placeholder="Monto del contrato">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Desde</label>
                                    <div class="input-group date date-time-picker">
                                        <input name="start-date" value="<?=$startDate?>" readonly="" class="form-control input-date" required="" data-parsley-errors-container="#error-start-date">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <div id="error-start-date"></div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Hasta</label>
                                    <div class="input-group date date-time-picker">
                                        <input name="end-date" value="<?=$expirationDate?>" readonly="" class="form-control input-date" required="" data-parsley-errors-container="#error-end-date">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <div id="error-end-date"></div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>UMBO</label>
                                    <input type="text"  data-parsley-type="number" class="form-control" required name="UMBO" value="<?=set_value("UMBO", $contract['umbo'])?>" placeholder="UMBO">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <em style="display:block">Si establece este contrato como activo, cualquier otro que haya estado activo, dejara de estarlo</em>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="active" value="1" <?=$contract['active']==1?'checked':''?>><strong>Activo</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <button type="button" class="btn btn-secondary" onclick="window.location.href='<?php echo base_url('panel/Contract'); ?>'">Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
