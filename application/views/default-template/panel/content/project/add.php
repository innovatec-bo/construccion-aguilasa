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
            <h1 class="page-header">AGREGAR PROYECTO</h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Informacion del proyecto
                </div>

                <div class="panel-body">
                    <form role="form" method="post" name="project-add-form" data-parsley-validate data-parsley-excluded="input[disabled]">
                        <input type="hidden" name="project-id" value="">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Codigo</label>
                                    <input class="form-control" value="<?=set_value("project-code")?>" required name="project-code" placeholder="Ingrese el código del proyecto">
                                </div>
                            </div>
                        </div>
                        <div class="row hide">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre de proyecto</label>
                                    <input class="form-control" value="<?=set_value("project-name")?>" name="project-name" placeholder="Ingrese el nombre del proyecto">
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha de folder</label>
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input name="project-folder-date" readonly class="form-control" />
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
                                            $html .= '<option value="'.$contract->id_con.'" >'.$contract->contract_number_con.'</option>';
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
<!--                                    <input class="form-control" required value="--><?//=set_value("project-cre-fiscal")?><!--" name="project-cre-fiscal" placeholder="Fiscal de CRE">-->
                                    <select  class="form-control" name="project-cre-fiscal" required>
                                        <option value="">Elija un Fiscal</option>
                                        <?php
                                        $html = "";
                                        foreach ($creFiscalList as $fiscal)
                                        {
                                            $html .= '<option value="'.$fiscal->id_cfi.'" >'.$fiscal->firstname_cfi.' '.$fiscal->lastname_cfi.'</option>';
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
                                    <input class="form-control" value="<?=set_value("project-points")?>" name="project-points" placeholder="Puntos">
                                </div>
                                <div class="form-group">
                                    <em>Distancia Km</em><br>
                                    <input class="form-control" value="<?=set_value("project-meters-distance")?>" name="project-meters-distance" placeholder="Distancia">
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
                                    <label>Nivel de calidad</label>
                                    <select  class="form-control" name="quality-level" required>
                                        <option value="0">Ninguno</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Finalizacion de diseño (CRE)</label>
                                    <div class='input-group date' id='datetimepicker2'>
                                        <input name="cre-design-completion-date" readonly class="form-control" />
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
                                        <input name="cre-building-completion-date" readonly class="form-control" />
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
                                            $html .= '<option value="'.$position.'" >'.$position.'</option>';
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
                                    <input class="form-control" name="project-detail" placeholder="Puede ingresar un detalle acerca del proyecto">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="instant-approvement" value="1" <?php echo set_checkbox('instant-approvement', '1'); ?>>Voy a aprobar este proyecto
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="well well-lg hide" id="approvement-section">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Fecha de aprobacion</label>
                                                <div class="input-group date date-time-picker">
                                                    <input name="approved-entry-date" readonly="" class="form-control" required="" data-parsley-group="approved" data-parsley-errors-container="#error-approved-entry-date">
                                                    <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                                </div>
                                                <div id="error-approved-entry-date"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Codigo secundario</label>
                                            <div class="form-group">
                                                <input class="form-control" value="" name="secondary-code" placeholder="Codigo secundario" required="" data-parsley-group="approved">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-inline">
                                        <div class="col-md-12">
                                            <label>Importe (<span id="total-project-amount">0.00</span>)</label><br>
                                            <div class="form-group">
                                                <em>Diseño</em><br>
                                                <input class="form-control input-masked" value="" name="design-budget" placeholder="Diseño" required="" data-parsley-group="approved" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                            </div>
                                            <div class="form-group">
                                                <em>Construccion</em><br>
                                                <input class="form-control input-masked" value="" name="building-budget" placeholder="Construccion" required="" data-parsley-group="approved" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                            </div>
                                            <div class="form-group">
                                                <em>Transporte</em><br>
                                                <input class="form-control input-masked" value="" name="transportation-budget" placeholder="Transporte" required="" data-parsley-group="approved" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                            </div>
                                            <div class="form-group">
                                                <em>Linea viva</em><br>
                                                <input class="form-control input-masked" value="" name="live-line-budget" placeholder="Linea viva" required="" data-parsley-group="approved" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                            </div>
                                            <div class="form-group">
                                                <em>Derecho de via</em><br>
                                                <input class="form-control input-masked" value="" name="right-of-way-budget" placeholder="Derecho de via" required="" data-parsley-group="approved" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Nro. de grafo</label>
                                            <div class="form-group">
                                                <input class="form-control" value="" name="graph-number-budget" placeholder="Grafo" data-parsley-type="number" required="" data-parsley-group="approved">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Nro. de reserva</label>
                                            <div class="form-group">
                                                <input class="form-control" value="" name="reservation-number-budget" placeholder="Reservacion" data-parsley-type="number" required="" data-parsley-group="approved">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Observaciones</label>
                                        <textarea class="form-control" name="approved-detail" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" class="btn btn-primary save-project" data-send-to-design="0">Guardar</button>
                                <button type="button" class="btn btn-info save-project" data-send-to-design="1">Guardar y enviar a diseño</button>
                                <input type="hidden" name="send-to-design" value="">
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
