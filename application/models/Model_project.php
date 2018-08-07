<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_project extends Model_project_base
{
    public function __construct($projectCode = "", $projectName = "", $system = NULL, $address = "", $entryDate = "", $creFiscal = "", $status = NULL, $projectStart = "", $projectEnd = "", $points = 0, $distance = 0)
    {
        parent::__construct($projectCode, $projectName, $system, $address, $entryDate, $creFiscal, $status, $projectStart, $projectEnd, $points, $distance);
    }

    public function savePoints($points, $metersDistance, $statusId, $statusDetail, $manualEntryDate, $responsibleList = array())
    {
        //Lets create a new log
        $projectStatus = new Model_project_status_log($this->_id, $statusId, $statusDetail, $manualEntryDate);
        $projectStatus->save();

        //Create the record about the points and distance and associate it to project status log
        $projectPoints = new Model_project_points($projectStatus->getId(), $points, $metersDistance);
        $projectPoints->save();

        //Each statusLog needs to have a o more responsible by log
        Model_status_log_responsible::addResponsible($projectStatus->getId(), $responsibleList);
    }

    public function saveBudget($design, $building, $graphNumber, $reservationNumber, $transportation, $statusId, $statusDetail, $manualEntryDate, $responsibleList = array())
    {
        //Lets create a new log
        $projectStatus = new Model_project_status_log($this->_id, $statusId, $statusDetail, $manualEntryDate);
        $projectStatus->save();

        //Create the record about the design and building and associate it to project status log
        $projectBudget = new Model_project_budget($projectStatus->getId(), $design, $building, $graphNumber, $reservationNumber, $transportation);
        $projectBudget->save();

        //Each statusLog needs to have a o more responsible by log
        Model_status_log_responsible::addResponsible($projectStatus->getId(), $responsibleList);
    }

    public function addStatusToLog($statusId, $detail = "", $manualEntryDate = "", $responsibleList = array())
    {
        $getLastProjectStatus = Model_project_status_log::getLastProjectStatusLogByProjectId($this->_id);
        $currentResponsibleList = Model_status_log_responsible::getByStatusLogId($statusId);
        $responsibleDifference = array_diff($responsibleList,array_column($currentResponsibleList,"id_sre"));
        if(!$getLastProjectStatus instanceof Model_project_status_log || $getLastProjectStatus->getProjectStatus() != $this->_status || $getLastProjectStatus->getDetail() != $detail || count($responsibleDifference) > 0)
        {
            //Lets create a new log
            $projectStatus = new Model_project_status_log($this->_id, $statusId, $detail, $manualEntryDate);
            $projectStatus->save();
            $this->_status = $statusId;
            $this->save();
            //Each statusLog needs to have a o more responsible by log
            Model_status_log_responsible::addResponsible($projectStatus->getId(), $responsibleList);
        }
    }

    public static function getStakesLeaderProjects()
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
            SELECT
                id_prs,
                id_stl,
                leader_stl,
                id_pro,
                address_pro,
                project_name_pro,
                points_quantity_prp,
                meters_distance_prp
            FROM
                wfl_project_stakes
            LEFT JOIN wfl_projects on project_id_prs = id_pro
            LEFT JOIN (
                        select 
                            pp1.project_id_prp,
                            pp1.points_quantity_prp,
                            pp1.meters_distance_prp
                        from wfl_project_points pp1
                        LEFT JOIN wfl_project_points pp2 on pp1.project_id_prp = pp2.project_id_prp and pp1.id_prp < pp2.id_prp
                        WHERE
                        pp1.deleted_prp != 1			
                        and pp2.id_prp is null
            ) project_points on project_points.project_id_prp = id_pro
            LEFT JOIN wfl_stakes_team_leader on stakes_leader_id_prs = id_stl
            WHERE 
                deleted_pro != 1
                and deleted_prs != 1
                and status_pro = 2
            ORDER BY id_stl
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function saveStakesTeam($stakesTeamList)
    {
        $ci = &get_instance();
        $ci->load->database();
        Model_project_stakes::removeAllStakesTeamByProjectId($this->_id);
        $arrayToSave = array();
        foreach ($stakesTeamList as $teamLeaderId)
        {
            $arrayToSave[] = array(
                "project_id_prs" => $this->_id,
                "stakes_leader_id_prs" =>  $teamLeaderId,
                "deleted_prs" => 0,
                "createdon_prs" => date("Y-m-d -H:i:s"),
                "createdby_prs" => NULL,
                "editedon_prs" => "",
                "editedby_prs" => NULL
            );
        }

        if(count($arrayToSave) > 0)
        {
            $ci->db->insert_batch("wfl_project_stakes", $arrayToSave);
        }
    }

    public static function getByCode($code)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        select * from ".static::TABLE_NAME." where ".static::notDeleted()." and code_pro = ".$ci->db->escape($code)." 
        ";

        $query = $ci->db->query($sql);
        $result = static::recast(get_called_class(), $query->row());
        return $result;
    }
}