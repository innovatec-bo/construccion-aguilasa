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
            <h1 class="page-header"><?=$viewTitle?></h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>

        <div class="col-md-12">
            <input type="hidden" name="status-set" value="<?=$statusSet?>">
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
                    <!-- <div class="col-md-2">
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
                    </div> -->
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
					<!-- <div class="col-md-2">
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
					</div> -->
                    <!-- <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkbox my-0">
                                    <label>
                                        <input type="checkbox" name="none-materials-picked-up-from-cre" value="0"> Sin material retirado de CRE
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkbox my-0">
                                    <label>
                                        <input type="checkbox" name="all-materials-picked-up-from-cre"> Todo el material retirado de CRE
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkbox my-0 mb-3">
                                    <label>
                                        <input type="checkbox" disabled> Todo el material devuelto a CRE
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                    </div> -->
                    
                    <div class="col-md-12">
                        <div class="form-group mb-0">
                            <button class="btn btn-primary input-sm" id="send-filters" type="button" data-content-data="chart-property-offers-based-on-property-types">Filtrar</button>
                            <button class="btn btn-danger input-sm" id="remove-additional-parameters" type="button" data-content-data="chart-property-offers-based-on-property-types">Remove filtros</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <form name="all-projects-log" action="<?=base_url("panel/Project/getAllProjectsLog")?>" method="post"></form>
        <form name="workflow-with-parameters" action="<?=base_url("panel/Project/getProjectWorkFlowReport")?>" method="post">
            <input type="hidden" name="is-super-admin" value="<?=$isSuperAdmin?>">
            <input type="hidden" name="code-list" value="">
            <input type="hidden" name="columns-to-download" value="">
        </form>
        <?php
        if($statusSet == "building") {
            ?>
            <div class="col-md-12">
                <div class="form-group">
                    <button type="button" class="btn btn-warning add-incident" data-status-id="<?=$status?>" data-project-id="all"><i class="fa fa-flag-o fa-fw"></i> Añadir incidencia a todos los proyectos
                    </button>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="project-index" data-project-systems='<?=json_encode($projectSystems)?>' data-project-status='<?=$projectStatusJson?>'>
                    <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">ORDEN</th>
                        <th class="text-center">CODIGO</th>
                        <th class="text-center">INGRESO<br>EN SISTEMA</th>
                        <!-- <th class="text-center">INGRESO<br>EN ESTADO</th> -->
                        <!-- <th class="text-center">DIAS<br>ESTATICO</th> -->
                        <th class="text-center">ESTADO</th>
                        <th class="text-center">SISTEMA</th>
                        <th class="text-center">DISTANCIA Y<br>PUNTOS</th>
                        <th class="text-center">FISCAL<br>DE CRE</th>
                        <!-- <th class="text-center">RESPONSABLE<br>DE ESTACADO</th> -->
                        <!-- <th class="text-center">RESPONSABLE</th> -->
                        <!-- <th class="text-center">FISCAL</th> -->
                        <!-- <th class="text-center">CONSTRUCTOR</th> -->
                        <th class="text-center">UBICACION</th>
                        <!-- <th class="text-center">IMPORTE<br>Bs.</th> -->
                        <th class="text-center"><i class="fa fa-cogs fa-2x"></i></th>
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
