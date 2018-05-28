<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_role extends Model_role_base
{
    public function __construct($roleName = "", $keyWord = "")
    {
        parent::__construct($roleName, $keyWord);
    }

    public static function getByUserId($userId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            select ".static::TABLE_NAME.".* 
            from ".static::TABLE_NAME."
            left join sec_userroles on roleid_uro = id_rol
            where 
            userid_uro = ".$ci->db->escape($userId)."
            and deleted_uro != 1
            and deleted_rol != 1 
        ";
        $result = $ci->db->query($sql);
        return static::recastArray(get_called_class(), $result->result());
    }
}