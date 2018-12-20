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
<!--        <div class="col-md-6 hidden">-->
<!--            <div class="panel panel-primary" id="panel-status-summary-chart">-->
<!--                <div class="panel-heading">-->
<!--                    <i class="fa fa-bar-chart-o fa-fw"></i> Status summary-->
<!--                </div>-->
<!--                <div class="panel-body">-->
<!--                    <div id="status-summary-chart-content" class="chart-content"></div>-->
<!--                </div>-->
<!--                <!-- /.panel-body -->
<!--            </div>-->
<!--        </div>-->
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
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-download"></i></button>
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

    <!-- /.row -->
    <!-- /.row -->
</div>
<!-- /.container-fluid -->