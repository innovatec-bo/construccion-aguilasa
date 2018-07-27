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
        $stakesTeamEntryDate = $formData["stakesTeamEntryDate"];
        $stakesTeamEntryDate = DateTime::createFromFormat('d-m-Y', $stakesTeamEntryDate);
        $stakesTeamEntryDate = date_format($stakesTeamEntryDate, 'Y-m-d');
        $stakesTeamEntryDate = $stakesTeamEntryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $responsibleList = $formData["responsibleList"];
        $statusDetail = $formData["statusDetail"];
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $stakesTeamEntryDate, $responsibleList);

        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveDigitization()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $digitizationEntryDate = $formData["digitizationEntryDate"];
        $digitizationEntryDate = DateTime::createFromFormat('d-m-Y', $digitizationEntryDate);
        $digitizationEntryDate = date_format($digitizationEntryDate, 'Y-m-d');
        $digitizationEntryDate = $digitizationEntryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $projectPoints = $formData["projectPoints"];
        $projectDistance = $formData["projectDistance"];
        $statusDetail = $formData["statusDetail"];
        $responsibleList = $formData["responsibleList"];

        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->savePoints($projectPoints, $projectDistance, $statusId, $statusDetail, $digitizationEntryDate, $responsibleList);

        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveDrawing()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $drawingEntryDate = $formData["drawingEntryDate"];
        $drawingEntryDate = DateTime::createFromFormat('d-m-Y', $drawingEntryDate);
        $drawingEntryDate = date_format($drawingEntryDate, 'Y-m-d');
        $drawingEntryDate = $drawingEntryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $responsibleList = $formData["responsibleList"];
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $drawingEntryDate, $responsibleList);

        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveSchedule()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $scheduleEntryDate = $formData["scheduleEntryDate"];
        $scheduleEntryDate = DateTime::createFromFormat('d-m-Y', $scheduleEntryDate);
        $scheduleEntryDate = date_format($scheduleEntryDate, 'Y-m-d');
        $scheduleEntryDate = $scheduleEntryDate." ".date("H:i:s");
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
        $project = Model_project::getById($projectId);
        $project->setStart($projectStart);
        $project->setEnd($projectEnd);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $scheduleEntryDate, $responsibleList);
        sleep(1);
        $project->addStatusToLog(8, "Iniciando etapa de aprobacion", date("Y-m-d H:i:s"), array(10));//check wfl_status_responsibles id 10
        sleep(1);
        $project->addStatusToLog(9, "Proyecto por enviar", date("Y-m-d H:i:s"), array(10));//check wfl_status_responsibles id 10

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
        $responsibleList = $formData["responsibleList"];
        $project = Model_project::getById($projectId);
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
        $responsibleList = $formData["responsibleList"];
        $project = Model_project::getById($projectId);
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList);
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
        if($statusSet == "design")
        {
            $scheduleEntry = Model_project_status_log::getLogByProjectIdAndStatusKeyWord($projectId, "schedule");
        }
        $response["previousEntry"] = $previousEntry;
        $response["scheduleEntry"] = $scheduleEntry;
        echo json_encode($response);exit;
    }

    public function getProjectLog()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $projectLog = Model_project_status_log::getLogByProjectId($projectId);
        echo json_encode($projectLog);exit;
    }
}