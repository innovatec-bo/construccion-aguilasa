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

    public static function saveUserRoleList($userId, $roleList, $sessionUser)
    {
        $ci = &get_instance();
        $ci->load->database();
        static::deleteUserRoles($userId);
        $rolesToSave = array();

        foreach ($roleList as $id)
        {
            $rolesToSave[] = array(
                "userid_uro" => $userId,
                "roleid_uro" => $id,
                "deleted_uro" => 0,
                "createdon_uro" => date("Y-m-d H:i:s"),
                "createdby_uro" => $sessionUser->id
            );
        }

        if(count($rolesToSave) > 0)
        {
            $ci->db->insert_batch(static::TABLE_NAME,$rolesToSave);
        }
    }

    public static function deleteUserRoles($userId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
        $sql = "
            update ".static::TABLE_NAME." set 
            deleted_uro = 1, 
            deleted_at = now(),
            deleted_by = ".$currentUserId."
            where userid_uro = ".$ci->db->escape($userId)."
        ";
        $ci->db->query($sql);
    }

    public static function deleteByRoleId($roleId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
        $sql = "
            update ".static::TABLE_NAME." set 
            deleted_uro = 1,
            deleted_at = now(),
            deleted_by = ".$currentUserId."
            where roleid_uro = ".$ci->db->escape($roleId)."
        ";
        $ci->db->query($sql);
    }
}