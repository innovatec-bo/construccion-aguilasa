<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_project extends Model_project_base
{
    public function __construct($projectCode = "", $projectName = "", $system = NULL, $address = "", $entryDate = "", $creFiscal = "", $status = NULL, $projectStart = "", $projectEnd = "", $points = 0, $distance = 0, $managementBy = NULL, $qualityLevel = 0, $creDesignCompletionDate = "", $creBuildingCompletionDate = "", $budgetaryPosition = 0, $secondaryCode = "", $folderDate = "")
    {
        parent::__construct($projectCode, $projectName, $system, $address, $entryDate, $creFiscal, $status, $projectStart, $projectEnd, $points, $distance, $managementBy, $qualityLevel, $creDesignCompletionDate, $creBuildingCompletionDate, $budgetaryPosition, $secondaryCode, $folderDate);
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

    /**
     * @param $design
     * @param $building
     * @param $graphNumber
     * @param $reservationNumber
     * @param $transportation
     * @param $liveLine
     * @param $rightOfWay
     * @param $statusId
     * @param $statusDetail
     * @param $manualEntryDate
     * @param array $responsibleList array id list referenced to status responsible table
     */
    public function saveBudget($design, $building, $graphNumber, $reservationNumber, $transportation, $liveLine, $rightOfWay, $statusId, $statusDetail, $manualEntryDate, $responsibleList = array())
    {
        //Lets create a new log
        $projectStatus = new Model_project_status_log($this->_id, $statusId, $statusDetail, $manualEntryDate);
        $projectStatus->save();

        //Create the record about the design and building and associate it to project status log
        $projectBudget = new Model_project_budget($projectStatus->getId(), $design, $building, $graphNumber, $reservationNumber, $transportation, $liveLine, $rightOfWay);
        $projectBudget->save();

        //Each statusLog needs to have a o more responsible by log
        Model_status_log_responsible::addResponsible($projectStatus->getId(), $responsibleList);
    }

    public function saveRealBudget($design, $building, $transportation, $liveLine, $rightOfWay, $statusId, $statusDetail, $manualEntryDate, $responsibleList = array())
    {
        //Lets create a new log
        $projectStatus = new Model_project_status_log($this->_id, $statusId, $statusDetail, $manualEntryDate);
        $projectStatus->save();

        //Create the record about the design and building and associate it to project status log
        $projectRealBudget = new Model_project_real_budget($projectStatus->getId(), $design, $building, $transportation, $liveLine, $rightOfWay);
        $projectRealBudget->save();

        //Each statusLog needs to have a o more responsible by log
        Model_status_log_responsible::addResponsible($projectStatus->getId(), $responsibleList);
    }

    public function saveConstructionAssignments($startDate, $endDate, $estimatedTime, $liveLine, $powerDown, $maneuver, $statusId, $statusDetail, $manualEntryDate, $responsibleList = array())
    {
        //Lets create a new log
        $projectStatus = new Model_project_status_log($this->_id, $statusId, $statusDetail, $manualEntryDate);
        $projectStatus->save();

        //Create the record about the design and building and associate it to project status log
        $constructionAssignment = new Model_construction_assignment($projectStatus->getId(), $startDate, $endDate, $estimatedTime, $liveLine, $powerDown, $maneuver);
        $constructionAssignment->save();

        //Each statusLog needs to have a o more responsible by log
        Model_status_log_responsible::addResponsible($projectStatus->getId(), $responsibleList);
    }

    /**
     * @param $statusId
     * @param string $detail
     * @param string $manualEntryDate
     * @param array $responsibleList array list ids
     */
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

    public static function getBySecondaryCode($secondaryCode)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
          select * from ".static::TABLE_NAME." where ".static::notDeleted()." and secondary_code_pro = ".$ci->db->escape($secondaryCode)." 
        ";

        $query = $ci->db->query($sql);
        $result = static::recast(get_called_class(), $query->row());
        return $result;
    }

    public function startWarehouseProcess($entryDate)
    {
        $warehouse = new Model_warehouse($this->_id);
        $warehouse->save();
        $warehouse->addStatusToLog(22, "Inicio de gestion de materiales de construccion", $entryDate);
    }

    public static function getApprovedProjectWithoutWarehouse()
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = '
        SELECT
            wfl_projects.*,
            id_war
        FROM
            wfl_projects
        LEFT JOIN wfl_warehouses on project_id_war = id_pro
        WHERE
        status_pro in (11)
        and id_war is null
        ';

        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public static function getAllByPaymentOrderId($orderId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = '
        SELECT
            wfl_projects.*
        FROM
            wfl_projects
        left JOIN wfl_payment_orders_projects on project_id_pop = id_pro
        WHERE
        deleted_pop != 1
        and deleted_pro != 1
        and order_id_pop = '.$ci->db->escape($orderId).'
        ';

        $query = $ci->db->query($sql);
        $result = static::recastArray(get_called_class(), $query->result());
        return $result;
    }

    function approveThisProject($entryDate = "", $statusDetail = "", $design = 0, $building = 0, $graphNumber = 0, $reservationNumber = 0, $transportation = 0, $liveLine = 0,$rightOfWay = 0, $secondaryCode = "")
    {
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = 11;
        $design = str_replace(",","",$design);
        $building = str_replace(",","",$building);
        $transportation = str_replace(",","",$transportation);
        $liveLine = str_replace(",","",$liveLine);
        $rightOfWay = str_replace(",","",$rightOfWay);
        $responsibleList = Model_status_responsible::getResponsibleDetailListByStatusKeyword("approved");
        $responsibleList = array_column($responsibleList,"id_sre");
        $this->_status = $statusId;
        $this->_secondaryCode = $secondaryCode;
        $this->save();
        $this->saveBudget($design, $building, $graphNumber, $reservationNumber, $transportation, $liveLine, $rightOfWay, $statusId, $statusDetail, $entryDate, $responsibleList);
        $wareHouse = Model_warehouse::getByProjectId($this->_id);
        if(!$wareHouse instanceof Model_warehouse)
        {
            $this->startWarehouseProcess($entryDate);
        }
    }
    public static function projectCodeDuplicated($projectCode, $projectId = NULL)
    {
        $alreadyExist = FALSE;
        //add project
        if(is_null($projectId))
        {
            $project = static::getByCode($projectCode);
        }
        //edit project
        else
        {
            $project = static::getByProjectCodeAndNotProjectId($projectCode, $projectId);
        }

        if($project instanceof Model_project)
        {
            $alreadyExist = TRUE;
        }

        return $alreadyExist;
    }

    public static function getByProjectCodeAndNotProjectId($projectCode, $projectId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            SELECT
                wfl_projects.*
            FROM
                wfl_projects
            WHERE
            code_pro = ".$ci->db->escape($projectCode)."
            and id_pro != ".$ci->db->escape($projectId)."
            and deleted_pro != 1
        ";

        $query = $ci->db->query($sql);
        $result = static::recast(get_called_class(), $query->row());
        return $result;
    }

    public static function projectSecondaryCodeDuplicated($secondaryCode, $projectId = NULL)
    {
        $alreadyExist = FALSE;
        //add project
        if(is_null($projectId))
        {
            $project = static::getBySecondaryCode($secondaryCode);
        }
        //edit project
        else
        {
            $project = static::getBySecondaryCodeAndNotProjectId($secondaryCode, $projectId);
        }

        if($project instanceof Model_project)
        {
            $alreadyExist = TRUE;
        }

        return $alreadyExist;
    }

    public static function getBySecondaryCodeAndNotProjectId($secondaryCode, $projectId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            SELECT
                wfl_projects.*
            FROM
                wfl_projects
            WHERE
            secondary_code_pro = ".$ci->db->escape($secondaryCode)."
            and id_pro != ".$ci->db->escape($projectId)."
            and deleted_pro != 1
        ";

        $query = $ci->db->query($sql);
        $result = static::recast(get_called_class(), $query->row());
        return $result;
    }
}