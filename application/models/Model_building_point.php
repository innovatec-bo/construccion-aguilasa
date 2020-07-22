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
		$currentUser = PrivateController::getSessionUser();
		$currentUserId = isset($currentUser) ? $currentUser->id:NULL;
        foreach ($structures as $structure)
        {
            $dataToSave[] = array(
            		"project_id_sbp" => $this->_projectId,
            		"label_sbp" => $this->_label,
                    "point_id_sbp" => $this->_id,
                    "quantity_to_use_sbp" => $structure["quantity"],
                    "labor_cost_id_sbp" => $structure["labor-cost-id"],
					'is_additional_sbp' => 1,
					'deleted_sbp' => 0,
					'createdon_sbp' => date('Y-m-d H:i:s'),
					'createdby_sbp' => $currentUserId
            );
        }
        if(count($dataToSave) > 0)
            Model_structure_by_point::insertBatch($dataToSave);
    }

    public static function getMasterDetail($projectId, $pointIdToFilter = NULL)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        SELECT
            id_bpo point_id,
            id_sbp,
            label_bpo point_label,
            latitude_bpo point_latitude,
            longitude_bpo point_longitude,
            activity_lac labor_activity,
            unit_price_lac unit_price,
            quantity_to_use_sbp quantity_to_use,
            structure_code_bus structure_code,
            execution_lac execution,
            unit_of_measurement_bus unit_of_measurement,
            description_bus description,
            id_lac labor_cost_id,
            id_lal,
            SUM(IFNULL(worked_up_wus,0)) total_worked_up
        FROM
            bui_building_points
        LEFT JOIN bui_structure_by_points on id_bpo = point_id_sbp AND deleted_sbp != 1
        LEFT JOIN bui_labor_cost on id_lac = labor_cost_id_sbp and deleted_lac != 1
        LEFT JOIN bui_building_structures on id_bus = building_structure_id_lac
        LEFT JOIN bui_labor_details on labor_detail_id_lac = id_lad and deleted_lad != 1           
        LEFT JOIN bui_labor_cost_log on point_id_lal = point_id_sbp
        LEFT JOIN bui_worked_up_structures on labor_cost_id_wus = labor_cost_id_sbp and id_lal = labor_cost_log_id_wus and deleted_wus !=1                        
        WHERE project_id_bpo = ".$ci->db->escape($projectId)." and deleted_bpo != 1
        GROUP BY id_bpo, id_sbp 
        ";

        $query = $ci->db->query($sql);
        $result = $query->result_array();

        $arrayPoints = array();
        $arrayStructures = array();
        $i = 1;
        foreach ($result as $row)
        {

            $pointId = $row["point_id"];
            if(!is_null($pointIdToFilter) && $pointIdToFilter != $pointId)
                continue;
            if(!isset($arrayPoints[$pointId]))
            {
                $i = 1;
                $arrayPoints[$pointId] = array(
                    "point_id" => $pointId,
                    "point_label" => $row["point_label"],
                    "point_latitude" => $row["point_latitude"],
                    "point_longitude" => $row["point_longitude"]
                );
            }
            if(!isset($arrayPoints[$pointId]["structures"]))
			{
				$arrayPoints[$pointId]["structures"] = array();
			}
			if(!is_null($row['id_sbp']))
			{
				$arrayPoints[$pointId]["structures"][] = array(
					"index" => $i,
					"labor_activity" => $row["labor_activity"],
					"quantity_to_use" => $row["quantity_to_use"],
					"unit_price" => $row["unit_price"],
					"structure_code" => $row["structure_code"],
					"execution" => $row["execution"],
					"unit_of_measurement" => $row["unit_of_measurement"],
					"description" => $row["description"],
					"labor_cost_id" => $row["labor_cost_id"],
					"total_worked_up" => $row["total_worked_up"]
				);
			}
            $i++;
        }

        return $arrayPoints;
    }
}
