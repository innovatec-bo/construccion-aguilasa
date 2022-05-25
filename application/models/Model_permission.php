<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_permission extends Model_permission_base
{
    public function __construct($roleId, $featureId)
    {
        parent::__construct($roleId, $featureId);
    }

    public static function getByRoleId($roleId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        select * from ".static::TABLE_NAME." where roleid_per = ".$ci->db->escape($roleId)." and ".static::notDeleted()."
        ";

        $query = $ci->db->query($sql);
        $result = static::recastArray(get_called_class(), $query->result());
        return $result;
    }

    public static function deleteByRoleId($roleId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
        $sql = "
            Update ".static::TABLE_NAME." set 
            deleted_per = 1,
            deleted_at = now(), 
            deleted_by = ".$currentUserId." 
            where roleid_per = ".$ci->db->escape($roleId)."
        ";
        $ci->db->query($sql);
    }

    public static function saveBatch($roleId, $featureList)
    {
        $ci = &get_instance();
        $ci->load->database();

        static::deleteByRoleId($roleId);
        $readyToSave = array();
        foreach($featureList as $featureId)
        {
            $readyToSave[] = array(
                "roleid_per" => $roleId,
                "featureid_per" => $featureId,
                "deleted_per" => 0,
                "createdon_per" => date("Y-m-d H:i:s")
            );
        }

        if(count($readyToSave) > 0)
            $ci->db->insert_batch(static::TABLE_NAME, $readyToSave);
    }
}