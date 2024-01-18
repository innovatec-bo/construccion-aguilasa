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
<div class="container-fluid box-shadow-2">
    <?php
    $this->load->view("default-template/panel/content/dashboard/heading");
    ?>
    <!-- <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" id="">
                <div class="panel-heading">
                    <form class="form-inline stake-report-inline-form" action="<?= base_url("panel/Project/getStakeReport") ?>" method="post">
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
    </div> -->
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary" id="panel-workflow-report">
                <div class="panel-heading">
                    <i class="fa fa-table fa-fw"></i> Workflow report
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12" id="workflow-report">
                            <form name="workflow-report" action="<?= base_url("panel/Project/getProjectWorkFlowReport") ?>" method="post">
                                <input type="hidden" name="workflow-column-list" value='<?= json_encode($workflowColumnList) ?>'>
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
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <!-- <form action="<?=base_url("panel/Project/downloadDailyReports")?>" method="post"> -->
                        <!-- <input type="hidden" value=""> -->
                        <button type="button" id="download-daily-reports" class="btn btn-danger btn-xs btn-block p-1 mb-2">
                            <strong>Descargar reportes diarios</strong><br>
                            La capacidad del servidor podr&iacute;a no ser suficiente para descargar los 4 reportes al mismo tiempo
                        </button>
                    <!-- </form> -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5">
                    <form class="form-inline builder-general-report" method="post">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Reporte general
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <div class="form-group">
                                            <select class="form-control input-sm" name="builder-general-report-month">
                                                <?php
                                                $html = '';
                                                foreach ($monthList as $key => $value) {
                                                    $selected = '';
                                                    if ($key == date('m'))
                                                        $selected = ' selected ';
                                                    $html .= '<option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
                                                }
                                                echo $html;
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control input-sm" name="builder-general-report-year">
                                                <?php
                                                $html = '';
                                                foreach (range(date("Y"), 2017) as $year) {
                                                    $html .= '<option value="' . $year . '">' . $year . '</option>';
                                                }
                                                echo $html;
                                                ?>
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
                <div class="col-lg-7 col-md-7">
                    <form class="form-inline builder-manpower-productivity-report" method="post">
                        <div class="panel panel-primary">
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
                                                foreach ($builderList as $builder) {
                                                    $html .= '<option value="' . $builder->getId() . '" >' . $builder->getFullName() . '</option>';
                                                }
                                                echo $html;
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control input-sm" name="builder-productivity-report-month">
                                                <?php
                                                $html = '';
                                                foreach ($monthList as $key => $value) {
                                                    $selected = '';
                                                    if ($key == date('m'))
                                                        $selected = ' selected ';
                                                    $html .= '<option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
                                                }
                                                echo $html;
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control input-sm" name="builder-productivity-report-year">
                                                <?php
                                                $html = '';
                                                foreach (range(date("Y"), 2017) as $year) {
                                                    $html .= '<option value="' . $year . '">' . $year . '</option>';
                                                }
                                                echo $html;
                                                ?>
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
                    <form class="form-inline projects-and-current-production" method="post">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Costo y producci&oacute;n
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <div class="form-group">
                                            <select class="form-control input-sm" name="projects-and-current-production-month">
                                                <?php
                                                $html = '';
                                                foreach ($monthList as $key => $value) {
                                                    $selected = '';
                                                    if ($key == date('m'))
                                                        $selected = ' selected ';
                                                    $html .= '<option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
                                                }
                                                echo $html;
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control input-sm" name="projects-and-current-production-year">
                                                <?php
                                                $html = '';
                                                foreach (range(date("Y"), 2017) as $year) {
                                                    $html .= '<option value="' . $year . '">' . $year . '</option>';
                                                }
                                                echo $html;
                                                ?>
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
                    <form class="form-inline daily-production" method="post">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Producci&oacute;n diaria
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <div class="form-group">
                                            <select class="form-control input-sm" name="daily-production-month">
                                                <?php
                                                $html = '';
                                                foreach ($monthList as $key => $value) {
                                                    $selected = '';
                                                    if ($key == date('m'))
                                                        $selected = ' selected ';
                                                    $html .= '<option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
                                                }
                                                echo $html;
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control input-sm" name="daily-production-year">
                                                <?php
                                                $html = '';
                                                foreach (range(date("Y"), 2017) as $year) {
                                                    $html .= '<option value="' . $year . '">' . $year . '</option>';
                                                }
                                                echo $html;
                                                ?>
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
                    <form class="form-inline executive-report" method="post">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Informe Ejecutivo
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <div class="form-group">
                                            <select class="form-control input-sm" name="executive-report-type">
                                                <option value="1" selected>Externo</option>
                                                <option value="2">Interno</option>
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
                    <form class="form-inline" action="<?= base_url("panel/Project/getStakeReport") ?>" method="post">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Reporte de estaqueado
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <div class="form-group">
                                            <label for="">Desde</label>
                                            <input type="text" class="form-control input-sm" style="width: 90px;" name="stake-report-from">
                                        </div>
                                        <div class="form-group">
                                        <label for="">Hasta</label>
                                            <input type="text" class="form-control input-sm" style="width: 90px;" name="stake-report-to">
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
                    <form class="form-inline" action="<?=base_url("panel/Project/getAllProjectsLog")?>" method="post">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Log de estados
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <p class="mb-0">Se descargar&aacute;n todos los logs de todos los proyectos. Este reporte puede demorar algo de tiempo</p>
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