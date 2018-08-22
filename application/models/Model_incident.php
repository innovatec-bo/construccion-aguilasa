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
            select * from ".static::TABLE_NAME." 
            where 
            ".static::notDeleted()." 
            and project_id_inc = ".$ci->db->escape($projectId)." 
            and status_log_id_inc = ".$ci->db->escape($statusId)."
            order by manual_entry_date_inc desc
        ";

        $query = $ci->db->query($sql);
        $result = static::recastArray(get_called_class(), $query->result());
        return $result;
    }
}