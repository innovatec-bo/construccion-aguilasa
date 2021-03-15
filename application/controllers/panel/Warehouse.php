<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 09/08/2018
 * Time: 10:34 AM
 */


class Warehouse extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
		$this->_validateFeature('warehouse_index');
		$this->complementHandler->addViewComplement("bootbox");
		$this->complementHandler->addViewComplement("jquery.datatables");
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
		$this->complementHandler->addProjectJs('DTAdditionalParameterHandler');
		$this->complementHandler->addProjectCss('project.index');
		$this->complementHandler->addProjectJs('project.index');
		$data["viewTitle"] = "Proyectos con materiales asignados";
		$data["status"] = "11,21,29,30,31,32,33,34,35,38,39,47";
		$data["statusSet"] = "";
		$data["projectSystems"] = $this->_projectSystems;
		$data['fiscalList'] = Model_user::getByRoleKeyword('fiscal');
		$data['builderList'] = Model_user::getByRoleKeyword('builder');
		$projectStatus = Model_project_status::getAll(100,0);
		$statusInLog = Model_project_status::getByStatusKeywordList(array("approved",
			"assign_to",
			"in_progress",
			'paused',
			'stopped',
			'completed',
			'project_energized',
			'as_built',
			'conciliation_reception',
			'conciliation_shipment',
			'cre_return_order',
			'project_return_materials'));
		$arrayStatus = array();
		foreach ($projectStatus as $status)
		{
			$status = (array)$status;
			$arrayStatus[$status['id_pst']] = $status["status_name_pst"];
		}
		$data['showEditButton'] = $this->_validateFeature('project_edit', TRUE);
		$data['showDeleteButton'] = $this->_validateFeature('delete_project', TRUE);
		$data["projectStatusJson"] = json_encode($arrayStatus);
		$data["statusInLog"] = $statusInLog;
		$this->_loadPanelView("warehouse/index",$data);
	}

	public function entry(string $code)
	{
		$this->complementHandler->addViewComplement('select2');
		$this->complementHandler->addProjectCss('warehouse.entry', TRUE);
		$this->complementHandler->addProjectJs('warehouse.entry', TRUE);

		$data = array();
		$project = Model_project::getByCode($code);
		if(!$project instanceof Model_project)
		{
			$this->session->set_flashdata("errorMessage", "El proyecto <strong>$code</strong> no existe o fue eliminado.");
			redirect(base_url("panel/Warehouse"));
		}
		$this->_loadPanelView("warehouse/entry",$data);
	}

	public function exit(string $code)
	{
		$data = array();
		$project = Model_project::getByCode($code);
		if(!$project instanceof Model_project)
		{
			$this->session->set_flashdata("errorMessage", "El proyecto <strong>$code</strong> no existe o fue eliminado.");
			redirect(base_url("panel/Warehouse"));
		}
		$this->_loadPanelView("warehouse/exit",$data);
	}

	public function index_old2()
	{
		$data = array();
		$this->_loadPanelView("warehouse/index",$data);
	}



    public function index_old()
    {
        $this->_validateFeature('warehouse_index');
        $this->complementHandler->addViewComplement("bootbox");
        $this->complementHandler->addViewComplement("jquery.datatables");
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
        $this->complementHandler->addProjectJs('DTAdditionalParameterHandler');
        $this->complementHandler->addProjectCss('warehouse.index', TRUE);
        $this->complementHandler->addProjectJs('warehouse.index', TRUE);
        $data["viewTitle"] = "Es necesario grabar los materiales de estos proyectos";
        $data["status"] = "22";
        $data["statusSet"] = "warehouse";
        $data['fiscalList'] = Model_user::getByRoleKeyword('fiscal');
        $data['builderList'] = Model_user::getByRoleKeyword('builder');
        $data["projectSystems"] = $this->_projectSystems;
        $projectStatus = Model_project_status::getAll(100,0);
        $arrayStatus = array();
        foreach ($projectStatus as $status)
        {
            $status = (array)$status;
            $arrayStatus[$status['id_pst']] = $status["status_name_pst"];
        }
        $data["projectStatusJson"] = json_encode($arrayStatus);
        $this->_loadPanelView("warehouse/index",$data);
    }

    public function recordBuildingMaterials()
    {
        $this->_validateFeature('warehouse_record_building_materials');
        $this->complementHandler->addViewComplement("bootbox");
        $this->complementHandler->addViewComplement("jquery.datatables");
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
        $this->complementHandler->addProjectJs('DTAdditionalParameterHandler');
        $this->complementHandler->addProjectCss('warehouse.index', TRUE);
        $this->complementHandler->addProjectJs('warehouse.index', TRUE);
        $data["viewTitle"] = "Materiales ya grabados en CRE";
        $data["status"] = 23;
        $data["statusSet"] = "warehouse";
        $data['fiscalList'] = Model_user::getByRoleKeyword('fiscal');
        $data['builderList'] = Model_user::getByRoleKeyword('builder');
        $data["projectSystems"] = $this->_projectSystems;
        $projectStatus = Model_project_status::getAll(100,0);
        $arrayStatus = array();
        foreach ($projectStatus as $status)
        {
            $status = (array)$status;
            $arrayStatus[$status['id_pst']] = $status["status_name_pst"];
        }
        $data["projectStatusJson"] = json_encode($arrayStatus);
        $this->_loadPanelView("project/index",$data);
    }

    public function getMaterials()
    {
        $this->_validateFeature('warehouse_get_materials');
        $this->complementHandler->addViewComplement("bootbox");
        $this->complementHandler->addViewComplement("jquery.datatables");
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
        $this->complementHandler->addProjectJs('DTAdditionalParameterHandler');
        $this->complementHandler->addProjectCss('warehouse.index', TRUE);
        $this->complementHandler->addProjectJs('warehouse.index', TRUE);
        $data["viewTitle"] = "Materiales ya retirados de CRE";
        $data["status"] = 24;
        $data["statusSet"] = "warehouse";
        $data['fiscalList'] = Model_user::getByRoleKeyword('fiscal');
        $data['builderList'] = Model_user::getByRoleKeyword('builder');
        $data["projectSystems"] = $this->_projectSystems;
        $projectStatus = Model_project_status::getAll(100,0);
        $arrayStatus = array();
        foreach ($projectStatus as $status)
        {
            $status = (array)$status;
            $arrayStatus[$status['id_pst']] = $status["status_name_pst"];
        }
        $data["projectStatusJson"] = json_encode($arrayStatus);
        $this->_loadPanelView("project/index",$data);
    }

    public function deliverMaterials()
    {
        $this->_validateFeature('warehouse_deliver_materials');
        $this->complementHandler->addViewComplement("bootbox");
        $this->complementHandler->addViewComplement("jquery.datatables");
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
        $this->complementHandler->addProjectJs('DTAdditionalParameterHandler');
        $this->complementHandler->addProjectCss('warehouse.index', TRUE);
        $this->complementHandler->addProjectJs('warehouse.index', TRUE);
        $data["viewTitle"] = "Materiales entragados a responsables de contruccion";
        $data["status"] = 25;
        $data["statusSet"] = "warehouse";
        $data['fiscalList'] = Model_user::getByRoleKeyword('fiscal');
        $data['builderList'] = Model_user::getByRoleKeyword('builder');
        $data["projectSystems"] = $this->_projectSystems;
        $projectStatus = Model_project_status::getAll(100,0);
        $arrayStatus = array();
        foreach ($projectStatus as $status)
        {
            $status = (array)$status;
            $arrayStatus[$status['id_pst']] = $status["status_name_pst"];
        }
        $data["projectStatusJson"] = json_encode($arrayStatus);
        $this->_loadPanelView("project/index",$data);
    }

    public function materialsReception()
    {
        $this->_validateFeature('warehouse_materials_reception');
        $this->complementHandler->addViewComplement("bootbox");
        $this->complementHandler->addViewComplement("jquery.datatables");
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
        $this->complementHandler->addProjectJs('DTAdditionalParameterHandler');
        $this->complementHandler->addProjectCss('warehouse.index', TRUE);
        $this->complementHandler->addProjectJs('warehouse.index', TRUE);
        $data["viewTitle"] = "Materiales recibidos de construccion";
        $data["status"] = 36;
        $data["statusSet"] = "warehouse";
        $data['fiscalList'] = Model_user::getByRoleKeyword('fiscal');
        $data['builderList'] = Model_user::getByRoleKeyword('builder');
        $data["projectSystems"] = $this->_projectSystems;
        $projectStatus = Model_project_status::getAll(100,0);
        $arrayStatus = array();
        foreach ($projectStatus as $status)
        {
            $status = (array)$status;
            $arrayStatus[$status['id_pst']] = $status["status_name_pst"];
        }
        $data["projectStatusJson"] = json_encode($arrayStatus);
        $this->_loadPanelView("project/index",$data);
    }

    public function requestMaterialsReturn()
    {
        $this->_validateFeature('warehouse_request_materials_return');
        $this->complementHandler->addViewComplement("bootbox");
        $this->complementHandler->addViewComplement("jquery.datatables");
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
        $this->complementHandler->addProjectJs('DTAdditionalParameterHandler');
        $this->complementHandler->addProjectCss('warehouse.index', TRUE);
        $this->complementHandler->addProjectJs('warehouse.index', TRUE);
        $data["viewTitle"] = "Devolvera CRE los materiales de estos proyectos";
        $data["status"] = 37;
        $data["statusSet"] = "warehouse";
        $data['fiscalList'] = Model_user::getByRoleKeyword('fiscal');
        $data['builderList'] = Model_user::getByRoleKeyword('builder');
        $data["projectSystems"] = $this->_projectSystems;
        $projectStatus = Model_project_status::getAll(100,0);
        $arrayStatus = array();
        foreach ($projectStatus as $status)
        {
            $status = (array)$status;
            $arrayStatus[$status['id_pst']] = $status["status_name_pst"];
        }
        $data["projectStatusJson"] = json_encode($arrayStatus);
        $this->_loadPanelView("project/index",$data);
    }

    public function returnMaterials()
    {
        $this->_validateFeature('warehouse_return_materials');
        $this->complementHandler->addViewComplement("bootbox");
        $this->complementHandler->addViewComplement("jquery.datatables");
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
        $this->complementHandler->addProjectJs('DTAdditionalParameterHandler');
        $this->complementHandler->addProjectCss('warehouse.index', TRUE);
        $this->complementHandler->addProjectJs('warehouse.index', TRUE);
        $data["viewTitle"] = "Materiales devueltos a CRE";
        $data["status"] = "26";
        $data["statusSet"] = "warehouse";
        $data['fiscalList'] = Model_user::getByRoleKeyword('fiscal');
        $data['builderList'] = Model_user::getByRoleKeyword('builder');
        $data["projectSystems"] = $this->_projectSystems;
        $projectStatus = Model_project_status::getAll(100,0);
        $arrayStatus = array();
        foreach ($projectStatus as $status)
        {
            $status = (array)$status;
            $arrayStatus[$status['id_pst']] = $status["status_name_pst"];
        }
        $data["projectStatusJson"] = json_encode($arrayStatus);
        $this->_loadPanelView("project/index",$data);
    }

    public function statusManagement($warehouseId)
    {
//        $this->_validateFeature('project_status_management');
        $warehouse = $this->_validateObjectToEdit($warehouseId,"Model_warehouse","panel/Home");
        $warehouse = $warehouse->toArray();
        $keywordList = array("warehouse","record_building_materials", "get_materials", "deliver_materials", "return_materials","materials_reception","request_materials_return");
        $this->complementHandler->addViewComplement("bootbox");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("jquery.inputmask.bundle");
        $this->complementHandler->addViewComplement('select2');
        $this->complementHandler->addProjectCss('warehouse.status-management',TRUE);
        $this->complementHandler->addProjectJs('warehouse.status-management',TRUE);
        $this->complementHandler->addProjectCss('project.status-management.wizardv2');
        $this->complementHandler->addProjectJs('project.status-management.wizardv2');
        $this->complementHandler->addProjectJs('modify-log', TRUE);

        $statusList = Model_project_status::getByStatusKeywordList($keywordList);
        $data["warehouse"] = $warehouse;
        $project = Model_project::getById($warehouse["project_id_war"]);
        $data["project"] = $project->toArray();
        $data["statusList"] = $statusList;
        $data["projectSystems"] = $this->_projectSystems;
        $responsibleList = Model_status_responsible::getUsersResponsible();
        $data["responsibleList"] = json_encode($responsibleList);
        $data["updateHistory"] = $this->_validateFeature("project_update_history",TRUE);
        $this->_loadPanelView("warehouse/status-management", $data);
    }
}
