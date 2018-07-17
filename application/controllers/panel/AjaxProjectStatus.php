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
        $stakesTeamEntryDate = DateTime::createFromFormat('d-m-Y H:i:s', $stakesTeamEntryDate);
        $stakesTeamEntryDate = date_format($stakesTeamEntryDate, 'Y-m-d H:i:s');
        $statusId = $formData["statusId"];
        $stakesTeamList = $formData["stakesTeamList"];
        $statusDetail = "";

        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $stakesTeamEntryDate);
        $project->save();
        $project->saveStakesTeam($stakesTeamList);

        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveDigitization()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $digitizationEntryDate = $formData["digitizationEntryDate"];
        $digitizationEntryDate = DateTime::createFromFormat('d-m-Y H:i:s', $digitizationEntryDate);
        $digitizationEntryDate = date_format($digitizationEntryDate, 'Y-m-d H:i:s');
        $statusId = $formData["statusId"];
        $projectPoints = $formData["projectPoints"];
        $projectDistance = $formData["projectDistance"];
        $statusDetail = $formData["statusDetail"];
//        $lastPoints = $formData["lastPoints"];
//        $lastDistance = $formData["lastDistance"];

        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->savePoints($projectPoints, $projectDistance);
        $project->addStatusToLog($statusId, $statusDetail, $digitizationEntryDate);
        $project->save();

        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveDrawing()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $drawingEntryDate = $formData["drawingEntryDate"];
        $drawingEntryDate = DateTime::createFromFormat('d-m-Y H:i:s', $drawingEntryDate);
        $drawingEntryDate = date_format($drawingEntryDate, 'Y-m-d H:i:s');
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];

        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $drawingEntryDate);
        $project->save();

        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveSchedule()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $scheduleEntryDate = $formData["scheduleEntryDate"];
        $scheduleEntryDate = DateTime::createFromFormat('d-m-Y H:i:s', $scheduleEntryDate);
        $scheduleEntryDate = date_format($scheduleEntryDate, 'Y-m-d H:i:s');
        $projectStart = $formData["projectStart"];
        $projectStart = DateTime::createFromFormat('d-m-Y H:i:s', $projectStart);
        $projectStart = date_format($projectStart, 'Y-m-d H:i:s');
        $projectEnd = $formData["projectEnd"];
        $projectEnd = DateTime::createFromFormat('d-m-Y H:i:s', $projectEnd);
        $projectEnd = date_format($projectEnd, 'Y-m-d H:i:s');
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];

        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->setStart($projectStart);
        $project->setEnd($projectEnd);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $scheduleEntryDate);
        $project->save();

        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function getResponsibleByStatusKeyword()
    {
        $keyword = 'design';
        $list = Model_status_responsible::getUsersResponsibleByStatusKeyword($keyword);
        echo json_encode($list);exit;
    }
}