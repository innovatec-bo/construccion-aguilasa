<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 13/06/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-status-schedule-form" type="text/x-handlebars-template">
    <div class="tab-pane active" role="tabpanel" id="step_schedule">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Formulario de Cronograma new
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 status-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha de ingreso</label>
                                            <div class="input-group date date-time-picker">
                                                <input name="schedule-entry-date" readonly="" class="form-control" required="" data-parsley-group="schedule" data-parsley-errors-container="#error-schedule-entry-date">
                                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                            </div>
                                            <div id="error-schedule-entry-date"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha inicio</label>
                                            <div class="input-group date date-time-picker">
                                                <input name="project-start" readonly="" class="form-control" required="" data-parsley-group="schedule" data-parsley-errors-container="#error-project-start">
                                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                            </div>
                                            <div id="error-project-start"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha fin</label>
                                            <div class="input-group date date-time-picker">
                                                <input name="project-end" readonly="" class="form-control" required="" data-parsley-group="schedule" data-parsley-errors-container="#error-project-end">
                                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                            </div>
                                            <div id="error-project-end"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea class="form-control" name="schedule-detail" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary save-status" data-status-id="6" data-status-keyword="schedule">Guardar y enviar a aprobacion</button>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</script>