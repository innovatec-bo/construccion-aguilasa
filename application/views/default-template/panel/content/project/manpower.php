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
            <h1 class="page-header">Mano de obra
                <em class="subtext"><?=$project['code_pro']?></em>
            </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="col-md-12">
        <?php
        $this->load->view("default-template/flash-data-basic-messages");
        ?>
    </div>
    <div class="col-md-6">
        <form class="form-inline" action="<?=base_url("panel/Project/uploadActivityByExcelFile/".$project['id_pro'])?>" method='post' enctype="multipart/form-data">
            <div class="form-group">
                <div class="input-group"> 
                    <input type="file" name="file" class="form-control" placeholder="Search for..."> 
                    <span class="input-group-btn"> 
                        <button class="btn btn-danger" type="submit">Cargar formulario <i class="fa fa-upload"></i></button> 
                    </span> 
                </div>
            </div>
        </form>
        <br>
    </div>
    <div class="col-md-6">
        <form class="form-inline pull-right" action="<?=base_url("panel/Project/getManpowerActivityForm/".$project['id_pro'])?>" method="post">
            <button type="submit" class="btn btn-info">Descargar formulario <i class="fa fa-download"></i></button>
        </form>
        <br>
    </div>
	<div class="col-md-12">
		<button type="button" class="btn btn-warning btn-sm add-building-structure mb-1" data-project-id="<?=$project['id_pro']?>" data-original-title="Agregue una estructura que no exista en el proyecto tomando en cuenta su actividad y ejecucion." data-toggle="tooltip" data-placement="top">Agregar estrucura al proyecto</button>
		<br><em class="block">Puede agregar una estructura sin repetir la actividad y ejecucion de otra existente. Ejem: Si el proyecto ya posee la estructura PH11B para retiro en linea muerta, puede volver a agregar la estructura
			PH11B pero sin repetir la atividad y ejecucion de la estructrua ya existente.</em>
	</div>
    <div class="col-md-9">
        <p id="builder-list"></p>
        <div class="table-responsive" id="manpower-table">

        </div>
    </div>
    <div class="col-md-3" id="history-content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Hist. de avance
                <div class="pull-right">
                    <div class="btn-group">
                        <a href="<?=base_url()?>" class="btn btn-default btn-xs download-manpower-progress"><i class="fa fa-download fa-fw"></i></a>
                        <button type="button" class="btn btn-default btn-xs add-manpower-progress"><i class="fa fa-plus fa-fw"></i></button>
                    </div>
                </div>
            </div>
            <div class="panel-body" style="overflow-y: scroll; height: 50vh;/* position: relative*/; zoom: 1;" id="status-project-log-content">
                Cargando historial..
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
