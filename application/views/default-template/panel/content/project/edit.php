<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 22:33
 */

$addressList = array(
    1 => "Sistema Santa Cruz",
    2 => "Sistema velasco",
    3 => "Sistema misiones",
    4 => "Sistema camiri",
    5 => "Sistema German bush",
    6 => "Sistema robore",
    7 => "Sistema valles"
);
?>
<div class="container-fluid">
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
                        <input type="hidden" name="project-id" value="">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Codigo</label>
                                    <input class="form-control" value="<?=set_value('project-code', $project["code_pro"])?>" required name="project-code" placeholder="Ingrese el codigo del proyecto">
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
                                    <div class='input-group date' id='datetimepicker1'>
                                        <?php
                                        $entryDate = "";
                                        if(isset($project["entry_date_pro"]))
                                        {
                                            $entryDate = $project["entry_date_pro"];
                                            $entryDate = DateTime::createFromFormat('Y-m-d 00:00:00', $entryDate);
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fiscal de CRE</label>
                                    <input class="form-control" value="<?=set_value('project-cre-fiscal', $project["cre_fiscal_pro"])?>" required name="project-cre-fiscal" placeholder="Fecha de ingreso del proyecto">
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
                                        foreach ($addressList as $key => $name)
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
                        <div class="row form-inline hide">
                            <div class="col-md-6">
                                <label>Area del proyecto</label><br>
                                <div class="form-group">
                                    <input class="form-control" readonly value="<?=set_value('project-points', $projectLastPoints["points_quantity_prp"])?>" name="project-points" placeholder="Puntos">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" readonly value="<?=set_value('project-meters-distance', $projectLastPoints["meters_distance_prp"])?>" name="project-meters-distance" placeholder="Distancia">
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" class="btn btn-primary save-project" data-project-status="">Guardar</button>
                                <?php
                                if($project["status_pro"] === NULL)
                                {
                                    ?>
                                    <button type="button" class="btn btn-info save-project" data-project-status="1">
                                        Guardar y enviar a diseño
                                    </button>
                                    <?php
                                }
                                ?>
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
