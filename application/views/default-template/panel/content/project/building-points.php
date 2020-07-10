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
            <h1 class="page-header">Puntos de construccion
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
	<div class="row">
		<div class="col-md-12">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab1" data-toggle="tab" aria-expanded="true">Datos t&eacute;cnicos</a>
				</li>
				<li class=""><a href="#point-locations" data-toggle="tab" aria-expanded="false">Mapa</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane fade active in" id="tab1">
					<div class="col-md-12">
						<p>
						<div class="alert alert-info">
							<i class="fa fa-info-circle fa-fw"></i>La opci&oacute;n de <strong>Completar puntos</strong> esta disponible para proyectos con 7 o menos puntos.
						</div>
						<button type="button" class="btn btn-info add-massive-point-to-point-progress hide">Completar puntos</button>
						</p>
					</div>
					<div class="col-md-12">
						<button type="button" class="btn btn-warning btn-sm add-building-structure mb-1" data-project-id="<?=$project['id_pro']?>">Agregar estrucura al proyecto</button>
						<button type="button" class="btn btn-danger btn-sm add-building-point mb-1">Crear punto</button>
					</div>
					<div id="building-points">
						<div class="col-md-9"></div>
					</div>
					<div class="col-md-3" id="history-content">
						<div class="panel panel-primary">
							<div class="panel-heading">
								Historial de avance
								<div class="pull-right">
									<div class="btn-group">
										<a href="<?=base_url()?>" class="btn btn-default btn-xs download-manpower-progress hide"><i class="fa fa-download fa-fw"></i></a>
										<button type="button" class="btn btn-default btn-xs add-manpower-progress hide"><i class="fa fa-plus fa-fw"></i></button>
									</div>
								</div>
							</div>
							<div class="panel-body" style="overflow-y: scroll; height: 50vh;/* position: relative*/; zoom: 1;" id="status-project-log-content">
								Cargando historial..
							</div>
							<!-- /.panel-body -->
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="point-locations">
					<div class="row">
						<div class="col-md-12">
							<div id="pagination-content" class="py-1"></div>
						</div>
						<div class="col-md-12" id="map-section">
							<div class="map-fancy-framework mb-2">
								<div id="maps" style="height: 500px;width: auto;position: relative;">
								</div>
								<em class="map-search-message"></em>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<?php
$this->load->view('default-template/panel/content/project/PointsLocationHandler');
?>
