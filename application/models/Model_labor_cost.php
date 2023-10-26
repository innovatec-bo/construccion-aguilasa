<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:04 PM
*/

class Model_labor_cost extends Model_labor_cost_base
{
    public function __construct($laborDetailId = NULL, $buildingStructureId = NULL, $activity = "", $execution = "", $quantity = "", $unitPrice = 0, $isAdditional = 0)
	{
		parent::__construct($laborDetailId, $buildingStructureId, $activity, $execution, $quantity, $unitPrice, $isAdditional);
	}

	public static function getMasterDetailByProjectId($projectId, $statusId = 11)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        SELECT
            id_lac labor_cost_id,
            labor_detail_id_lac labor_detail,
            building_structure_id_lac building_structure_id,
            activity_lac activity,
            execution_lac execution,
            quantity_lac quantity,
            unit_price_lac unit_price,
            id_bus structure_id,
            structure_code_bus structure_code,
            description_bus description,
            unit_of_measurement_bus unit_of_measurement,
            round(unit_price_lac * quantity_lac,2) total_price_by_structure,
            IFNULL(bui_worked_up_structures.worked_up_wus,0) worked_up,
            (quantity_lac - IFNULL(bui_worked_up_structures.worked_up_wus,0)) diff,
            CONCAT(id_bus,'-',activity_lac,'-',execution_lac) labor_cost_unique
        FROM
            bui_labor_cost
        LEFT JOIN bui_building_structures on building_structure_id_lac = id_bus
        LEFT JOIN bui_labor_details on labor_detail_id_lac = id_lad
				LEFT JOIN (
								SELECT
									labor_cost_id_wus,
									SUM(worked_up_wus) worked_up_wus
								FROM
									bui_labor_cost_log
									LEFT JOIN bui_worked_up_structures on labor_cost_log_id_wus = id_lal
								where 
									deleted_lal != 1
									and deleted_wus != 1
									GROUP BY labor_cost_id_wus) bui_worked_up_structures on id_lac = labor_cost_id_wus
        where
        project_id_lad = ".$ci->db->escape($projectId)."
        and status_id_lad = ".$statusId."
        and deleted_lac != 1
        and deleted_bus != 1
        and deleted_lad != 1
        ";

        $query = $ci->db->query($sql);
        $response = $query->result_array();
        return $response;
    }

    public static function getByProjectIdAndStructureCodeList($projectId = NULL, $list = array(), $statusId = 11)
    {
        $ci = &get_instance();
        $ci->load->database();

        $escapedList = "";
        foreach($list as $code)
        {
            $escapedList .= $ci->db->escape($code).", ";
        }
        $escapedList = substr($escapedList, 0, -2);
        $sql = "
        SELECT
            structure_code_bus,
            description_bus,
            bui_labor_cost.*
        FROM
            bui_labor_details
        LEFT JOIN bui_labor_cost on labor_detail_id_lac = id_lad
        LEFT JOIN bui_building_structures on building_structure_id_lac = id_bus
        WHERE
            deleted_bus != 1
            and deleted_lac != 1
            and deleted_lad != 1
            and status_id_lad = ".$statusId."
            and project_id_lad = ".$ci->db->escape($projectId)."
            and structure_code_bus in (".$escapedList.")
        ";

        $query = $ci->db->query($sql);
        $response = $query->result_array();
        return $response;   
    }

    public static function removeAllByLaborDetailId($laborDetailId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
        $sql = "
            update ".static::TABLE_NAME." set 
            deleted_lac = 1, 
            deleted_at = now(), 
            deleted_by = ".$currentUserId." 
            where labor_detail_id_lac = ".$ci->db->escape($laborDetailId)."
        ";
        $ci->db->query($sql);
    }

    public static function getByProjectStructureExecutionActivity($projectId, $structureId, $execution, $activity)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        SELECT
            structure_code_bus,
            description_bus,
            bui_labor_cost.*
        FROM
            bui_labor_details
        LEFT JOIN bui_labor_cost on labor_detail_id_lac = id_lad
        LEFT JOIN bui_building_structures on building_structure_id_lac = id_bus
        WHERE
            deleted_bus != 1
            and deleted_lac != 1
            and deleted_lad != 1
            and status_id_lad = 11
            and project_id_lad = ".$ci->db->escape($projectId)."
            and building_structure_id_lac = ".$ci->db->escape($structureId)."
            and execution_lac = ".$ci->db->escape($execution)."
            and activity_lac = ".$ci->db->escape($activity)."
        ";

        $query = $ci->db->query($sql);
        $response = $query->result_array();
        return $response;
    }
}
