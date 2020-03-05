<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 10/1/2018
 * Time: 2:01 PM
 */


class AjaxWorkPlan extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        $this->_validateFeature("work_plan");
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function ajaxDtAllWorkPlans()
    {
        $dt = new JqdtHandler($this->input->post());
        $additionalParameters = array();
        if($this->_is("fiscal"))
            $additionalParameters['fiscal'] = $this->sessionUser->id;
        $recordsTotal = Model_work_plan::countAll($additionalParameters);
        $recordsFiltered = $recordsTotal;
        if (!$dt->hasSearchValue())
        {
            $resultArray = Model_work_plan::getAll($dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0), $additionalParameters);
        }
        else
        {
            $resultArray = Model_work_plan::search($dt->getSearchValue(), $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0), $dt->getSearchableColumnDefs(), $additionalParameters);
            $recordsFiltered = Model_work_plan::searchTotalCount($dt->getSearchValue(),$dt->getSearchableColumnDefs(), $additionalParameters);
        }

        echo $dt->getJsonResponse($recordsTotal, $recordsFiltered, $resultArray);
        exit;
    }

    public function add()
    {
        // $this->_validateFeature('role_edit');

        /** Server Side Validations **/
        $this->form_validation->set_rules('fiscalId', 'Fiscal', 'trim|required');
        $this->form_validation->set_rules('builderId', 'Constructor', 'trim|required');

        if($this->form_validation->run() === FALSE)
        {
            $validationErrors = validation_errors();
            $validationErrors = str_replace("<p>","",$validationErrors);
            $validationErrors = str_replace("</p>","<br>",$validationErrors);
            $response = array("success" => 0, "message" => $validationErrors);
            $success = $validationErrors != ""?0:1;
            $response["success"] = $success;
            $response["message"] = $validationErrors;
            $fiscalList = Model_user::getByRoleKeyword('fiscal');
            $arrayFiscal = array();
            foreach ($fiscalList as $fiscal)
            {
                $fiscal = $fiscal->toArray();
                $arrayFiscal[] = array(
                    "id" => $fiscal['id_usr'],
                    "fullName" => $fiscal['firstname_usr']." ".$fiscal['lastname_usr']
                );
            }
            $builderList = Model_user::getByRoleKeyword('builder');
            $arrayBuilder = array();
            foreach ($builderList as $builder)
            {
                $builder = $builder->toArray();
                $arrayBuilder[] = array(
                    "id" => $builder['id_usr'],
                    "fullName" => $builder['firstname_usr']." ".$builder['lastname_usr']
                );
            }
            $response['data']["template"] = $this->loadView("panel/content/work-plan/WorkPlanHandler", array(),true);
            $response['data']["templateName"] = '#work-plan-add-form';
            $response["data"]["workPlanMasterDetail"] = array('projectList'=> array('projectDateList'=>array()));
            $response['data']['fiscalList'] = $arrayFiscal;
            $response['data']['builderList'] = $arrayBuilder;
        }
        else
        {
            $formData = $this->input->post();
            $fiscalId = $formData["fiscalId"];
            $builderId = $formData["builderId"];
            $weekNumber = $formData["weekNumber"];
            $datesToWork = $formData["datesToWork"];
            $workPlan = new Model_work_plan("", $fiscalId, $builderId, $weekNumber);
            $workPlan->save();
            $workPlan->updateDatesToWork($datesToWork);
            $response["success"] = 1;
            $response["message"] = "Plan de trabajo creado correctamente";

        }
        echo json_encode($response);exit;
    }

    public function edit($workPlanId = NULL)
    {
        // $this->_validateFeature('role_edit');

        if(!is_numeric($workPlanId))
        {
            $response["success"] = 0;
            $response["message"] = "Invalid parameter.";
            echo json_encode($response);exit;
        }
        $workPlan = Model_work_plan::getById($workPlanId);
        if(!$workPlan instanceof Model_work_plan)
        {
            $response["success"] = 0;
            $response["message"] = "No se encontro el plan de trabajo.";
            echo json_encode($response);exit;
        }

        /** Server Side Validations **/
        $this->form_validation->set_rules('fiscalId', 'Fiscal', 'trim|required');
        $this->form_validation->set_rules('builderId', 'Constructor', 'trim|required');

        if($this->form_validation->run() === FALSE)
        {
            $validationErrors = validation_errors();
            $validationErrors = str_replace("<p>","",$validationErrors);
            $validationErrors = str_replace("</p>","<br>",$validationErrors);
            $response = array("success" => 0, "message" => $validationErrors);
            $success = $validationErrors != ""?0:1;
            $response["success"] = $success;
            $response["message"] = $validationErrors;
            $fiscalList = Model_user::getByRoleKeyword('fiscal');
            $arrayFiscal = array();
            foreach ($fiscalList as $fiscal)
            {
                $fiscal = $fiscal->toArray();
                $arrayFiscal[] = array(
                    "id" => $fiscal['id_usr'],
                    "fullName" => $fiscal['firstname_usr']." ".$fiscal['lastname_usr']
                );
            }
            $builderList = Model_user::getByRoleKeyword('builder');
            $arrayBuilder = array();
            foreach ($builderList as $builder)
            {
                $builder = $builder->toArray();
                $arrayBuilder[] = array(
                    "id" => $builder['id_usr'],
                    "fullName" => $builder['firstname_usr']." ".$builder['lastname_usr']
                );
            }
            // echo"<pre>";var_dump($arrayFiscal);exit;
            $workPlanMasterDetail = Model_work_plan::getWorkPlanMasterDetail($workPlanId);
            $workPlanMasterDetail = $workPlanMasterDetail[0];
            $response['data']["template"] = $this->loadView("panel/content/work-plan/WorkPlanHandler", array(),true);
            $response['data']["templateName"] = '#work-plan-edit-form';
            $response["data"]["workPlanMasterDetail"] = $workPlanMasterDetail;
            $response['data']['fiscalList'] = $arrayFiscal;
            $response['data']['builderList'] = $arrayBuilder;
        }
        else
        {
            $formData = $this->input->post();
            $fiscalId = $formData["fiscalId"];
            $builderId = $formData["builderId"];
            $weekNumber = $formData["weekNumber"];
            $datesToWork = $formData["datesToWork"];
            $workPlan->setFiscalId($fiscalId);
            $workPlan->setBuilderId($builderId);
            $workPlan->setWeekNumber($weekNumber);
            $workPlan->save();
            $workPlan->updateDatesToWork($datesToWork);
            $response["success"] = 1;
            $response["message"] = "Plan de trabajo editado correctamente";

        }
        echo json_encode($response);exit;
    }

    public function getTotalRoles()
    {
        $recordsTotal = Model_role::countAll();
        $response["total"] = $recordsTotal;
        echo json_encode($response);exit;
    }

    public function getWorkPlan_deprecated()
    {
        $fiscalList = Model_user::getByRoleKeyword('fiscal');
        $arrayFiscal = array();
        foreach ($fiscalList as $fiscal)
        {
            $fiscal = $fiscal->toArray();
            $arrayFiscal[] = array(
                "id" => $fiscal['id_usr'],
                "fullName" => $fiscal['firstname_usr']." ".$fiscal['lastname_usr'],
            );
        }
        $builderList = Model_user::getByRoleKeyword('builder');
        $arrayBuilder = array();
        foreach ($builderList as $builder)
        {
            $builder = $builder->toArray();
            $arrayBuilder[] = array(
                "id" => $builder['id_usr'],
                "fullName" => $builder['firstname_usr']." ".$builder['lastname_usr'],
            );
        }
        $workPlanMasterDetail = Model_work_plan::getWorkPlanMasterDetail(1);

        $result['data']['fiscalList'] = $fiscalList;
        $result['data']['builderList'] = $builderList;
        $result['data']['workPlanMasterDetail'] = $workPlanMasterDetail;
    }

    public function delete($workPlanId)
    {
        // $this->_validateFeature("delete_project");
        $project = $this->_validateObjectToEdit($workPlanId,"Model_work_plan","panel/WorkPlan");
        $project->delete();
        $response["success"] = 1;
        $response["message"] = "Plan de trabajo eliminado exitosamente.";       
        echo json_encode($response);exit;
    }

    public function getWorkPlanSummary($workPlanId, $startDate, $endDate)
    {
        $workPlanSummary = Model_work_plan::getMonthlySummary();
        $response["success"] = 1;
        $response["message"] = "";
        $response["data"]["workPlanSummary"] = $workPlanSummary;
        $response['data']["template"] = $this->loadView("panel/content/work-plan/WorkPlanHandler", array(),true);
        $response['data']["templateName"] = '#work-plan-summary-table';
        echo json_encode($response);exit;
    }
}