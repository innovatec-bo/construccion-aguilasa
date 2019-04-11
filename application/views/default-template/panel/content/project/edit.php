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
                        <input type="hidden" name="project-id" value="<?=$project["id_pro"]?>">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Codigo</label>
                                    <input class="form-control" value="<?=set_value('project-code', $project["code_pro"])?>" required name="project-code" placeholder="Ingrese el codigo del proyecto">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Codigo secundario</label>
                                <div class="form-group">
                                    <input class="form-control" value="<?=set_value('project-secondary-code', $project["secondary_code_pro"])?>" name="project-secondary-code" placeholder="Codigo secundario" required="" data-parsley-group="approved">
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
                        </div>
                        <div class="row">
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
                        </div>
                        <div class="row">
                            <div class="col-md-12">
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
                        </div>
                        <div class="row">
                            <div class="col-md-6">
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
                        </div>
                        <div class="row">
                            <div class="col-md-12">
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
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Direccion</label>
                                    <input class="form-control" value="<?=set_value('project-address', $project["address_pro"])?>" required name="project-address" placeholder="Ubicación/dirección del proyecto">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
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
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nivel de calidad</label>
                                    <select  class="form-control" name="quality-level" required>
                                        <option value="0"<?=$project["quality_level_pro"] == 0?"selected":""?>>Ninguno</option>
                                        <option value="1"<?=$project["quality_level_pro"] == 1?"selected":""?>>1</option>
                                        <option value="2"<?=$project["quality_level_pro"] == 2?"selected":""?>>2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Finalizacion de diseño (CRE)</label>
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
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Finalizacion de construccion (CRE)</label>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Detalle del proyecto</label>
                                    <input class="form-control" value="<?=$project["detail_pro"]?>" name="project-detail" placeholder="Puede ingresar un detalle acerca del proyecto">
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
