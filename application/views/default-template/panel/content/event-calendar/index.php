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
            <h1 class="page-header">Plan de trabajo</h1>
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
        <div class="col-md-offset-2 col-md-8">
            <label>Elija un mes para filtrar los proyectos</label>
        </div>    
        <div class="col-md-offset-2 col-md-2">
            <div class="form-group">
                <input name="report-year" readonly="" class="form-control input-lg date-time text-center" size="1" required="">
            </div>
        </div>
        <div class="col-md-offset-2 col-md-8">
            <p class="help-block">Los proyectos que figuran en la tabla estan en etapa de construccion.</p>
        </div>    
    </div>
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="table-content">
              
            </div>
        </div>    
    </div>
</div>
<!-- /.container-fluid -->
<?php
    $this->load->view("default-template/panel/content/event-calendar/WorkPlanHandler");
?>