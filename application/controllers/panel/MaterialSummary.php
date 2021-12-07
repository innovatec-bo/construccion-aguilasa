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
        $this->_tabTitle = "Resumen de materiales";
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

        $projects = Model_project::getByStatusKeywordList(['approved','assign_to','in_progress','stopped','paused','completed','as_built','conciliation_reception','conciliation_shipment','cre_return_order','project_return_materials','project_energized']);
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
        $this->complementHandler->addProjectCss('material-summary.materials-request-list');
        $this->complementHandler->addProjectJs('material-summary.materials-request-list');
        $this->_tabTitle = "Solicitudes de materiales";
        $isFiscal = $this->_is('fiscal');
        $materialSummary = new SummaryPaginationHandler();
		$materialSummary->setAdditionalParameters(['fiscal-id' => 30, 'builder-id' => 16]);
		
        if($isFiscal == 1)
        {
            $fiscalList = [Model_user::getById($this->sessionUser->id)];
            $requestList = [];// Model_material_summary::getRequestsList(NULL, $this->sessionUser->id);
        }
        else
        {
            $fiscalList = Model_user::getByRoleKeyword('fiscal');
            $requestList = [];
        }
        $data['fiscalList'] = $fiscalList;
        $data['builderList'] = Model_user::getByRoleKeyword('builder');
        
        if($_POST)
        {
            $id = intval($this->input->post('request-id'));
            $fiscalResponsible = $this->input->post('fiscal-responsible') == ""?NULL:intval($this->input->post('fiscal-responsible'));
            $builderResponsible = $this->input->post('builder-responsible') == ""?NULL:intval($this->input->post('builder-responsible'));
            $requestList = Model_material_summary::getRequestsList($id, $fiscalResponsible, $builderResponsible);
        }

        $data['requestList'] = $materialSummary->getAll();
        $this->_loadPanelView("material-summary/materials-request-list",$data);
    }

    public function type($type = "")
    {
        $this->_validateFeature($type);
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
        // $this->complementHandler->addProjectCss('material-summary.type');
        $this->complementHandler->addProjectJs('material-summary.type');
        

        $summaryType = Model_material_summary_type::getByKeyword([$type]);
        $summaryType = array_values($summaryType);
        $this->_tabTitle = $summaryType[0]->getName();
        $isFiscal = $this->_is('fiscal');
        if($isFiscal == 1)
        {
            $fiscalList = [Model_user::getById($this->sessionUser->id)];
        }
        else
        {
            $fiscalList = Model_user::getByRoleKeyword('fiscal');
        }
        $data['fiscalList'] = $fiscalList;
        $data['builderList'] = Model_user::getByRoleKeyword('builder');
        $this->_loadPanelView("material-summary/type",$data);
    }

    public function show($id)
    {
        $data['materialSummary'] = Model_material_summary::getMasterDetailByListId($id);
		$data['materialList'] = Model_project_material::getBySummaryId($id);
        $this->_loadPanelView("material-summary/material-summary-show",$data);
    }
}
