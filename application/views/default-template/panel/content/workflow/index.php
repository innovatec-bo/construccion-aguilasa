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
            <h1 class="page-header">Workflow</h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
		<div class="col-md-12">
			<form class="form-group" id="extra-request-data">
				<input type="hidden" name="status" value="<?=$status?>">
				<input type="hidden" name="show-edit-button" value="<?=$showEditButton?>">
				<input type="hidden" name="show-delete-button" value="<?=$showDeleteButton?>">
				<fieldset class="custom-border">
					<legend class="custom-border">Filtros</legend>
					<div class="col-md-2">
						<div class="form-group">
							<label>Area de trabajo</label>
							<select class="form-control" name="work-area">
								<option value="">--Todos--</option>
								<option value="gir">GIR</option>
								<option value="gis">GIS</option>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label>Fiscales</label>
							<select class="form-control" name="fiscal-responsible-id">
								<option value="">--Todos--</option>
								<?php
								$list = "";
								foreach ($fiscalList as $fiscal)
								{
									$list .= "<option value='".$fiscal->getId()."'>".$fiscal->getFullName()."</option>";
								}
								echo $list;
								?>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label>Constructores</label>
							<select class="form-control" name="builder-responsible-id">
								<option value="">--Todos--</option>
								<?php
								$list = "";
								foreach ($builderList as $builder)
								{
									$list .= "<option value='".$builder->getId()."'>".$builder->getFullName()."</option>";
								}
								echo $list;
								?>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label>Mano de obra</label>
							<select class="form-control" name="manpower-uploaded">
								<option value="">--Todos--</option>
								<option value="1">SI</option>
								<option value="0">NO</option>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label>Estado</label>
							<select class="form-control" name="status">
								<option value="">--Todos--</option>
								<?php
								$excludedStatusId = array(1,8,13,22);
								$html = '';
								/** @var Model_project_status $status */
								foreach ($statusInLog as $status)
								{
									if(array_search($status->getId(),$excludedStatusId) !== FALSE)
										continue;
									$html .= '<option value="'.$status->getId().'">'.$status->getName().'</option>';
								}
								echo $html;
								?>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group mb-0">
							<button class="btn btn-primary input-sm" id="send-filters" type="button" data-content-data="chart-property-offers-based-on-property-types">Filtrar</button>
							<button class="btn btn-danger input-sm" id="remove-additional-parameters" type="button" data-content-data="chart-property-offers-based-on-property-types">Remove filtros</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
        <div class="col-md-12">
			<script>
				var columns = <?=json_encode($columns)?>;
			</script>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="workflow-index">
                    <thead>
                    <tr>
						<?php
						$th = "";
						foreach ($columns as $key => $title)
						{
							$th .= "<th>{$title}</th>";
						}
						echo $th;
						?>
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
