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
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function add()
    {
        // $this->_validateFeature('role_add');
        /** Server Side Validations **/
        $this->form_validation->set_rules('role-name', 'Name', 'trim');
        $this->form_validation->set_rules('role-keyword', 'Keyword', 'trim');

        if($this->form_validation->run() === FALSE)
        {
            $response["success"] = 1;
            $response["message"] = "";
            $response["template"] = $this->loadView("panel/content/work-plan/WorkPlanHandler", array(), true);
            $response["WorkPlan"] = array();
        }
        else
        {
            $formData = $this->input->post();
            $fecha = $formData["date"];
            $role = new Model_work_plan($roleName, $roleKeyword);
            $role->save();
            $response["success"] = 1;
            $response["message"] = "User was added successfully";
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
        $this->form_validation->set_rules('role-name', 'Name', 'trim');

        if($this->form_validation->run() === FALSE)
        {
            $response["success"] = 1;
            $response["message"] = "";
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
            $workPlanMasterDetail = Model_work_plan::getWorkPlanMasterDetail(1);
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

    public function getWorkPlan()
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
}