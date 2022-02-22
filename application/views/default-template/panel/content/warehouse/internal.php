<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Ingreso en Almacen interno</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="col-md-12">
        <?php
        $this->load->view("default-template/flash-data-basic-messages");
		?>
    </div>
	<form method="post">
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
		<div class="col-md-9">
			<div class="form-group">
				<label>Detalle</label>
				<div class="form-group">
					<input type="text" class="form-control" name="detail" autocomplete="off">
				</div>
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
					<button class="btn btn-default btn-sm iw-add-row" type="button" style="padding: 4px 10px;">Agregar a la lista</button>
				</span>
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
						<th>Ingreso</th>
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
			<button type="button" data-confirm-question="Guardar?" class="btn btn-primary">Guardar</button>
			<br><br>
		</div>
	</div>
    </form>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->

<script id="table-row" type="text/x-handlebars-template">
	<tr
		data-material-code="{{data.material_code}}">
		<td class="text-center">{{data.material_code}}</td>
		<td class="text-left">{{data.material_description}}</td>
		<td class="text-right">
			<input 
			type="text" 
			class="quantity quantity-{{data.material_code}} text-right input-masked text-muted" 
			name="summary[{{rowId}}][quantity]" 
			value=""
			size="7" 
			data-parsley-trigger="input"
			data-inputmask="'alias': 'decimal', 'groupSeparator': '', 'autoGroup': true, 'digits':2, 'placeholder':'0','digitsOptional': false">
		</td>
		<td>
			<select class="wh-table-component-select tension text-muted" name="summary[{{rowId}}][tension]">
				<option value="4">Indefinido</option>
				<option value="1">Media</option>
				<option value="2">Baja</option>
				<option value="3">Transformador</option>
			</select>
		</td>
		<td>
			<select class="wh-table-component-select status text-muted" name="summary[{{rowId}}][status]">
				<option value="1">NVO</option>
				<option value="2">MEO</option>
				<option value="3">RBE</option>
				<option value="4">Indefinido</option>
			</select>
		</td>
		<td><input type="button" class="btn btn-xs btn-danger btn-sm iw-quit-row" value="X"></td>
		<input type="hidden" class="material" name="summary[{{rowId}}][id]" value="{{data.material_id}}">
		<input type="hidden" class="material" name="summary[{{rowId}}][code]" value="{{data.material_code}}">
	</tr>
</script>
