<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 10/1/2018
 * Time: 2:01 PM
 */
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class AjaxProjectStatus extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function ajaxDtAllProjectStatus()
    {
        $dt = new JqdtHandler($this->input->post());
        $recordsTotal = Model_project_status::countAll();
        $recordsFiltered = $recordsTotal;
        if (!$dt->hasSearchValue())
        {
            $resultArray = Model_project_status::getAll($dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0));
        }
        else
        {
            $resultArray = Model_project_status::search($dt->getSearchValue(), $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0), $dt->getSearchableColumnDefs());
            $recordsFiltered = Model_project_status::searchTotalCount($dt->getSearchValue(),$dt->getSearchableColumnDefs());
        }

        echo $dt->getJsonResponse($recordsTotal, $recordsFiltered, $resultArray);
        exit;
    }

    public function add()
    {
        $this->_validateFeature('project_status_add');
        /** Server Side Validations **/
        $this->form_validation->set_rules('role-name', 'Name', 'trim|required');
        $this->form_validation->set_rules('role-keyword', 'Keyword', 'trim|required');

        if($this->form_validation->run() === FALSE)
        {
            $response["success"] = 1;
            $response["message"] = "";
            $response["template"] = $this->loadView("panel/content/role/ht-modal-add", array(),true);
            $response["role"] = array();
        }
        else
        {
            $formData = $this->input->post();
            $roleName = $formData["role-name"];
            $roleKeyword = $formData["role-keyword"];
            $role = new Model_saveStructuresInDataBaserole($roleName, $roleKeyword);
            $role->save();
            $response["success"] = 1;
            $response["message"] = "User was added successfully";
        }
        echo json_encode($response);exit;
    }

    public function edit($roleId = NULL)
    {
        $this->_validateFeature('project_status_add');

        if(!is_numeric($roleId))
        {
            $response["success"] = 0;
            $response["message"] = "Invalid parameter.";
            echo json_encode($response);exit;
        }
        $role = Model_role::getById($roleId);
        if(!$role instanceof Model_role)
        {
            $response["success"] = 0;
            $response["message"] = "Role not found.";
            echo json_encode($response);exit;
        }

        /** Server Side Validations **/
        $this->form_validation->set_rules('role-name', 'Name', 'trim|required');

        if($this->form_validation->run() === FALSE)
        {
            $response["success"] = 1;
            $response["message"] = "";
            $response["template"] = $this->loadView("panel/content/role/ht-modal-edit", array(),true);
            $role = $role->toArray();
            $response["role"]["roleId"] = $role["id_rol"];
            $response["role"]["roleName"] = $role["rolename_rol"];
            $response["role"]["keyword"] = $role["keyword_rol"];
        }
        else
        {
            $formData = $this->input->post();
            $roleName = $formData["role-name"];
            $role->setRoleName($roleName);
            $role->save();
            $response["success"] = 1;
            $response["message"] = "User was added successfully";

        }
        echo json_encode($response);exit;
    }

    public function getTotalRoles()
    {
        $recordsTotal = Model_role::countAll();
        $response["total"] = $recordsTotal;
        echo json_encode($response);exit;
    }

    public function getAllStakesTeamLeader()
    {
        $term = $this->input->post("term");
        $limit = $this->input->post("limit");
        $page = $this->input->post("page");
        $offset = ($page-1)*$limit;
        $companies = Model_stakes_team_leader::search($term, $limit, $offset, 'leader_stl', 'asc', array('leader_stl'));
        $recordsFiltered = Model_stakes_team_leader::searchTotalCount($term, array('leader_stl'));

        $resultArray = array();
        $list = array();

        foreach ($companies as $company)
        {
            $list[] = array(
                "id" => $company->id_stl,
                "text" => $company->leader_stl
            );
        }
        $moreResults = ($page * $limit) < $recordsFiltered;
        $resultArray['list'] = $list;
        $resultArray['pagination'] = array("more" => $moreResults);
        echo json_encode($resultArray);exit ;

    }

    public function saveStakesTeam()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $responsibleList = $formData["responsibleList"];
        $statusDetail = $formData["statusDetail"];
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList);

        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveReturned()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $responsibleList = $formData["responsibleList"];
