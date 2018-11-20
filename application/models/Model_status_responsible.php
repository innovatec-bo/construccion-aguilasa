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
        $ci = &get_instance();
        $ci->load->database();
        $keywordFilter = "";
        if($keyword != "")
        {
            $keywordFilter = " and keyword_pst = ".$ci->db->escape($keyword);
        }

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

    public static function getResponsibleDetailListByStatusKeyword($statusKeyword, $roleKeyword)
    {
        $ci = &get_instance();
        $ci->load->database();

        $roleKeywordSql = "";
        foreach ($roleKeyword as $keyword)
        {
            $roleKeywordSql .= $ci->db->escape($keyword).', ';
        }

        $roleKeywordSql = substr($roleKeywordSql, 0, -2);

        $sql = "
        SELECT
            id_sre,
            keyword_rol,
            sec_users.*
        FROM
            wfl_status_responsibles
        LEFT JOIN sec_users on user_id_sre = id_usr
        LEFT JOIN wfl_project_status on id_pst = status_id_sre
        LEFT JOIN (
            SELECT 
                userid_uro,
                keyword_rol
            FROM sec_userroles 
            LEFT JOIN sec_roles on id_rol = roleid_uro
            WHERE keyword_rol in (".$roleKeywordSql.") and deleted_uro != 1
        ) role on role.userid_uro = id_usr
        where keyword_pst = ".$ci->db->escape($statusKeyword)." and role.keyword_rol is not null
        ";

        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}