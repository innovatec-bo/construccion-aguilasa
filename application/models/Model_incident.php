<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 22/08/2018
 * Time: 09:42 AM
 */

class Model_incident extends Model_incident_base
{
    public function __construct($statusLogId = NULL, $percentage = 0, $detail = "", $manualEntryDate = "", $projectId = NULL, $paused = 0, $stopped = 0, $incidentType = NULL, $needToBeSolved = 0, $solvedOnDate = '')
    {
        parent::__construct($statusLogId, $percentage, $detail, $manualEntryDate, $projectId, $paused, $stopped, $incidentType, $needToBeSolved, $solvedOnDate);
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

    public static function incidentLog()
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            SELECT
                firstname_usr first_name,
                lastname_usr last_name,
                code_pro project_code,	
                detail_inc incident_detail,
                incident_status.status_name_pst status_on_incident,
                project_status.status_name_pst current_status,		
                case incident_type_inc
                WHEN 1 then 'Permisos'
                WHEN 2 then 'Fiscales'
                WHEN 3 then 'Vecinos'
                WHEN 4 then 'Linea Viva'
                WHEN 5 then 'Mecanico'
                WHEN 6 then 'Materiales incompletos'
                WHEN 7 then 'Climatológico'
                WHEN 8 then 'Otros'
                WHEN 9 then 'Ninguno'
                WHEN 10 then 'CRE'                
                end incident_type,
                manual_entry_date_inc manual_entry_date
            FROM
                wfl_incidents
            LEFT JOIN sec_users on id_usr = createdby_inc
            LEFT JOIN wfl_project_status incident_status on status_id_inc = incident_status.id_pst
            LEFT JOIN wfl_projects on id_pro = project_id_inc
            LEFT JOIN wfl_project_status project_status on status_pro = project_status.id_pst
            WHERE
                detail_inc not in('Construccion completada','En construccion','','En Contruccion')
            ORDER BY manual_entry_date_inc desc
        ";

        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}