<div class="container-fluid box-shadow-2 hidden-print">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Solicitar Materiales a CRE</h1>
		</div>
		<div class="col-md-12">
			<?php
			$this->load->view("default-template/flash-data-basic-messages");
			?>
		</div>
	</div>
	<form method="post" name="materials-summary" data-parsley-validate>
	<div class="row">
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
		<div class="col-md-4" id="extra-request-data">
			<div class="form-group">
				<label>Proyecto</label>
				<select class="form-control input-sm project" name="project">
					<option></option>
					<?php
					$options = "";
					/** @var Model_project $project */
					foreach ($projects as $project)
					{
						$options .= "<option value='{$project->getId()}'>{$project->getCode()}</option>";
					}
					echo $options;
					?>

				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group" id="reservation-number-selection">
				<label>Nro reserva</label>
				<input type="text" class="form-control" readonly value="1234">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<label>Materiales</label>
			<div class="form-group input-group">
				<select class="form-control select2-materials" parsley-trigger="change" name="materials">
					<option></option>
				</select>
				<span class="input-group-btn">
					<button class="btn btn-default btn-sm wh-add-row" type="button" style="padding: 4px 10px;">Agregar a la lista</button>
					<button class="btn btn-warning btn-sm wh-add-new-material" type="button" style="padding: 4px 10px;">Crear material</button>
					<button class="btn btn-danger btn-sm wh-clear-table" type="button" style="padding: 4px 10px;">Limpiar lista</button>
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
						<th>COD</th>
						<th>Descripci&oacute;n</th>
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
if($this->session->flashdata("printView"))
{
	echo $this->session->flashdata('printView');
}
?>
<?php
$this->load->view("default-template/panel/content/project/WarehouseHandler.php");
?>
<!-- /.container-fluid -->