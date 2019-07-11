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
            <div class="panel-body" style="overflow: auto; height: 50vh; position: relative; zoom: 1;" id="status-project-log-content" data-allow-update-history="1">
                <h6 class="quick-log-status-name">Fiscal 1<span class="pull-right edit-date" data-log-id="7631" data-status-name="Proyecto Creado">26-06-2019</span></h6>
                <blockquote>
                    <dl>
                        <dt>Constructores</dt>
                        <dd>Constructor 1, Constructor 2, Constructor 3</dd>
                        <dt>Structuras</dt>
                        <dd>
                            Structura 1<br>
                            Structura 2<br>
                            Structura 3<br>
                        </dd>
                    </dl>
                </blockquote>
                <h6 class="quick-log-status-name">Fiscal 2<span class="pull-right edit-date" data-log-id="7631" data-status-name="Proyecto Creado">26-06-2019</span></h6>
                <blockquote>
                    <dl>
                        <dt>Constructores</dt>
                        <dd>Constructor 1, Constructor 2, Constructor 3</dd>
                        <dt>Structuras</dt>
                        <dd>
                            Structura 1<br>
                            Structura 2<br>
                            Structura 3<br>
                        </dd>
                    </dl>
                </blockquote>
                <h6 class="quick-log-status-name">Fiscal 3<span class="pull-right edit-date" data-log-id="7631" data-status-name="Proyecto Creado">26-06-2019</span></h6>
                <blockquote>
                    <dl>
                        <dt>Constructores</dt>
                        <dd>Constructor 1, Constructor 2, Constructor 3</dd>
                        <dt>Structuras</dt>
                        <dd>
                            Structura 1<br>
                            Structura 2<br>
                            Structura 3<br>
                        </dd>
                    </dl>
                </blockquote>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
