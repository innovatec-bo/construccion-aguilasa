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
			<h1 class="page-header"><?=$viewTitle?></h1>
		</div>
		<div class="col-md-12">
			<?php
			$this->load->view("default-template/flash-data-basic-messages");
			?>
		</div>
		<div class="col-md-12">
			<div class="alert alert-info">
				<strong>Nota</strong><br>
				<ol>
					<li>La lista se limpia cuando los valores de "Proyecto" y "Nro. de reserva" cambian.</li>
					<li>Si ingresa un material mas de una vez y repite su tension y estado, se registra la ultima ocurrencia ingresada en la tabla/lista.</li>
					<li>Las columnas son dinamicas y estan en funcion al tipo de movimiento que se realiza.</li>
				</ol>
			</div>
		</div>
	</div>
	<form method="post" name="materials-summary">

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label><?=$summaryTypeTitle?></label>
				<select class="form-control input-sm" name="summary-type">
					<?php
					$options = "";
					$columnsToShow = "material_code,material_description,quantity_assigned_materials,quantity_picked_up_from_cre,pending_material_in_cre,quantity_materials_delivered_to_builder,quantity_in_warehouse,movement,tension,status";
					/** @var Model_material_summary_type $summaryType */
					foreach ($summaryTypes as $summaryType)
					{
						$options .= "<option value='{$summaryType->getId()}' data-columns='$columnsToShow'>{$summaryType->getName()}</option>";
					}
					echo $options;
					?>
				</select>
			</div>
		</div>
		<div id="builder-selection" style="display: none">
			<div class="col-md-4">
				<div class="form-group">
					<label>Fiscal</label>
					<select class="form-control input-sm" name="fiscal">
						<?php
						$html = '';
						foreach ($fiscals as $fiscal)
						{
							$html .= "<option value='{$fiscal->getId()}'>{$fiscal->getFullName()}</option>";
						}
						echo $html;
						?>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Constructor</label>
					<select class="form-control input-sm" name="builder">
						<?php
						$html = '';
						foreach ($builders as $builder)
						{
							$html .= "<option value='{$builder->getId()}'>{$builder->getFullName()}</option>";
						}
						echo $html;
						?>
					</select>
				</div>
			</div>
		</div>

	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>Fecha</label>
				<div class="input-group date date-time-picker input-group-sm">
					<input name="entry-date" readonly="" required="" class="form-control" data-parsley-errors-container="#error-entry-date">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
				<div id="error-entry-date"></div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Proyecto</label>
				<select class="form-control input-sm select2 project" name="project">
					<option></option>
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group" id="reservation-number-selection">
				<label>Nro reserva</label>
				<select class="form-control input-sm" name="reservation-number">
					<option value="">--Elija un Nro. de reserva--</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group input-group">
				<select class="form-control select2-materials" data-parsley-required="" parsley-trigger="change" name="materials">
					<option></option>
				</select>
				<span class="input-group-btn">
					<button class="btn btn-default btn-sm wh-add-row" type="button" style="padding: 4px 10px;">Agregar a la lista</button>
					<button class="btn btn-warning btn-sm wh-add-new-material" type="button" style="padding: 4px 10px;">Crear material</button>-->
				</span>
<!--				<span class="input-group-btn">-->
<!--					<button class="btn btn-info btn-sm wh-add-new-material" type="button" style="padding: 4px 10px;">Crear material</button>-->
<!--				</span>-->
			</div>
		</div>
	</div>
	<div class="row hide">
		<div class="col-md-6">
			<div class="checkbox">
				<label>
					<input type="checkbox" name="is-loan">Pr&eacute;stamo de materiales
				</label>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover display pageResize" id="items-summary-list">
					<thead>
					<tr>
						<th>COD</th>
						<th>Descripci&oacute;n</th>
						<th>Comprometido<br>de la CRE</th>
						<th>Total<br>retirado<br>de CRE</th>
						<th>Saldo por<br>retirar<br>de CRE</th>
						<th>Entregado<br>al constructor</th>
<!--						<th>Total<br>entregado<br>a CRE</th>-->
<!--						<th>Total<br>devuelto<br>por el constructor</th>-->
<!--						<th>Total<br>material viejo<br>devuelto</th>-->
<!--						<th>Total<br>devuelto<br>en buen estado</th>-->
						<th>Disponible<br>en almac&eacute;n</th>
						<th>Movimiento</th>
						<th>Tension</th>
						<th>Estado</th>
						<th>Quitar</th>
					</tr>
					</thead>
					<tbody id="table-body">
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<button type="submit" class="btn btn-primary">Guardar</button>
			<br><br>
		</div>
	</div>
	</form>
</div>
<?php
$this->load->view("default-template/panel/content/project/WarehouseHandler.php");
?>
<!-- /.container-fluid -->
