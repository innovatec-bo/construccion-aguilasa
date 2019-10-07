<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 10/1/2018
 * Time: 2:01 PM
 */


class AjaxProject extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
//        $this->_validateFeature("project_index");
    }

    public function ajaxDtAllProjects()
    {
        $response = $this->_is("fiscal");
        $userId = "";
        if($response == 1)
        {
            $userId = $this->sessionUser->id;
        }
        $dt = new JqdtHandler($this->input->post());
        $additionalParameters = $this->input->post("additionalParameters");
        $additionalParameters["status"] = isset($additionalParameters["status"])?$additionalParameters["status"]:"";
        $recordsTotal = Model_project::countAll($additionalParameters["status"], $userId);
        $recordsFiltered = $recordsTotal;
        if (!$dt->hasSearchValue() && count($additionalParameters) <= 1)
        {
            $resultArray = Model_project::getAllProjects($additionalParameters["status"], $userId, $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0));
        }
        else
        {
            $resultArray = Model_project::searchProject($additionalParameters["status"], $userId, $dt->getSearchValue(), $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0), $dt->getSearchableColumnDefs(), $additionalParameters);
            $recordsFiltered = Model_project::searchTotalCount($additionalParameters["status"], $userId, $dt->getSearchValue(),$dt->getSearchableColumnDefs(), $additionalParameters);
        }

        echo $dt->getJsonResponse($recordsTotal, $recordsFiltered, $resultArray);
        exit;
    }

    public function getStakesLeaderProjects()
    {
        $stakesLeaderProject = Model_project::getStakesLeaderProjects();
        $arrayStakes = array();
        $singleList = array();
        for ($i = 0; $i < count($stakesLeaderProject); $i++)
        {
            $stakeLeaderId = $stakesLeaderProject[$i]["id_stl"];
            $singleList[] = $stakesLeaderProject[$i];
            if(isset($stakesLeaderProject[$i+1]))
            {
                if($stakesLeaderProject[$i]["id_stl"] != $stakesLeaderProject[$i+1]["id_stl"])
                {
                    $arrayStakes[$stakeLeaderId]['teamLeaderId'] = $stakesLeaderProject[$i]["id_stl"];
                    $arrayStakes[$stakeLeaderId]['teamLeader'] = $stakesLeaderProject[$i]["leader_stl"];
                    $arrayStakes[$stakeLeaderId]['projectList'] = $singleList;
                    $singleList = array();
                }
            }
            else
            {
                $arrayStakes[$stakeLeaderId]['teamLeaderId'] = $stakesLeaderProject[$i]["id_stl"];
                $arrayStakes[$stakeLeaderId]['teamLeader'] = $stakesLeaderProject[$i]["leader_stl"];
                $arrayStakes[$stakeLeaderId]['projectList'] = $singleList;
            }
        }
        $list[] = $arrayStakes;
        echo json_encode($arrayStakes);exit;
    }

    public function updateStakesLeaderProjects()
    {
        $formData = $this->input->post();
        $leaderId = $formData["leaderId"];
        $projectId = $formData["projectId"];
//        var_dump($leaderId, $projectId);exit;
        $projectStakes = Model_project_stakes::getByLeaderIdAndProjectId($leaderId, $projectId);
        if($projectStakes instanceof Model_project_stakes)
        {

        }
    }

    public function select2ProjectsThatReturnedMaterials()
    {
        $currentIds = array();//$this->input->post("currentIds");
        $term = $this->input->post("term");
        $limit = $this->input->post("limit");
        $page = $this->input->post("page");
        $offset = ($page-1)*$limit;
        $projects = Model_project::searchProject("39","",$term, $limit, $offset, 'code_pro', 'asc', array('code_pro'));
        $recordsFiltered = Model_project::searchTotalCount("39","",$term, array('code_pro'));

        $resultArray = array();
        $list = array();

        foreach ($projects as $project)
        {
            if(array_search($project->id_pro,$currentIds) === FALSE)
            {
                $list[] = array(
                    "id" => $project->id_pro,
                    "text" => $project->code_pro,
                    "responsible" => $project->responsible,
                    "points" => $project->points_pro,
                    "distance" => $project->distance_pro
                );
            }
        }
        $moreResults = ($page * $limit) < $recordsFiltered;
        $resultArray['list'] = $list;
        $resultArray['pagination'] = array("more" => $moreResults);
        echo json_encode($resultArray);exit;
    }

    public function getTotalProjects()
    {
        $recordsTotal = Model_project::countAll();
        $response["total"] = $recordsTotal;
        echo json_encode($response);exit;
    }

    public function getManpower($projectId)
    {
        $laborCostMasterDetail = Model_labor_cost::getMasterDetailByProjectId($projectId);
        $i = 0;
        foreach($laborCostMasterDetail as &$laborCost)
        {
            $i++;
            $laborCost['index'] = $i;
            $laborCost['quantity'] = number_format($laborCost['quantity'], 2);
            $laborCost['unit_price'] = number_format($laborCost['unit_price'], 2);
            $laborCost['total_price_by_structure'] = number_format($laborCost['total_price_by_structure'], 2);
            $laborCost['worked_up'] = number_format($laborCost['worked_up'], 2);
            $laborCost['diff'] = number_format($laborCost['diff'], 2);
        }
        if(count($laborCostMasterDetail) > 0)
        {
            $data['isSuperAdmin'] = $this->_is('super_admin');
            $result['success'] = 1;
            $result['message'] = '';
            $result['data']['template'] = $this->loadView('panel/content/project/ManpowerHandler', $data, TRUE);
            $result['data']['templateName'] = "#ht-manpower-table";
            $result['data']['laborCostMasterDetail'] = $laborCostMasterDetail;
        }
        else
        {
            $result['success'] = 0;
            $result['message'] = 'No se encontraron datos';
            $result['data']['laborCostMasterDetail'] = array();
        }
        echo json_encode($result);exit;
    }

    public function addManpowerProgress($projectId = NULL)
    {
        //        $this->_validateFeature('qb_create_invoice');
        $this->_validateObjectToEdit($projectId,"Model_project","panel/Home");
        /** Server Side Validations **/
        $this->form_validation->set_rules('entry-date', 'Fecha', 'trim|required');
        $this->form_validation->set_rules('detail', 'Detalle', 'trim');

        if($this->form_validation->run() === FALSE)
        {
            $validationErrors = validation_errors();
            $validationErrors = str_replace("<p>","",$validationErrors);
            $validationErrors = str_replace("</p>","<br>",$validationErrors);
            $response = array("success" => 0, "message" => $validationErrors);
            $success = $validationErrors != ""?0:1;
            $response["success"] = $success;
            $response["message"] = $validationErrors;
            $template = $this->loadView('panel/content/project/ManpowerHandler', array(), TRUE);
            $laborCostMasterDetail = Model_labor_cost::getMasterDetailByProjectId($projectId);
            $i = 0;
            foreach($laborCostMasterDetail as &$laborCost)
            {
                $i++;
                $laborCost['index'] = $i;
                $laborCost['quantity'] = number_format($laborCost['quantity'], 2);
                $laborCost['unit_price'] = number_format($laborCost['unit_price'], 2);
                $laborCost['total_price_by_structure'] = number_format($laborCost['total_price_by_structure'], 2);
            }
            $builders = Model_user::getBySupervisingUserId($this->sessionUser->id);
            $builders = Model_user::getByRoleKeyword('builder');
            $arrayBuilder = array();
            foreach($builders as $builder)
            {
                $builder = $builder->toArray();
                $arrayBuilder[] = array(
                    'id' => $builder['id_usr'],
                    'firstName' => $builder['firstname_usr'],
                    'lastName' => $builder['lastname_usr']
                );
            }
            $response["data"]["laborCostMasterDetail"] = $laborCostMasterDetail;
            $response["data"]["builders"] = $arrayBuilder;
            $response["data"]["template"] = $template;
            $response["data"]["templateName"] = "#ht-modal-form-add-manpower-progress";
        }
        else
        {
            $formData = $this->input->post();
            $manualEntryDate = $formData["entry-date"];
            $manualEntryDate = DateTime::createFromFormat('d-m-Y', $manualEntryDate);
            $manualEntryDate = date_format($manualEntryDate, 'Y-m-d');
            $manualEntryDate = $manualEntryDate." ".date("H:i:s");
            $detail = $formData["detail"];
            $workedUp = $formData["worked-up"];
            $builders = $formData["builders"];
            $userId = $this->sessionUser->id;            
            Model_labor_cost_log::addLog($userId, $detail, $manualEntryDate, $workedUp, $builders);
            $response["success"] = 1;
            $response["message"] = "Avance registrado correctamente.";
        }
        echo json_encode($response);exit;
    }

    public function getManpowerLog($projectId)
    {
        $arrayLog = Model_labor_cost_log::prepareArrayLog($projectId);
        $response['success'] = 1;
        $response['message'] = '';
        $response['data']['log'] = array_values($arrayLog);
        $response['data']['template'] = $this->loadView('panel/content/project/ManpowerHandler', array(), TRUE);
        $response['data']['templateName'] = "#ht-manpower-quick-log";
        echo json_encode($response);exit;
    }

    public function getBuildingPoints($projectId)
    {
        $laborCostMasterDetail = Model_labor_cost::getMasterDetailByProjectId($projectId);
        $i = 0;
        foreach($laborCostMasterDetail as &$laborCost)
        {
            $i++;
            $laborCost['index'] = $i;
            $laborCost['quantity'] = number_format($laborCost['quantity'], 2);
            $laborCost['unit_price'] = number_format($laborCost['unit_price'], 2);
            $laborCost['total_price_by_structure'] = number_format($laborCost['total_price_by_structure'], 2);
            $laborCost['worked_up'] = number_format($laborCost['worked_up'], 2);
            $laborCost['diff'] = number_format($laborCost['diff'], 2);
        }
        if(count($laborCostMasterDetail) > 0)
        {
            $data['isSuperAdmin'] = $this->_is('super_admin');
            $result['success'] = 1;
            $result['message'] = '';
            $result['data']['template'] = $this->loadView('panel/content/project/ManpowerHandler', $data, TRUE);
            $result['data']['templateName'] = "#ht-building-points";
            $result['data']['laborCostMasterDetail'] = $laborCostMasterDetail;
        }
        else
        {
            $result['success'] = 0;
            $result['message'] = 'No se encontraron datos';
            $result['data']['laborCostMasterDetail'] = array();
        }
        echo json_encode($result);exit;
    }
}