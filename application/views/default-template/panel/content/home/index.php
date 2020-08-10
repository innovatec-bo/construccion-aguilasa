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
            <h1 class="page-header">Home</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="col-md-12">
        <?php
        $this->load->view("default-template/flash-data-basic-messages");
        ?>
    </div>
    <!-- /.row -->
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <form class="form-inline stake-report-inline-form" name="work-plan-report" action="<?=base_url("panel/Project/getWorkPlanReport")?>" method="post">
                    <i class="fa fa-file-excel-o fa-fw"></i> Plan de Trabajo
                    <div class="form-group">
                        <label class="sr-only input-sm" for="exampleInputEmail3">Desde</label>
                        <input type="text" class="form-control input-sm date-time-work-plan-report" size="10" style="height: 21px" name="work-plan-report-from">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control input-sm date-time-work-plan-report" size="10" style="height: 21px" name="work-plan-report-to">
                    </div>
                    <button type="button" class="btn btn-default btn-xs load-work-plan-report">Ver <i class="fa fa-search"></i></button>
                </form>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="work-plan-summary-table">

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Todos los incidentes
                    <small><span id="days-without-incidents">...</span> sin incidentes</small>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="incident-content">
                <div class="list-group" id="incident-list">
                    Cargando incidentes...
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>

    <div class="col-md-12">

    </div>
</div>
<!-- /.container-fluid -->
<?php
$this->load->view('default-template/panel/content/dashboard/ht-report-executive-summary');
$this->load->view('default-template/panel/content/project-status/ht-modal-incident-form');
?>
