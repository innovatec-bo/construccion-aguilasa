<div class="container">
    <div class="row">
        <div class="col-md-offset-1 col-md-9">
            <div class="title-system-panel panel panel-default">
                <div class="panel-heading">
                    <h1 class="system-title text-center">Proyecto <?=$project['code_pro']?></h1>
                    <?php
                        $myEncrypt = new MY_Encrypt();
                        $dataToEncrypt = array("userId" => $user['id_usr']);
                        $dataToEncrypt = json_encode($dataToEncrypt);
                        $dataEncrypted = $myEncrypt->encode($dataToEncrypt);
                        $url = base_url('Incident/'.$dataEncrypted);
                    ?>
                    <a href="<?=$url?>" class="btn btn-outline btn-default btn-xs">Ir al Inicio <i class="fa fa-home"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-1 col-md-9">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-1 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Mi registro de incidencias
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="list-group" id='incident-list' style="height: 300px !important;position: relative;">
                                <?php 
                                    $html = '';
                                    foreach ($incidentList as $row) 
                                    {
                                        $label = '<span class="label label-danger">Pendiente</span>';
                                        if(is_numeric($row['solved_by']))
                                            $label = '<span class="label label-success">Solucionado</span>';
                                        $incidentType = $row['incident_type'] == ""?"Sin Definir":$row['incident_type'];
                                        $html .= '
                                            <a href="javascript:void(0)" class="list-group-item" data-project-percentage="0"  data-incident-date="'.$row['manual_entry_date'].'">
                                                '.$label.'<br>
                                                <strong>Detalle: </strong>'.$row['incident_detail'].'<br>
                                                <strong>Estatus en incidente: </strong>'.$row['status_on_incident'].'<br>
                                                <strong>Estatus actual: </strong>'.$row['current_status'].'<br>
                                                <strong>Tipo de incidente: </strong>'.$incidentType.'<br>
                                                <span class="text-muted small btn-block text-right">
                                                    <em>
                                                        '.$row['manual_entry_date'].'
                                                    </em>
                                                 </span>
                                            </a>
                                        '; 
                                    }
                                    echo $html;
                                ?>                    
                            </div>        
                        </div>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-primary panel-form-incident">
                <div class="panel-heading">
                    Formulario de registro de incidentes
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form role='form' name="incident-form" data-parsley-validate method="post">
                                <div class="form-group">
                                    <label>Fecha del incidente</label>
                                    <div class="input-group date date-time-picker">
                                        <input name="incident-manual-entry-date" readonly="" class="form-control input-sm" required="" data-parsley-errors-container="#error-incident-manual-entry-date" data-parsley-group="none-incident">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <div id="error-incident-manual-entry-date"></div>
                                </div>
                                <div class="form-group">
                                    <label>Tipo de incidente</label>
                                    <select class="form-control" name="incident-type" required>
                                        <option value=""></option>
                                        <option value="1" <?php echo  set_select('incident-type', '1'); ?>>Permisos</option>
                                        <option value="2" <?php echo  set_select('incident-type', '2'); ?>>Fiscales</option>
                                        <option value="3" <?php echo  set_select('incident-type', '3'); ?>>Vecinos</option>
                                        <option value="4" <?php echo  set_select('incident-type', '4'); ?>>Linea Viva</option>
                                        <option value="5" <?php echo  set_select('incident-type', '5'); ?>>Mecanico</option>
                                        <option value="6" <?php echo  set_select('incident-type', '6'); ?>>Materiales incompletos</option>
                                        <option value="7" <?php echo  set_select('incident-type', '7'); ?>>Climatológico</option>
                                        <option value="8" <?php echo  set_select('incident-type', '8'); ?>>Otros</option>
                                        <option value="10" <?php echo  set_select('incident-type', '10'); ?>>CRE</option>
                                        <option value="9" <?php echo  set_select('incident-type', '9'); ?>>Ninguno</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Detalle</label>                                    
                                    <textarea class="form-control" rows="3" name="incident-detail" maxlength="300"><?php echo set_value('incident-detail'); ?></textarea>
                                    <p class="help-block"><span id="textarea-counter">300</span> caracteres restantes</p>
                                </div>
                                <button type="submit" class="btn btn-default btn-block">Guardar</button>
                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>
</div>
