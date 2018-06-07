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
            <h1 class="page-header">Agregar proyecto</h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Informacion del proyecto
                </div>

                <div class="panel-body">
                    <form role="form" method="post" name="project-add-form" data-parsley-validate>
                        <input type="hidden" name="project-id" value="">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Codigo</label>
                                    <input class="form-control" required name="project-code" placeholder="Ingrese el codigo del proyecto">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre del proyecto</label>
                                    <input class="form-control" required name="project-name" placeholder="Ingrese nombre del proyecto">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha de ingreso</label>
                                    <input class="form-control date date-picker" required name="project-entry-date" placeholder="Fecha de ingreso del proyecto">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fiscal de CRE</label>
                                    <input class="form-control" required name="project-entry-date" placeholder="Fecha de ingreso del proyecto">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    <!-- /.row (nested) -->
                    </form>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
