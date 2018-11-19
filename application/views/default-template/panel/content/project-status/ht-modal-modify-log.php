<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 13/06/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-modal-modify-history-manual-entry-date" type="text/x-handlebars-template">
    <div class="row">
        <div class="col-md-12 status-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha de ingreso</label>
                                <div class="input-group date date-time-picker">
                                    <input name="modify-manual-entry-date" readonly="" class="form-control" required="" data-parsley-errors-container="#error-modify-manual-entry-date">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <div id="error-modify-manual-entry-date"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

<script id="ht-modal-modify-history-points-distance" type="text/x-handlebars-template">
    <div class="row">
        <div class="col-md-12 status-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="row form-inline">
                        <div class="col-md-6">
                            <label>Area del proyecto</label><br>
                            <div class="form-group">
                                <em>Puntos</em><br>
                                <input class="form-control" value="" name="log-project-points" placeholder="Puntos" required="" data-parsley-type="integer">
                            </div>
                            <div class="form-group">
                                <em>Distancia Km</em><br>
                                <input class="form-control" value="" name="log-project-distance" placeholder="Distancia" data-parsley-type="number" required="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

<script id="ht-modal-modify-history-construction-responsible" type="text/x-handlebars-template">
    <div class="row">
        <div class="col-md-12 status-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="row form-inline">
                        <div class="col-md-6">
                            <label>Area del proyecto</label><br>
                            <div class="form-group">
                                <em>Puntos</em><br>
                                <input class="form-control" value="" name="log-project-points" placeholder="Puntos" required="" data-parsley-type="integer">
                            </div>
                            <div class="form-group">
                                <em>Distancia Km</em><br>
                                <input class="form-control" value="" name="log-project-distance" placeholder="Distancia" data-parsley-type="number" required="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>