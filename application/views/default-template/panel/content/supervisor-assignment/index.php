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
            <h1 class="page-header">Asignacion de Supervisor</h1>
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
	<div class="row area-to-block">
		<div class="col-md-12">
			<form class="form-inline mb-2">
				<div class="form-group">
					<select class="form-control" name="month">
						<?php
						foreach ($months as $number => $text)
						{
							$selected = $number == date('m')?" selected ":"";
							echo '<option value="'.$number.'" '.$selected.' >'.$text.'</option>';
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<select class="form-control" name="year">
						<?php
						foreach ($years as $year)
						{
							$selected = $year == date('Y')?" selected ":"";
							echo '<option value="'.$year.'" '.$selected.' >'.$year.'</option>';
						}
						?>
					</select>
				</div>
				<button type="button" class="btn btn-info load-distribution-list">Ver distribuci&oacute;n</button>
				<button type="button" class="btn btn-success save-distribution-list">Guardar cambios</button>
			</form>
		</div>
		<div class="col-md-12">
			<p class="help-block">Para realizar cambios en las asignaciones, solo debe arrastrar los nombres de los constructores al lugar que corresponda.<br><strong>No olvide guardar los cambios</strong></p>
		</div>
	</div>
    <div class="row area-to-block">
		<div class="col-md-3">
			<div class="row">
				<div class="col-md-12" id="available-builders-content">

				</div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="row" id="distribution-content">

			</div>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
