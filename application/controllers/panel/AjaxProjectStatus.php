<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 10/1/2018
 * Time: 2:01 PM
 */


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
            $role = new Model_role($roleName, $roleKeyword);
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
        $entryDate = $formData["scheduleEntryDate"];
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
        $project = Model_project::getById($projectId);
        $project->setStart($projectStart);
        $project->setEnd($projectEnd);
        $project->save();

//        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList); the schedule step now register the design budget
        $project->saveBudget($design, 0, "", "", 0, 0, 0, $statusId, $statusDetail, $entryDate, $responsibleList);
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

    public function saveAlreadySent()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $alreadySentEntryDate = $formData["alreadySentEntryDate"];
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
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->setSecondaryCode($secondaryCode);
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
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->saveRealBudget($design, $building, $transportation, $liveLine, $rightOfWay, $statusId, $statusDetail, $entryDate, $responsibleList);
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
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->saveBudget($design, 0, 0, 0, 0, $statusId, $statusDetail, $entryDate, $responsibleList);
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
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList);
        $warehouse = Model_warehouse::getByProjectId($project->getId());
//        echo"<pre>";var_dump($project->getId(), $warehouse);exit;
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
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $responsibleList = $formData["responsibleList"];
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList);
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
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
//        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList);
        $project->savePoints($projectPoints, $projectDistance, $statusId, $statusDetail, $entryDate, $responsibleList);
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
            //Now the building progress has the complete team at "in_progress" step.
            $assignmentEntry = Model_project_status_log::getLogByProjectIdAndStatusKeyWord($projectId, "in_progress");
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

        if(isset($formData["responsibleIds"]))
        {
            $projectId = $formData["projectId"];
            $responsibleIds = $formData["responsibleIds"];
            $arrayKeywords = array(
                            "assign_to",
                            "building",
                            "ready_to_start",
                            "in_progress",
                            "paused",
                            "stopped",
                            "completed",
                            "as_built",
                            "conciliation_reception",
                            "conciliation_shipment",
                            "cre_return_order",
                            "project_return_materials");
            $log = Model_project_status_log::getLogByProjectId($projectId);

            foreach ($log as $record)
            {
                if(array_search($record["keyword_pst"], $arrayKeywords) !== FALSE)
                {
                    $statusLogId = $record["id_psl"];
                    //let's remove the current responsible
                    Model_status_log_responsible::removeResponsibleByStatusLogId($statusLogId);
                    //If the step is "assign_to" then let's remove the builder form responsible list. On assign_to only is defined the fiscal.
                    if($record["keyword_pst"] == "assign_to")
                    {
                        $responsibleIdsForAssignToStep = $responsibleIds;
                        unset($responsibleIdsForAssignToStep[1]);
                        //After remove the responsible let's assigns the new responsible
                        Model_status_log_responsible::addResponsible($statusLogId, $responsibleIdsForAssignToStep);
                    }
                    else
                    {
                        //After remove the responsible let's assigns the new responsible
                        Model_status_log_responsible::addResponsible($statusLogId, $responsibleIds);
                    }
                }
            }
            $response["success"] = 1;
            $response["message"] = "Se asignaron nuevos responsables al proceso de construccion.";
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
        echo json_encode($response);exit;
    }
}