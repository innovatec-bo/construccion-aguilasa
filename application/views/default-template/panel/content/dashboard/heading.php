<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 22:33
 */
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Dashboard
            <?php
            switch($view)
            {
                case "tables":
                    $tablesActive = "active";
                    $chartsActive = "";
                    $tablesUrl = "#";
                    $chartsUrl = base_url("panel/Dashboard/charts");
                    break;
                case "charts":
                    $tablesActive = "";
                    $chartsActive = "active";
                    $tablesUrl = base_url("panel/Dashboard/tables");
                    $chartsUrl = "#";
                    break;
                default:
            }
            ?>
            <ul class="nav nav-pills dashboard-navigation">
                <li class="<?=$chartsActive?>">
                    <a class='p-0' href="<?=$chartsUrl?>">
                        <?php
                        $timthumbUrl = base_url("timthumb/timthumb.php");
                        $imageUrl = assets_url("images/flaticon/analysis.png");
                        $imageSrc = $timthumbUrl."?src=".$imageUrl."&h=30";
                        ?>
                        <img src="<?=$imageSrc?>" style='padding-top: 4px;padding-bottom: 0px;padding-right: 0px;padding-left: 4px;'>
                    </a>
                </li>
                <li class="<?=$tablesActive?>">
                    <a class='p-0' href="<?=$tablesUrl?>">
                        <?php
                        $timthumbUrl = base_url("timthumb/timthumb.php");
                        $imageUrl = assets_url("images/flaticon/frequency.png");
                        $imageSrc = $timthumbUrl."?src=".$imageUrl."&h=30";
                        ?>
                        <img src="<?=$imageSrc?>" style='padding-top: 4px;padding-bottom: 0px;padding-right: 0px;padding-left: 4px;'>
                    </a>
                </li>
            </ul>
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
                        <?php
                        $timthumbUrl = base_url("timthumb/timthumb.php");
                        $imageUrl = assets_url("images/flaticon/business-and-finance.png");
                        $imageSrc = $timthumbUrl."?src=".$imageUrl."&h=76";
                        ?>
                        <img src="<?=$imageSrc?>" style='filter: invert(100%);'>
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
                        <?php
                        $timthumbUrl = base_url("timthumb/timthumb.php");
                        $imageUrl = assets_url("images/flaticon/money.png");
                        $imageSrc = $timthumbUrl."?src=".$imageUrl."&h=76";
                        ?>
                        <img src="<?=$imageSrc?>" style='filter: invert(100%);'>
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
                        <?php
                        $timthumbUrl = base_url("timthumb/timthumb.php");
                        $imageUrl = assets_url("images/flaticon/deadline.png");
                        $imageSrc = $timthumbUrl."?src=".$imageUrl."&h=76";
                        ?>
                        <img src="<?=$imageSrc?>" style='filter: invert(100%);'>
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
                        <?php
                        $timthumbUrl = base_url("timthumb/timthumb.php");
                        $imageUrl = assets_url("images/flaticon/balance.png");
                        $imageSrc = $timthumbUrl."?src=".$imageUrl."&h=76";
                        ?>
                        <img src="<?=$imageSrc?>" style='filter: invert(100%);'>
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
<div class="row">
    <div class="col-lg-3 col-md-6">
        <form class="form-inline builder-general-report" method="post">
            <div class="panel panel-primary" id="panel-days-progress-chart">
                <div class="panel-heading">
                    Reporte general
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <div class="form-group">
                                <select class="form-control input-sm" name="builder-general-report-month">
                                    <option value="">Mes</option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>    
                            </div>
                            <div class="form-group">
                                <select class="form-control input-sm" name="builder-general-report-year">
                                    <option value="">A&ntilde;o</option>
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                </select>    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer p-0">
                    <button type="submit" class="btn btn-info btn-xs btn-block p-1"><i class="fa fa-download fa-fw"></i>Descargar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-lg-6 col-md-6">
        <form class="form-inline builder-manpower-productivity-report" method="post">
            <div class="panel panel-primary" id="panel-days-progress-chart">
                <div class="panel-heading">
                    Reporte de productividad
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <div class="form-group">
                                <select class="form-control input-sm" name="builder-productivity-report-builder">
                                    <option value="">Constructor</option>
                                    <?php
                                    $html = "";
                                    foreach ($builderList as $builder)
                                    {
                                        $html .= '<option value="'.$builder->getId().'" >'.$builder->getFullName().'</option>';
                                    }
                                    echo $html;
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control input-sm" name="builder-productivity-report-month">
                                    <option value="">Mes</option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>    
                            </div>
                            <div class="form-group">
                                <select class="form-control input-sm" name="builder-productivity-report-year">
                                    <option value="">A&ntilde;o</option>
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                </select>    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer p-0">
                    <button type="submit" class="btn btn-info btn-xs btn-block p-1"><i class="fa fa-download fa-fw"></i>Descargar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-lg-3 col-md-6">
        <form class="form-inline projects-and-current-production" method="post">
            <div class="panel panel-primary" id="panel-days-progress-chart">
                <div class="panel-heading">
                    Costo y producci&oacute;n
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <div class="form-group">
                                <select class="form-control input-sm" name="projects-and-current-production-month">
                                    <option value="">Mes</option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>    
                            </div>
                            <div class="form-group">
                                <select class="form-control input-sm" name="projects-and-current-production-year">
                                    <option value="">A&ntilde;o</option>
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                </select>    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer p-0">
                    <button type="submit" class="btn btn-info btn-xs btn-block p-1"><i class="fa fa-download fa-fw"></i>Descargar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" id="">
            <div class="panel-heading">
                <form class="form-inline stake-report-inline-form" action="<?=base_url("panel/Project/getStakeReport")?>" method="post">
                    <i class="fa fa-file-excel-o fa-fw"></i> Reporte de estaqueado
                    <div class="form-group">
                        <label class="sr-only input-sm" for="exampleInputEmail3">Desde</label>
                        <input type="text" class="form-control input-sm date-time-stake-report" name="stake-report-from">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control input-sm date-time-stake-report" name="stake-report-to">
                    </div>
                    <button type="submit" class="btn btn-default btn-xs">Descargar</button>
                </form>
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
<div class="row">
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
