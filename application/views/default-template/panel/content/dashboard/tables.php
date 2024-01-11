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
        <!-- <div class="col-md-6">
            <div class="panel panel-primary hide" id="panel-executive-summary-report">
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
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12" id="executive-summary-report">

                        </div>
                    </div>
                </div>
            </div>
        </div> -->
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
