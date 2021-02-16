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
            <h1 class="page-header">Almacen</h1>
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
	<div class="row">
		<div class="col-md-12">
			<h4>Proyectos que deben materiales a otros proyectos</h4>
		</div>
		<div class="col-md-12">
			<span class="label label-info">..</span> Menor a 15 dias.<br>
			<span class="label label-warning">..</span> Igual o mayor a 15 dias y menor que 30 dias.<br>
			<span class="label label-danger">..</span> Mas de 30 dias.
		</div>
		<div class="col-md-12">
			<span class="label label-info">RD.20.1923 =&gt; RD.19.2345 (14 dias)</span>
			<span class="label label-warning">RD.20.1923 =&gt; RD.19.2345 (30 dias)</span>
			<span class="label label-danger">RD.20.1923 =&gt; RD.19.2345 (60 dias)</span>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h4>Operaciones de almacen</h4>
		</div>
		<div class="col-sm-6 col-md-3">
			<a href="#" class="thumbnail">
				<div class="thumbnail p-0 m-0">
					<?php
					$timthumb = base_url('timthumb/timthumb.php');
					$image = assets_url('images/flaticon/importa-cre.png');
					$timthumbImage = $timthumb.'?src='.$image.'&w=150&h=150';
					?>
					<img src="<?=$timthumbImage?>">
					<div class="caption">
						<h4 class="text-center">Registrar ingreso de materiales de CRE</h4>
					</div>
				</div>
			</a>
		</div>
		<div class="col-sm-6 col-md-3">
			<a href="#" class="thumbnail">
				<div class="thumbnail p-0 m-0">
					<?php
					$timthumb = base_url('timthumb/timthumb.php');
					$image = assets_url('images/flaticon/exportar-constructor.png');
					$timthumbImage = $timthumb.'?src='.$image.'&w=150&h=150';
					?>
					<img src="<?=$timthumbImage?>">
					<div class="caption">
						<h4 class="text-center">Registrar retiro por constructor</h4>
					</div>
				</div>
			</a>
		</div>
		<div class="col-sm-6 col-md-3">
			<a href="#" class="thumbnail">
				<div class="thumbnail p-0 m-0">
					<?php
					$timthumb = base_url('timthumb/timthumb.php');
					$image = assets_url('images/flaticon/importar-constructor.png');
					$timthumbImage = $timthumb.'?src='.$image.'&w=150&h=150';
					?>
					<img src="<?=$timthumbImage?>">
					<div class="caption">
						<h4 class="text-center">Registrar devolucion de constructor</h4>
					</div>
				</div>
			</a>
		</div>
		<div class="col-sm-6 col-md-3">
			<a href="#" class="thumbnail">
				<div class="thumbnail p-0 m-0">
					<?php
					$timthumb = base_url('timthumb/timthumb.php');
					$image = assets_url('images/flaticon/exportar-cre.png');
					$timthumbImage = $timthumb.'?src='.$image.'&w=150&h=150';
					?>
					<img src="<?=$timthumbImage?>">
					<div class="caption">
						<h4 class="text-center">Registrar devolucion a CRE</h4>
					</div>
				</div>
			</a>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
