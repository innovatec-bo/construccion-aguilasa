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
			<?php
			$projectCode = "";
			if(isset($_GET['project-code']))
				$projectCode = '- '.$project['code_pro'];
			?>
            <h1 class="page-header">Ingreso de materiales <?=$projectCode?></h1>
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
		<div class="col-md-3">
			<form method="get" action="<?=base_url('panel/Warehouse/entry')?>">
				<div class="form-group input-group">
					<input type="text" placeholder="Codigo del proyecto" class="form-control" name="project-code">
					<span class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
						</button>
					</span>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<?php
		foreach ($summaryList as $summary)
		{
		?>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<a href="#">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-file fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge">26</div>
								<div>Mat. iniciales</div>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
		<?php
		}
		?>
	</div>
	<?php
	if(isset($_GET['project-code']))
	{
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Especifique la entrada de materiales</label>
				<div class="radio">
					<label>
						<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">Retirado de CRE
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">Material viejo devuelto por el constructor
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">Material sobrante devuelto por el constructor
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="optionsRadios" id="optionsRadios4" value="option4">Devolucion de material prestado
					</label>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<thead>
					<tr>
						<th>#</th>
						<th>Material</th>
						<th>Descripci&oacute;n</th>
						<th>Total<br>asignado</th>
						<th>Total<br>retirado<br>de CRE</th>
						<th>Total<br>retirado<br>por constructor</th>
						<th>Total<br>devuelto<br>por constructor</th>
						<th>Total<br>prestado</th>
						<th>Total<br>prestado<br>y devuelto</th>
						<th>Total en<br>almacen</th>
						<th>Nueva<br>entrada</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>1</td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><input type="text" size="7"></td>
					</tr>
					<tr>
						<td>2</td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><input type="text" size="7"></td>
					</tr>
					<tr>
						<td>3</td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><?=rand(1,20)?></td>
						<td class="text-right"><input type="text" size="7"></td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<button type="button" class="btn btn-primary">Guardar</button>
			<br><br>
		</div>
	</div>
	<?php
	}
	?>
</div>
<!-- /.container-fluid -->
