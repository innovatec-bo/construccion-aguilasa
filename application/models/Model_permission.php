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
}