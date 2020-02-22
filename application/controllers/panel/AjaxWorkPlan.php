<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 10/1/2018
 * Time: 2:01 PM
 */


class AjaxRole extends PrivateController
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
            $response["template"] = $this->loadView("panel/content/event-calendar/WorkPlanHandler", array(), true);
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

    public function edit($roleId = NULL)
    {
        $this->_validateFeature('role_edit');

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

    public function getWorkPlan()
    {
        $fiscalList = Model_user::getByRoleKeyword('fiscal');
        $arrayFiscal = array();
        foreach ($fiscalList as $fiscal)
        {
            $fiscal = $fiscal->toArray();
            $arrayFiscal[] = array();
        }
        $builderList = Model_user::getByRoleKeyword('builder');
        $arrayBuilder = array();
        foreach ($fiscalList as $fiscal)
        {
            $fiscal = $fiscal->toArray();
            $fiscal = $fiscal->toArray();
            $arrayBuilder[] = array();
        }
    }
}