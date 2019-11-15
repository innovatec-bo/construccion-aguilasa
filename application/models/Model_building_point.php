<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_building_point extends Model_building_point_base
{
    public function __construct($projectId = NULL, $label = "", $latitude = "", $longitude = "", $previousPoint = "", $distance = "", $angle = "")
    {
        parent::__construct($projectId, $label, $latitude, $longitude, $previousPoint, $distance, $angle);
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

    public static function getMasterDetail($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        SELECT
            id_bpo point_id,
            label_bpo point_label,
            activity_lac labor_activity,
            quantity_to_use_sbp quantity_to_use,
            structure_code_bus structure_code,
            execution_lac execution,
            unit_of_measurement_bus unit_of_measurement,
            description_bus description	
        FROM
            bui_building_points
        LEFT JOIN bui_structure_by_points on id_bpo = point_id_sbp
        LEFT JOIN bui_labor_cost on id_lac = labor_cost_id_sbp
        LEFT JOIN bui_building_structures on id_bus = building_structure_id_lac
        LEFT JOIN bui_labor_details on labor_detail_id_lac = id_lad
        WHERE project_id_lad = ".$ci->db->escape($projectId)."
        ";

        $query = $ci->db->query($sql);
        $result = $query->result_array();

        $arrayPoints = array();
        $arrayStructures = array();
        foreach ($result as $row)
        {
            $pointId = $row["point_id"];
            if(!isset($arrayPoints[$pointId]))
            {
                $arrayPoints[$pointId] = array(
                    "point_id" => $pointId,
                    "point_label" => $row["point_label"]
                );
            }

            $arrayPoints[$pointId]["structures"][] = array(
                                                        "labor_activity" => $row["labor_activity"],
                                                        "quantity_to_use" => $row["quantity_to_use"],
                                                        "structure_code" => $row["structure_code"],
                                                        "execution" => $row["execution"],
                                                        "unit_of_measurement" => $row["unit_of_measurement"],
                                                        "description" => $row["description"]
                                                    );
        }

        return $arrayPoints;
    }
}