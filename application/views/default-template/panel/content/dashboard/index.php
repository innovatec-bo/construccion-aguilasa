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
                            <div class="huge"><span id="dashboard-total-users"><i class="fa fa-spinner fa-pulse fa-fw"></i></span></div>
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
                            <div class="huge"><span id="dashboard-total-roles"><i class="fa fa-spinner fa-pulse fa-fw"></i></span></div>
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
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-folder fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><span id="dashboard-total-projects"><i class="fa fa-spinner fa-pulse fa-fw"></i></span></div>
                            <div>Projects!</div>
                        </div>
                    </div>
                </div>
                <a href="<?=base_url("panel/Project")?>">
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
            <div class="panel panel-default" id="panel-workflow-report">
                <div class="panel-heading">
                    <i class="fa fa-table fa-fw"></i> Workflow report
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12" id="workflow-report">
                            <form name="workflow-report" action="<?=base_url("panel/Project/getProjectWorkFlowReport")?>" method="post">
                                <div class="form-group">
                                    <label>Listas de seguimiento</label>
                                    <select class="form-control input-sm select2 tracking-list" name="tracking-list-id">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pegue aqui los Proyectos(Códigos) que para que sean exportados en el reporte.<br><em>Los códigos deben estar separados por un espacio.</em></label>
                                    <textarea name="code-list" class="form-control" rows="3" placeholder="Este campo no es obligatorio"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Acciones adicionales</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="workflow-additional-actions" id="workflow-additional-actions1" value="1">Guardar como nueva lista de seguimiento
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="workflow-additional-actions" id="workflow-additional-actions2" value="2">Actualizar lista de seguimiento
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="workflow-additional-actions" id="workflow-additional-actions3" value="3" checked>Ninguna
                                        </label>
                                    </div>
                                    <div class="form-group" style="display: none">
                                        <label>Nombre de la nueva lista de seguimiento</label>
                                        <input class="form-control" name="tracking-list-name" placeholder="Ingrese un nombre para su lista de seguimiento">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Descargar reporte</button>
                                </div>
                            </form>
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
            <div class="panel panel-default" id="panel-current-status-summary-report">
                <div class="panel-heading">
                    <form name="report" action="<?=base_url("panel/Project/getCurrentStatusSummary")?>" method="post">
                        <i class="fa fa-table fa-fw"></i> Reporte de estados actuales
                        <select class="form-control input-sm" name="project-system">
                            <option value="">Todos los sistemas</option>
                            <?php
                            $html = "";
                            foreach ($systemList as $key => $name)
                            {
                                $html .= '<option value="'.$key.'" >'.$name.'</option>';
                            }
                            echo $html;
                            ?>
                        </select>
                        <select class="form-control input-sm" name="management-by">
                            <option value="">Todas las administraciones</option>
                            <?php
                            $html = "";
                            foreach ($systemList as $key => $name)
                            {
                                $html .= '<option value="'.$key.'" >'.$name.'</option>';
                            }
                            echo $html;
                            ?>
                        </select>
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-default btn-xs">Descargar reporte</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12" id="current-status-summary-report">
                            Here goes the current status report table
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
                    <i class="fa fa-table fa-fw"></i> Tabla de totales
                    <input name="report-year" readonly="" class="form-control input-sm date-time" size="1" required="">
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
                    <form name="report" action="<?=base_url("panel/Project/networksBuilding")?>" method="post">
                        <i class="fa fa-table fa-fw"></i> Reporte de Construccion
                        <select class="form-control input-sm" name="keyword">
                            <option value="project_has_been_created">Ingresados</option>
                            <option value="already_sent">Diseñados</option>
                            <option value="approved">Aprobados</option>
                            <option value="as_built">Contruidos</option>
                            <option value="conciliation_shipment">Conciliados</option>
                            <option value="project_real_budget_confirmation">Con # orden</option>
                        </select>
                        <input name="building-report-year" readonly="" class="form-control input-sm date-time" size="1" required="">
                        <div class="pull-right">
                            <div class="btn-group">
                                    <button type="submit" class="btn btn-default btn-xs">Descargar reporte</button>
                            </div>
                        </div>
                    </form>
                    <form name="workflow-with-parameters" action="<?=base_url("panel/Project/downloadWorkflowWithParameters")?>" method="post">
                        <input type="hidden" name="keyword" value="">
                        <input type="hidden" name="year" value="">
                        <input type="hidden" name="month" value="">
                        <input type="hidden" name="rowKey" value="">
                    </form>
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
$this->load->view('default-template/panel/content/dashboard/ht-report-current-status-summary');

?>