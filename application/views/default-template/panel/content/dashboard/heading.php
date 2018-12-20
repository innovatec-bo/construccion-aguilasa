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
                <li class="<?=$tablesActive?>"><a href="<?=$tablesUrl?>"><i class="fa fa-table fa-fw"></i></a>
                </li>
                <li class="<?=$chartsActive?>"><a href="<?=$chartsUrl?>"><i class="fa fa-bar-chart-o fa-fw"></i></a>
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
    <div class="col-lg-3 col-md-6" style="display: none">
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
    <div class="col-lg-3 col-md-6" style="display: none">
        <div class="panel panel-primary">
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
        <div class="panel panel-primary">
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
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary" id="panel-serebo-thermometer-chart">
            <div class="panel-heading">
                <div class="row" id="serebo-thermometer-chart-content" style="height: 76px">

                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">
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
                </span>
                <span class="pull-right">
                    <select class="form-control input-sm" name="stage" style="width: 90px">
                        <option value="">Etapa</option>
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
</div>