//        echo"<pre>";var_dump($formData);exit;
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList);
        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveDigitization()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $projectPoints = $formData["projectPoints"];
        $projectDistance = $formData["projectDistance"];
        $statusDetail = $formData["statusDetail"];
        $responsibleList = $formData["responsibleList"];
        $sendToApprovement = isset($formData["sendToApprovement"])?$formData["sendToApprovement"]:0;
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->savePoints($projectPoints, $projectDistance, $statusId, $statusDetail, $entryDate, $responsibleList);
        if($sendToApprovement == 1)
        {
            $approvementEntryDate = $entryDate;
            $seconds = 1;
            $approvementEntryDate = date("Y-m-d H:i:s", (strtotime(date($approvementEntryDate)) + $seconds));
            $project->addStatusToLog(8, $statusDetail, $approvementEntryDate, $responsibleList);
            $seconds = 2;
            $approvementEntryDate = date("Y-m-d H:i:s", (strtotime(date($approvementEntryDate)) + $seconds));
            $project->addStatusToLog(9, $statusDetail, $approvementEntryDate, $responsibleList);
        }

        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveDrawing()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $responsibleList = $formData["responsibleList"];
        $sendToApprovement = isset($formData["sendToApprovement"])?$formData["sendToApprovement"]:0;
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList);
        if($sendToApprovement == 1)
        {
            $approvementEntryDate = $entryDate;
            $seconds = 1;
            $approvementEntryDate = date("Y-m-d H:i:s", (strtotime(date($approvementEntryDate)) + $seconds));
            $project->addStatusToLog(8, "Iniciando etapa de aprobacion", $approvementEntryDate, array(10));
            $seconds = 2;
            $approvementEntryDate = date("Y-m-d H:i:s", (strtotime(date($approvementEntryDate)) + $seconds));
            $project->addStatusToLog(9, "Proyecto por enviar", $approvementEntryDate, array(11));
        }

        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveSchedule()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $projectStart = $formData["projectStart"];
        $projectStart = DateTime::createFromFormat('d-m-Y', $projectStart);
        $projectStart = date_format($projectStart, 'Y-m-d');
        $projectStart = $projectStart." ".date("H:i:s");
        $projectEnd = $formData["projectEnd"];
        $projectEnd = DateTime::createFromFormat('d-m-Y', $projectEnd);
        $projectEnd = date_format($projectEnd, 'Y-m-d');
        $projectEnd = $projectEnd." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $responsibleList = Model_status_responsible::getUsersResponsible("schedule");
        $responsibleList = array_column($responsibleList,'id_sre');
        $design = $formData["design"];
        $design = str_replace(",","",$design);
		$tentativeTotalBudget = $formData["tentativeTotalBudget"];
		$tentativeTotalBudget = str_replace(",","",$tentativeTotalBudget);
		/** @var Model_project $project */
        $project = Model_project::getById($projectId);
        $project->setStart($projectStart);
        $project->setEnd($projectEnd);
        $project->save();

//        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList); the schedule step now register the design budget
        $project->saveBudget($design, 0, "", "", 0, 0, 0, $tentativeTotalBudget, $statusId, $statusDetail, $entryDate, $responsibleList);
        $approvementEntryDate = $entryDate;
        $seconds = 1;
        $approvementEntryDate = date("Y-m-d H:i:s", (strtotime(date($approvementEntryDate)) + $seconds));
        $project->addStatusToLog(8, "Iniciando etapa de aprobacion", $approvementEntryDate, array(10));
        $seconds = 2;
        $approvementEntryDate = date("Y-m-d H:i:s", (strtotime(date($approvementEntryDate)) + $seconds));
        $project->addStatusToLog(9, "Proyecto por enviar", $approvementEntryDate, array(11));

        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    /**
     * @deprecated
     */
    public function saveAlreadySent_deprecated()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $alreadySentEntryDate = $formData["entryDate"];
        $alreadySentEntryDate = DateTime::createFromFormat('d-m-Y', $alreadySentEntryDate);
        $alreadySentEntryDate = date_format($alreadySentEntryDate, 'Y-m-d');
        $alreadySentEntryDate = $alreadySentEntryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $responsibleList = $formData["responsibleList"];
        $project = Model_project::getById($projectId);
        $project->addStatusToLog($statusId, $statusDetail, $alreadySentEntryDate, $responsibleList);

        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveRectifyDesign()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
