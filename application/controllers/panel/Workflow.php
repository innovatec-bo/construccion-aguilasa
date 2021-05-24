<?php
class Workflow extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_validateFeature('workflow_index');
        $this->complementHandler->addViewComplement("jquery.datatables");
        $this->complementHandler->addViewComplement("bootbox");
        $this->complementHandler->addViewComplement("jquery.datatables.bootstrap");
        $this->complementHandler->addViewComplement("jquery.datatables.buttons");
        $this->complementHandler->addViewComplement("jquery.datatables.buttons.bootstrap");
        $this->complementHandler->addViewComplement("jquery.datatables.buttons.flash");
        $this->complementHandler->addViewComplement("jquery.datatables.buttons.html5");
        $this->complementHandler->addViewComplement("jquery.datatables.buttons.print");
        $this->complementHandler->addViewComplement("jquery.datatables.jszip");
        $this->complementHandler->addViewComplement("jquery.datatables.pdfmake");
        $this->complementHandler->addViewComplement("jquery.datatables.vfs_fonts");
        $this->complementHandler->addViewComplement("jquery.datatables.filterdelay");
		$this->complementHandler->addProjectJs('DTAdditionalParameterHandler', TRUE);
        $this->complementHandler->addProjectCss('workflow.index', TRUE);
        $this->complementHandler->addProjectJs('workflow.index', TRUE);
		$statusInLog = Model_project_status::getAllInLog();
		$data['fiscalList'] = Model_user::getByRoleKeyword('fiscal');
		$data['builderList'] = Model_user::getByRoleKeyword('builder');
		$data["status"] = '';//todos los estados
        $data['columns'] = PrivateController::getWorkflowColumns();
		$data["statusInLog"] = $statusInLog;
		$data['showEditButton'] = $this->_validateFeature('project_edit', TRUE);
		$data['showDeleteButton'] = $this->_validateFeature('delete_project', TRUE);
        $this->_loadPanelView("workflow/index",$data);
    }
}
