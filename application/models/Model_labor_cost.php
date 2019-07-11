<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:04 PM
*/

class Model_labor_cost extends Model_labor_cost_base
{
    public function __construct($laborDetailId = NULL, $buildingStructureId = NULL, $activity = "", $execution = "", $quantity = "", $unitPrice = 0)
    {
        parent::__construct($laborDetailId, $buildingStructureId, $activity, $execution, $quantity, $unitPrice);
    }

    public static function getMasterDetailByProjectId($projectId)
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
            round(unit_price_lac * quantity_lac,2) total_price_by_structure
        FROM
            bui_labor_cost
        LEFT JOIN bui_building_structures on building_structure_id_lac = id_bus
        LEFT JOIN bui_labor_details on labor_detail_id_lac = id_lad
        where
        project_id_lad = ".$ci->db->escape($projectId)."
        and deleted_lac != 1
        and deleted_bus != 1
        and deleted_lad != 1
        ";

        $query = $ci->db->query($sql);
        $response = $query->result_array();
        return $response;
    }
}