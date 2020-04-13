<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 6/5/2018
 * Time: 21:06
 */
$projectSystems = array(
            1 => "Sistema Santa Cruz",
            2 => "Sistema Velasco",
            3 => "Sistema Misiones",
            4 => "Sistema Camiri",
            5 => "Sistema German bush",
            6 => "Sistema Robore",
            7 => "Sistema Valles"
        );
?>

<script id="ht-building-points" type="text/x-handlebars-template">
    <div class="col-md-9">
        <div class="panel-group" id="accordion">
            {{#each buildingPoints}}
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{point_id}}">
                            <span class="fa fa-map-marker"></span> Punto {{point_label}}
                        </a>
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-default btn-xs add-point-to-point-progress" data-point-id="{{point_id}}"><span class="fa fa-plus"></span></button>
                            </div>
                        </div>
                    </h4>
                </div>
                <div id="collapse{{point_id}}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="table-responsive" id="manpower-table">
                            <table class="table table-striped table-bordered table-hover table-minimum-padding">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ACTIV.</th>
                                        <th>CANTIDAD<br>A USAR</th>
                                        <th>ESTRUCTURA</th>
                                        <th>EJEC.</th>
                                        <th>UNIDAD</th>
                                        <th>DESCRIPCION</th>
                                        <th>CANTIDAD<br>UTILIZADA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{#each structures}}
                                    <tr>
                                        <td class="text-center">{{index}}</td>
                                        <td class="text-center">{{labor_activity}}</td>
                                        <td class="text-right">{{quantity_to_use}}</td>
                                        <td>{{structure_code}}</td>
                                        <td class="text-center">{{execution}}</td>
                                        <td class="text-center">{{unit_of_measurement}}</td>
                                        <td>{{description}}</td>
                                        <td class="text-right">{{total_worked_up}}{{unit_of_measurement}}</td>
                                    </tr>
                                    {{/each}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{/each}}
        </div>
    </div>
</script>
<script id="ht-table-structures-to-use" type="text/x-handlebars-template">
    
</script>
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
            
            <th>P/UNITARIO</th>
            <th>P/TOTAL</th>
            <th>TRABAJADO</th>
            <th>DIFERENCIA</th>
            
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
                
                <td class="text-right">{{unit_price}}</td>
                <td class="text-right">{{total_price_by_structure}}</td>
                <td class="text-right">{{worked_up}}</td>
                <td class="text-right">{{diff}}</td>
                
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
                                    <th width="10">ACTIV.</th>
                                    <th width="10">EJEC.</th>
                                    <th>DESCRIPCION</th>
                                    <th width="10">UNIDAD</th>
                                    <th width="10">CANT.</th>
                                    <th width="10">AVANCE</th>
                                    <th width="10">P.UNITARIO</th>
                                    <th width="10">QUITAR</th>
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
                    <option value="{{labor_cost_id}}" data-activity="{{activity}}" data-execution="{{execution}}" data-description="{{description}}" data-quantity="{{quantity}}" 
                    data-unit-price="{{unit_price}}" 
                    data-unit-of-measurement="{{unit_of_measurement}}">{{structure_code}}</option>
                {{/each}}
            </select>
        </td>
        <td><span class="activity"></span></td>
        <td class="text-center"><span class="execution"></span></td>
        <td><span class="description"></span></td>
        <td class="text-center"><span class="unit-of-measurement"></span></td>
        <td class="text-right"><span class="quantity"></span></td>
        <td class="text-center" style="padding:1px">
            <input class="input-masked" name="worked-up[{{index}}][quantity]" size="10" data-parsley-required="">
        </td>
        <td class="text-center" style="padding:1px">
            <input class="input-masked-price unit-price" name="worked-up[{{index}}][unit-price]" size="10" data-parsley-required="">
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
        <h6 class="quick-log-status-name">
            <div class="dropdown" style='display:inline'>
              <button class="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <span class="caret"></span>
                
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="#" class='edit-log' data-log-id="{{logId}}"><i class='fa fa-edit fa-fw'></i> Editar</a></li>
                <li><a href="#" class='delete-log' data-log-id="{{logId}}"><i class='fa fa-trash fa-fw'></i> Eliminar</a></li>
              </ul>
            </div>
            {{fiscal}}
            {{#ifCond detail '!=' ''}}
                <a href="#" data-original-title="{{detail}}" data-toggle="tooltip" data-placement="top"><span class="fa fa-comment fa-fw"></span></a>
            {{/ifCond}}
            <span class="pull-right edit-date" data-log-id="{{logId}}">{{formatDate manualEntryDate "short"}}</span>
        </h6>
        <blockquote>
            <dl>
                {{#ifCond pointLabel '!=' null}}
                <dt class="text-center"><i class='fa fa-map-marker fa-fw'></i>Punto {{pointLabel}}</dt>
                {{/ifCond}}
                {{#ifCond builders '!=' null}}
                    <dt>Constructores</dt>
                    <dd style='padding-left:10px'>{{builders}}</dd>
                {{/ifCond}}
                <dt>Structuras</dt>
                <dd style='padding-left:10px'>
                    {{#each itemList}}
                    {{activity}} {{execution}} <a href="#" data-original-title="{{description}}" data-toggle="tooltip" data-placement="top">{{structure_code}}</a> {{worked_up}} {{unit_of_measurement}}<br>
                    {{/each}}
                </dd>
            </dl>
        </blockquote>
    {{/each}}
</script>
<script id="ht-modal-form-add-labor-cost" type="text/x-handlebars-template">
    <div class='row'>
        <div class='col-md-6'>
            <dl>
                <dt>Proyecto</dt>
                <dd>{{project.code_pro}}</dd>
                <dt>Posicion presupuestaria</dt>
                <dd>{{project.budgetary_position_pro}}</dd>
            </dl>
        </div>
        <div class='col-md-6'>
            <dl>
                <dt>Administracion</dt>
                <dd>{{project.managementBy}}</dd>
                <dt>Detalle</dt>
                <dd>{{project.detail_pro}}</dd>
            </dl>
        </div>
    </div>
    
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">Aniadir desde estructura existente</a>
        </li>
        <li class=""><a href="#profile" data-toggle="tab" aria-expanded="false">Aniadir una nueva estructura</a>
        </li>                                
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade active in" id="home">
            <div class='row'>
                <div class="col-lg-12">
                    <form role="form" name='add-existing-structure'>
                        <h5 class="modal-form-header">Seleccion de estructura</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Posicion presupuestaria</label>
                                    <select  class="form-control" name="project-budgetary-position">
                                        <option value="">Cualquiera</option>
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
                            <div class='col-md-6'>            
                                <div class="form-group">
                                    <label>Administrado por</label>
                                    <select  class="form-control" name="management-by" required>
                                        <option value="">Cualquiera</option>
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
                            <div class='col-md-12'>
                                <div class="form-group">
                                    <label>Estructuras y costos existentes</label>
                                    <select class='select2-labor-cost' name="structure-id"></select>
                                    <p class="help-block">Puede ingresar el codigo de estructura, descripcion de estructura o el codigo del proyecto</p>
                                </div>
                            </div>
                        </div>
                        <h5 class="modal-form-header">Detalle de Mano de obra</h5>                    
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Actividad</label>
                                    <select class="form-control" name='activity'>
                                        <option value='I'>Instalacion</option>
                                        <option value='R'>Retiro</option>
                                        <option value='M'>Movimiento</option>
                                    </select>
                                </div>        
                            </div>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Ejecucion</label>
                                    <select class="form-control" name='execution'>
                                        <option value='LV'>Linea viva</option>
                                        <option value='LM'>Linea muerta</option>
                                    </select>
                                </div>        
                            </div>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <input class="form-control input-masked" name='quantity' data-inputmask="'alias': 'decimal','digits':'2', 'groupSeparator': ',', 'autoGroup': true" value="0" readonly>
                                    <p class="help-block">La cantidad por defecto es 0 ya que no ha sido provisto por CRE</p>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Precio unitario</label>
                                    <input class="form-control input-masked" name='price' data-inputmask="'alias': 'decimal','digits':'2', 'groupSeparator': ',', 'autoGroup': true">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>  
        </div>
        <div class="tab-pane fade" id="profile">
            <div class='row'>
                <div class="col-lg-12">
                    <form role="form" name='add-new-structure'>
                        <h5 class="modal-form-header">Datos de la estructura</h5>
                        <div class="alert alert-info">
                            Si el codigo de la estructura ya existe en el sistema, entonces se utilizara la estructura existente.
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Codigo</label>
                                    <input class="form-control" name="structure-code">
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Unidad de medida</label>
                                    <select class="form-control" name="structure-unit-of-measurement">
                                        <option value='KM'>KM</option>
                                        <option value='M'>M</option>
                                        <option value='Pza'>Pza</option>
                                    </select>
                                </div>        
                            </div>
                            <div class='col-md-12'>
                                <div class="form-group">
                                    <label>Detalle</label>
                                    <input class="form-control" name="structure-detail">
                                </div>
                            </div>
                        </div>
                        <h5 class="modal-form-header">Detalle de Mano de obra</h5>                    
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Actividad</label>
                                    <select class="form-control" name='activity'>
                                        <option value='I'>Instalacion</option>
                                        <option value='R'>Retiro</option>
                                        <option value='M'>Movimiento</option>
                                    </select>
                                </div>        
                            </div>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Ejecucion</label>
                                    <select class="form-control" name='execution'>
                                        <option value='LV'>Linea viva</option>
                                        <option value=LM'>Linea muerta</option>
                                    </select>
                                </div>        
                            </div>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <input class="form-control input-masked" name='quantity' data-inputmask="'alias': 'decimal','digits':'2', 'groupSeparator': ',', 'autoGroup': true" value="0" readonly>
                                    <p class="help-block">La cantidad por defecto es 0 ya que no ha sido provisto por CRE</p>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Precio unitario</label>
                                    <input class="form-control input-masked" name='price' data-inputmask="'alias': 'decimal','digits':'2', 'groupSeparator': ',', 'autoGroup': true">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</script>
<script id="ht-modal-form-add-point-to-point-progress" type="text/x-handlebars-template">
    <form name="point-to-point-progress-form" data-parsley-validate>
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
                    <button type="button" class="btn btn-primary btn-sm add-row hide">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div class="form-group">
                    <div class="table-responsive">
                        <em class="table-error-message hide">Debe agregar al menos una estructura al detalle</em>
                        <table class="table table-striped table-bordered table-hover table-minimum-padding">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ACTIV.</th>
                                    <th>CANTIDAD<br>A USAR</th>
                                    <th>ESTRUCTURA</th>
                                    <th>EJEC.</th>
                                    <th>UNIDAD</th>
                                    <th>DESCRIPCION</th>
                                    <th>CANTIDAD<br>UTILIZADA</th>
                                    <th>NUEVO<br>REGISTRO</th>
                                    <th>PRECIO<br>UNITARIO</th>
                                </tr>
                            </thead>
                            <tbody id="structure-item-list-content">
                                {{#each point.structures}}
                                <tr>
                                    <input type="hidden" value="{{labor_cost_id}}" name="worked-up[{{index}}][labor-cost-id]">
                                    <td class="text-center">{{index}}</td>
                                    <td class="text-center">{{labor_activity}}</td>
                                    <td class="text-right">{{quantity_to_use}}</td>
                                    <td>{{structure_code}}</td>
                                    <td class="text-center">{{execution}}</td>
                                    <td class="text-center">{{unit_of_measurement}}</td>
                                    <td>{{description}}</td>
                                    <td class="text-right">{{total_worked_up}}{{unit_of_measurement}}</td>
                                    <td class="text-center"><input class="input-masked" name="worked-up[{{index}}][quantity]" size="10" style="text-align: right;"></td>
                                    <td class="text-center"><input class="input-masked-price" name="worked-up[{{index}}][unit-price]" size="10" style="text-align: right;" value="{{unit_price}}"></td>
                                </tr>
                                {{/each}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
</script>
<script id="ht-modal-form-edit-point-to-point-progress" type="text/x-handlebars-template">
    <form name="point-to-point-progress-form" data-parsley-validate>
        <input type="hidden" name="labor-cost-log-id" value="{{data.logMasterDetail.logId}}">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Fecha</label>
                    <div class="input-group date date-time-picker">
                        <input name="entry-date" readonly="" value="{{data.logMasterDetail.manualEntryDate}}" class="form-control" required="" data-parsley-errors-container="#error-entry-date">
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
                        {{#each buildersSelected}}
                            <option selected value="{{id}}">{{fullName}}</option>
                        {{/each}}
                        {{#each data.builders}}
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
                    <textarea class="form-control" name="detail" rows="2" placeholder="">{{data.logMasterDetail.detail}}</textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="table-responsive">
                        <em class="table-error-message hide">Debe agregar al menos una estructura al detalle</em>
                        <table class="table table-striped table-bordered table-hover table-minimum-padding">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ACTIV.</th>
                                    <th>ESTRUCTURA</th>
                                    <th>EJEC.</th>
                                    <th>UNIDAD</th>
                                    <th>DESCRIPCION</th>
                                    <th>REGISTRO<br>DEL LOG</th>
                                    <th>PRECIO<br>UNITARIO</th>
                                </tr>
                            </thead>
                            <tbody id="structure-item-list-content">
                                {{#each data.logMasterDetail.itemList}}
                                <tr>
                                    <input type="hidden" value="{{labor_cost_id}}" name="worked-up[{{index}}][labor-cost-id]">
                                    <td class="text-center">{{index}}</td>
                                    <td class="text-center">{{activity}}</td>
                                    <td>{{structure_code}}</td>
                                    <td class="text-center">{{execution}}</td>
                                    <td class="text-center">{{unit_of_measurement}}</td>
                                    <td>{{description}}</td>
                                    <td class="text-center"><input class="input-masked" value="{{worked_up}}" name="worked-up[{{index}}][quantity]" size="10" style="text-align: right;"></td>
                                    <td class="text-center"><input class="input-masked-price" name="worked-up[{{index}}][unit-price]" size="10" style="text-align: right;" value="{{worked_up_price}}"></td>
                                </tr>
                                {{/each}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
</script>
<script id="ht-modal-form-add-several-point-to-point-progress" type="text/x-handlebars-template">
    <form name="point-to-point-massive-progress-form" data-parsley-validate>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle fa-fw"></i>Espeficique la fecha, los constructores el detalle y los puntos que han sido completados.<br>
                </div>
            </div>
        </div>
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
                    <label for="select2-points">Puntos</label><br>
                    <select id="select2-points" name="points-to-finish[]" required class="form-control"  multiple="multiple">
                        {{#each response.data.points}}
                            <option value="{{point_id}}">Punto {{point_label}}</option>
                        {{/each}}
                    </select>
                </div>
            </div>
        </div>
    </form>
</script>