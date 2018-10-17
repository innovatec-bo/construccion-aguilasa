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
                    <i class="fa fa-table fa-fw"></i> Tabla de cantidades
                    <input name="report-year" readonly="" class="form-control input-sm" size="1" required="">
                    <div class="pull-right">
                        <div class="btn-group">
                            <form name="report" action="<?=base_url("panel/Project/getProjectWorkFlowReport")?>" method="post">
<!--                                <input type="submit" value="Workflow">-->
                                <button type="submit" class="btn btn-default btn-xs">Descargar workflow</button>
                            </form>

                        </div>
                    </div>
                </div>

                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>CRITERIO</th>
                                        <th>ENERO</th>
                                        <th>FEBRERO</th>
                                        <th>MARZO</th>
                                        <th>ABRIL</th>
                                        <th>MAYO</th>
                                        <th>JUNIO</th>
                                        <th>JULIO</th>
                                        <th>AGOSTO</th>
                                        <th>SEPTIEMBRE</th>
                                        <th>OCTUBRE</th>
                                        <th>NOVIEMBRE</th>
                                        <th>DICIEMBRE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th>INGRESADOS</th>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                    </tr>
                                    <tr>
                                        <th>DISEÑADOS</th>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                    </tr>
                                    <tr>
                                        <th>APROBADOS</th>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                    </tr>
                                    <tr>
                                        <th>CONSTRUIDOS</th>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                    </tr>
                                    <tr>
                                        <th>CONCILIADOS</th>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                    </tr>
                                    <tr>
                                        <th>CON # ORDEN</th>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                    </tr>
                                    <tr>
                                        <th>PAGADOS</th>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                        <td class="text-center"><?=rand(3,6)?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
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
<!--            <form name="report" action="--><?//=base_url("panel/Project/getNewProjectsByMonthAndYear")?><!--" method="post">-->
<!--                <input type="submit" value="Nuevos proyectos">-->
<!--            </form>-->
<!--            <form name="report" action="--><?//=base_url("panel/Project/getProjectWorkFlowReport")?><!--" method="post">-->
<!--                <input type="submit" value="Workflow">-->
<!--            </form>-->
<!--            <form name="report" action="--><?//=base_url("panel/Project/getApprovedProjectsByMonthAndYear")?><!--" method="post">-->
<!--                <input type="submit" value="Projectos aprobados">-->
<!--            </form>-->
<!--            <form name="report" action="--><?//=base_url("panel/Project/getConciliatedProjectsByMonthAndYear")?><!--" method="post">-->
<!--                <input type="submit" value="Projectos conciliados">-->
<!--            </form>-->
<!--            <form name="report" action="--><?//=base_url("panel/Project/getAsBuiltProjectsByMonthAndYear")?><!--" method="post">-->
<!--                <input type="submit" value="Projectos construidos(as built enviado)">-->
<!--            </form>-->
<!--            <form name="report" action="--><?//=base_url("panel/Project/orderNumberAndTotalsByMonthAndYear")?><!--" method="post">-->
<!--                <input type="submit" value="Numero de orden  + importes">-->
<!--            </form>-->
<!--            <form name="report" action="--><?//=base_url("panel/Project/paymentSettledAndTotalsByMonthAndYear")?><!--" method="post">-->
<!--                <input type="submit" value="Proyectos pagados + importes">-->
<!--            </form>-->
        </div>
    </div>
    <!-- /.row -->
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
