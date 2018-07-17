<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 17/07/2018
 * Time: 04:01 PM
 */

class Model_status_responsible extends Model_status_responsible_base
{
    public function __construct($userId = "", $statusId = "")
    {
        parent::__construct($userId, $statusId);
    }

    public static function getUsersResponsible($keyword = "")
    {
        $keywordFilter = "";
        if($keyword != "")
        {
            $keywordFilter = " and keyword_pst = ".$ci->db->escape($keyword);
        }
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
            SELECT
                sec_users.*,
                id_sre,
                id_pst,
                status_name_pst,
                keyword_pst
            FROM
            wfl_status_responsibles
            LEFT JOIN sec_users on user_id_sre = id_usr
            LEFT JOIN wfl_project_status on status_id_sre = id_pst
            WHERE 
            deleted_usr != 1
            and deleted_sre != 1
            ".$keywordFilter."
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}