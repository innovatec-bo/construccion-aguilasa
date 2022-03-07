<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 22:33
 */
?>
<script>
	var materialSummary = <?=json_encode($materialSummary)?>;
	var materialList = <?=json_encode($materialList)?>;
	var summaryTypeId = <?=json_encode($summaryTypeId)?>;
</script>
<div class="container-fluid box-shadow-2 hidden-print">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?=$viewTitle?></h1>
		</div>
		<div class="col-md-12">
			<?php
			$this->load->view("default-template/flash-data-basic-messages");
			?>
		</div>
	</div>
	<?php
	if($showSearchBox == 1)
	{
	?>
	<form role="form" method="get">

		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label>Ingresar ID de solicitud</label>
					<div class="form-group input-group">
						<input type="text" class="form-control" name="request-id" autocomplete="off">
						<span class="input-group-btn">
					<button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
					</button>
				</span>
					</div>
				</div>
			</div>
		</div>
	</form>
	<?php
	}
	?>
	<form method="post" name="materials-summary" data-parsley-validate>
		<input type="hidden" name="show-assigned-materials-only" value="<?=$showAssignedMaterialsOnly?>">
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label><?=$summaryTypeTitle?></label>
				<select class="form-control input-sm" name="summary-type">
					<?php
					$options = "";
					
					/** @var Model_material_summary_type $summaryType */
					foreach ($summaryTypes as $summaryType)
					{
						switch($summaryType->getKeyword())
						{
							case 'materials_additional_list':
								$columnsToShow = "material_code,material_description,movement,tension,status";
							break;
							case 'materials_delivered_to_builder':
								$columnsToShow = "material_code,material_description,quantity_assigned_materials,quantity_picked_up_from_cre,pending_material_in_cre,quantity_materials_delivered_to_builder,request_materials_quantity,quantity_in_warehouse,all_quantity_in_warehouse,movement,tension,status,delivered_to_builder_detail";
							break;
							default:
							//all_quantity_in_warehouse,
								$columnsToShow = "material_code,material_description,quantity_assigned_materials,quantity_picked_up_from_cre,pending_material_in_cre,quantity_materials_delivered_to_builder,request_materials_quantity,quantity_in_warehouse,movement,tension,status";

						}
						$options .= "<option data-keyword='{$summaryType->getKeyword()}' value='{$summaryType->getId()}' data-columns='$columnsToShow'>{$summaryType->getName()}</option>";
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
				<select class="form-control input-sm" name="reservation-number">
					<option value="">--Elija un Nro. de reserva--</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<label><?=$materialsTitle?></label>
			<div class="form-group input-group">
				<select class="form-control select2-materials" parsley-trigger="change" name="materials">
					<option></option>
				</select>
				<span class="input-group-btn">
					<button class="btn btn-default btn-sm wh-add-row" type="button" style="padding: 4px 10px;">Agregar a la lista</button>
					<button class="btn btn-warning btn-sm wh-add-new-material" type="button" style="padding: 4px 10px;">Crear material</button>
					<?php
					if($showBtnListAll == 1)
					{
					?>
						<button class="btn btn-info btn-sm wh-show-all-in-table" type="button" style="padding: 4px 10px;">Mostrar todos</button>
					<?php
					}
					?>
					<button class="btn btn-danger btn-sm wh-clear-table" type="button" style="padding: 4px 10px;">Limpiar lista</button>
					<button class="btn btn-danger btn-sm wh-set-cero-as-movement" type="button" style="padding: 4px 10px;">Movimiento en cero "0"</button>
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
				<table class="table table-bordered display pageResize" id="items-summary-list">
					<thead>
					<tr>
						<th>COD</th>
						<th>Descripci&oacute;n</th>
						<th>Comprometido<br>de la CRE</th>
						<th>Total<br>retirado<br>de CRE</th>
						<th>Saldo por<br>retirar<br>de CRE</th>
						<th>
							<div data-toggle="tooltip" data-placement="top" title="Esta columna es dinamica de acuerdo a lo que reciba o devuelva el constructor">Entregado<br>al constructor<br>(<em>Prestamos incluidos</em>)</div>
						</th>
<!--						<th>Total<br>entregado<br>a CRE</th>-->
<!--						<th>Total<br>devuelto<br>por el constructor</th>-->
<!--						<th>Total<br>material viejo<br>devuelto</th>-->
<!--						<th>Total<br>devuelto<br>en buen estado</th>-->
						<th>
							<div data-toggle="tooltip" data-placement="top" title="Cantidad solicitada por un fiscal de SEREBO">Comprometido<br>en SEREBO</div> 
						</th>
						<th>Disponible<br>en el almac&eacute;n</th>
						<th class="bg-warning">Disponible<br>en el almac&eacute;n</th>
						<th>Movimiento</th>
						<th>Tension</th>
						<th>Estado</th>
						<th>Detalle</th>
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
			<button type="button" data-confirm-question="Guardar?" class="btn btn-primary">Guardar</button>
			<br><br>
		</div>
	</div>
	</form>
	<div id="like_button_container"></div>
	<div id="hello-example" style="display: none;"></div>
	<!-- <script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
	<script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script> -->
	<!-- Load our React component. -->
	<!-- <script src="<?=assets_url('resource-sb-admin2/react-components/like_button.js')?>"></script> -->
</div>
<?php
if($this->session->flashdata("printView"))
{
	echo $this->session->flashdata('printView');
}
?>
<?php
$this->load->view("default-template/panel/content/project/WarehouseHandler.hbr");
?>
<!-- /.container-fluid -->
