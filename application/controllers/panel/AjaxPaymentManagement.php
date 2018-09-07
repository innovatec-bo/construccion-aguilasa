<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 07/09/2018
 * Time: 10:44 AM
 */


class AjaxPaymentManagement extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }
    //TODO: needs to be implemented!
    public function ajaxDtAllPaymentOrders()
    {
        $dt = new JqdtHandler($this->input->post());
        $recordsTotal = Model_role::countAll();
        $recordsFiltered = $recordsTotal;
        if (!$dt->hasSearchValue())
        {
            $resultArray = Model_role::getAll($dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0));
        }
        else
        {
            $resultArray = Model_role::search($dt->getSearchValue(), $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0), $dt->getSearchableColumnDefs());
            $recordsFiltered = Model_role::searchTotalCount($dt->getSearchValue(),$dt->getSearchableColumnDefs());
        }

        echo $dt->getJsonResponse($recordsTotal, $recordsFiltered, $resultArray);
        exit;
    }

    public function add()
    {
        $this->_validateFeature('role_add');
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

    public function deletePaymentOrderProject()
    {
        $formData = $this->input->post();
        echo "<pre>";var_dump($formData);exit;
    }

    public function getOriginalBudgets()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $originalBudgets = Model_project_status_log::getLogByProjectIdAndStatusKeyWord($projectId, "approved");
        $response = array("design" => 0, "transportation" => 0, "building" => 0, "liveLine" => 0);
        if(count($originalBudgets) > 0)
        {
            $response["design"] = $originalBudgets[0]["design_prb"];
            $response["transportation"] = $originalBudgets[0]["transportation_prb"];
            $response["building"] = $originalBudgets[0]["building_prb"];
            $response["liveLine"] = $originalBudgets[0]["live_line_prb"];
        }
        echo json_encode($response);exit;
    }
}