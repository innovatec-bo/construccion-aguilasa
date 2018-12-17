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
    <div class="row">
        <div class="col-md-12" id="chartdiv" style="height: 500px">

        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?php
$this->load->view('default-template/panel/content/dashboard/ht-report-executive-summary');
?>