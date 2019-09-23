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
            <h1 class="page-header">Mano de obra
                <em class="subtext"><?=$project['code_pro']?></em>
            </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="col-md-12">
        <?php
        $this->load->view("default-template/flash-data-basic-messages");
        ?>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-offset-2 col-sm-8">
            <ul class="event-list">
                <li>
                    <div class="info">
                        <h2 class="title">CAM2/02/0M</h2>
                        <p class="desc">ENSAMBLE SECUNDARIO 1F Ó 3F PREEN. DOBLE TENSION BT</p>
                        <ul>
                            <li style="width:25%;"><span class="fa fa-globe"></span> Santa cruz</li>
                            <li style="width:25%;"><span class="fa fa-money"></span> $39.99</li>
                            <li style="width:25%;"><span class="fa fa-signal"></span> 18</li>
                            <li style="width:25%;"><span class="fa fa-folder"></span> RD.19.0245</li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <div class="table-responsive" id="manpower-table">

        </div>
    </div>
    <div class="col-md-3" id="history-content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Historial de avance
                <div class="pull-right">
                    <div class="btn-group">
                        <a href="<?=base_url()?>" class="btn btn-default btn-xs download-manpower-progress"><i class="fa fa-download fa-fw"></i></a>
                        <button type="button" class="btn btn-default btn-xs add-manpower-progress"><i class="fa fa-plus fa-fw"></i></button>
                    </div>
                </div>
            </div>
            <div class="panel-body" style="overflow-y: scroll; height: 50vh;/* position: relative*/; zoom: 1;" id="status-project-log-content">
                Cargando historial..
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
