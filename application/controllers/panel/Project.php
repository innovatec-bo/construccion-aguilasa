<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 04/06/2018
 * Time: 10:34 AM
 */


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
        $this->complementHandler->addProjectJs('DTAdditionalParameterHandler');
        $this->complementHandler->addProjectCss('project.index',TRUE);
        $this->complementHandler->addProjectJs('project.index',TRUE);
        $data["viewTitle"] = "Lista de proyectos";
        $data["status"] = '';//todos los estados
        $data["statusSet"] = "none";
        $data["projectSystems"] = $this->_projectSystems;
        $projectStatus = Model_project_status::getAll(100,0);
        $arrayStatus = array();
        foreach ($projectStatus as $status)
        {
            $status = (array)$status;
            $arrayStatus[$status['id_pst']] = $status["status_name_pst"];
        }
        $data["projectStatusJson"] = json_encode($arrayStatus);
        $this->_loadPanelView("project/index", $data);
    }

    public function add()
    {
        $this->_validateFeature('project_add');

        /** View complements */
        $this->complementHandler->addViewComplement("jquery.inputmask.bundle");
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("parsley");
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

        $projectStatusList = Model_project_status::getAll(100,0);
        $data["projectStatusList"] = $projectStatusList;
        $data["projectSystems"] = $this->_projectSystems;
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
            $projectStatus = $formData["project-status"] == ""?NULL:$formData["project-status"];
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
            $project = new Model_project($projectCode, $projectName, $projectSystem, $projectAddress, $projectEntryDate, $projectCreFiscal, $projectStatus,"","",$projectPoints,$projectMetersDistance,
                $managementBy, $qualityLevel, $creDesignCompletionDate, $creBuildingCompletionDate, $budgetaryPosition, $projectCode, $projectFolderDate);
            $project->save();
            $statusDetail = "Proyecto enviado a diseño";
            $keyword = "design";
            if($projectStatus == 7)
            {
                $keyword = "unsigned";
                $statusDetail = "Proyecto creado";
            }
            $responsibleList = Model_status_responsible::getUsersResponsible($keyword);
            $responsibleList = $responsibleList[0];//array_column($responsibleList,'id_sre');
            $responsibleList = array($responsibleList['id_sre']);
            $statusHasBeenCreated = "46";
            $project->addStatusToLog($statusHasBeenCreated, $statusDetail, $projectEntryDate, $responsibleList);
            $seconds = 1;
            $projectEntryDate = date("Y-m-d H:i:s", (strtotime(date($projectEntryDate)) + $seconds));
            $project->savePoints($projectPoints, $projectMetersDistance,$projectStatus,$statusDetail,$projectEntryDate,$responsibleList);
            $project->setStatus($projectStatus);
            $project->save();

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
                $project->approveThisProject($entryDate, $statusDetail, $design, $building, $graphNumber, $reservationNumber, $transportation, $liveLine, $rightOfWay, $secondaryCode);
            }

            $this->session->set_flashdata("successMessage", "Proyecto agregado exitosamente!");
            redirect(base_url("panel/Project"));
        }
    }

    public function edit($projectId = NULL)
    {
        $this->_validateFeature('project_edit');
        $project = $this->_validateObjectToEdit($projectId,"Model_project","panel/Project");

        /** View complements */
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("parsley");
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

        $getLastProjectStatus = Model_project_status_log::getLastProjectStatusLogByProjectId($project->getId());
        $data["lastProjectStatus"] = $getLastProjectStatus;
        $projectStatusList = Model_project_status::getAll(100,0);
        $data["projectStatusList"] = $projectStatusList;
        $data["project"] = $project->toArray();
        $data["projectSystems"] = $this->_projectSystems;
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

            $project->setProjectName($projectName);
            $project->setCode($projectCode);
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
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->saveBudget($design, $building, $graphNumber, $reservationNumber, $transportation, $liveLine, $rightOfWay, $statusId, $statusDetail, $entryDate, $responsibleList);
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
        $excel = new ExcelProjectWorkflow($this->sessionUser);
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
        $excel = new ExcelCurrentStatusSummary($this->sessionUser);
        $excel->getReport();
    }
}