<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 18/01/2019
 * Time: 12:11 PM
 */

class AjaxWorkflowColumnGroup extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function ajaxDtAllWorkflowColumnsGroup()
    {
        $dt = new JqdtHandler($this->input->post());
        $recordsTotal = Model_workflow_column_group::countAll();
        $recordsFiltered = $recordsTotal;
        if (!$dt->hasSearchValue())
        {
            $resultArray = Model_workflow_column_group::getAll($dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0));
        }
        else
        {
            $resultArray = Model_workflow_column_group::search($dt->getSearchValue(), $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0), $dt->getSearchableColumnDefs());
            $recordsFiltered = Model_workflow_column_group::searchTotalCount($dt->getSearchValue(),$dt->getSearchableColumnDefs());
        }

        echo $dt->getJsonResponse($recordsTotal, $recordsFiltered, $resultArray);
        exit;
    }

    public function add()
    {
//        $this->_validateFeature('role_add');
        /** Server Side Validations **/
        $this->form_validation->set_rules('groupName', 'Name', 'trim|required');
        $this->form_validation->set_rules('groupColumns', 'Columns', 'trim');

        if($this->form_validation->run() === FALSE)
        {
            //Right now isn't necessary make a get request to add a new column group.
//            $response["success"] = 1;
//            $response["message"] = "";
//            $response["template"] = $this->loadView("panel/content/role/ht-modal-add", array(),true);
//            $response["role"] = array();
        }
        else
        {
            $formData = $this->input->post();
            $groupName = $formData["groupName"];
            $groupColumns = $formData["groupColumns"];
            if(is_array($groupColumns))
            {
                $groupColumns = implode(",",$groupColumns);
            }
            else
            {
                $groupColumns = "";
            }
            $wfColumnGroup = new Model_workflow_column_group($groupName, $groupColumns);
            $wfColumnGroup->save();
            $response["success"] = 1;
            $response["message"] = "User was added successfully";
            $wfColumnGroup = $wfColumnGroup->toArray();
            $response["wfColumnGroup"]["wfGroupId"] =  $wfColumnGroup["id_wcg"];
            $response["wfColumnGroup"]["wfGroupName"] =  $wfColumnGroup["column_group_name_wcg"];
            $response["wfColumnGroup"]["wfGroupList"] =  $wfColumnGroup["column_list_wcg"];
            echo json_encode($response);exit;
        }
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
}