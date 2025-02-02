<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 17/07/2018
 * Time: 04:01 PM
 */

class Model_status_responsible extends Model_status_responsible_base
{
    public function __construct($userId = "", $statusId = "", $active = TRUE)
    {
        parent::__construct($userId, $statusId, $active);
    }

    public static function getUsersResponsible($keyword = "", $userId = NULL)
    {
        $ci = &get_instance();
        $ci->load->database();
		$keywordFilter = "";
        if($keyword != "")
        {
            $keywordFilter = " and keyword_pst = ".$ci->db->escape($keyword);
        }
        $userIdFilter = "";
		if(!is_null($userId))
		{
			$userIdFilter = " and id_usr = ".$ci->db->escape($userId);
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
            and active_sre = 1
            ".$keywordFilter."
            ".$userIdFilter."
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
//echo"<pre>";var_dump($sql);exit;
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }


    public static function getStatusSetByResponsibleGroup($responsibleGroup)
    {
        //Responsible on design
        $arrayStatus["design_process"][] = "design";
        $arrayStatus["design_process"][] = "rectify_design";
        $arrayStatus["design_process"][] = "rectify_illustration";
        $arrayStatus["design_process"][] = "returned";

        //Responsible on stakes
        $arrayStatus["stakes_process"][] = "stakes";
        $arrayStatus["stakes_process"][] = "rd_stakes";

        //Responsible on digitization
        $arrayStatus["digitization_process"][] = "drawing";
        $arrayStatus["digitization_process"][] = "rd_drawing";
        $arrayStatus["digitization_process"][] = "ri_drawing";

        //Responsible on building process
        $arrayStatus["building_process"][] = "assign_to";
        $arrayStatus["building_process"][] = "building";
        $arrayStatus["building_process"][] = "ready_to_start";
        $arrayStatus["building_process"][] = "in_progress";
        $arrayStatus["building_process"][] = "stopped";
        $arrayStatus["building_process"][] = "paused";
        $arrayStatus["building_process"][] = "completed";
        $arrayStatus["building_process"][] = "as_built";
        $arrayStatus["building_process"][] = "conciliation_reception";
        $arrayStatus["building_process"][] = "conciliation_shipment";
        $arrayStatus["building_process"][] = "cre_return_order";
        $arrayStatus["building_process"][] = "project_return_materials";

        //Responsible on warehouse process
        $arrayStatus["warehouse_process"][] = "warehouse";
        $arrayStatus["warehouse_process"][] = "record_building_materials";
        $arrayStatus["warehouse_process"][] = "get_materials";
        $arrayStatus["warehouse_process"][] = "deliver_materials";
        $arrayStatus["warehouse_process"][] = "return_materials";

        return $arrayStatus[$responsibleGroup];
    }

    public static function saveUserResponsible($userId, $responsibleGroup)
    {
        $statusKeywordList = static::getStatusSetByResponsibleGroup($responsibleGroup);
        $statusList = Model_project_status::getByStatusKeywordList($statusKeywordList);
        foreach ($statusList as $status)
        {
            $statusResponsible = new Model_status_responsible($userId,$status->getId());
            $statusResponsible->save();
        }
    }

    public static function getResponsiblesByStatusId()
    {
        $sql = "
        SELECT
            id_sre,	
            firstname_usr,
            lastname_usr,
            id_pst,
            status_name_pst	
        FROM
            wfl_status_responsibles
        LEFT JOIN sec_users on user_id_sre = id_usr
        LEFT JOIN wfl_project_status on status_id_sre = id_pst
        where deleted_sre != 1 and active_sre = 1
        order by order_pst
        ";
    }
}
