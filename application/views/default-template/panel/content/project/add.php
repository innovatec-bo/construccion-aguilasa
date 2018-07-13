<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 22:33
 */
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Agregar proyecto</h1>
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
                    <form role="form" method="post" name="project-add-form" data-parsley-validate>
                        <input type="hidden" name="project-id" value="">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Codigo</label>
                                    <input class="form-control" required name="project-code" placeholder="Ingrese el código del proyecto">
                                </div>
                            </div>
                        </div>
                        <div class="row hide">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre de proyecto</label>
                                    <input class="form-control" name="project-name" placeholder="Ingrese el nombre del proyecto">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha de ingreso</label>
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input name="project-entry-date" readonly class="form-control" />
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
                                    <input class="form-control" required name="project-cre-fiscal" placeholder="Fecha de ingreso del proyecto">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Sistema</label>
                                    <select  class="form-control" name="project-system" required>
                                        <option value="">Elija un sistema</option>
                                        <?php
                                        $html = "";
                                        foreach ($projectSystems as $key => $name)
                                        {
                                            $html .= '<option value="'.$key.'" >'.$name.'</option>';
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
                                    <label>Dirección</label>
                                    <input class="form-control" required name="project-address" placeholder="Ubicación/dirección del proyecto">
                                </div>
                            </div>
                        </div>
                        <div class="row form-inline">
                            <div class="col-md-6">
                                <label>Area del proyecto</label><br>
                                <div class="form-group">
                                    <em>Puntos</em><br>
                                    <input class="form-control" name="project-points" placeholder="Puntos">
                                </div>
                                <div class="form-group">
                                    <em>Distancia Km</em><br>
                                    <input class="form-control" name="project-meters-distance" placeholder="Distancia">
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" class="btn btn-primary save-project" data-project-status="7">Guardar</button>
                                <button type="button" class="btn btn-info save-project" data-project-status="1">Guardar y enviar a diseño</button>
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
