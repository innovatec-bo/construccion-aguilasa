<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 28/08/2018
 * Time: 12:12 PM
 */

class Model_warehouse extends Model_warehouse_base
{
    public function __construct($projectId = NULL, $statusId = 22)
    {
        parent::__construct($projectId, $statusId);
    }

    public static function getByProjectId($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
            select ".static::TABLE_NAME.".*
            from 
                ".static::TABLE_NAME."
            where
                ".static::notDeleted()."
                and project_id_war = ".$ci->db->escape($projectId)."
        ";
        $query = $ci->db->query($sql);
        $result = static::recast(get_called_class(), $query->row());
        return $result;
    }

    public function addStatusToLog($statusId, $detail = "", $manualEntryDate = "")
    {
        //Lets create a new log
        $projectStatus = new Model_warehouse_status_log($this->_id, $statusId, $detail, $manualEntryDate);
        $projectStatus->save();
        $this->_statusId = $statusId;
        $this->save();
    }
}