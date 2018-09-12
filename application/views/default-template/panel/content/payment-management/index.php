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
            <h1 class="page-header"><?=$viewTitle?></h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>

        <div class="col-md-12 hide">
            <input type="hidden" name="status-set" value="<?=$statusSet?>">
            <form class="form-group" id="extra-request-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="radio-inline">
                                <input name="status" value="<?=$status?>">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary input-sm" id="send-filters" type="button" data-content-data="chart-property-offers-based-on-property-types">Filtrar</button>
                    <button class="btn btn-danger input-sm" id="remove-additional-parameters" type="button" data-content-data="chart-property-offers-based-on-property-types">Remove parametros adicionales</button>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="project-index" data-project-systems='<?=json_encode($projectSystems)?>' data-project-status='<?=$projectStatusJson?>'>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>NRO ORDEN</th>
                        <th>ESTADO</th>
                        <th>NRO FACTURA</th>
                        <th>FECHA DE RECEPCION</th>
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