//        $responsibleList = $formData["responsibleList"];
        $project = Model_project::getById($projectId);
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, array(15));
        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveRdStakesTeam()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $responsibleList = $formData["responsibleList"];
        $statusDetail = $formData["statusDetail"];
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList);

        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveRectifyIllustration()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
//        $responsibleList = $formData["responsibleList"];
        $project = Model_project::getById($projectId);
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, array(16));
        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveApproved()
    {
        set_time_limit(240);
       	ini_set('memory_limit','256M');
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
        $secondaryCode = $formData["secondaryCode"];
        $manpowerFileId = $formData["manpowerFileId"] == ''?NULL:$formData["manpowerFileId"];
        $pointToPointFileId = $formData["pointToPointFileId"] == ''?NULL:$formData["pointToPointFileId"];
        $materialsFileId = $formData["materialsFileId"] == ''?NULL:$formData["materialsFileId"];
        /** @var $project Model_project*/
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->setSecondaryCode($secondaryCode);
        $project->save();
        $statusLogId = $project->saveBudget($design, $building, $graphNumber, $reservationNumber, $transportation, $liveLine, $rightOfWay,0, $statusId, $statusDetail, $entryDate, $responsibleList, $manpowerFileId, $pointToPointFileId, $materialsFileId);
        $wareHouse = Model_warehouse::getByProjectId($project->getId());
        if(!$wareHouse instanceof Model_warehouse)
        {
            $project->startWarehouseProcess($entryDate);
        }

        //The manpower file is the main document
        if(is_numeric($manpowerFileId))
        {
        	//Validating materials file
			if(is_numeric($materialsFileId))
			{
				$materialsFile = Model_file::getById($materialsFileId);
				if($materialsFile instanceof Model_file)
				{
					$currentUser = PrivateController::getSessionUser();
					$currentUserId = isset($currentUser) ? $currentUser->id:NULL;
					$initialMaterials = Model_material_summary_type::getByKeyword(array('materials_initial_list'));
					$initialMaterials = array_values($initialMaterials);
					/** @var Model_material_summary_type $initialMaterialType */
					$initialMaterialType = $initialMaterials[0];
					$materialsFileReader = new MaterialsFileReader($projectId, $materialsFile);
					$materialsFileReader->saveMaterialsInDataBase();
					$materialsFileReader->registerMaterialsInSystem($statusLogId, $entryDate, $currentUserId, $initialMaterialType->getId(), $initialMaterialType->getName(), NULL, $reservationNumber);
				}
			}
            //Validating point to point file
            $pointToPointFile = NULL;
            if(is_numeric($pointToPointFileId))
            {
                $file = Model_file::getById($pointToPointFileId);
                if($file instanceof Model_file)
                {
                    $pointToPointFile = $file;
                }
            }
            $manpowerFile = Model_file::getById($manpowerFileId);
            if($manpowerFile instanceof Model_file)
            {
                $manpowerFileReader = new ManpowerFileReader($projectId, $manpowerFile, $pointToPointFile);
                $manpowerFileReader->saveStructuresInDataBase();
                $manpowerFileReader->registerManpowerInSystem();
                $manpowerFileReader->registerDesignBudgetOnLog();
                if($pointToPointFile instanceof Model_file)
                {
                    $manpowerFileReader->registerPointToPointInSystem();
                }
            }
        }
        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveConciliationShipment()
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
        $transportation = $formData["transportation"];
        $transportation = str_replace(",","", $transportation);
        $liveLine = $formData["liveLine"];
        $liveLine = str_replace(",","", $liveLine);
        $rightOfWay = $formData["rightOfWay"];
        $rightOfWay = str_replace(",","", $rightOfWay);
        $responsibleList = $formData["responsibleList"];
        $fileIds = isset($formData["statusFilesIdsToSave"])?$formData["statusFilesIdsToSave"]:array();
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->saveRealBudget($design, $building, $transportation, $liveLine, $rightOfWay, $statusId, $statusDetail, $entryDate, $responsibleList, $fileIds);
        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveCanceled()
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
        $responsibleList = $formData["responsibleList"];
        /** @var Model_project $project */
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->saveBudget($design, 0, 0, 0, 0, 0, 0, 0,$statusId, $statusDetail, $entryDate, $responsibleList);
        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveCreReturnOrder()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $responsibleList = $formData["responsibleList"];
        $fileIds = isset($formData["statusFilesIdsToSave"])?$formData["statusFilesIdsToSave"]:array();
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList, $fileIds);
        $warehouse = Model_warehouse::getByProjectId($project->getId());
        $warehouse->addStatusToLog(37, "El fiscal ha recibido la orden de devolucion a CRE", $entryDate);
        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveBasicLog()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusKeyword = $formData["statusKeyword"];
        $status = Model_project_status::getByStatusKeyword($statusKeyword);
        $statusId = $status->getId();
        $statusDetail = $formData["statusDetail"];
        $responsibleList = $formData["responsibleList"];
        $fileIds = isset($formData["statusFilesIdsToSave"])?$formData["statusFilesIdsToSave"]:array();
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList, $fileIds);
        //If the status is "completed", then lets add an incident to "in_progress" as completed percentage
        if($statusKeyword == "completed")
        {
            $incident = new Model_incident(29, 100, "Construccion completada", $entryDate, $projectId,0,0,9);
            $incident->save();
        }

        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveProjectEnergized()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $projectEnergized = $formData["projectEnergized"];
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $responsibleList = $formData["responsibleList"];
        $fileIds = isset($formData["statusFilesIdsToSave"])?$formData["statusFilesIdsToSave"]:array();
        $project = Model_project::getById($projectId);
        $project->setEnergized($projectEnergized);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList, $fileIds);
        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveAsBuilt()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $responsibleList = $formData["responsibleList"];

        $projectPoints = $formData["projectPoints"];
        $projectDistance = $formData["projectDistance"];
        $fileIds = isset($formData["statusFilesIdsToSave"])?$formData["statusFilesIdsToSave"]:array();
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
//        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList);
        $project->savePoints($projectPoints, $projectDistance, $statusId, $statusDetail, $entryDate, $responsibleList, $fileIds);
        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function getResponsibleByStatusKeyword()
    {
        $keyword = 'design';
        $list = Model_status_responsible::getUsersResponsible($keyword);
        echo json_encode($list);exit;
    }

    public function verifyPreviousEntry()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $statusKeyword = $formData["statusKeyword"];
        $statusSet = $formData["statusSet"];
        $previousEntry = Model_project_status_log::getLogByProjectIdAndStatusKeyWord($projectId, $statusKeyword);
        $scheduleEntry = array();
        $assignmentEntry = array();

        if($statusSet == "design")
        {
            $scheduleEntry = Model_project_status_log::getLogByProjectIdAndStatusKeyWord($projectId, "schedule");
        }
        if($statusSet == "warehouse" || $statusSet == "building")
        {
            $projectLog = Model_project_status_log::getLogByProjectId($projectId);
            $key = array_search('assign_to', array_column($projectLog, 'keyword_pst'));
            //If the project has been paused in the past
            $buildingFromAssigned = $projectLog;
            if($key !== FALSE)
            {
                
                $buildingFromAssigned = array_slice($projectLog, 0, $key);

            }

            //Now the building progress has the complete team at "in_progress" step.
            $assignmentEntry = Model_project_status_log::getLogByProjectIdAndStatusKeyWord($projectId, "in_progress");

            //if the "In_progress" step doesn't have data, then let's use the assign to previous entry
            if(array_search('in_progress', array_column($buildingFromAssigned, 'keyword_pst')) === FALSE)
            {
                $assignmentEntry = Model_project_status_log::getLogByProjectIdAndStatusKeyWord($projectId, "assign_to");

            }
        }
        $response["previousEntry"] = $previousEntry;
        $response["scheduleEntry"] = $scheduleEntry;
        $response["assignmentEntry"] = $assignmentEntry;
        echo json_encode($response);exit;
    }

    public function getProjectLog()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $projectLog = Model_project_status_log::getLogByProjectId($projectId);
        echo json_encode($projectLog);exit;
    }

    public function updateLog()
    {
        $this->_validateFeature("project_update_history");
        $formData = $this->input->post();

        $response["success"] = 0;
        $response["message"] = "Ocurrio un problema, por favor intente de nuevo.";

        if(isset($formData["entryDate"]))
        {
            $logId = $formData["logId"];
            $entryDate = $formData["entryDate"];
            $entryDate = DateTime::createFromFormat('d-m-Y H:i:s', $entryDate);
            $entryDate = date_format($entryDate, 'Y-m-d H:i:s');

            $projectStatusLog = Model_project_status_log::getById($logId);
            $projectStatusLog->setManualEntryDate($entryDate);
            $projectStatusLog->save();
            $response["success"] = 1;
            $response["message"] = "Se modifico la fecha del registro.";
        }

        if(isset($formData["points"]) && isset($formData["distance"]))
        {
            $logId = $formData["logId"];
            $points = $formData["points"];
            $distance = $formData["distance"];
            $projectPoints = Model_project_points::getByStatusLogId($logId);
            $projectPoints->setPoints($points);
            $projectPoints->setDistance($distance);
            $projectPoints->save();
            $response["success"] = 1;
            $response["message"] = "Se actualizaron los puntos y distancia.";
        }
        // echo"<pre>";var_dump($formData['responsibleIds']);exit;
        if(isset($formData["responsibleIds"]))
        {
			$response = Model_status_log_responsible::reAssignResponsibleIds($formData["responsibleIds"],$formData["projectId"]);
        }

        echo json_encode($response);exit;
    }

    public function addIncident()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $statusId = $formData["statusLogId"];
        $entryDate = $formData["entryDate"];
        $pauseProject = $formData["pauseProject"];
        $stopProject = $formData["stopProject"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $percentage = $formData["percentage"];
        $detail = $formData["detail"];
        $incident = new Model_incident($statusId, $percentage, $detail, $entryDate, $projectId);
        $incident->save();
        if($pauseProject != 0|| $stopProject != 0)
        {
            //Now the building team is completed at in_progress step
            $assignmentEntry = Model_project_status_log::getLogByProjectIdAndStatusKeyWord($projectId, "in_progress");
            $responsibleList = array();
            if(count($assignmentEntry) >= 0)
            {
                $responsibleList = json_decode("[".$assignmentEntry[0]["jsonResponsible"]."]",TRUE);
                $responsibleList = array_column($responsibleList,"id");
            }

            $project = Model_project::getById($projectId);

            if($pauseProject == 1)
            {
                $statusId = 31;//project paused
                $incident->setPaused(1);
                $incident->save();
            }
            if($stopProject == 1)
            {
                $statusId = 30;//project stopped
                $incident->setStopped(1);
                $incident->save();
            }

            $project->setStatus($statusId);
            $project->save();
            $project->addStatusToLog($statusId, $detail, $entryDate, $responsibleList);
        }


        echo json_encode($formData);exit;
    }

    public function checkIncidents()
    {
        $formData = $this->input->post();
        $statusId = $formData["statusId"];
        $projectId = $formData["projectId"];
        $allIncidents = Model_incident::getAllByProjectId($projectId);
        $incidentList = Model_incident::getAllByProjectIdAndStatusId($projectId, $statusId);
        $response["allIncidents"] = $allIncidents;
        $response["incidentList"] = $incidentList;
        $response["template"] = $this->load->view("default-template/panel/content/project-status/ht-modal-incident-list",array(), true);
        echo json_encode($response);exit;
    }

    public function addQuickIncidents()
    {

    }

    public function statusManagement($statusSet = "", $projectId = NULL)
    {
        $this->_validateFeature('project_status_management');
        $project = $this->_validateObjectToEdit($projectId,"Model_project","panel/Project");
        $project = $project->toArray();
        $keywordList = $this->_validateStatusSet($statusSet, $project);

        $responsibleListFiscal = Model_status_responsible::getResponsibleDetailListByStatusKeyword("assign_to", array('fiscal'));
        $responsibleListBuilder = Model_status_responsible::getResponsibleDetailListByStatusKeyword("assign_to", array('builder'));
        $statusList = Model_project_status::getByStatusKeywordList($keywordList);
        $statusListArray = array();
        foreach ($statusList as $status)
        {
            $statusListArray[$status->getId()] = $status->toArray();
        }
        $workFlow = Model_project::getWorkflowDetail(['id-list'=>$projectId]);
		$projectWorkFlow = $workFlow[0];
        $statusSetHandler = new StatusSetHandler($statusSet);
        $stepTree = $statusSetHandler->getStepTree();
        $data["statusList"] = $statusListArray;
        $data["statusArray"] = array_values($statusListArray);
        $responsibleList = Model_status_responsible::getUsersResponsible();
        $data["responsibleList"] = json_encode($responsibleList);
        $data["responsibleListFiscal"] = json_encode($responsibleListFiscal);
        $data["responsibleListBuilder"] = json_encode($responsibleListBuilder);
        $data["statusSet"] = $statusSet;
        $data["stepTree"] = $stepTree;
        $projectLog = Model_project_status_log::getLogByProjectId($projectId);
        $data["projectLog"] = $projectLog;
        $data["updateHistory"] = $this->_validateFeature("project_update_history",TRUE);
        $data["deleteStatusLog"] = $this->_validateFeature("deleted_status_log_add",TRUE);
        $processLinesEnabled = Model_process_line::getByUserIdAndProjectId($this->sessionUser->id, $projectId);
        $data["allowBackSteps"] = count($processLinesEnabled) > 0? 1:0;
        $data["projectFullDetail"] = $projectWorkFlow;//$projectFullDetail;
        $data["template"] = $this->loadView("panel/content/project-status/ht-status-management", array(), TRUE);
		$data['projectCurrentBudget'] = $projectWorkFlow['project_current_budget'];
        $response["success"] = 1;
        $response["message"] = "";
        $response["data"] = $data;
        echo json_encode($response);

    }

    public function getExcelFile()
    {
//        echo"<pre>";var_dump($formData, $_FILES['workforce-file']['tmp_name']);exit;
        set_time_limit(240);
        ini_set('memory_limit','256M');
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
        $reader = new Xlsx();
        $spreadsheet = $reader->load($_FILES['workforce-file']['tmp_name']);
        $sheetList = $spreadsheet->getAllSheets();
        $dataSheet = $sheetList[0];
        echo'<pre>';var_dump($_FILES, $_FILES['workforce-file']['tmp_name'],$dataSheet->toArray());exit;

    }

    public function readManpowerFile($registerManpowerInSystem = 0)
    {
        $this->_validateFeature('project_upload_manpower');
//        echo"<pre>";var_dump($_FILES);exit;
        if (!empty($_FILES['manpower-file']['name']))
        {
            try
            {
                $formData = $this->input->post();
                $projectId = $formData['project-id'];
                $fileHandler = new FileHandler();
                $document = $fileHandler->fileUpload($_FILES['manpower-file'], "manpower_doc", "documents", "document");
                $document->save();
                $manpowerFileReader = new ManpowerFileReader($projectId, $document);
                $manpowerFileReader->saveStructuresInDataBase();
                if($registerManpowerInSystem == 1)
                    $manpowerFileReader->registerManpowerInSystem();
                $response['success'] = 1;
                $response['message'] = '';
                $response['data']['file']['id'] = $document->getId();
                $response['data']['budget']['design'] = $manpowerFileReader->getDesignBudget();
                $response['data']['budget']['building'] = $manpowerFileReader->getBuildingBudget();
                $response['data']['budget']['transportation'] = $manpowerFileReader->getTransportationBudget();
                $response['data']['budget']['liveLine'] = $manpowerFileReader->getLiveLineBudget();
                $response['data']['budget']['rightOfWay'] = $manpowerFileReader->getRightOfWayBudget();
                $response['data']['extraInfo']['graphNumber'] = $manpowerFileReader->getGraphNumber();
                $projectBudgetId = $formData['project-budget-id'];
                //If already exist a project budget id then lets assign the manpower file id
                if($projectBudgetId != "")
                {
                	/** @var Model_project_budget $projectBudget */
                    $projectBudget = Model_project_budget::getById($projectBudgetId);
					$projectBudget->setDesign($manpowerFileReader->getDesignBudget());
					$projectBudget->setBuilding($manpowerFileReader->getBuildingBudget());
					$projectBudget->setTransportation($manpowerFileReader->getTransportationBudget());
					$projectBudget->setLiveLine($manpowerFileReader->getLiveLineBudget());
					$projectBudget->setRightOfWay($manpowerFileReader->getRightOfWayBudget());
                    $projectBudget->setManpowerFileId($document->getId());
                    $projectBudget->save();
                }
            }
            catch (Exception $e)
            {
                $response['success'] = 0;
                $response['message'] = $e->getMessage();
                $response['data'] = array();
            }
        }
        else
        {
            $response['success'] = 0;
            $response['message'] = 'No se selecciono ningun archivo de mano de obra para revisar.';
            $response['data']['file'] = array();
        }
        echo json_encode($response);exit;
    }

    public function readPointToPointFile($registerPointToPointInSystem = 0, $manpowerFileId = NULL)
    {
        $this->_validateFeature('project_upload_manpower');
        if(is_null($manpowerFileId))
        {
            $response['success'] = 0;
            $response['message'] = 'Primero ejecute la revision de un archivo de <strong>Mano De Obra</strong> antes de revisar un archivo de <strong>Punto a Punto</strong>.';
            $response['data']['file'] = array();
        }
        else if (!empty($_FILES['point-to-point-file']['name']))
        {
            try
            {
                $formData = $this->input->post();
                $projectId = $formData['project-id'];
                $fileHandler = new FileHandler();
                $pointToPointFile = $fileHandler->fileUpload($_FILES['point-to-point-file'], "point_to_point_doc", "documents", "document");
                $pointToPointFile->save();
                /** @var  $manpowerFile Model_file*/
                $manpowerFile = Model_file::getById($manpowerFileId);
                $manpowerFileReader = new ManpowerFileReader($projectId, $manpowerFile, $pointToPointFile);
                $pointList = "";
                if($registerPointToPointInSystem == 1)
                    $pointList = $manpowerFileReader->registerPointToPointInSystem();
                $response['success'] = 1;
                $response['message'] = '';
                $response['data']['file']['id'] = $pointToPointFile->getId();
                $response['data']['budget']['building'] = $manpowerFileReader->getBuildingBudget();
                $response['data']['pointList'] = $pointList;
                $projectBudgetId = $formData['project-budget-id'];
                //If already exist a project budget id and the registerPointToPointInSystem is true then lets assign the manpower file id
                if($projectBudgetId != "" && $registerPointToPointInSystem == 1)
                {
                    /** @var Model_project_budget $projectBudget */
                    $projectBudget = Model_project_budget::getById($projectBudgetId);
                    $projectBudget->setPointToPointFileId($pointToPointFile->getId());
                    $projectBudget->save();
                }
            }
            catch (Exception $e)
            {
                $response['success'] = 0;
                $response['message'] = $e->getMessage();
                $response['data'] = array();
            }
        }
        else
        {
            $response['success'] = 0;
            $response['message'] = 'No se selecciono ningun archivo de punto a punto para revisar.';
            $response['data']['file'] = array();
        }
        echo json_encode($response);exit;
    }

	public function readMaterialsFile($registerMaterialsInSystem = 0, $materialFileId = NULL)
	{
		$this->_validateFeature('project_upload_manpower');
		if(is_null($materialFileId))
		{
			$response['success'] = 0;
			$response['message'] = 'Primero ejecute la revision de un archivo de <strong>Mano De Obra</strong> antes de revisar un archivo de <strong>materiales</strong>.';
			$response['data']['file'] = array();
		}
		else if (!empty($_FILES['materials-file']['name']))
		{
			try
			{
				$formData = $this->input->post();
				$projectId = $formData['project-id'];
				$fileHandler = new FileHandler();
				$materialsFile = $fileHandler->fileUpload($_FILES['materials-file'], "materials_doc", "documents", "document");
				$materialsFile->save();
				$materialsFileReader = new MaterialsFileReader($projectId, $materialsFile);
				$materialsFileReader->saveMaterialsInDataBase();
				if($registerMaterialsInSystem == 1)
				{
					$currentUser = PrivateController::getSessionUser();
					$currentUserId = isset($currentUser) ? $currentUser->id:NULL;
					$log = Model_project_status_log::getLogByProjectIdAndStatusKeyWord($projectId,'approved');
					$materialsFileReader->registerMaterialsInSystem($log[0]['id_psl'], $log[0]['manual_entry_date_psl'], $currentUserId,1);
				}

				$response['success'] = 1;
				$response['message'] = '';
				$response['data']['file']['id'] = $materialsFile->getId();
			}
			catch (Exception $e)
			{
				$response['success'] = 0;
				$response['message'] = $e->getMessage();
				$response['data'] = array();
			}
		}
		else
		{
			$response['success'] = 0;
			$response['message'] = 'No se selecciono ningun archivo de materiales para revisar.';
			$response['data']['file'] = array();
		}
		echo json_encode($response);exit;
	}
}
