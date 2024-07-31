<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 13/06/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-modal-modify-schedule-budget" type="text/x-handlebars-template">
    <div class="row">
        <div class="col-md-12 status-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Total importe tentativo</label>
                                <input name="tentative-total-budget" data-parsley-type="number" type="number" class="form-control" required="" data-parsley-errors-container="#error-tentative-total-budget">
                                <div id="error-modify-manual-entry-date"></div>
                            </div>

                            <div class="form-group">
                                <label>Total importe tentativo</label>
                                <input name="design-budget" data-parsley-type="number" class="form-control" type="number" required="" data-parsley-errors-container="#error-design-budget">
                                <div id="error-design-budget"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

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
        <div class="col-md-12">
            <fieldset>
                <label>Fiscal(es) <a href="#" class="check-stakes-team"><i class="fa fa-question-circle"></i></a></label>
                <div class="form-group">
                    <select class="form-control ajax-get-responsible-list" multiple="multiple" parsley-trigger="change" id="ajax-get-responsible-list1">
                        {{#each responsibleListFiscal}}
                            <option data-user-id="{{id_usr}}" value="{{id_sre}}">{{firstname_usr}} {{lastname_usr}}</option>
                        {{/each}}
                    </select>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <fieldset>
                <label>Constructore(s) <a href="#" class="check-stakes-team"><i class="fa fa-question-circle"></i></a></label>
                <div class="form-group">
                    <select class="form-control ajax-get-responsible-list" multiple="multiple" data-parsley-required="" parsley-trigger="change" id="ajax-get-responsible-list2">
                        {{#each responsibleListBuilder}}
                            <option data-supervising-id="{{supervising_user_usr}}" value="{{id_sre}}">{{firstname_usr}} {{lastname_usr}}</option>
                        {{/each}}
                    </select>
                    <input type="hidden" name="responsible-list" value="">
                </div>
            </fieldset>
        </div>
    </div>
</script>