<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 6/5/2018
 * Time: 21:06
 */
?>
<script id="ht-manpower-table" type="text/x-handlebars-template">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>ACTIV.</th>
            <th>ESTRUCTURA</th>
            <th>EJEC.</th>
            <th>DESCRIPCION</th>
            <th>UNIDAD</th>
            <th>CANTIDAD</th>
            <?php if($isSuperAdmin == 1){?>
            <th>P/UNITARIO</th>
            <th>P/TOTAL</th>
            <th>TRABAJADO</th>
            <th>DIFERENCIA</th>
            <?php }?>
        </tr>
        </thead>
        <tbody>
        {{#each laborCostMasterDetail}}
            <tr>
                <td class="text-center">{{index}}</td>
                <td class="text-center">{{activity}}</td>
                <td>{{structure_code}}</td>
                <td class="text-center">{{execution}}</td>
                <td>{{description}}</td>
                <td class="text-center">{{unit_of_measurement}}</td>
                <td class="text-right">{{quantity}}</td>
                <?php if($isSuperAdmin == 1){?>
                <td class="text-right">{{unit_price}}</td>
                <td class="text-right">{{total_price_by_structure}}</td>
                <td class="text-right">{{worked_up}}</td>
                <td class="text-right">{{diff}}</td>
                <?php }?>
            </tr>
        {{/each}}
        </tbody>
    </table>
</script>
<script id="ht-modal-form-add-manpower-progress" type="text/x-handlebars-template">
    <form name="manpower-progress-form" data-parsley-validate>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Fecha</label>
                    <div class="input-group date date-time-picker">
                        <input name="entry-date" readonly="" class="form-control" required="" data-parsley-errors-container="#error-entry-date">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    <div id="error-entry-date"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Constructores</label><br>
                    <select class="form-control select2-builders" multiple="multiple" data-parsley-required="" parsley-trigger="change" name="builders[]">
                        {{#each builders}}
                        <option value="{{id}}">{{firstName}} {{lastName}}</option>
                        {{/each}}
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Detalles</label>
                    <textarea class="form-control" name="detail" rows="2" placeholder=""></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-sm add-row">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div class="form-group">
                    <div class="table-responsive">
                        <em class="table-error-message hide">Debe agregar al menos una estructura al detalle</em>
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="thead-inverse">
                                <tr>
                                    <th class="hide">#</th>
                                    <th>ESTRUCTURA</th>
                                    <th>ACTIV.</th>
                                    <th>EJEC.</th>
                                    <th>DESCRIPCION</th>
                                    <th>UNIDAD</th>
                                    <th>CANTIDAD</th>
                                    <th>AVANCE</th>
                                    <th>QUITAR</th>
                                </tr>
                            </thead>
                            <tbody id="structure-item-list-content">
                            {{#each structureList}}
                                {{> ht-structure-item structure = this}}
                            {{/each}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
</script>
<script id="ht-structure-item-list" type="text/x-handlebars-template">
    {{#each structureList}}
        {{> ht-structure-item structure = this}}
    {{/each}}
</script>

<script id="ht-structure-item" type="text/x-handlebars-template">
    <tr data-row-index="{{index}}">
        <td class="text-center hide">{{index}}</td>
        <td>
            <select class="form-control input-sm select2-structure-code" name="worked-up[{{index}}][labor-cost-id]" data-parsley-required="">
                <option value=""></option>
                {{#each laborCostList}}
                    <option value="{{labor_cost_id}}" data-activity="{{activity}}" data-execution="{{execution}}" data-description="{{description}}" data-quantity="{{quantity}}" data-unit-of-measurement="{{unit_of_measurement}}">{{structure_code}}</option>
                {{/each}}
            </select>
        </td>
        <td><span class="activity"></span></td>
        <td class="text-center"><span class="execution"></span></td>
        <td><span class="description"></span></td>
        <td class="text-center"><span class="unit-of-measurement"></span></td>
        <td class="text-right"><span class="quantity"></span></td>
        <td class="text-center" style="padding:1px">
            <input class="input-masked" name="worked-up[{{index}}][quantity]" size="7" data-parsley-required="">
        </td>
        <td class="text-center">
            <a href="#" class="remove-row"><i class="fa fa-times"></i></a>
        </td>
    </tr>
</script>
<script id="ht-select2-template-result" type="text/x-handlebars-template">
    <div class="timeline-heading select2-template-result">
        <h4 class="timeline-title">{{structureCode}}</h4>
        <p style="margin-bottom: 0px;">
            <span class="label label-info">{{activity}}</span>
            <span class="label label-info">{{execution}}</span>
            <span class="label label-info">{{quantity}}</span>
            <span class="label label-info">{{unitOfMeasurement}}</span><br>
            <small>{{description}}</small>
        </p>
    </div>
</script>

<script id="ht-manpower-quick-log" type="text/x-handlebars-template">
    {{#ifCond log '==' ''}}
        Sin historial de avance.
    {{/ifCond}}
    {{#each log}}
        <h6 class="quick-log-status-name">{{fiscal}}
            {{#ifCond detail '!=' ''}}
                <a href="#" data-original-title="{{detail}}" data-toggle="tooltip" data-placement="top"><span class="fa fa-comment fa-fw"></span></a>
            {{/ifCond}}
            <span class="pull-right edit-date" data-log-id="{{logId}}">{{formatDate manualEntryDate "short"}}</span>
        </h6>
        <blockquote>
            <dl>
                {{#ifCond builders '!=' null}}
                    <dt>Constructores</dt>
                    <dd>{{builders}}</dd>
                {{/ifCond}}
                <dt>Structuras</dt>
                <dd>
                    {{#each itemList}}
                    {{activity}} {{execution}} <a href="#" data-original-title="{{description}}" data-toggle="tooltip" data-placement="top">{{structure_code}}</a> {{worked_up}} {{unit_of_measurement}}<br>
                    {{/each}}
                </dd>
            </dl>
        </blockquote>
    {{/each}}
</script>
<script id="ht-modal-form-add-labor-cost" type="text/x-handlebars-template">
    <select class='select2-labor-cost'></select>
</script>