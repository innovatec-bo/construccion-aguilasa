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
			<h1 class="page-header">Movimiento de materiales</h1>
		</div>
		<div class="col-md-12">
			<?php
			$this->load->view("default-template/flash-data-basic-messages");
			?>
		</div>
	</div>
	<form method="post" name="materials-summary">

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label>Tipo de movimiento</label>
				<select class="form-control input-sm" name="summary-type">
					<option value="3" data-columns="material_code:name,material_description:name,quantity_assigned:name,quantity_picked_up_from_cre:name,pending_material_in_cre:name,movement:name,status:name">Retirado de CRE</option>
					<option value="4" data-columns="material_code:name,material_description:name,quantity_assigned:name,quantity_in_warehouse:name,movement:name,status:name">Entrega de materiales al contructor</option>
					<option value="8" data-columns="material_code:name,material_description:name,quantity_assigned:name,movement:name,status:name">Envio de materiales a CRE(222)</option>
					<option value="9" data-columns="material_code:name,material_description:name,quantity_assigned:name,movement:name,status:name">Ingreso por conciliacion 221</option>
					<option value="10" data-columns="material_code:name,material_description:name,quantity_assigned:name,movement:name,status:name">Constructor devuelve materiales no utilizados</option>
					<option value="11" data-columns="material_code:name,material_description:name,quantity_assigned:name,movement:name,status:name">Constructor devuelve materiales retirados de obra</option>
					<option value="12" disabled data-columns="material_code:name,material_description:name,quantity_assigned:name,movement:name,status:name">Ajuste</option>
				</select>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group" id="builder-selection" style="display: none">
				<label>Especifique el constructor</label>
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
					<option>--Elija un Nro. de reserva--</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row hide">
		<div class="col-md-6">
			<div class="form-group input-group">
				<select class="form-control select2-materials" data-parsley-required="" parsley-trigger="change" name="materials">
					<option></option>
				</select>
				<span class="input-group-btn">
					<button class="btn btn-success btn-sm wh-add-row" type="button" style="padding: 4px 10px;">Agregar a la lista</button>
				</span>
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
<!--						<th>#</th>-->
						<th>C&oacute;digo</th>
						<th>Descripci&oacute;n</th>
						<th>Total<br>asignado</th>
						<th>Total<br>retirado<br>de CRE</th>
						<th>Saldo por<br>retirar de CRE</th>
<!--						<th>Total<br>entregado<br>al constructor</th>-->
<!--						<th>Total<br>entregado<br>a CRE</th>-->
<!--						<th>Total<br>devuelto<br>por el constructor</th>-->
<!--						<th>Total<br>material viejo<br>devuelto</th>-->
<!--						<th>Total<br>devuelto<br>en buen estado</th>-->
						<th>Disponible</th>
						<th>Movimiento</th>
						<th>Estado</th>
<!--						<th>Quitar</th>-->
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
