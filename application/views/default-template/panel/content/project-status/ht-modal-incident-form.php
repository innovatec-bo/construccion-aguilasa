<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 22/08/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-modal-incident-form" type="text/x-handlebars-template">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <form name="incident-form" data-parsley-validate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha del incidente</label>
                                    <div class="input-group date date-time-picker">
                                        <input name="incident-manual-entry-date" readonly="" class="form-control" required="" data-parsley-errors-container="#error-incident-manual-entry-date">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <div id="error-incident-manual-entry-date"></div>
                                </div>
                            </div>
                            {{#ifCond statusKeyword "==" "in_progress"}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>% fisico</label>
                                    <div class="input-group date date-time-picker">
                                        <input name="incident-percentage" value="{{currentPercentage}}" min="{{currentPercentage}}" max="99" class="form-control" required="" data-parsley-numeric data-parsley-errors-container="#error-incident-percentage">
                                        <span class="input-group-addon">
                                            %
                                        </span>
                                    </div>
                                    <div id="error-incident-percentage"></div>
                                </div>
                            </div>
                            {{/ifCond}}
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tipo de incidentes</label>
                                    <select class="form-control">
                                        <option value="1">Permisos</option>
                                        <option value="2">Fiscales</option>
                                        <option value="3">Vecinos</option>
                                        <option value="4">Linea Viva</option>
                                        <option value="5">Mecanico</option>
                                        <option value="6">Materiales incompletos</option>
                                        <option value="7">Climatológico</option>
                                        <option value="8">Otros</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{#ifCond statusKeyword "==" "in_progress"}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="pause-project">Esta incidencia pausa el proyecto.<br><em>Si marca esta casilla se recomienda colocar un detalle del por que de la pausa del proyecto.</em>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        {{/ifCond}}
                        {{#ifCond statusKeyword "==" "paused"}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="stop-project">Esta incidencia detiene el proyecto.<br><em>Si marca esta casilla se recomienda colocar un detalle del por que de la detencion del proyecto.</em>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        {{/ifCond}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Detalle</label>
                                        <textarea class="form-control" rows="2" name="incident-detail" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</script>