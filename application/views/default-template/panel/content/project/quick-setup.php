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
            <h1 class="page-header">Quick Setup<em class="subtext"><?=$projectFullDetail['code_pro']." (".$projectFullDetail['status_name_pst'].")"?></em></h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
        <div class="col-md-12">
			<?php
//			echo"<pre>";print_r($projectFullDetail);
			?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Configuraci&oacute;n r&aacute;pida para CAMBIOS en el proyecto.
                </div>
                <div class="panel-body">
                    <form role="form" method="post" name="project-quick-setup-form" data-parsley-validate>
                        <input type="hidden" name="project-id" value="<?=$project["id_pro"]?>">
                        <div class="row">
							<div class="col-md-12">
								<h3>Datos basicos <a href="javascript:void(0)" class="fa fa-question-circle"  data-trigger="hover" data-toggle="popover" title="Nota" data-content="No se requieren estados especificos para hacer estos cambios."></a></h3>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Codigo</label>
									<input class="form-control" value="<?=set_value('project-code', $project["code_pro"])?>" required name="project-code" placeholder="Ingrese el codigo del proyecto">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Contrato</label>
									<select  class="form-control" name="project-contract-id">
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
									<label>Fiscal de CRE</label>
									<select  class="form-control" name="project-cre-fiscal">
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
							<div class="col-md-12">
								<h3>Datos condicionados <a href="javascript:void(0)" class="fa fa-question-circle"  data-trigger="hover" data-toggle="popover" title="Nota" data-content="Algunos campos requiren que el proyecto haya pasado por cierto estados."></a></h3>
							</div>
							<div class="col-md-12">
								<h3></h3>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Encargado/Responsable
										<?php
										if(is_null($workFlow['project_manager_user_id']))
										{
										?>
										<a href="javascript:void(0)" class="fa fa-exclamation-circle text-danger"  data-trigger="hover" data-toggle="popover" data-container="body" title="Estados requeridos" data-content="Requiere haber sido previamente asignado"></a>
										<?php
										}
										?>
									</label>
									<select name="project-manager" class="form-control" parsley-trigger="change">
										<?php
										$options = "";
										foreach ($projectManagers as $user)
										{
											$selected = $workFlow['project_manager_user_id'] == $user->getId()?" selected ":"";
											$options .= " <option value='".$user->getId()."' ".$selected." >".$user->getFullName()."</option> ";
										}
										if(!is_null($workFlow['project_manager_user_id']))
											echo $options;
										?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Fiscal SEREBO
										<?php
										if(is_null($workFlow['fiscal_responsible_id']))
										{
											?>
											<a href="javascript:void(0)" class="fa fa-exclamation-circle text-danger"  data-trigger="hover" data-toggle="popover" data-container="body" title="Estados requeridos" data-content="Requiere haber sido previamente asignado"></a>
											<?php
										}
										?>
									</label>
									<select  class="form-control" name="responsible-ids[]">
										<?php
										$html = "";
										foreach ($responsibleListFiscal as $fiscal)
										{
											$selected = $workFlow['fiscal_responsible_id'] == $fiscal["id_usr"]?" selected ":"";
											$html .= '<option '.$selected.' value="'.$fiscal["id_sre"].'" >'.$fiscal["firstname_usr"].' '.$fiscal["lastname_usr"].'</option>';
										}
										if(!is_null($workFlow['fiscal_responsible_id']))
											echo $html;
										?>
									</select>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Constructor
										<?php
										if(is_null($workFlow['builder_responsible_id']))
										{
											?>
											<a href="javascript:void(0)" class="fa fa-exclamation-circle text-danger"  data-trigger="hover" data-toggle="popover" data-container="body" title="Estados requeridos" data-content="Requiere haber sido previamente puesto en construcci&oacute;n"></a>
											<?php
										}
										?>
									</label>
									<select  class="form-control" name="responsible-ids[]">
										<?php
										$html = "";
										foreach ($responsibleListBuilder as $builder)
										{
											$selected = $workFlow['builder_responsible_id'] == $builder["id_usr"]?" selected ":"";
											$html .= '<option '.$selected.' value="'.$builder["id_sre"].'" >'.$builder["firstname_usr"].' '.$builder["lastname_usr"].'</option>';
										}
										if(!is_null($workFlow['builder_responsible_id']))
											echo $html;
										?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Estacador
										<?php
										if(is_null($workFlow['stake_responsible_user_id']))
										{
											?>
											<a href="javascript:void(0)" class="fa fa-exclamation-circle text-danger"  data-trigger="hover" data-toggle="popover" data-container="body" title="Estados requeridos" data-content="Requiere haber sido previamente puesto en estacado"></a>
											<?php
										}
										?>
										</label>
									<select  class="form-control" name="staker">
										<?php
										$html = "";
										foreach ($responsibleListStacker as $staker)
										{
											$selected = $workFlow['stake_responsible_user_id'] == $staker["id_usr"]?" selected ":"";
											$html .= '<option '.$selected.' value="'.$staker["id_sre"].'" >'.$staker["firstname_usr"].' '.$staker["lastname_usr"].'</option>';
										}
										if(!is_null($workFlow['stake_responsible_user_id']))
											echo $html;
										?>
									</select>
								</div>
							</div>
                        </div>
                        <div class="row">

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="submit" class="btn btn-primary">
                                    Guardar
                                </button>
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
