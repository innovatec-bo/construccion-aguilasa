<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_role extends Model_role_base
{
    public function __construct($roleName)
    {
        parent::__construct($roleName);
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
        ";
//        echo"<pre>";var_dump($sql);exit;
        $result = $ci->db->query($sql);
        return static::recastArray(get_called_class(), $result->result());
    }
}