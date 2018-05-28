<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 28/03/2018
 * Time: 05:41 PM
 */

class Model_user_role extends Model_user_role_base
{

    public function __construct($userId = "", $roleId = "")
    {
        parent::__construct($userId, $roleId);
    }

    /**
     * @param $userId
     * @return array of roles
     */
    public static function getByUserId($userId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        select * from ".static::TABLE_NAME." where userid_uro = ".$ci->db->escape($userId)."
        ";
        $query = $ci->db->query($sql);
        $result = static::recastArray(get_called_class(),$query->result());
        return $result;
    }

    public static function saveUserRoleList($roleList)
    {

    }
}