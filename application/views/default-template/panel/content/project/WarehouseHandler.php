<script id="table-row" type="text/x-handlebars-template">
	<tr>

<!--		<td>1</td>-->
		<td class="text-center">{{data.material_code}}</td>
		<td class="text-left">{{data.material_description}}</td>
		<td class="text-right">{{numberFormat data.quantity_assigned_materials}}</td>
		<td class="text-right">{{numberFormat data.quantity_picked_up_from_cre}}</td>
		<td class="text-right">{{numberFormat data.pending_material_in_cre}}</td>
		<td class="text-right">{{numberFormat data.quantity_in_warehouse}}</td>
		<td class="text-right"><input type="text" name="summary[{{rowId}}][quantity]" value="0" size="7"></td>

		<td>
			<select class="form-control input-sm" name="summary[{{rowId}}][tension]">
				<option value="1">Media</option>
				<option value="2">Baja</option>
				<option value="3">Transformador</option>
			</select>
		</td>
		<td>
			<select class="form-control input-sm" name="summary[{{rowId}}][status]">
				<option value="1">NVO</option>
				<option value="2">MEO</option>
				<option value="3">RBE</option>
			</select>
		</td>
		<td><input type="button" class="btn btn-danger btn-sm wh-quit-row" value="X"></td>
		<input type="hidden" name="summary[{{rowId}}][id]" value="{{data.material_id}}">
	</tr>
</script>
<script id="reservation-number-options" type="text/x-handlebars-template">
	<option value="">--Elija un Nro. de reserva--</option>
	{{#each options}}
		<option value="{{reservation_number}}">{{reservation_number}}</option>
	{{/each}}
</script>
