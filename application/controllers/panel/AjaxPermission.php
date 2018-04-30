<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/4/2018
 * Time: 11:15
 */

class AjaxPermission extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getByRoleId()
    {
        $formData = $this->input->post();
        $roleId = $formData["roleId"];
        $roleList = Model_permission::getByRoleId($roleId);
        $arrayRoles = array();
        foreach ($roleList as $role)
        {
            $arrayRoles[] = $role->toArray();
        }
        echo json_encode($arrayRoles);exit;
    }
}