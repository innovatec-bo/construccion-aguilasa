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
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><span id="dashboard-total-users"></span></div>
                            <div>Users!</div>
                        </div>
                    </div>
                </div>
                <a href="<?=base_url("panel/User")?>">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><span id="dashboard-total-roles"></span></div>
                            <div>Roles!</div>
                        </div>
                    </div>
                </div>
                <a href="<?=base_url("panel/Role")?>">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-table fa-fw"></i> Tabla de totales
                    <input name="report-year" readonly="" class="form-control input-sm date-time" size="1" required="">
                    <div class="pull-right">
                        <div class="btn-group">
                            <form name="report" action="<?=base_url("panel/Project/getProjectWorkFlowReport")?>" method="post">
                                <button type="submit" class="btn btn-default btn-xs">Descargar workflow</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12" id="report-project-totals-table">
                            Here goes the report project totals table
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.col-lg-4 (nested) -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-table fa-fw"></i> Reporte de Construccion
                    <input name="building-report-year" readonly="" class="form-control input-sm date-time" size="1" required="">
<!--                    <div class="form-group">-->
                        <select class="form-control input-sm" name="criteria">
                            <option>Ingresado</option>
                            <option>Diseñado</option>
                            <option>Aprobado</option>
                            <option>Contruido</option>
                            <option>Conciliado</option>
                            <option>Con # orden</option>
                        </select>
<!--                    </div>-->
                    <div class="pull-right">
                        <div class="btn-group">
                            <form name="report" action="<?=base_url("panel/Project/getProjectWorkFlowReport")?>" method="post">
                                <button type="submit" class="btn btn-default btn-xs">Descargar reporte</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12" id="net-building-report">
                            Here goes the report project totals table
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.col-lg-4 (nested) -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>
    <!-- /.row -->
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<?php
$this->load->view('default-template/panel/content/dashboard/ht-report-project-totals-table');
$this->load->view('default-template/panel/content/dashboard/ht-report-net-building-table');
?>