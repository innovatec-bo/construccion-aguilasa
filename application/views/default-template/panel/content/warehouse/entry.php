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
			<h1 class="page-header">Entrada de materiales</h1>
		</div>
		<div class="col-md-12">
			<?php
			$this->load->view("default-template/flash-data-basic-messages");
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Especifique la entrada de materiales</label>
				<select class="form-control">
					<option>Retirado de CRE</option>
					<option>Material nuevo devuelto por el constructor</option>
					<option disabled>Material viejo devuelto por el constructor</option>
					<option disabled>Material en buen estado devuelto por el constructor</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Materiales</label><br>
				<select class="form-control select2-materials" data-parsley-required="" parsley-trigger="change" name="materials">
					<option></option>
				</select>
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
						<th>Quitar</th>
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
						<td><input type="button" class="btn btn-danger btn-sm" value="X"></td>
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
</div>
<!-- /.container-fluid -->
