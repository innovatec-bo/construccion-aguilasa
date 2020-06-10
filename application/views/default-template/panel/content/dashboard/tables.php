<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 22:33
 */
?>
<div class="container-fluid box-shadow-2">
    <?php
    $this->load->view("default-template/panel/content/dashboard/heading");
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" id="panel-workflow-report">
                <div class="panel-heading">
                    <i class="fa fa-table fa-fw"></i> Workflow report
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12" id="workflow-report">
                            <form name="workflow-report" action="<?=base_url("panel/Project/getProjectWorkFlowReport")?>" method="post">
                                <input type="hidden" name="workflow-column-list" value='<?=json_encode($workflowColumnList)?>'>
                                <input type="hidden" name="columns-to-download" value=''>
                                <input type="hidden" name="override-list" value="0">
                                <div class="form-group input-group">
                                    <select class="form-control input-sm select2 tracking-list" name="tracking-list-id">
                                        <option value="" selected></option>
                                    </select>
                                    <span class="input-group-btn">
<!--                                        <button class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus"></i>-->
<!--                                        </button>-->
                                        <button class="btn btn-danger btn-sm delete-tracking-list" type="button"><i class="fa fa-trash"></i>
                                        </button>
<!--                                        <button class="btn btn-info btn-sm" type="button"><i class="fa fa-floppy-o"></i>-->
<!--                                        </button>-->
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label>Listas de seguimiento</label>
<!--                                    <select class="form-control input-sm select2 tracking-list" name="tracking-list-id">-->
<!--                                    </select>-->
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
                                    <button type="button" class="btn btn-primary">Descargar reporte</button>
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
        <div class="col-md-6">
            <div class="panel panel-primary" id="panel-current-status-summary-report">
                <div class="panel-heading">
                    <form name="report" action="<?=base_url("panel/Project/getCurrentStatusSummary")?>" method="post">
                        <i class="fa fa-table fa-fw"></i> Rep. Estados actuales
                        <select class="form-control input-sm" name="project-system">
                            <option value="">Sistemas</option>
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
                            <option value="">Administraciones</option>
                            <?php
                            $html = "";
                            foreach ($systemList as $key => $name)
                            {
                                $html .= '<option value="'.$key.'" >'.$name.'</option>';
                            }
                            echo $html;
                            ?>
                        </select>
                        <select class="form-control input-sm" name="contract-number">
                            <option value="">Contratos</option>
                            <?php
                            $html = "";
                            foreach ($contractList as $contract)
                            {
                                $html .= '<option value="'.$contract->id_con.'" >'.$contract->contract_number_con.'</option>';
                            }
                            echo $html;
                            ?>
                        </select>
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-download"></i></button>
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
        <div class="col-md-6">
            <div class="panel panel-primary" id="panel-executive-summary-report">
                <div class="panel-heading">
                    <form name="report" action="<?=base_url("panel/Project/getExecutiveSummaryReport")?>" method="post">
                        <i class="fa fa-table fa-fw"></i> Executive summary report
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-download fa-fw"></i></button>
                                <a href="<?=base_url("panel/Dashboard/executiveSummaryDifferential")?>" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-info fa-fw"></i></a>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12" id="executive-summary-report">

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
            <div class="panel panel-primary" id="panel-report-project-totals-table">
                <div class="panel-heading">
                    <i class="fa fa-table fa-fw"></i> Tabla de totales
                    <input name="report-year" readonly="" class="form-control input-sm date-time" size="4" required="">
                    <select class="form-control input-sm" name="data-type">
                        <option value="countId">Unidades</option>
                        <option value="sumBudget">Montos aprobados</option>
                    </select>
                    <select class="form-control input-sm" name="contract-number">
                        <option value="">Contratos</option>
                        <?php
                        $html = "";
                        foreach ($contractList as $contract)
                        {
                            $html .= '<option value="'.$contract->id_con.'" >'.$contract->contract_number_con.'</option>';
                        }
                        echo $html;
                        ?>
                    </select>
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
            <div class="panel panel-primary" id="panel-production-report">
                <div class="panel-heading">
                    <form name="report" action="<?=base_url("panel/Project/networksBuilding")?>" method="post">
                        <i class="fa fa-table fa-fw"></i> Reporte de Construccion
                        <select class="form-control input-sm" name="keyword">
                            <option value="project_has_been_created">Ingresados</option>
                            <option value="already_sent">Diseñados</option>
                            <option value="approved">Aprobados</option>
                            <option value="completed">Construidos</option>
                            <option value="as_built">As Built</option>
                            <option value="conciliation_shipment">Conciliados</option>
                            <option value="project_real_budget_confirmation">Con # orden</option>
                        </select>
                        <input name="building-report-year" readonly="" class="form-control input-sm date-time" size="4" required="">
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
$this->load->view('default-template/panel/content/dashboard/ht-report-executive-summary');
$this->load->view('default-template/panel/content/dashboard/ht-workflow-report-columns-to-download');
?>