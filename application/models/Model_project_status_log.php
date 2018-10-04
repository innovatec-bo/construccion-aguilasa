<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_project_status_log extends Model_project_status_log_base
{
    public function __construct($projectId = NULL, $statusId = NULL, $logDetail = "", $manualEntryDate = "")
    {
        parent::__construct($projectId, $statusId, $logDetail, $manualEntryDate);
    }

    public static function getLastProjectStatusLogByProjectId($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
            select ".static::TABLE_NAME.".* 
            from ".static::TABLE_NAME."
            where
                ".static::notDeleted()."
                and project_id_psl = ".$ci->db->escape($projectId)."
                order by createdon_psl desc limit 1 
        ";
        $query = $ci->db->query($sql);//echo"<pre>";var_dump($sql);exit;
        $result = static::recast(get_called_class(), $query->row());
        return $result;
    }

    public static function getLogByProjectId($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        SELECT
            wfl_project_status_log.*,
            status_name_pst,
            keyword_pst,
            points_quantity_prp,
            distance_prp,
            GROUP_CONCAT(responsible.full_name) responsible_user,
            points_pro,
            distance_pro,
            design_prb,
            building_prb,
            graph_number_prb,
            reservation_number_prb,
            transportation_prb,
            live_line_prb,
            start_date_cas,
            end_date_cas,
            estimated_time_cas,
            live_line_cas,
            power_down_cas,
            maneuver_cas
        FROM
                wfl_project_status_log
        LEFT JOIN wfl_project_status ON status_id_psl = id_pst
        LEFT JOIN wfl_project_points on id_psl = status_log_id_prp
        LEFT JOIN wfl_projects on id_pro = project_id_psl
        LEFT JOIN wfl_project_budgets on id_psl = status_log_id_prb
        LEFT JOIN wfl_construction_assignments on id_psl = status_log_id_cas
        LEFT JOIN (
            SELECT
                status_log_id_slr,
                firstname_usr,
                lastname_usr,
                CONCAT(firstname_usr,' ',lastname_usr) full_name
            FROM
                wfl_status_log_responsibles
            LEFT JOIN wfl_status_responsibles on responsible_id_slr = id_sre
            LEFT JOIN sec_users on user_id_sre = id_usr 
        ) responsible on responsible.status_log_id_slr = id_psl
        WHERE
                project_id_psl = ".$ci->db->escape($projectId)."
                and deleted_psl != 1
        GROUP BY id_psl
        ORDER BY manual_entry_date_psl DESC
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public static function getLogByProjectIdAndStatusKeyWord($projectId, $statusKeyword)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        SELECT
            wfl_project_status_log.*,
            wfl_project_budgets.*,
            wfl_construction_assignments.*,
            status_name_pst,
            keyword_pst,
            GROUP_CONCAT(
                CONCAT('{','\"id\":',id_sre,',\"name\":\"',firstname_usr,' ',lastname_usr,'\"}')
            ) jsonResponsible,
            secondary_code_pro
        FROM
            wfl_project_status_log
        LEFT JOIN wfl_project_status ON status_id_psl = id_pst
        LEFT JOIN wfl_project_budgets on id_psl  = status_log_id_prb
        LEFT JOIN wfl_construction_assignments on id_psl = status_log_id_cas
        LEFT JOIN wfl_status_log_responsibles on id_psl = status_log_id_slr
        LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
        LEFT JOIN sec_users on id_usr = user_id_sre
        LEFT JOIN  wfl_projects on project_id_psl = id_pro
        WHERE
            project_id_psl = " . $ci->db->escape($projectId) . "
            and keyword_pst = ".$ci->db->escape($statusKeyword)."
        GROUP BY id_psl
        ORDER BY manual_entry_date_psl DESC
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}
