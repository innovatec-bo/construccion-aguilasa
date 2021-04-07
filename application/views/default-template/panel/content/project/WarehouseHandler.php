<script id="table-row" type="text/x-handlebars-template">
	<tr>
		<input type="hidden" name="summary[{{data.material_code}}][id]" value="{{data.material_id}}">
<!--		<td>1</td>-->
		<td class="text-right">{{data.material_code}}</td>
		<td class="text-left">{{data.material_description}}</td>
		<td class="text-right">{{numberFormat data.quantity_assigned}}</td>
		<td class="text-right">{{numberFormat data.quantity_picked_up_from_cre}}</td>
<!--		<td class="text-right">{{numberFormat data.quantity_materials_delivered_to_builder}}</td>-->
<!--		<td class="text-right">{{numberFormat data.quantity_materials_delivered_to_cre}}</td>-->
<!--		<td class="text-right">{{numberFormat data.quantity_new_materials_returned_by_builder}}</td>-->
<!--		<td class="text-right">{{numberFormat data.quantity_old_materials_returned_by_builder}}</td>-->
<!--		<td class="text-right">{{numberFormat data.quantity_good_condition_materials_returned_by_builder}}</td>-->
		<td class="text-right">{{numberFormat data.quantity_in_warehouse}}</td>
		<td class="text-right"><input type="text" name="summary[{{data.material_code}}][quantity]" value="0" size="7"></td>
<!--		<td><input type="button" class="btn btn-danger btn-sm wh-quit-row" value="X"></td>-->
		<td>
			<select class="form-control input-sm" name="summary[{{data.material_code}}][status]">
				<option value="1">NVO</option>
			</select>
		</td>
	</tr>
</script>
<script id="reservation-number-options" type="text/x-handlebars-template">
	<option>--Elija un Nro. de reserva--</option>
	{{#each options}}
		<option value="{{reservation_number}}">{{reservation_number}}</option>
	{{/each}}
</script>
