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
        <div class="col-md-6">
            <div class="panel panel-primary" id="panel-executive-summary-chart">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Executive summary
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