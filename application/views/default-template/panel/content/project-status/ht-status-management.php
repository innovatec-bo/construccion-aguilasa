<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 06/06/2018
 * Time: 10:23 AM
 */
?>
<script id="ht-status-management" type="text/x-handlebars-template">
    <div class="col-lg-12">
        <h1 class="page-header mb-0">{{viewData.statusName}}
            <em class="subtext">{{viewData.project.code_pro}}</em>
            {{#ifCond viewData.project.trim_tree '==' 1}}
                <a class="btn btn-success pull-right">Con poda</a>
            {{/ifCond}}
            <a class="btn btn-warning pull-right add-incident mr-1" data-status-id="{{viewData.project.project_status_id}}" data-project-id="{{viewData.project.id_pro}}"><i class="fa-regular fa-flag"></i></a>
            <a class="btn btn-info pull-right show-materials-summary mr-1" data-project-id="{{viewData.project.id_pro}}" data-project-id="{{viewData.project.id_pro}}"><i class="fa fa-list"></i></a>
		</h1>
    <div class="progress mb-0">
		{{var 'progress' 'sucess'}}
		{{#ifCond viewData.project.production_percentage '<' 100}}
			{{var 'progress' 'warning'}}
		{{/ifCond}}
	  <div class="progress-bar progress-bar-{{progress}}" role="progressbar" aria-valuenow="{{viewData.project.production_percentage}}" aria-valuemin="0" aria-valuemax="100" style="width: {{viewData.project.production_percentage}}%;">
	  </div>
	</div>

    </div>
    <div class="col-md-12">
        <?php
        $this->load->view("default-template/flash-data-basic-messages");
        ?>
    </div>
    <div class='col-md-12'>
    	<h2>Importe: Bs. {{numberFormat viewData.projectCurrentBudget}}
			<em class="subtext">
				{{#ifCond viewData.project.manpower_file_id '==' null}}
					(Producci&oacute;n al {{viewData.project.production_percentage}}%)
				{{/ifCond}}
				{{#ifCond viewData.project.manpower_file_id '!=' null}}
					<a href="{{base_url}}panel/Project/manpower/{{viewData.project.id_pro}}" target="_blank">(Producci&oacute;n al {{viewData.project.production_percentage}}%)</a>
				{{/ifCond}}
			</em>
    	</h2>
	</div>
    <div id="basic-data">
        <div class="col-md-2 col-xs-12">
            <div class="panel panel-info status-management-card">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-2 col-xs-2">
                            <i class="fa fa-cogs fa-3x"></i>
                        </div>
                        <div class="col-md-9 col-xs-10 text-right">
                            <div class="">{{viewData.project.system}}</div>
                        </div>
                    </div>
                    <div class="status-management-card-title">SISTEMA</div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-xs-12">
            <div class="panel panel-info status-management-card">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-2 col-xs-2">
                            <i class="fa fa-calendar fa-3x"></i>
                        </div>
                        <div class="col-md-9 col-xs-10 text-right">
                            <div class="">{{formatDate viewData.project.entry_date_pro "short"}}</div>
                        </div>
                    </div>
                    <div class="status-management-card-title">INGRESO</div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-xs-12">
            <div class="panel panel-info status-management-card">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-2 col-xs-2">
                            <i class="fa fa-user fa-3x"></i>
                        </div>
                        <div class="col-md-9 col-xs-10 text-right">
                            <div class="">{{viewData.project.cre_fiscal_pro}}</div>
                        </div>
                    </div>
                    <div class="status-management-card-title">FISCAL</div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-xs-12">
            <div class="panel panel-info status-management-card">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-2 col-xs-2">
                            <i class="fa fa-map-marker fa-3x"></i>
                        </div>
                        <div class="col-md-9 col-xs-10 text-right">
                            <div class="">{{viewData.project.address_pro}}</div>
                        </div>
                    </div>
                    <div class="status-management-card-title">DIRECCION</div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-xs-12">
            <div class="panel panel-info status-management-card {{viewData.showBtnEditConstructionAssignments}} asd">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-2 col-xs-2">
                            <i class="fa fa-arrows-alt fa-3x"></i>
                        </div>
                        <div class="col-md-9 col-xs-10 text-right">
                            <div class=""><span id="points">{{viewData.project.points_pro}}</span>p/<span id="distance">{{viewData.project.distance_pro}}</span>Km</div>
                        </div>
                    </div>
                    <div class="status-management-card-title">AREA</div>
                </div>
            </div>
        </div>
        {{#ifCond viewData.showBtnEditConstructionAssignments "==" 1}}
        <div class="col-md-2 col-xs-12">
            <button type="button" class="btn btn-danger edit-construction-assignments">REASIGNAR<br>CONSTRUCCION</button>
        </div>
        {{/ifCond}}
    </div>
    <div id="help-content">
        <div class="row">
            <div class="col-md-12">
                <p>
                    La descripcion de los iconos puede variar de acuerdo a la etapa(Diseño, aprobacion, construccion).
                </p>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped js-options-table js-options-table">
                        <thead>
                        <tr>
                            <th style="width:5%;">Icono</th>
                            <th>Descripcion</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{#each viewData.statusArray}}
                            <tr>
                                <td><i class="{{status_icon_pst}} fa-3x"></i></td>
                                <td class="icon-description">{{status_name_pst}}</td>
                            </tr>
                        {{/each}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="col-xs-5" id="btn-detail-content">
        <a class="btn btn-social-icon btn-primary show-detail"><i class="fa fa-tags"></i></a>
    </div>
    <div class="col-xs-5" id="btn-history-content">
        <a class="btn btn-social-icon btn-primary show-history"><i class="fa fa-book"></i></a>
    </div>
    <div class="col-xs-2" id="btn-help-content">
        <a class="btn btn-social-icon btn-info show-help"><i class="fa fa-question"></i></a>
    </div>
    <div class="col-md-12">
        <div class="tabbable">
            <ul class="nav nav-tabs wizard step-list">
                {{#each viewData.stepList}}
                    {{> ht-wizard-step allowBackSteps=../viewData.allowBackSteps}}
                {{/each}}
            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <section>
            <div class="wizard">
                <form role="form" name="status-management" data-parsley-validate>
                    <input type="hidden" value="{{viewData.project.id_pro}}" name="project-id">
                    <input type="hidden" value='{{viewData.responsibleList}}' name="responsible-list">
                    <input type="hidden" value='{{viewData.responsibleListFiscal}}' name="responsible-list-fiscal">
                    <input type="hidden" value='{{viewData.responsibleListBuilder}}' name="responsible-list-builder">
                    <input type="hidden" value="{{viewData.statusSet}}" name="status-set">
                    <div class="tab-content" id="status-form-content"></div>
                </form>
            </div>
        </section>
    </div>
    <div class="col-md-3" id="history-content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Historial

            </div>
            <div class="panel-body" style="overflow: auto;height: 50vh;" id="status-project-log-content" data-allow-update-history="{{viewData.updateHistory}}">

            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <div class="col-md-12" id="incident-content">
    </div>
    <!-- /.col-lg-12 -->
</script>
<script id="ht-wizard-step" type="text/x-handlebars-template">
	{{#ifCond stepId "==" null}}
		<li class="{{stepStatus}}">
			<a href="#none" class="add-step" data-toggle="" aria-expanded="false"><span class="step-icon-add"><i class="fa fa-plus fa-fw"></i></span></a>
		</li>
	{{/ifCond}}
	{{#ifCond stepId "!=" null}}
		{{#ifCond allowBackSteps "==" 1}}
			<li class="{{stepStatus}}">
				<a href="{{stepKeyword}}" data-toggle="tab" aria-expanded="false" data-status-id="{{stepId}}" id="{{stepKeyword}}" data-icon="{{stepIcon}}"><span class="step-icon"><span class="{{stepIcon}}"></span> </span> <span class="step-name">{{stepName}}</span></a>
			</li>
		{{/ifCond}}
		{{#ifCond allowBackSteps "!=" 1}}
			<li class="{{stepStatus}} disabled">
				<a href="javascript: void(0)" data-toggle="tabb" aria-expanded="false" data-status-id="{{stepId}}" id="{{stepKeyword}}" data-icon="{{stepIcon}}"><span class="step-icon"><span class="{{stepIcon}}"></span> </span> <span class="step-name">{{stepName}}</span></a>
			</li>
		{{/ifCond}}
	{{/ifCond}}
</script>
<script id="ht-select-next-step" type="text/x-handlebars-template">
    {{#each nextStepObjectArray}}
        <a class="btn btn-block btn-social btn-primary btn-xs add-step-from-list" data-step-id="{{stepId}}" data-step-name="{{stepName}}" data-step-status="active" data-keyword="{{stepKeyword}}" data-icon="{{stepIcon}}">
            {{stepName}}
        </a>
    {{/each}}
    <a class="btn btn-block btn-social btn-info btn-xs add-incident" data-status-id="{{project.status_pro}}" data-project-id="{{project.id_pro}}">
        Incidente
    </a>
    <a class="btn btn-block btn-social btn-danger btn-xs cancel-add-step">
        Cancelar
    </a>
</script>
<!-- /.container-fluid -->
<?php
$this->load->view("default-template/panel/content/project-status/ht-stakes-project");

$this->load->view("default-template/panel/content/project-status/ht-status-unsigned-form");
$this->load->view("default-template/panel/content/project-status/ht-status-no-created-view-form");
//diseño
$this->load->view("default-template/panel/content/project-status/ht-status-project_has_been_created-form");
$this->load->view("default-template/panel/content/project-status/ht-status-design-form");
$this->load->view("default-template/panel/content/project-status/ht-status-stakes-form");
$this->load->view("default-template/panel/content/project-status/ht-status-returned-form");
$this->load->view("default-template/panel/content/project-status/ht-status-digitization-form");
$this->load->view("default-template/panel/content/project-status/ht-status-drawing-form");
$this->load->view("default-template/panel/content/project-status/ht-status-schedule-form");
//approvement
$this->load->view("default-template/panel/content/project-status/ht-status-ready_to_send-form");
$this->load->view("default-template/panel/content/project-status/ht-status-already_sent-form");
$this->load->view("default-template/panel/content/project-status/ht-status-rectify_design-form");
$this->load->view("default-template/panel/content/project-status/ht-status-rectify_illustration-form");
$this->load->view("default-template/panel/content/project-status/ht-status-approved-form");
$this->load->view("default-template/panel/content/project-status/ht-status-canceled-form");
$this->load->view("default-template/panel/content/project-status/ht-status-warehouse-form");
//rectify design
$this->load->view("default-template/panel/content/project-status/ht-status-rd_stakes-form");
$this->load->view("default-template/panel/content/project-status/ht-status-rd_digitization-form");
$this->load->view("default-template/panel/content/project-status/ht-status-rd_drawing-form");
//rectify illustration
$this->load->view("default-template/panel/content/project-status/ht-status-ri_digitization-form");
$this->load->view("default-template/panel/content/project-status/ht-status-ri_drawing-form");
//building
$this->load->view("default-template/panel/content/project-status/ht-status-assign_to-form");
$this->load->view("default-template/panel/content/project-status/ht-status-ready_to_start-form");
$this->load->view("default-template/panel/content/project-status/ht-status-in_progress-form");
$this->load->view("default-template/panel/content/project-status/ht-status-stopped-form");
$this->load->view("default-template/panel/content/project-status/ht-status-paused-form");
$this->load->view("default-template/panel/content/project-status/ht-status-completed-form");
$this->load->view("default-template/panel/content/project-status/ht-status-project_energized-form");
$this->load->view("default-template/panel/content/project-status/ht-status-as_built-form");
$this->load->view("default-template/panel/content/project-status/ht-status-conciliation_reception-form");
$this->load->view("default-template/panel/content/project-status/ht-status-conciliation_shipment-form");
$this->load->view("default-template/panel/content/project-status/ht-status-cre_return_order-form");
$this->load->view("default-template/panel/content/project-status/ht-status-project_return_materials-form");
$this->load->view("default-template/panel/content/project-status/ht-status-project_real_budget_confirmation-form");

$this->load->view("default-template/panel/content/project-status/ht-finished-stage-design");
$this->load->view("default-template/panel/content/project-status/ht-status-saved-view");

$this->load->view("default-template/panel/content/project-status/ht-status-project-log-quick-view.hbr");
$this->load->view("default-template/panel/content/project-status/ht-modal-modify-log");
$this->load->view("default-template/panel/content/project-status/ht-modal-incident-form");
$this->load->view("default-template/panel/content/project-status/ht-modal-incident-list");
?>
