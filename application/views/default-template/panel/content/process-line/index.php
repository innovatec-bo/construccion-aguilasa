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
            <h1 class="page-header">Habilitar linea de proceso</h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
		<div class="col-md-12">
			<div class="alert alert-info">
				<i class="fa fa-info-circle"></i>
				Para habilitar la linea de procesos (presente en la vista de adminstraci&oacute;n de estados) es necesario agregar una excepcion a la lista
				inferior. La excepcion es temporal y por proyecto y fiscal.
			</div>
		</div>
		<div class="col-md-12">
			<div id="parsley-notices"></div>
			<form class="form-inline mb-2" data-parsley-validate="" name="external-observations-form">
				<div class="form-group">
					<label class="sr-only">Proyecto</label>
					<select class="form-control select2 project" name="project-id" required data-parsley-required-message="El proyecto es requerido." data-parsley-errors-container="#parsley-notices"></select>
				</div>
				<div class="form-group">
					<label class="sr-only" for="exampleInputEmail2">Fiscal</label>
					<select class="form-control" name="cre-fiscal-id" required data-parsley-required-message="Debe especificar un fiscal."  data-parsley-errors-container="#parsley-notices">
						<option value="">Elija un fiscal</option>
						<?php
						$option = "";
						/** @var Model_user $fiscal */
						foreach ($fiscals as $fiscal)
						{
							$option .= "<option value='".$fiscal->getId()."'>".$fiscal->getFullName()."</option>";
						}
						echo $option;
						?>
					</select>
				</div>
				<div class="form-group">
					<label class="sr-only" name="observation">Observaci&oacute;n</label>
					<textarea class="form-control" name="observation" rows="2" required data-parsley-required-message="La observacion es requerida." data-parsley-errors-container="#parsley-notices"></textarea>
				</div>
				<div class="form-group">
					<label class="sr-only" name="entry-date">Fecha</label>
					<div class="input-group date date-time-picker">
						<input name="entry-date" readonly="" class="form-control" required=""  data-parsley-required-message="La fecha de la observaci&oacute;n. es requerida" data-parsley-errors-container="#parsley-notices">
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
				<button type="submit" class="btn btn-danger">Guardar</button>
			</form>
		</div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="external-observation-index">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Proyecto</th>
						<th>Estado en<br>observaci&oacute;n</th>
                        <th>Observaci&oacute;n</th>
                        <th>Fecha<br>Observaci&oacute;n</th>
                        <th>Fiscal Externo</th>
                        <th>Registrado por</th>
                        <th>Corregido por</th>
                        <th>Detalle de<br>la correccion</th>
                        <th>Fecha de correccion</th>
                        <th>Corregido</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<?php
$this->load->view("default-template/panel/content/external-observation/ExternalObservationHandler");
?>
