<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 22/08/2018
 * Time: 09:42 AM
 */

class Model_incident extends Model_incident_base
{
    public function __construct($statusLogId = NULL, $percentage = 0, $detail = "", $manualEntryDate = "", $projectId = NULL, $paused = 0, $stopped = 0, $incidentType = NULL)
    {
        parent::__construct($statusLogId, $percentage, $detail, $manualEntryDate, $projectId, $paused, $stopped, $incidentType);
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
            and status_id_inc = ".$ci->db->escape($statusId)."
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

    public function pauseStopProject($statusId)
    {
        if($this->_paused == 1 || $this->_stopped == 1)
        {
            //Now the building team is completed at in_progress step
            $assignmentEntry = Model_project_status_log::getLogByProjectIdAndStatusKeyWord($this->_projectId, "in_progress");
            $responsibleList = array();
            if(count($assignmentEntry) >= 0)
            {
                $responsibleList = json_decode("[".$assignmentEntry[0]["jsonResponsible"]."]",TRUE);
                $responsibleList = array_column($responsibleList, "id");
            }

            $project = Model_project::getById($this->_projectId);

            if($this->_paused == 1)
            {
                $statusId = 31;//project paused
            }
            if($this->_stopped == 1)
            {
                $statusId = 30;//project stopped
            }

            $project->setStatus($statusId);
            $project->save();
            $project->addStatusToLog($statusId, $this->_detail, $this->_manualEntryDate, $responsibleList);
        }
    }
}