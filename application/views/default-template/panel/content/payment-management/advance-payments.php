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
            <h1 class="page-header"><?=$viewTitle?></h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <a href="<?=base_url('Warehouse')?>" class="btn btn-primary">Ingresar anticipo</a>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="project-index" data-project-systems='<?=json_encode($projectSystems)?>' data-project-status='<?=$projectStatusJson?>'>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>PROYECTO</th>
                        <th>MONTO</th>
                        <th>NRO ANTICIPO</th>
                        <th>DETALLE</th>
                        <th>ACCIONES</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
