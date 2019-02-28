<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 06/06/2018
 * Time: 10:23 AM
 */
$statusName = "Este proyecto no esta etapa";
$projectOnCurrentStage = FALSE;
$disableStatus = FALSE;
if($project["status_pro"] == 20)
{
    $statusName = "Este proyecto ha sido devuelto a CRE";
    $disableStatus = TRUE;
}
elseif(isset($statusList[$project["status_pro"]]))
{
    $projectOnCurrentStage = TRUE;
    $statusName = $statusList[$project["status_pro"]]->getName();
}
$projectSystem = $projectSystems[$project["system_pro"]];
$entryDate = DateTime::createFromFormat('Y-m-d H:i:s', $project["entry_date_pro"]);
$entryDate = date_format($entryDate, 'd-m-Y');
?>
<script id="ht-status-management" type="text/x-handlebars-template">
    <div class="col-lg-12">
        <h1 class="page-header">{{viewData.statusName}}<em class="subtext">{{viewData.project.code_pro}}({{viewData.project.project_percentage_pro}}%)</em></h1>
    </div>
    <div class="col-md-12">
        <?php
        $this->load->view("default-template/flash-data-basic-messages");
        ?>
    </div>
    <div class="col-md-2">
        <dl class="header-description well well-sm">
            <dt>SISTEMA</dt>
            <dd>{{viewData.project.system}}</dd>
        </dl>
    </div>
    <div class="col-md-2">
        <dl class="header-description well well-sm">
            <dt>FECHA DE INGRESO</dt>
            <dd>{{formatDate viewData.project.entry_date_pro "short"}}</dd>
        </dl>
    </div>
    <div class="col-md-2">
        <dl class="header-description well well-sm">
            <dt>FISCAL DE CRE</dt>
            <dd>{{viewData.project.firstname_cfi}} {{viewData.project.lastname_cfi}}</dd>
        </dl>
    </div>
    <div class="col-md-2">
        <dl class="header-description well well-sm">
            <dt>DIRECCION</dt>
            <dd><dd>{{viewData.project.address_pro}}</dd></dd>
        </dl>
    </div>
    <div class="col-md-2">
        <dl class="header-description well well-sm">
            <dt>AREA</dt>
            <dd><span id="points">{{viewData.project.points_pro}}</span>p/<span id="distance">{{viewData.project.distance_pro}}</span>Km</dd>
        </dl>
    </div>
    {{#ifCond showBtnEditConstructionAssignments "==" 1}}
        <button type="button" class="btn btn-danger edit-construction-assignments">REASIGNAR<br>CONSTRUCCION</button>
    {{/ifCond}}
    <div class="col-md-10">
        <div class="tabbable">
            <ul class="nav nav-tabs wizard step-list">
                {{#each viewData.stepList}}
                    {{> ht-wizard-step}}
                {{/each}}
            </ul>
        </div>
    </div>
    <div class="col-md-1">
        <div class="">
            <a href="#next-step" id="next-step">Siguiente</a>
        </div>
    </div>
    <div class="col-md-1">
        <div class="">
            <a href="#next-step" class="add-incident" data-status-id="{{viewData.project.status_pro}}" data-project-id="{{viewData.project.id_pro}}" id="add-incident"><i class="fa fa-plus"></i> Incid.</a>
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
                    <?php
//                    $html = '
//                            <div class="tab-content">
//                             <div class="well">
//                                <h4>Esta etapa ha finalizado!</h4>
//                            </div>
//                            </div>
//                        ';
//                    if($projectOnCurrentStage)
//                    {
//                        $html = '
//                            <div class="tab-content" id="status-form-content">
//                            </div>
//                        ';
//                    }
//                    $html = '
//                            <div class="tab-content" id="status-form-content">
//                            </div>
//                        ';
//                    echo $html;
                    ?>

                </form>
            </div>
        </section>
    </div>
    <div class="col-md-3">
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
    <li class="{{stepStatus}}">
        {{#ifCond stepId "==" null}}
            <a href="#none" class="add-step" data-toggle="" aria-expanded="false"><i class="fa fa-plus fa-fw"></i></a>
        {{/ifCond}}
        {{#ifCond stepId "!=" null}}
            <a href="#{{stepKeyword}}" data-toggle="tab" aria-expanded="false" data-status-id="{{stepId}}" id="{{stepKeyword}}">{{stepName}}</a>
        {{/ifCond}}
    </li>
</script>
<script id="ht-select-next-step" type="text/x-handlebars-template">
    {{#each nextStepObjectArray}}
        <a class="btn btn-block btn-social btn-primary btn-xs add-step-from-list" data-step-id="{{stepId}}" data-step-name="{{stepName}}" data-step-status="active" data-keyword="{{stepKeyword}}">
            {{stepName}}
        </a>
    {{/each}}
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

$this->load->view("default-template/panel/content/project-status/ht-status-project-log-quick-view");
$this->load->view("default-template/panel/content/project-status/ht-modal-modify-log");
$this->load->view("default-template/panel/content/project-status/ht-modal-incident-form");
$this->load->view("default-template/panel/content/project-status/ht-modal-incident-list");
?>