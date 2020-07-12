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
            <h1 class="page-header">Editar proyecto</h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Informacion del proyecto
                </div>
                <div class="panel-body">
                    <form role="form" method="post" name="proyect-edit-form" data-parsley-validate>
                        <div class="hide">
                            <!-- <input name="latitude" value="<?=set_value('latitude',$project["latitude_pro"])?>" type="text" required>
                            <input name="longitude" value="<?=set_value('longitude',$project["longitude_pro"])?>" type="text" required data-parsley-errors-container="#map-location-error-message-parsley" data-parsley-error-message="Debe marcar un punto en el mapa"> -->
                        </div>
                        <input type="hidden" name="project-id" value="<?=$project["id_pro"]?>">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Codigo</label>
                                    <input class="form-control" value="<?=set_value('project-code', $project["code_pro"])?>" required name="project-code" placeholder="Ingrese el codigo del proyecto">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Codigo secundario</label>
                                <div class="form-group">
                                    <input class="form-control" value="<?=set_value('project-secondary-code', $project["secondary_code_pro"])?>" name="project-secondary-code" placeholder="Codigo secundario" required="" data-parsley-group="approved">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Area de trabajo</label>
                                    <select  class="form-control" name="work-area">
                                        <option value="">Elija una area</option>
                                        <option value="gis"<?=$project["work_area_pro"] == "gis"?"selected":""?>>GIS</option>
                                        <option value="gir"<?=$project["work_area_pro"] == "gir"?"selected":""?>>GIR</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Año del proyecto</label>
                                    <div class='input-group year'>
                                        <input name="project-year" readonly class="form-control" value="<?=$project["project_year_pro"]?>" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Detalle del proyecto</label>
                                    <input class="form-control" value="<?=$project["detail_pro"]?>" required name="project-detail" placeholder="Puede ingresar un detalle acerca del proyecto">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 hide">
                                <div class="form-group">
                                    <label>Nombre del proyecto</label>
                                    <input class="form-control" value="<?=set_value('project-name', $project["project_name_pro"])?>" name="project-name" placeholder="Nombre del proyecto">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha de ingreso</label>
                                    <div class='input-group'>
                                        <?php
                                        $entryDate = "";
                                        if(isset($project["entry_date_pro"]))
                                        {
                                            $entryDate = $project["entry_date_pro"];
                                            $entryDate = DateTime::createFromFormat('Y-m-d H:i:s', $entryDate);
                                            $entryDate = date_format($entryDate, 'd-m-Y');
                                        }
                                        ?>
                                        <input name="project-entry-date" value="<?=set_value('project-entry-date', $entryDate)?>" readonly class="form-control" />
                                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha de folder</label>
                                    <div class='input-group date' id='datetimepicker1'>
                                        <?php
                                        $folderDate = "";
                                        if(isset($project["folder_date_pro"]))
                                        {
                                            $folderDate = $project["folder_date_pro"];
                                            $folderDate = DateTime::createFromFormat('Y-m-d H:i:s', $folderDate);
                                            $folderDate = date_format($folderDate, 'd-m-Y');
                                        }
                                        ?>
                                        <input name="project-folder-date" value="<?=set_value('project-folder-date', $folderDate)?>" readonly class="form-control" />
                                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Contrato</label>
                                    <select  class="form-control" name="project-contract-id" required>
                                        <option value="">Elija un contrato</option>
                                        <?php
                                        $html = "";
                                        foreach ($contractList as $contract)
                                        {
                                            $selected = $project["contract_id_pro"] == $contract->id_con?" selected ":"";
                                            $html .= '<option '.$selected.' value="'.$contract->id_con.'" >'.$contract->contract_number_con.'</option>';
                                        }
                                        echo $html;
                                        ?>
                                    </select>
                                </div>
                            </div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Contrato final</label>
									<select  class="form-control" name="project-end-contract-id">
										<option value="">Elija un contrato</option>
										<?php
										$html = "";
										foreach ($contractList as $contract)
										{
											$selected = $project["end_contract_pro"] == $contract->id_con?" selected ":"";
											$html .= '<option '.$selected.' value="'.$contract->id_con.'" >'.$contract->contract_number_con.'</option>';
										}
										echo $html;
										?>
									</select>
								</div>
							</div>
                        </div>
                        <div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Fiscal de CRE</label>
									<!--                                    <input class="form-control" value="--><?//=set_value('project-cre-fiscal', $project["cre_fiscal_pro"])?><!--" required name="project-cre-fiscal" placeholder="Fecha de ingreso del proyecto">-->
									<select  class="form-control" name="project-cre-fiscal" required>
										<option value="">Elija un Fiscal</option>
										<?php
										$html = "";
										foreach ($creFiscalList as $fiscal)
										{
											$fiscal = $fiscal->toArray();
											$selected = $project["cre_fiscal_pro"] == $fiscal["id_usr"]?" selected ":"";
											$html .= '<option '.$selected.' value="'.$fiscal["id_usr"].'" >'.$fiscal["firstname_usr"].' '.$fiscal["lastname_usr"].'</option>';
										}
										echo $html;
										?>
									</select>
								</div>
							</div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Sistema</label>
                                    <select  class="form-control" name="project-system" required>

                                        <option value="">Elija una direccion</option>
                                        <?php
                                        $html = "";
                                        foreach ($projectSystems as $key => $name)
                                        {
                                            $selected = $project["system_pro"] == $key?" selected ":"";
                                            $html .= '<option value="'.$key.'" '.$selected.'>'.$name.'</option>';
                                        }
                                        echo $html;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Direccion</label>
                                    <input class="form-control" value="<?=set_value('project-address', $project["address_pro"])?>" required name="project-address" placeholder="Ubicación/dirección del proyecto">
                                </div>
                            </div>
                        </div>
                        <div class="row form-inline">
                            <div class="col-md-6">
                                <label>Coordenadas del proyecto</label><br>
                                <div class="form-group">
                                    <!-- <em>Latitud</em><br> -->
                                    <input class="form-control" value="<?=set_value('latitude',$project["latitude_pro"])?>" name="latitude" placeholder="-17.778556">
                                </div>
                                <div class="form-group">
                                    <!-- <em>Longitud</em><br> -->
                                    <input class="form-control" value="<?=set_value('longitude',$project["longitude_pro"])?>" name="longitude" placeholder="-63.180389">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary search-coordinate-button" type="button">Buscar</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <em>En google earth ir al menu Herramientas -> opciones -> escoger tipo de coordenadas Grados decimales. Con esto obtendra el formato indicado de coordenadas para este mapa. NOTA: no copiar el simbolo de grados (°)</em>
                                <a target="_blank" href="https://wa.me/?text=https://www.google.com/maps/search/?q=47.5951518,-122.3316393">hhh</a>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-md-12">
                                <label class="required hide" data-field="name">
                                    <label>Ubicacion del proyecto</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control search-address-data" placeholder="Ingrese ubicacion">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary search-address-button" type="button">Buscar</button>
                                        </span>
                                    </div>
                                </label><!-- /input-group -->
                                <div class="map-fancy-framework">
                                    <div id="maps" style="height: 300px;width: auto">
                                    </div>
                                    <em class="map-search-message"></em>
                                    <div id="map-location-error-message-parsley"></div>
                                </div>
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Administrado por</label>
                                    <select  class="form-control" name="management-by" required>
                                        <option value="">Elija donde esta la administracion de este proyecto</option>
                                        <?php
                                        $html = "";
                                        foreach ($projectSystems as $key => $name)
                                        {
                                            $selected = $project["management_by_pro"] == $key?" selected ":"";
                                            $html .= '<option value="'.$key.'" '.$selected.'>'.$name.'</option>';
                                        }
                                        echo $html;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Nivel de calidad</label>
                                    <select  class="form-control" name="quality-level" required>
                                        <option value="0"<?=$project["quality_level_pro"] == 0?"selected":""?>>Ninguno</option>
                                        <option value="1"<?=$project["quality_level_pro"] == 1?"selected":""?>>1</option>
                                        <option value="2"<?=$project["quality_level_pro"] == 2?"selected":""?>>2</option>
                                        <option value="3"<?=$project["quality_level_pro"] == 3?"selected":""?>>3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fin de diseño (CRE)</label>
                                    <div class='input-group date' id='datetimepicker2'>
                                        <?php
                                        $date = "";
                                        if(isset($project["cre_design_completion_date_pro"]))
                                        {
                                            $date = $project["cre_design_completion_date_pro"];
                                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
                                            $date = date_format($date, 'd-m-Y');
                                        }
                                        ?>
                                        <input name="cre-design-completion-date" readonly class="form-control" value="<?=set_value('cre-design-completion-date', $date)?>"/>
                                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fin de construccion (CRE)</label>
                                    <div class='input-group date' id='datetimepicker3'>
                                        <?php
                                        $date = "";
                                        if(isset($project["cre_building_completion_date_pro"]))
                                        {
                                            $date = $project["cre_building_completion_date_pro"];
                                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
                                            $date = date_format($date, 'd-m-Y');
                                        }
                                        ?>
                                        <input name="cre-building-completion-date" readonly class="form-control" value="<?=set_value('cre-building-completion-date', $date)?>" />
                                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Posicion presupuestaria</label>
                                    <select  class="form-control" name="project-budgetary-position">
                                        <option value="">Elija la posicion presupuestaria</option>
                                        <?php
                                        $html = "";
                                        for ($i = 0; $i<11; $i++)
                                        {
                                            $position = ($i+1) * 10;
                                            $selected = $project["budgetary_position_pro"] == $position?" selected ":"";
                                            $html .= '<option '.$selected.' value="'.$position.'" >'.$position.'</option>';
                                        }
                                        echo $html;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" class="btn btn-info save-project" data-project-status="">
                                    Guardar
                                </button>
                                <input type="hidden" name="project-status" value="">
                            </div>
                        </div>
                    <!-- /.row (nested) -->
                    </form>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
