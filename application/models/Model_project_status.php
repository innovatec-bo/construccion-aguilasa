<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_project_status extends Model_project_status_base
{
    public function __construct($name = "", $icon = "", $order = "")
    {
        parent::__construct($name, $icon, $order);
    }

    public function delete($makePhysicalDelete = FALSE)
    {
        //Delete all roles
//        Model_user_role::deleteByRoleId($this->_id);
        //Delete role
        parent::delete($makePhysicalDelete);
    }
}