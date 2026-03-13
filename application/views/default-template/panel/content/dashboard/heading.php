<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 22:33
 */
$monthList = array(
		"01" => "Enero",
		"02" => "Febrero",
		"03" => "Marzo",
		"04" => "Abril",
		"05" => "Mayo",
		"06" => "Junio",
		"07" => "Julio",
		"08" => "Agosto",
		"09" => "Septiembre",
		"10" => "Octubre",
		"11" => "Noviembre",
		"12" => "Diciembre"
);
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Dashboard - 
            <?php
            switch($view)
            {
                case "tables":
                    $tablesActive = "active";
                    $chartsActive = "";
                    $tablesUrl = "#";
                    $chartsUrl = base_url("panel/Dashboard/charts");
                    $title = "Tablas";
                    break;
                case "charts":
                    $tablesActive = "";
                    $chartsActive = "active";
                    $tablesUrl = base_url("panel/Dashboard/tables");
                    $chartsUrl = "#";
                    $title = "Graficos";
                    break;
                case 'executiveSummaryDifferential':
                    $title = "Diferencial de resumen ejecutivo";
                case 'reports':
                    $title = "Reportes descargables";
            }
            ?>
            <?=$title?>
        </h1>
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
                        <img src="<?=assets_url("images/flaticon/business-and-finance.png")?>" style='filter: invert(100%);height:76px'>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><span id="dashboard-total-projects"><i class="fa fa-spinner fa-pulse fa-fw"></i></span></div>
                        <div>Proyectos!</div>
                    </div>
                </div>
            </div>
            <a href="<?=base_url("panel/Project")?>">
                <div class="panel-footer">
                    <span class="pull-left">Ver detalles</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary" id="panel-serebo-thermometer-chart">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <img src="<?=assets_url("images/flaticon/money.png")?>" style='filter: invert(100%);height:76px'>
                    </div>
                    <div class="col-xs-9 text-right" id="serebo-thermometer-chart-content"  style="height: 76px">
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">
                    Ejecutado
                </span>
                <span class="pull-right">
                    <select class="form-control input-sm" name="stage" style="width: 90px">
                        <option value="total">Total</option>
                        <option value="inProgress">Contruccion</option>
                        <option value="closure">Cierre</option>
                        <option value="closed">Cerrado</option>
                    </select>
                </span>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary" id="panel-days-progress-chart">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <img src="<?=assets_url("images/flaticon/deadline.png")?>" style='filter: invert(100%);height:76px'>
                    </div>
                    <div class="col-xs-9 text-right" id="days-progress-chart-content"  style="height: 76px">
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">
                    Tiempo seg&uacute;n contrato
                </span>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <img src="<?=assets_url("images/flaticon/balance.png")?>" style='filter: invert(100%);height:76px'>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h4><span id="dashboard-total-amount-worked"><i class="fa fa-spinner fa-pulse fa-fw"></i></span></h4>
                        <div><span id="dashboard-total-quantity-projects-worked"></span> proyectos!</div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">
                    Producci&oacute;n de <span id="dashboard-amount-worked-month"></span>
                </span>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" id="">
            <div class="panel-heading">
                <form class="form-inline builder-report-inline-form" action="<?=base_url("panel/Project/getBuilderReport")?>" method="post">
                    <i class="fa fa-file-excel-o fa-fw"></i> Reporte de fiscales y constructores
                    <div class="form-group">
                        <input type="text" class="form-control input-sm date-time-builder-report" name="builder-report-from">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control input-sm date-time-builder-report" name="builder-report-to">
                    </div>
                    <button type="submit" class="btn btn-default btn-xs">Descargar</button>
                </form>
            </div>
        </div>
    </div>
</div> -->
<div class="row hidden">
    <div class="col-md-12">
        <div class="panel panel-primary" id="panel-main-report-control-filter">
            <div class="panel-heading">
                <i class="fa fa-cogs fa-fw"></i> Control Principal
                <input name="report-year" readonly="" class="form-control input-sm date-time-default-blank" size="1" required="">
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
            </div>
            <!-- /.panel-heading -->
        </div>
    </div>
</div>
<form name="workflow-with-parameters" action="<?=base_url("panel/Project/downloadWorkflowWithParameters")?>" method="post">
    <input type="hidden" name="status-keyword" value="">
    <input type="hidden" name="keyword" value="">
    <input type="hidden" name="year" value="">
    <input type="hidden" name="month" value="">
    <input type="hidden" name="rowKey" value="">
    <input type="hidden" name="contract-id" value="">
</form>
