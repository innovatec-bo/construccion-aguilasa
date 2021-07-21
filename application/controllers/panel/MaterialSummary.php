<?php

class MaterialSummary extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // $this->_validateFeature('material_summary_index');
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
        $this->complementHandler->addProjectCss('material-summary.index');
        $this->complementHandler->addProjectJs('material-summary.index');

        $projects = Model_project::getByStatusKeywordList(['approved','in_progress','stopped','paused','completed','as_built','conciliation_reception','conciliation_shipment','cre_return_order','project_return_materials','project_energized']);
        $data['projects'] = $projects;
        $data['fiscalList'] = Model_user::getByRoleKeyword('fiscal');
        $this->_loadPanelView("material-summary/index",$data);
    }

    public function downloadExcelMaterialSummary()
    {
        $formData = $this->input->post();
        $materialSummary = new ExcelMaterialSummary($this->sessionUser);
        $materialSummary->setAdditionalParameters($formData);
        $materialSummary->getReport();
    }

    public function materialsRequestList()
    {
        // $this->_validateFeature('material_summary_index');
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
        $this->complementHandler->addProjectCss('material-summary.index');
        $this->complementHandler->addProjectJs('material-summary.index');

        
        $data['fiscalList'] = Model_user::getByRoleKeyword('fiscal');
        $data['builderList'] = Model_user::getByRoleKeyword('builder');
        $requestList = [];
        if($_POST)
        {
            $id = $this->input->post('request-id');
            $fiscalResponsible = $this->input->post('fiscal-responsible');
            $builderResponsible = $this->input->post('builder-responsible');
            $requestList = Model_material_summary::getRequestsList($id, $fiscalResponsible, $builderResponsible);
            dd($requestList);
        }

        $data['requestList'] = $requestList;
        $this->_loadPanelView("material-summary/materials-request-list",$data);
    }
}
