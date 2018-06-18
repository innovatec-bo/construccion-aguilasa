<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_project_status extends Model_project_status_base
{
    public function __construct($name = "", $icon = "", $order = "", $parentStatus = "")
    {
        parent::__construct($name, $icon, $order, $parentStatus);
    }

    public static function getChildrenByParentStatusId($parentStatusId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        select ".static::TABLE_NAME.".*
        from ".static::TABLE_NAME."
        where 
        ".static::notDeleted()."
        and parent_status_pst = ".$ci->db->escape($parentStatusId)."        
        ";
        $query = $ci->db->query($sql);
        $result = static::recastArray(get_called_class(), $query->result());
        return $result;
    }

    public function delete($makePhysicalDelete = FALSE)
    {
        //Delete all roles
//        Model_user_role::deleteByRoleId($this->_id);
        //Delete role
        parent::delete($makePhysicalDelete);
    }
}