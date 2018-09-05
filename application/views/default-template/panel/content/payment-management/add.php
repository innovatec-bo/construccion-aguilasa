<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 22:33
 */
?>
<div class="container-fluid">
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

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" method="post" name="user-add-form" data-parsley-validate>
                                <div class="form-group">
                                    <label>Numero de orden</label>
                                    <input class="form-control" required name="order-number" placeholder="Ingrese el numero de orden de pago de CRE" value="8154651385">
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary">Agregar proyecto</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Proyecto</th>
                                        <th>Importe diseño</th>
                                        <th>Importe de transporte</th>
                                        <th>Importe de construccion</th>
                                        <th>Importe de linea viva</th>
                                        <th class="text-center"><i class="fa fa-times"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><select class="form-control input-sm"><option>RA.8252.54</option></select></td>
                                        <td><input class="form-control input-sm" placeholder="Importe diseño" value="500"></td>
                                        <td><input class="form-control input-sm" placeholder="Importe transporte" value="500"></td>
                                        <td><input class="form-control input-sm" placeholder="Importe construccion" value="500"></td>
                                        <td><input class="form-control input-sm" placeholder="Importe linea viva" value="500"></td>
                                        <td class="text-center"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><select class="form-control input-sm"><option>RA.8252.55</option></select></td>
                                        <td><input class="form-control input-sm" placeholder="Importe diseño" value="500"></td>
                                        <td><input class="form-control input-sm" placeholder="Importe transporte" value="500"></td>
                                        <td><input class="form-control input-sm" placeholder="Importe construccion" value="500"></td>
                                        <td><input class="form-control input-sm" placeholder="Importe linea viva" value="500"></td>
                                        <td class="text-center"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><select class="form-control input-sm"><option>RA.8252.56</option></select></td>
                                        <td><input class="form-control input-sm" placeholder="Importe diseño" value="500"></td>
                                        <td><input class="form-control input-sm" placeholder="Importe transporte" value="500"></td>
                                        <td><input class="form-control input-sm" placeholder="Importe construccion" value="500"></td>
                                        <td><input class="form-control input-sm" placeholder="Importe linea viva" value="500"></td>
                                        <td class="text-center"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
