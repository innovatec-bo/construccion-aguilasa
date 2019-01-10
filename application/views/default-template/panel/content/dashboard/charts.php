<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 22:33
 */
?>
<div class="container-fluid">
    <?php
    $this->load->view("default-template/panel/content/dashboard/heading");
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" id="panel-projects-evolution-chart">
                <div class="panel-heading">
                    <i class="fa fa-table fa-fw"></i> Evolucion de proyectos
                    <input name="report-year" readonly="" class="form-control input-sm date-time" size="1" required="">
                    <select class="form-control input-sm" name="data-type">
                        <option value="countId">Unidades</option>
                        <option value="sumBudget">Montos aprobados</option>
                    </select>
                    <select class="form-control input-sm" name="contract-number">
                        <option value="">Contrato</option>
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
                            <button type="button" class="btn btn-default btn-xs open-table"><i class="fa fa-table"></i></button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="projects-evolution-chart-content" class="chart-content"></div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" id="panel-executive-summary-chart">
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
                        <select class="form-control input-sm" name="contract-number">
                            <option value="">Contrato</option>
                            <?php
                            $html = "";
                            foreach ($contractList as $contract)
                            {
                                $html .= '<option value="'.$contract->id_con.'" >'.$contract->contract_number_con.'</option>';
                            }
                            echo $html;
                            ?>
                        </select>
                        <select class="form-control input-sm" name="data-type">
                            <option value="totalProjectsBySection">Unidades</option>
                            <option value="totalApprovedBudgetBySection">Montos aprobados</option>
                        </select>
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-download"></i></button>
                                <button type="button" class="btn btn-default btn-xs open-table"><i class="fa fa-table"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-body">
                    <div id="executive-summary-chart-content" class="chart-content"></div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" id="panel-project-totals-chart">
                <div class="panel-heading">
                    <i class="fa fa-table fa-fw"></i> Tabla de totales
                    <input name="report-year" readonly="" class="form-control input-sm date-time" size="1" required="">
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
                <div class="panel-body">
                    <div id="project-totals-chart-content" class="chart-content"></div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" id="panel-system-chart">
                <div class="panel-heading">
                    <form name="report" action="<?=base_url("panel/Project/getCurrentStatusSummary")?>" method="post">
                        <i class="fa fa-table fa-fw"></i> Reporte de Sistemas
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
                        <select class="form-control input-sm" name="contract-number">
                            <option value="">Contrato</option>
                            <?php
                            $html = "";
                            foreach ($contractList as $contract)
                            {
                                $html .= '<option value="'.$contract->id_con.'" >'.$contract->contract_number_con.'</option>';
                            }
                            echo $html;
                            ?>
                        </select>
                        <select class="form-control input-sm" name="data-type">
                            <option value="total_projects">Unidades</option>
                            <option value="approved_budgets">Montos aprobados</option>
                        </select>
                        <div class="pull-right">
                            <div class="btn-group hide">
                                <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-download"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-body">
                    <div id="system-chart-content" class="chart-content"></div>
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
$this->load->view('default-template/panel/content/dashboard/ht-report-current-status-summary');
$this->load->view('default-template/panel/content/dashboard/ht-report-executive-summary');
$this->load->view('default-template/panel/content/dashboard/ht-report-executive-summary-and-current-status-summary');
?>