<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 22/08/2018
 * Time: 09:42 AM
 */

class Model_incident extends Model_incident_base
{
    public function __construct($statusLogId = NULL, $percentage = 0, $detail = "", $manualEntryDate = "", $projectId = NULL)
    {
        parent::__construct($statusLogId, $percentage, $detail, $manualEntryDate, $projectId);
    }

    public static function getAllByProjectIdAndStatusId($projectId, $statusId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            select 
             wfl_incidents.*,
            firstname_usr,
            lastname_usr,
            CONCAT(firstname_usr,' ',lastname_usr) full_name
             from ".static::TABLE_NAME."
             LEFT JOIN sec_users on id_usr = createdby_inc 
            where 
            ".static::notDeleted()." 
            and project_id_inc = ".$ci->db->escape($projectId)." 
            and status_log_id_inc = ".$ci->db->escape($statusId)."
            order by manual_entry_date_inc desc
        ";

        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public static function getAllByProjectId($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            select 
             wfl_incidents.*,
            firstname_usr,
            lastname_usr,
            CONCAT(firstname_usr,' ',lastname_usr) full_name
             from ".static::TABLE_NAME."
             LEFT JOIN sec_users on id_usr = createdby_inc 
            where 
            ".static::notDeleted()." 
            and project_id_inc = ".$ci->db->escape($projectId)." 
            order by manual_entry_date_inc desc
        ";

        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}