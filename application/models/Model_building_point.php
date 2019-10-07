<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_building_point extends Model_building_point_base
{
    public function __construct($label = "", $latitude = "", $longitude = "", $previousPoint = "", $distance = "", $angle = "")
    {
        parent::__construct($label, $latitude, $longitude, $previousPoint, $distance, $angle);
    }

    /**
     * This method allows to insert new structures to use in a specific point
     * @param array $structures
     */
    public function addStructuresToUse($structures = array())
    {
        $dataToSave = array();
        foreach ($structures as $structure)
        {
            $dataToSave[] = array(
                    "point_id_sbp" => $this->_id,
                    "quantity_to_use_sbp" => $structure["quantity_to_use"],
                    "labor_cost_id_sbp" => $structure["labor_cost_id"]
            );
        }
        if(count($dataToSave) > 0)
            Model_structure_by_point::insertBatch($dataToSave);
    }

    public static function geMasterDetail()
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        SELECT
            id_bpo point_id,
            label_bpo point_label,
            activity_lac,
            quantity_to_use_sbp,		
            structure_code_bus,
            execution_lac,
            unit_of_measurement_bus,
            description_bus	
        FROM
            bui_building_points
        LEFT JOIN bui_structure_by_points on id_bpo = point_id_sbp
        LEFT JOIN bui_labor_cost on id_lac = labor_cost_id_sbp
        LEFT JOIN bui_building_structures on id_bus = building_structure_id_lac
        ";

        $query = $ci->db->query($sql);
        $result = $query->result_array();

        $arrayPoints = array();
        foreach ($result as $row)
        {
            $pointId = $row["point_id"];
            $arrayPoints[$pointId] = array(
                "point_id" => $pointId,
                "point_label" => $row["point_label"]
            );
        }
    }
}