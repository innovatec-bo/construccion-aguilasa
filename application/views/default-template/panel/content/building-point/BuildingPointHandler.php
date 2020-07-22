<script id="building-point-add-form" type="text/x-handlebars-template">
  <form name="building-point-form" data-parsley-validate>
    <input type="hidden" name="building-point-id" value="">
    <div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>Label</label>
				<input class="form-control" name="label" required>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>Latitud</label>
				<input class="form-control" name="latitude" required>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>Longitud</label>
				<input class="form-control" name="longitude" required>
			</div>
		</div>
        <div class="col-md-3">
			<div class="form-group">
				<label>Punto anterior</label>
				<input class="form-control" name="previous-point" required>
			</div>
        </div>
    </div>
  </form>
</script>

<script id="building-point-structure-add-form" type="text/x-handlebars-template">
	<form name="building-point-structure-form" data-parsley-validate>
		<input type="hidden" name="project-id" value="{{buildingPoint.project.id}}">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Buscar y agregar estructura existente en el proyecto</label>
					<select class='select2-search-labor-cost' name="labor-cost-structure-id"></select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive" id="manpower-table">
					<p>
						Separador de miles ( <strong>,</strong> )<br>
						Separador de decimales ( <strong>.</strong> )
					</p>
					<table class="table table-striped table-bordered table-hover table-minimum-padding">
						<thead>
						<tr>
							<th style="width:35px">ESTRUCTURA</th>

							<th>DESCRIPCION</th>
							<th style="width:20px">ACTIV.</th>
							<th style="width:20px">EJEC.</th>
							<th style="width:20px">PRECIO<br>UNITARIO</th>
							<th style="width:20px">UNIDAD</th>
							<th style="width:40px">CANTIDADA UTILIZAR</th>
							<th style="width:40px" class="text-center">X</th>
						</tr>
						</thead>
						<tbody class="building-point-structure-add-form-item-list">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</form>
</script>
<script id="building-point-structure-add-form-item" type="text/x-handlebars-template">
	<tr data-labor-cost-id="{{labor_cost_id}}">
		<td class="">{{structure_code}}</td>
		<td>{{structure_detail}}</td>
		<td class="text-center">{{structure_activity}}</td>
		<td class="text-center">{{structure_execution}}</td>
		<td class="text-right">{{structure_unit_price}}</td>
		<td class="text-center">{{structure_unit_of_measurement}}</td>
		<td class="text-right">
			<input type="hidden" name="additional-structures[{{labor_cost_id}}][labor-cost-id]" size="10" value="{{labor_cost_id}}" data-parsley-required="">
			<input class="input-masked quantity-to-use" name="additional-structures[{{labor_cost_id}}][quantity]" size="10" data-parsley-required="">
		</td>
		<td class="text-center"><a href="#" class="remove-structure-from-building-point-form-add">X</a></td>
	</tr>
</script>
