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
		$additionalParameters = $this->input->post('additionalParameters')??array();

		$dt = new JqdtHandler($this->input->post());
		$paginationHandler = new WorkflowPaginationHandler($dt->getLength(), $dt->getStart(),$dt->getOrderName(0), $dt->getOrderDir(0),$dt->getSearchValue(),$dt->getSearchableColumnDefs());
		//$paginationHandler->setColumnsToShow(['order_pst','cre_fiscal_pro','assign_to_responsible','fiscal_responsible','builder_responsible','project_current_budget','status_log_manual_entry_date','static_days','status_name_pst','manpower_file_id','builder_responsible_id','fiscal_responsible_id','quantity_picked_up_from_cre','materials_delivered_to_cre','quantity_materials_assigned','pending_material_in_cre','stake_responsible']);
        $paginationHandler->setReturnAsObjectCollection(false);
        $paginationHandler->setAdditionalParameters($additionalParameters);
        $response = $paginationHandler->getResponseForDataTable();

		// $codeList = "";
		// foreach ($response['resultArray'] as $row)
		// {
		// 	$codeList .= $row->code_pro." ";

		// }
		// $projectWorkflow = Model_project::getWorkflowDetail(['code-list' => $codeList]);
		// foreach ($response['resultArray'] as &$row)
		// {
		// 	$positionInWorkFlow = array_search($row->id_pro,array_column($projectWorkflow,'id_pro'));
		// 	$projectBudget = PublicController::getPaymentByStatusFromWorkflow($projectWorkflow[$positionInWorkFlow]);
		// 	$row->projectBudget = number_format($projectBudget, 2, '.', ',');
		// }
		echo $dt->getJsonResponse($response['recordsTotal'], $response['recordsFiltered'], $response['resultArray']);exit;
	}

    public function ajaxDtAllProjects_old2()
	{
		$additionalParameters = $this->input->post('additionalParameters')??array();
//		$response = $this->_is("fiscal");
//		if($response == 1)
//		{
//			$additionalParameters["fiscal-responsible-id"] = $this->sessionUser->id;
//		}
		$dt = new JqdtHandler($this->input->post());
		$paginationHandler = new ProjectPaginationHandler($dt->getLength(), $dt->getStart(),$dt->getOrderName(0), $dt->getOrderDir(0),$dt->getSearchValue(),$dt->getSearchableColumnDefs());
		$paginationHandler->setAdditionalParameters($additionalParameters);
        
		$response = $paginationHandler->getResponseForDataTable();

		$codeList = "";
		foreach ($response['resultArray'] as $row)
		{
			$codeList .= $row->code_pro." ";

		}
		$projectWorkflow = Model_project::getWorkflowDetail(['code-list' => $codeList]);
		foreach ($response['resultArray'] as &$row)
		{
			$positionInWorkFlow = array_search($row->id_pro,array_column($projectWorkflow,'id_pro'));
			$projectBudget = PublicController::getPaymentByStatusFromWorkflow($projectWorkflow[$positionInWorkFlow]);
			$row->projectBudget = number_format($projectBudget, 2, '.', ',');
		}
		echo $dt->getJsonResponse($response['recordsTotal'], $response['recordsFiltered'], $response['resultArray']);exit;
	}

    public function ajaxDtAllProjects_old()
    {
        $additionalParameters = $this->input->post("additionalParameters");
        $response = $this->_is("fiscal");
        if($response == 1)
        {
            // $additionalParameters["fiscal-responsible-id"] = $this->sessionUser->id;
        }
        $dt = new JqdtHandler($this->input->post());
        
        $recordsTotal = Model_project::countAll($additionalParameters);
        $recordsFiltered = $recordsTotal;
        // echo"<pre>";var_dump($additionalParameters);exit;
        if (!$dt->hasSearchValue())
        {
            $resultArray = Model_project::getAll($dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0), $additionalParameters);
        }
        else
        {
            $resultArray = Model_project::search($dt->getSearchValue(), $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0), $dt->getSearchableColumnDefs(), $additionalParameters);
            $recordsFiltered = Model_project::searchTotalCount($dt->getSearchValue(),$dt->getSearchableColumnDefs(), $additionalParameters);
            
        }

        echo $dt->getJsonResponse($recordsTotal, $recordsFiltered, $resultArray);
        exit;
    }

	/**
	 * @deprecated
	 */
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
        $additionalParameters['status'] = "39,12";
        $projects = Model_project::search($term, $limit, $offset, 'code_pro', 'asc', array('code_pro'), $additionalParameters);
        $recordsFiltered = Model_project::searchTotalCount($term, array('code_pro'), $additionalParameters);

        $resultArray = array();
        $list = array();

        foreach ($projects as $project)
        {
            if(array_search($project->id_pro,$currentIds) === FALSE)
            {
                $list[] = array(
                    "id" => $project->id_pro,
                    "text" => $project->code_pro,
                    // "responsible" => $project->responsible,
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
			$dateRangesToBlock = Model_blocked_log_date_range::getAll(100, 0);
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
            $fiscals = Model_user::getByRoleKeyword('fiscal');
            $arrayFiscal = array();
            foreach($fiscals as $fiscal)
            {
                $fiscal = $fiscal->toArray();
                $arrayFiscal[] = array(
                    'id' => $fiscal['id_usr'],
                    'firstName' => $fiscal['firstname_usr'],
                    'lastName' => $fiscal['lastname_usr']
                );
            }
            $workflowPagination = new WorkflowPaginationHandler(1);
            $workflowPagination->setAdditionalParameters(['id-list'=>$projectId]);
            $workflowPagination->setColumnsToShow(['fiscal_responsible_id','fiscal_responsible','keyword_pst','production_total_bs','project_current_design_budget','production_percentage','project_current_budget']);
            $productionLimit = Model_production_limit::getByProjectId($projectId);
            if(!$productionLimit instanceof Model_production_limit)
            {
                $productionLimit = new Model_production_limit($projectId, 110, date('Y-m-d H:i:s'), null);
                $productionLimit->save();
            }
            $project = $workflowPagination->getAll();
            $response["data"]["laborCostMasterDetail"] = $laborCostMasterDetail;
            $response["data"]["builders"] = $arrayBuilder;
            $response["data"]["fiscals"] = $arrayFiscal;
            $response["data"]["template"] = $template;
            $response["data"]["templateName"] = "#ht-modal-form-add-manpower-progress";
            $response["data"]["dateRangesToBlock"] = $dateRangesToBlock;
            $response['data']['project'] = $project[0];
            $response['data']['productionLimit'] = $productionLimit->toArray();
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
            $fiscalId = $formData['fiscal'];
            $pointId = !isset($formData["point-id"])?NULL:$formData["point-id"];
            $userId = $this->sessionUser->id;
            Model_labor_cost_log::addLog($fiscalId, $detail, $manualEntryDate, $workedUp, $builders);
            $response["success"] = 1;
            $response["message"] = "Avance registrado correctamente.";
        }
        echo json_encode($response);exit;
    }

    public function addPointToPointProgress($projectId = NULL, $pointId = NULL)
    {
        //        $this->_validateFeature('qb_create_invoice');
        $this->_validateObjectToEdit($projectId,"Model_project","panel/Home");
        $this->_validateObjectToEdit($pointId,"Model_building_point","panel/Home");
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
			$dateRangesToBlock = Model_blocked_log_date_range::getAll(100, 0);
            $buildingPoints = Model_building_point::getMasterDetail($projectId, $pointId);

            $workflowPagination = new WorkflowPaginationHandler(1);
            $workflowPagination->setAdditionalParameters(['id-list'=>$projectId]);
            $workflowPagination->setColumnsToShow(['fiscal_responsible_id','fiscal_responsible','keyword_pst','production_total_bs','project_current_design_budget','production_percentage','project_current_budget']);
            $productionLimit = Model_production_limit::getByProjectId($projectId);
            if(!$productionLimit instanceof Model_production_limit)
            {
                $productionLimit = new Model_production_limit($projectId, 110, date('Y-m-d H:i:s'), null);
                $productionLimit->save();
            }
            $project = $workflowPagination->getAll();

            $response["data"]["project"] = $project[0];
            $response['data']['productionLimit'] = $productionLimit->toArray();
            $response["data"]["laborCostMasterDetail"] = $laborCostMasterDetail;
            $response["data"]["builders"] = $arrayBuilder;
            $response["data"]["template"] = $template;
            $response["data"]["point"] = array_values($buildingPoints)[0];
            $response["data"]["structuresToUse"] = array_values($buildingPoints[$pointId]["structures"]);
            $response["data"]["templateName"] = "#ht-modal-form-add-point-to-point-progress";
            $response["data"]["dateRangesToBlock"] = $dateRangesToBlock;
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
            Model_labor_cost_log::addLog($userId, $detail, $manualEntryDate, $workedUp, $builders, $pointId);
            $response["success"] = 1;
            $response["message"] = "Avance registrado correctamente.";
        }
        echo json_encode($response);exit;
    }

    public function addMassivePointToPointProgress($projectId = NULL)
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
//            $builders = Model_user::getBySupervisingUserId($this->sessionUser->id);
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
            $buildingPoints = Model_building_point::getMasterDetail($projectId);
            $dateRangesToBlock = Model_blocked_log_date_range::getAll(100, 0);
            $response["data"]["laborCostMasterDetail"] = $laborCostMasterDetail;
            $response["data"]["builders"] = $arrayBuilder;
            $response["data"]["template"] = $template;
            $response["data"]["points"] = array_values($buildingPoints);
            $response["data"]["templateName"] = "#ht-modal-form-add-several-point-to-point-progress";
            $response["data"]["dateRangesToBlock"] = $dateRangesToBlock;
        }
        else
        {
            $formData = $this->input->post();
            // echo"<pre>";var_dump($formData, $buildingPoints);exit;
            $manualEntryDate = $formData["entry-date"];
            $manualEntryDate = DateTime::createFromFormat('d-m-Y', $manualEntryDate);
            $manualEntryDate = date_format($manualEntryDate, 'Y-m-d');
            $manualEntryDate = $manualEntryDate." ".date("H:i:s");
            $detail = $formData["detail"];
            $builders = $formData["builders"];
            $pointsToFinish = $formData["points-to-finish"];
            $userId = $this->sessionUser->id;            
            $response = Model_labor_cost_log::addMassiveLog($userId, $detail, $manualEntryDate, $builders, $pointsToFinish, $projectId);
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
        $buildingPoints = Model_building_point::getMasterDetail($projectId);
        $i = 0;
        $data['isSuperAdmin'] = $this->_is('super_admin');
        foreach($buildingPoints as &$point)
        {
            $i++;
            $point['index'] = $i;
        }
        if(count($buildingPoints) > 0)
        {
            
            $result['success'] = 1;
            $result['message'] = '';
            $result['data']['template'] = $this->loadView('panel/content/project/ManpowerHandler', $data, TRUE);
            $result['data']['templateName'] = "#ht-building-points";
            $result['data']['buildingPoints'] = array_values($buildingPoints);
        }
        else
        {
            $result['success'] = 0;
            $result['message'] = 'No se encontraron datos';
            $result['data']['template'] = $this->loadView('panel/content/project/ManpowerHandler', $data, TRUE);
            $result['data']['templateName'] = "#ht-building-points";
            $result['data']['buildingPoints'] = array();
        }
        echo json_encode($result);exit;
    }

    public function getByCodeList()
    {
        $this->_validateFeature('project_quick_search');
        $formData = $this->input->post();
        $codeList = $formData['codeList'];
        $codeList = explode(" ", $codeList);
        $projectList = Model_project::getByCodeList($codeList);
        $projectIds = array_keys($projectList);
        $projectData = array();
        foreach ($projectList as $row) 
        {
            $row = $row->toArray();
            $projectData[] = array(
                "id" => $row["id_pro"],
                "status" => $row["status_pro"]
            );
        }
        $result['success'] = 1;
        $result['message'] = '';
        $result['data']['projectList'] = $projectData;
        echo json_encode($result);exit;
    }

    public function select2()
    {
        $term = $this->input->post("term");
        $limit = $this->input->post("limit");
        $page = $this->input->post("page");
        $currentIds = $this->input->post("currentIds");
        $currentIds = array_filter($currentIds);
        $offset = ($page-1)*$limit;
        $records = Model_project::search($term, $limit, $offset, 'code_pro', 'asc', array('code_pro'));
        $recordsFiltered = Model_project::searchTotalCount($term, array('code_pro'));

        $resultArray = array();
        $list = array();

        foreach ($records as $row)
        {
            if(array_search($row->id_pro,$currentIds) === FALSE)
            {
                $list[] = array(
                    "id" => $row->id_pro,
                    "text" => $row->code_pro,
                    "address"=> $row->address_pro,
                    "responsible" => $row->responsible,
                    "points" => $row->points_pro,
                    "distance" => $row->distance_pro,
                    "status" => $row->status_name_pst
                );
            }
        }
        $moreResults = ($page * $limit) < ($recordsFiltered - count($currentIds));
        $resultArray['list'] = $list;
        $resultArray['pagination'] = array("more" => $moreResults);
        echo json_encode($resultArray);exit;

    }

    /**
     * @deprecated
     */
    public function paginationJs_old()
    {
        $formData = $this->input->post();
        $pageSize = $formData['pageSize'];
        $pageNumber = $formData['pageNumber'] == 1?($formData['pageNumber'] - 1):(($formData['pageNumber']-1)*20)+1;
        $textToSearch = isset($formData['textToSearch'])?$formData['textToSearch']:"";
        $additionalParameters = isset($formData["additionalParameters"])?$formData["additionalParameters"]:array();
        $additionalParameters["has-location"] = 1;
        $response = $this->_is("fiscal");
        if($response == 1)
        {
            $additionalParameters["fiscal-responsible-id"] = $this->sessionUser->id;
        }
        $recordsTotal = Model_project::countAll($additionalParameters);
        $recordsFiltered = $recordsTotal;
        if ($textToSearch == "")
        {
            $resultArray = Model_project::getAll($pageSize, $pageNumber, NULL, "asc", $additionalParameters);
        }
        else
        {   
            $resultArray = Model_project::search($textToSearch, $pageSize, $pageNumber, NULL, "asc", array("code_pro"), $additionalParameters);
            $recordsFiltered = Model_project::searchTotalCount($textToSearch, array("code_pro"), $additionalParameters);
            
        }
        $response = array();
        $response['recordsTotal'] = $recordsTotal;
        $response['recordsFiltered'] = $recordsFiltered;
        $response['resultArray'] = $resultArray;
        echo json_encode($response);exit;
    }

    /**
     * Used to paginated the locations view
     */
    public function paginationJs()
    {
        $formData = $this->input->post();
        $pageSize = $formData['pageSize'];
        $pageNumber = $formData['pageNumber'] == 1?($formData['pageNumber'] - 1):(($formData['pageNumber']-1)*20)+1;
        $textToSearch = isset($formData['textToSearch'])?$formData['textToSearch']:"";
        $additionalParameters = isset($formData["additionalParameters"])?$formData["additionalParameters"]:[];
        $additionalParameters["has-location"] = 1;
        $response = $this->_is("fiscal");
        //Line commente because the map now show all projects
        // if($response == 1)
        // {
        //     $additionalParameters["fiscal-responsible-id"] = $this->sessionUser->id;
        // }

		//$dt = new JqdtHandler($this->input->post());
		$paginationHandler = new WorkflowPaginationHandler($pageSize, $pageNumber, '', 'asc',$textToSearch, ['code_pro']);
		//$paginationHandler->setColumnsToShow(['order_pst','cre_fiscal_pro','responsible','assign_to_responsible','fiscal_responsible','builder_responsible','project_current_budget','status_log_manual_entry_date','static_days','status_name_pst','manpower_file_id','builder_responsible_id','fiscal_responsible_id']);
        $paginationHandler->setColumnsToShow(['status_name_pst','fiscal_responsible','responsible']);
        $paginationHandler->setAdditionalParameters($additionalParameters);
        $response = $paginationHandler->getResponseForDataTable();

        echo json_encode($response);exit;
		//echo $dt->getJsonResponse($response['recordsTotal'], $response['recordsFiltered'], $response['resultArray']);exit;
    }
}
