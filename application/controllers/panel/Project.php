<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 04/06/2018
 * Time: 10:34 AM
 */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Project extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
//        $this->_validateFeature('project_index');
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
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addProjectJs('DTAdditionalParameterHandler');
        $this->complementHandler->addProjectCss('project.index',TRUE);
        $this->complementHandler->addProjectJs('project.index',TRUE);
        $data["viewTitle"] = "Lista de proyectos";
        $data["status"] = '';//todos los estados
        $data["statusSet"] = "none";
        $data["projectSystems"] = $this->_projectSystems;
        $data['fiscalList'] = Model_user::getByRoleKeyword('fiscal');
        $data['builderList'] = Model_user::getByRoleKeyword('builder');
        // echo"<pre>";var_dump($data['builderList']);exit;
        $projectStatus = Model_project_status::getAll(100,0);
        $statusInLog = Model_project_status::getAllInLog();
        $arrayStatus = array();
        foreach ($projectStatus as $status)
        {
            $status = (array)$status;
            $arrayStatus[$status['id_pst']] = $status["status_name_pst"];
        }
        $data["projectStatusJson"] = json_encode($arrayStatus);
        $data["statusInLog"] = $statusInLog;
        $this->_loadPanelView("project/index", $data);
    }

    public function add()
    {
        $this->_validateFeature('project_add');

        /** View complements */
        $this->complementHandler->addViewComplement('select2');
        $this->complementHandler->addViewComplement("jquery.inputmask.bundle");
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement("google.maps.api");
        // $this->complementHandler->addViewComplement("gmaps");
        // $this->complementHandler->addProjectJs('gmaps-script-handler');
        $this->complementHandler->addProjectJs('MapsHandler',TRUE);
        $this->complementHandler->addProjectCss('project.add', TRUE);
        $this->complementHandler->addProjectJs('project.add', TRUE);

        /** Server Side Validations **/
        $this->form_validation->set_rules('project-code', 'Codigo del proyecto', 'trim|required|callback_validate_code');
        $this->form_validation->set_rules('project-name', 'Nombre del proyecto', 'trim');
        $this->form_validation->set_rules('project-entry-date', 'Nombre del proyecto', 'trim|required');
        $this->form_validation->set_rules('project-folder-date', 'Fecha de folder', 'trim|required');
        $this->form_validation->set_rules('project-cre-fiscal', 'Fiscal de CRE', 'trim|required');
        $this->form_validation->set_rules('project-system', 'Sistema', 'trim|required');
        $this->form_validation->set_rules('project-address', 'Direccion/Ubicacion', 'trim|required');
        $this->form_validation->set_rules('project-points', 'Cantidad de puntos', 'trim|required|numeric');
        $this->form_validation->set_rules('project-meters-distance', 'Metros de distancia', 'trim|required|numeric');
        $this->form_validation->set_rules('project-status', 'Estado', 'trim|numeric');
        $this->form_validation->set_rules('project-budgetary-position', 'Posicion presupuestaria', 'trim|numeric');
        $this->form_validation->set_rules('project-contract-id', 'Contract ID', 'trim|numeric');
        $this->form_validation->set_rules('project-detail', 'Detalle', 'trim|required');

        $projectStatusList = Model_project_status::getAll(100,0);
        $contractList = Model_contract::getAll(100, 0);
//        $creFiscalList = Model_cre_fiscal::getAll(100,0);
        $creFiscalList = Model_user::getByRoleKeyword("cre_fiscal");
        $data["projectStatusList"] = $projectStatusList;
        $data["projectSystems"] = $this->_projectSystems;
        $data["contractList"] = $contractList;
        $data["creFiscalList"] = $creFiscalList;

        if($this->form_validation->run() === FALSE)
        {
            $this->_loadPanelView("project/add",$data);
        }
        else
        {
            $formData = $this->input->post();
            $projectCode = $formData["project-code"];
            $projectName = $formData["project-name"];

            $projectEntryDate = $formData["project-entry-date"];
            $projectEntryDate = DateTime::createFromFormat('d-m-Y', $projectEntryDate);
            $projectEntryDate = date_format($projectEntryDate, 'Y-m-d');
            $projectEntryDate = $projectEntryDate." ".date("H:i:s");

            $projectFolderDate = $formData["project-folder-date"];
            $projectFolderDate = DateTime::createFromFormat('d-m-Y', $projectFolderDate);
            $projectFolderDate = date_format($projectFolderDate, 'Y-m-d');
            $projectFolderDate = $projectFolderDate." ".date("H:i:s");

            $projectCreFiscal = $formData["project-cre-fiscal"];
            $projectSystem = $formData["project-system"];
            $projectAddress = $formData["project-address"];
            $projectPoints = $formData["project-points"];
            $projectMetersDistance = $formData["project-meters-distance"];
            $managementBy = $formData["management-by"];
            $qualityLevel = $formData["quality-level"];

            $creDesignCompletionDate = $formData["cre-design-completion-date"];
            $creDesignCompletionDate = DateTime::createFromFormat('d-m-Y', $creDesignCompletionDate);
            $creDesignCompletionDate = date_format($creDesignCompletionDate, 'Y-m-d');
            $creDesignCompletionDate = $creDesignCompletionDate." ".date("H:i:s");

            $creBuildingCompletionDate = $formData["cre-building-completion-date"];
            $creBuildingCompletionDate = DateTime::createFromFormat('d-m-Y', $creBuildingCompletionDate);
            $creBuildingCompletionDate = date_format($creBuildingCompletionDate, 'Y-m-d');
            $creBuildingCompletionDate = $creBuildingCompletionDate." ".date("H:i:s");

            $budgetaryPosition = $formData["project-budgetary-position"];
            $contractId = $formData["project-contract-id"];
            $detail = $formData["project-detail"];
            $latitude = $formData["latitude"];
            $longitude = $formData["longitude"];
            $workArea = $formData['work-area'];
            $projectYear = $formData['project-year'];
            //Our first project status is 'project_has_been_created'
            $statusHasBeenCreated = "46";
            $project = new Model_project($projectCode, $projectName, $projectSystem, $projectAddress, $projectEntryDate, $projectCreFiscal, $statusHasBeenCreated,"","",$projectPoints,$projectMetersDistance,
                $managementBy, $qualityLevel, $creDesignCompletionDate, $creBuildingCompletionDate, $budgetaryPosition, $projectCode, $projectFolderDate, $contractId,$detail,0,0,$latitude, $longitude, $workArea, $projectYear);
            $project->save();
            //Let's search the status responsible
            $responsibleList = Model_status_responsible::getUsersResponsible("project_has_been_created");
            $responsibleList = $responsibleList[0];//array_column($responsibleList,'id_sre');
            $responsibleList = array($responsibleList['id_sre']);
            $project->savePoints($projectPoints, $projectMetersDistance, $statusHasBeenCreated,"El proyecto ha sido creado.", $projectEntryDate,$responsibleList);


            if(isset($formData["instant-approvement"]))
            {
                $entryDate = $formData["approved-entry-date"];
                $statusDetail = $formData["approved-detail"];
                $design = $formData["design-budget"];
                $building = $formData["building-budget"];
                $graphNumber = $formData["graph-number-budget"];
                $reservationNumber = $formData["reservation-number-budget"];
                $transportation = $formData["transportation-budget"];
                $liveLine = $formData["live-line-budget"];
                $rightOfWay = $formData["right-of-way-budget"];
                $secondaryCode = $formData["secondary-code"];
                $manpowerFileId = !isset($formData["manpower-file-id"]) || $formData["manpower-file-id"] == ''?NULL:$formData["manpower-file-id"];
                $project->approveThisProject($entryDate, $statusDetail, $design, $building, $graphNumber, $reservationNumber, $transportation, $liveLine, $rightOfWay, $secondaryCode, $manpowerFileId);
            }

            $this->session->set_flashdata("successMessage", "Proyecto agregado exitosamente!");
            redirect(base_url("panel/Project"));
        }
    }

    public function edit($projectId = NULL)
    {
        $this->_validateFeature('project_edit');
        /** @var Model_project $project */
        $project = $this->_validateObjectToEdit($projectId,"Model_project","panel/Project");

        /** View complements */
        $this->complementHandler->addViewComplement('select2');
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("google.maps.api");
        // $this->complementHandler->addViewComplement("gmaps");
        // $this->complementHandler->addProjectJs('gmaps-script-handler');
        $this->complementHandler->addProjectJs('MapsHandler',TRUE);
        $this->complementHandler->addProjectCss('project.edit',TRUE);
        $this->complementHandler->addProjectJs('project.edit', TRUE);

        /** Server Side Validations **/
        $this->form_validation->set_rules('project-code', 'Codigo del proyecto', 'trim|required|callback_validate_code');
        $this->form_validation->set_rules('project-secondary-code', 'Codigo del proyecto', 'trim|required|callback_validate_secondary_code');
        $this->form_validation->set_rules('project-folder-date', 'Fecha de folder', 'trim');
        $this->form_validation->set_rules('project-cre-fiscal', 'Fiscal', 'trim|required');
        $this->form_validation->set_rules('project-system', 'sistema', 'trim|required');
        $this->form_validation->set_rules('project-address', 'Direccion', 'trim');
        $this->form_validation->set_rules('project-status', 'Estado', 'trim|numeric');
        $this->form_validation->set_rules('project-budgetary-position', 'Posicion presupuestaria', 'trim|numeric');
        $this->form_validation->set_rules('project-contract-id', 'Contract ID', 'trim|numeric');
        $this->form_validation->set_rules('project-end-contract-id', 'End contract ID', 'trim|numeric');
        $this->form_validation->set_rules('project-detail', 'Detalle', 'trim|required');

        $getLastProjectStatus = Model_project_status_log::getLastProjectStatusLogByProjectId($project->getId());
//        $creFiscalList = Model_cre_fiscal::getAll(100,0);
        $creFiscalList = Model_user::getByRoleKeyword("cre_fiscal");
        $contractList = Model_contract::getAll(100, 0);
        $data["lastProjectStatus"] = $getLastProjectStatus;
        $projectStatusList = Model_project_status::getAll(100,0);
        $data["projectStatusList"] = $projectStatusList;
        $data["project"] = $project->toArray();
        $data["projectSystems"] = $this->_projectSystems;
        $data["contractList"] = $contractList;
        $data["creFiscalList"] = $creFiscalList;
        if($this->form_validation->run() === FALSE)
        {
            $this->_loadPanelView("project/edit", $data);
        }
        else
        {
            $formData = $this->input->post();
            $projectCode = $formData["project-code"];
            $secondaryCode = $formData["project-secondary-code"];
            $projectName = $formData["project-name"];

            $folderDate = NULL;
            if($formData["project-folder-date"] != "")
            {
                $folderDate = $formData["project-folder-date"];
                $folderDate = DateTime::createFromFormat('d-m-Y', $folderDate);
                $folderDate = date_format($folderDate, 'Y-m-d');
                $folderDate = $folderDate." ".date("H:i:s");
            }

            $projectCreFiscal = $formData["project-cre-fiscal"];
            $projectSystem = $formData["project-system"];
            $projectAddress = $formData["project-address"];
            $projectStatus = $formData["project-status"];
            $managementBy = $formData["management-by"];
            $qualityLevel = $formData["quality-level"];

            $creDesignCompletionDate = NULL;
            if($formData["cre-design-completion-date"] != "")
            {
                $creDesignCompletionDate = $formData["cre-design-completion-date"];
                $creDesignCompletionDate = DateTime::createFromFormat('d-m-Y', $creDesignCompletionDate);
                $creDesignCompletionDate = date_format($creDesignCompletionDate, 'Y-m-d');
                $creDesignCompletionDate = $creDesignCompletionDate." ".date("H:i:s");
            }

            $creBuildingCompletionDate = NULL;
            if($formData["cre-building-completion-date"] != "")
            {
                $creBuildingCompletionDate = $formData["cre-building-completion-date"];
                $creBuildingCompletionDate = DateTime::createFromFormat('d-m-Y', $creBuildingCompletionDate);
                $creBuildingCompletionDate = date_format($creBuildingCompletionDate, 'Y-m-d');
                $creBuildingCompletionDate = $creBuildingCompletionDate." ".date("H:i:s");
            }


            $budgetaryPosition = $formData["project-budgetary-position"];
            $contractId = $formData["project-contract-id"];
            $endContractId = $formData["project-end-contract-id"];
            $detail = $formData["project-detail"];
            $latitude = $formData["latitude"];
            $longitude = $formData["longitude"];
            $workArea = $formData['work-area'];
            $projectYear = $formData['project-year'];

            $project->setLatitude($latitude);
            $project->setLongitude($longitude);
            if($projectStatus != "")
            {
                $project->setStatus($projectStatus);
            }
            $project->setSecondaryCode($secondaryCode);
            $project->setFolderDate($folderDate);
            $project->setCREFiscal($projectCreFiscal);
            $project->setSystem($projectSystem);
            $project->setAddress($projectAddress);
            $project->setManagementBy($managementBy);
            $project->setQualityLevel($qualityLevel);
            $project->setCreDesignCompletionDate($creDesignCompletionDate);
            $project->setCreBuildingCompletionDate($creBuildingCompletionDate);
            $project->setBudgetaryPosition($budgetaryPosition);
            $project->setContractId($contractId);
            $project->setEndContract($endContractId);
            $project->setDetail($detail);
            $project->setWorkArea($workArea);
            $project->setProjectYear($projectYear);
            $project->save();
            //The status isn't empty when is send to design
            if($projectStatus != "")
            {
                $responsibleList = Model_status_responsible::getUsersResponsible("design");
                $responsibleList = $responsibleList[0];
                $responsibleList = array($responsibleList['id_sre']);
                $project->addStatusToLog($projectStatus,$detail = "Inicio de diseño del proyecto", date("Y-m-d H:i:s"), $responsibleList);
            }

            $this->session->set_flashdata("successMessage", "Proyecto editado correctamente!");
            redirect(base_url("panel/Project/edit/".$project->getId()));
        }
    }

    public function delete($projectId = NULL)
    {
        $this->_validateFeature("delete_project");
        $project = $this->_validateObjectToEdit($projectId,"Model_project","panel/Project");
        $project->delete();
        $this->session->set_flashdata("successMessage", "Proyecto eliminado!");
        redirect(base_url("panel/Project"));
    }

    public function test()
    {
        $a1=array(0 => 2, 1=>3);
        $a2=array(0 => 2, 1=>4);

        $result=array_diff($a1,$a2);
        print_r($result);exit;
    }

    public function validate_code()
    {
        $formData = $this->input->post();
        $projectId = isset($formData["project-id"])?$formData["project-id"]:"";
        $code = isset($formData["project-code"])?$formData["project-code"]:"";
        $isDuplicated = Model_project::projectCodeDuplicated($code, $projectId);
        $result = TRUE;
        if($isDuplicated)
        {
            $this->form_validation->set_message('validate_code', 'Ya existe un proyecto con el codigo '.$code);
            $result = FALSE;
        }
        return $result;
    }

    public function validate_secondary_code()
    {
        $formData = $this->input->post();
        $projectId = isset($formData["project-id"])?$formData["project-id"]:"";
        $code = isset($formData["project-secondary-code"])?$formData["project-secondary-code"]:"";
        $isDuplicated = Model_project::projectSecondaryCodeDuplicated($code, $projectId);
        $result = TRUE;
        if($isDuplicated)
        {
            $this->form_validation->set_message('validate_secondary_code', 'Ya existe un proyecto con ese codigo secundario '.$code);
            $result = FALSE;
        }
        return $result;
    }

    private function saveApproved()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $design = $formData["design"];
        $design = str_replace(",","",$design);
        $building = $formData["building"];
        $building = str_replace(",","",$building);
        $graphNumber = $formData["graphNumber"];
        $reservationNumber = $formData["reservationNumber"];
        $transportation = $formData["transportation"];
        $transportation = str_replace(",","",$transportation);
        $liveLine = $formData["liveLine"];
        $liveLine = str_replace(",","",$liveLine);
        $rightOfWay = $formData["rightOfWay"];
        $rightOfWay = str_replace(",","",$rightOfWay);
        $responsibleList = $formData["responsibleList"];
        /** @var Model_project $project */
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->saveBudget($design, $building, $graphNumber, $reservationNumber, $transportation, $liveLine, $rightOfWay, 0, $statusId, $statusDetail, $entryDate, $responsibleList);
        $wareHouse = Model_warehouse::getByProjectId($project->getId());
        if(!$wareHouse instanceof Model_warehouse)
        {
            $project->startWarehouseProcess($entryDate);
        }
        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function getNewProjectsByMonthAndYear()
    {
        $excel = new ExcelNewProjectsByYearAndMonth($this->sessionUser);
        $excel->getReport();
    }

    public function getProjectWorkFlowReport()
    {
        set_time_limit(300);
		ini_set('memory_limit','256M');
        $formData = $this->input->post();
        $codeList = $formData["code-list"];
        $specialColumns = isset($formData["columns-to-download"])?$formData["columns-to-download"]:array();
        $specialColumns = explode(",",$specialColumns);
        $additionalParameters = array("code-list" => $codeList);
        $excel = new ExcelProjectWorkflow($this->sessionUser);
        $excel->setAdditionalParameters($additionalParameters);
        $excel->setColumnDefinition($specialColumns);
        $excel->getReport();
    }

    public function getApprovedProjectsByMonthAndYear()
    {
        $excel = new ExcelApprovedProjectsByYearAndMonth($this->sessionUser);
        $excel->getReport();
    }

    public function getConciliatedProjectsByMonthAndYear()
    {
        $excel = new ExcelConciliatedProjectsByYearAndMonth($this->sessionUser);
        $excel->getReport();
    }

    public function getAsBuiltProjectsByMonthAndYear()
    {
        $excel = new ExcelAsBuiltProjectsByYearAndMonth($this->sessionUser);
        $excel->getReport();
    }

    public function orderNumberAndTotalsByMonthAndYear()
    {
        $excel = new ExcelOrderNumberAndTotalsByYearAndMonth($this->sessionUser);
        $excel->getReport();
    }

    public function paymentSettledAndTotalsByMonthAndYear()
    {
        $excel = new ExcelPaymentSettledAndTotalsByYearAndMonth($this->sessionUser);
        $excel->getReport();
    }

    public function networksBuilding()
    {
        $formData = $this->input->post();
        $mainList = $formData["keyword"];
        $year = $formData["building-report-year"];
        $excel = new ExcelNetworksBuilding($this->sessionUser, $mainList, $year);
        $excel->getReport();
    }

    public function getCurrentStatusSummary()
    {
        $formData = $this->input->post();
        $system = $formData["project-system"];
        $managementBy = $formData["management-by"];
        $contract = $formData["contract-number"];
        $excel = new ExcelCurrentStatusSummary($this->sessionUser, $system, $managementBy, $contract);
        $excel->getReport();
    }

    public function downloadWorkflowWithParameters()
    {
       	set_time_limit(300);
		ini_set('memory_limit','256M');
        $additionalParameters = $this->input->post();
        // $additionalParameters['status-keyword'] = "";
        // $additionalParameters['keyword'] = "project_has_been_created";
        // $additionalParameters['year'] = "2020";
        // $additionalParameters['month'] = "01";
        // $additionalParameters['rowKey'] = "countWithoutDigitizationPoints";
        // $additionalParameters['contract-id'] = "";
        // echo"<pre>";var_dump($additionalParameters);exit;
        $excel = new ExcelProjectWorkflow($this->sessionUser);
        $excel->setAdditionalParameters($additionalParameters);
        $excel->getReport();
    }

    public function getExecutiveSummaryReport()
    {
        $formData = $this->input->post();
        $excel = new ExcelExecutiveSummary($this->sessionUser);
        $excel->getReport();
    }

    public function getStakeReport()
    {
        $formData = $this->input->post();
        $startDate = $formData["stake-report-from"];
        $startDate = DateTime::createFromFormat('d-m-Y', $startDate);
        $startDate = date_format($startDate, 'Y-m-d');
        $startDate = $startDate." 00:00:00";

        $endDate = $formData["stake-report-to"];
        $endDate = DateTime::createFromFormat('d-m-Y', $endDate);
        $endDate = date_format($endDate, 'Y-m-d');
        $endDate = $endDate." 23:59:59";
        $excel = new ExcelStakesReport($this->sessionUser, $startDate, $endDate);
        $excel->getReport();
    }

    public function getBuilderReport()
    {
        set_time_limit(240);
        ini_set('memory_limit','256M');
        $formData = $this->input->post();
        $startDate = $formData["builder-report-from"];
        $startDate = DateTime::createFromFormat('d-m-Y', $startDate);
        $startDate = date_format($startDate, 'Y-m-d');
        $startDate = $startDate." 00:00:00";

        $endDate = $formData["builder-report-to"];
        $endDate = DateTime::createFromFormat('d-m-Y', $endDate);
        $endDate = date_format($endDate, 'Y-m-d');
        $endDate = $endDate." 23:59:59";
        $excel = new ExcelBuilderReport($this->sessionUser, $startDate, $endDate);
        $excel->getReport();
    }

    public function downloadManPowerFile($fileHash)
    {
        /** @var Model_file $file */
        $file = Model_file::getByHash($fileHash);
        $fileHandler = new FileHandler();
        $fileName = str_replace('.xlsx','', $file->getOriginalFileName());
        $fileName = str_replace('.xls','', $fileName);
        $fileHandler->download($file, $fileName);
    }

    public function manpower($projectId)
    {

        $this->_validateFeature('project_manpower');
        $project = $this->_validateObjectToEdit($projectId,"Model_project","panel/Project");
        $result = Model_structure_by_point::getByProjectId($projectId);
        if(count($result) > 0)
        {
            redirect(base_url('panel/Project/buildingPoints/'.$projectId));
        }
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
        $this->complementHandler->addViewComplement("moment-with-locales");
		$this->complementHandler->addViewComplement("moment-range");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("jquery.inputmask.bundle");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement('select2');
		$this->complementHandler->addProjectJs('StructureUsageValidator', TRUE);
        $this->complementHandler->addProjectCss('project.manpower', TRUE);
        $this->complementHandler->addProjectJs('project.manpower', TRUE);
        $this->complementHandler->addProjectCss('ManpowerHandler', TRUE);
        $this->complementHandler->addProjectJs('ManpowerHandler', TRUE);
        $this->complementHandler->addProjectJs('LaborCostLogHandler', TRUE);
		$approved = Model_project_status_log::getLogByProjectIdAndStatusKeyWord($projectId, "approved");
		$approved = $approved[0];
		$design = $approved['design_prb'];
		$building = $approved['building_prb'];
		$transportation = $approved['transportation_prb'];
		$liveLine = $approved['live_line_prb'];
		$rightOfWay = $approved['right_of_way_prb'];
		$total = $design + $building + $transportation + $liveLine + $rightOfWay;
		$total = number_format($total, 2);
		$data['total'] = $total;
//		echo"<pre>";var_dump($assignmentEntry);exit;
        $data['project'] = $project->toArray();
		$productionGeneralSummary = Model_project::productionGeneralSummary(array(), $project->getId());
		if(count($productionGeneralSummary) > 0)
			$productionGeneralSummary = $productionGeneralSummary[0];
		$data['productionGeneralSummary'] = $productionGeneralSummary;
        $this->_loadPanelView('project/manpower', $data);
    }

    public function buildingPoints($projectId)
    {
        $this->_validateFeature('project_manpower');
        /** @var Model_project $project */
        $project = $this->_validateObjectToEdit($projectId,"Model_project","panel/Project");
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
        $this->complementHandler->addViewComplement("moment-with-locales");
		$this->complementHandler->addViewComplement("moment-range");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("jquery.inputmask.bundle");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement('select2');
		$this->complementHandler->addViewComplement("pagination-js");
		$this->complementHandler->addViewComplement("google.maps.api.cluster");
		$this->complementHandler->addViewComplement("google.maps.api");
//		$this->complementHandler->addProjectJs('DTAdditionalParameterHandler');
		$this->complementHandler->addProjectJs('PointsLocationHandler', TRUE);
		$this->complementHandler->addProjectJs('StructureUsageValidator', TRUE);
        $this->complementHandler->addProjectCss('project.building-points', TRUE);
        $this->complementHandler->addProjectJs('project.building-points', TRUE);
        $this->complementHandler->addProjectCss('BuildingPointHandler', TRUE);
        $this->complementHandler->addProjectjs('BuildingPointHandler', TRUE);
        $this->complementHandler->addProjectCss('PointToPointHandler', TRUE);
        $this->complementHandler->addProjectJs('PointToPointHandler', TRUE);
		$this->complementHandler->addProjectCss('ManpowerHandler', TRUE);
		$this->complementHandler->addProjectJs('ManpowerHandler', TRUE);
        $this->complementHandler->addProjectJs('LaborCostLogHandler', TRUE);
		$approved = Model_project_status_log::getLogByProjectIdAndStatusKeyWord($projectId, "approved");
		$approved = $approved[0];
		$design = $approved['design_prb'];
		$building = $approved['building_prb'];
		$transportation = $approved['transportation_prb'];
		$liveLine = $approved['live_line_prb'];
		$rightOfWay = $approved['right_of_way_prb'];
		$total = $design + $building + $transportation + $liveLine + $rightOfWay;
		$total = number_format($total, 2);
		$data['total'] = $total;
        $productionGeneralSummary = Model_project::productionGeneralSummary(array(), $project->getId());
		if(count($productionGeneralSummary) > 0)
			$productionGeneralSummary = $productionGeneralSummary[0];
		$data['productionGeneralSummary'] = $productionGeneralSummary;
        $data['project'] = $project->toArray();
        $data['productionGeneralSummary'] = $productionGeneralSummary;

        $this->_loadPanelView('project/building-points', $data);
    }

    public function getWorkPlanReport()
    {
        $formData = $this->input->post();
        $startDate = $formData["work-plan-report-from"];
        $startDate = DateTime::createFromFormat('d-m-Y', $startDate);
        $startDate = date_format($startDate, 'Y-m-d');

        $endDate = $formData["work-plan-report-to"];
        $endDate = DateTime::createFromFormat('d-m-Y', $endDate);
        $endDate = date_format($endDate, 'Y-m-d');
        $report = new ExcelWorkPlanReport($this->sessionUser, $startDate, $endDate);
        $report->getReport();
    }

    public function getManpowerActivityForm($projectId)
    {
        $report = new ExcelManPowerEntryActivity($this->sessionUser, $projectId);
        $report->getReport();   
    }

    public function uploadActivityByExcelFile($projectId)
    {

        if (!empty($_FILES['file']['name']))
        {
            try
            {
                $fileHandler = new FileHandler();
                $document = $fileHandler->fileUpload($_FILES['file'],"activity_form","documents","document");
                $document->save();

                $excelManPowerEntryActivity = new ExcelManPowerEntryActivity($this->sessionUser, $projectId);
                $log = $excelManPowerEntryActivity->uploadActivity($document);
                // $log = Model_team::uploadXlsx($document);
                if (count($log) > 0)
                {
                    $errorList = array();
                    foreach ($log as $form)
                    {
                        if(count($form)>0)
                        {
                            $errorList = array_merge($errorList,$form);
                        }
                    }
                    if(count($errorList)>0)
                    {
                        $logHtml = implode("<br/>", $errorList);
                        $this->session->set_flashdata('errorMessage', "<br/>". $logHtml);    
                    }
                    else
                    {
                        $this->session->set_flashdata('successMessage', "Todos los formularios se ingresaron correctamente.");       
                    }
                }
                else
                {
                    $this->session->set_flashdata('successMessage', "Todos los formularios se ingresaron correctamente.");
                }
            }catch (Exception $e)
            {
                $this->session->set_flashdata('errorMessage', $e->getMessage());
                redirect(base_url("panel/Project/manpower/".$projectId));
                
            }
        }
        redirect(base_url("panel/Project/manpower/".$projectId));
    }

    public function locations()
    {
        $this->_validateFeature('project_locations');
        $this->complementHandler->addViewComplement('select2');
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("pagination-js");
        $this->complementHandler->addViewComplement("google.maps.api.cluster");
        $this->complementHandler->addViewComplement("google.maps.api");
        $this->complementHandler->addProjectJs('DTAdditionalParameterHandler');
        $this->complementHandler->addProjectJs('ProjectsLocationHandler', TRUE);
        $this->complementHandler->addProjectCss('project.locations',TRUE);
        $this->complementHandler->addProjectJs('project.locations', TRUE);       
        $data = array();
		$statusInLog = Model_project_status::getAllInLog();
        $data['fiscalList'] = Model_user::getByRoleKeyword('fiscal');
        $data['builderList'] = Model_user::getByRoleKeyword('builder');
        $data['statusInLog'] = $statusInLog;
        $this->_loadPanelView("project/locations", $data);
    }

    public function getAllProjectsLog()
    {
		set_time_limit(300);
		ini_set('memory_limit','256M');
        $report = new ExcelAllProjectsLog($this->sessionUser);
        $report->getReport();
    }

    public function projectBudgets($month, $year)
    {
        $startDate = $year."-".$month."-01 00:00:00";
        $endDate = date("Y-m-t 23:59:59", strtotime($startDate));
        $logDateRange = array("from" => $startDate, "to" => $endDate);
        $report = new ExcelProjectMasterDetail($this->sessionUser, $logDateRange);
        $report->getReport();
    }

    public function dailyProductivityReport($month, $year)
    {
        $startDate = $year."-".$month."-01 00:00:00";
        $endDate = date("Y-m-t 23:59:59", strtotime($startDate));
        $logDateRange = array("from" => $startDate, "to" => $endDate);
        $pdf = new ExcelDailyProductivityReport($this->sessionUser, $logDateRange);
        $pdf->getReport();
    }

	public function executiveReport()
	{
		$report = new ExcelExecutiveReport($this->sessionUser);
		$report->getReport();
	}

	public function importItems()
	{
		set_time_limit(240);
		ini_set('memory_limit','512M');
		require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
		$currentMaterials = Model_material::getAll(2000,0);
		$currentCodes = array();
		foreach ($currentMaterials as $material)
		{
			$currentCodes[] = $material->code_mat;
		}

//		echo"<pre>";var_dump($currentCodes);exit;
		$inputFileName = FCPATH.'assets/MATERIALES-2019-CRE.xlsx';
		/** Load $inputFileName to a Spreadsheet Object  **/
		$spreadsheet = IOFactory::load($inputFileName);
		$items = $spreadsheet->getSheet(0);
		$arrayItems = $items->toArray();
		$itemsToSave = array();
		$i = 0;

		foreach ($arrayItems as $row)
		{
			if($i > 0)
			{
				$code = $row[0];
				$description = $row[1];
				if(array_search($code,$currentCodes) === FALSE)
				{
					$itemsToSave[] = array(
						'code_mat' => $row[0],
						'description_mat' => $row[1]
					);
				}
			}
			$i++;
		}
//		echo"<pre>";var_dump($itemsToSave);exit;
		if(count($itemsToSave) > 0)
			Model_material::insertBatch($itemsToSave);
	}

	public function assignItemsToBuildingStructures()
	{
		set_time_limit(240);
		ini_set('memory_limit','512M');
		require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
		$buildingStructures = Model_building_structure::getAll(2000,0);
		$arrayBuildingStructures = array();
		foreach ($buildingStructures as $row)
		{
			$arrayBuildingStructures[$row->structure_code_bus] = (array)$row;
		}

		$currentMaterials = Model_material::getAll(2000,0);
		$arrayMaterials = array();
		foreach ($currentMaterials as $material)
		{
			$arrayMaterials[$material->code_mat] = (array)$material;
		}
//		echo"<pre>";var_dump($arrayMaterials, $arrayBuildingStructures);exit;
		$inputFileName = FCPATH.'assets/MATERIALES-2019-CRE.xlsx';
		/** Load $inputFileName to a Spreadsheet Object  **/
		$spreadsheet = IOFactory::load($inputFileName);
		$items = $spreadsheet->getSheet(2);
		$arrayItemsBuildingStructures = $items->toArray();
		$dataToSave = array();

		$i = 0;
		$notFoundStructures = array();
		foreach ($arrayItemsBuildingStructures as $row)
		{
			if($i > 0)
			{
				$structureCode = $row[0];
				$materialCode = $row[2];
				$quantity = $row[3];

				$structureId = NULL;
				if(isset($arrayBuildingStructures[$structureCode]))
				{
					$structureId = $arrayBuildingStructures[$structureCode];
				}
				else
				{
					$notFoundStructures[] = $row[0];
				}

				$materialId = NULL;
				if(isset($arrayMaterials[$materialCode]))
				{
					$materialId = $arrayMaterials[$materialCode];
				}

				$dataToSave[] = [
					'structure_id_dsm' => $structureId,
					'material_id_dsm' => $materialId,
					'quantity_dsm' => $quantity
				];
			}
			$i++;
		}
		echo"<pre>";var_dump($notFoundStructures,$dataToSave);exit;
		if(count($dataToSave) > 0)
			Model_default_structure_material::insertBatch($dataToSave);
	}
}
