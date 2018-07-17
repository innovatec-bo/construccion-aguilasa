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
            keyword_pst
        FROM
            wfl_project_status_log
        LEFT JOIN wfl_project_status ON status_id_psl = id_pst
        WHERE
            project_id_psl = " . $ci->db->escape($projectId) . "
        ORDER BY manual_entry_date_psl DESC
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}