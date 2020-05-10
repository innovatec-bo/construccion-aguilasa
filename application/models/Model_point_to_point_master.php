<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_point_to_point_master extends Model_point_to_point_master_base
{
    public function __construct($projectCode = "", $point = "", $latitude = "", $longitude = "", $reg = "", $previousPoint = "", $distanceAT = 0, $angleAT = 0, 
        $distanceMT = 0, $angleMT = 0, $distanceBT = 0, $angleBT = 0, $activity = "", $quantity = 0, $buildingStructureCode = "", $execution = "", $unitOfMeasurement = "",
        $buildingStructureDetail = "")
    {
        parent::__construct($projectCode, $point, $latitude, $longitude, $reg, $previousPoint, $distanceAT, $angleAT, 
        $distanceMT, $angleMT, $distanceBT, $angleBT, $activity, $quantity, $buildingStructureCode, $execution, $unitOfMeasurement,
        $buildingStructureDetail);
    }

    public static function exportBuildingPoints($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        INSERT into bui_building_points(project_id_bpo, label_bpo, latitude_bpo, longitude_bpo, previous_point_bpo)
        SELECT
        id_pro,
        point_ptp,
        latitude_ptp,
        longitude_ptp,
        previous_point_ptp
        FROM
        bui_point_to_point_master
        LEFT JOIN wfl_projects on code_pro = project_code_ptp and deleted_ptp != 1
        WHERE id_pro = ".$ci->db->escape($projectId)."
        GROUP BY point_ptp
        ";

        $ci->db->query($sql);
    }

    public static function exportStructuresToUse($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        INSERT into bui_structure_by_points(project_id_sbp, label_sbp, point_id_sbp, quantity_to_use_sbp, labor_cost_id_sbp)
        SELECT
            project_id_lad,
            point_ptp,
            NULL 'PointId',
            quantity_ptp,
            id_lac  
            From
            bui_point_to_point_master
            LEFT JOIN wfl_projects on code_pro = project_code_ptp and deleted_pro != 1
            LEFT JOIN bui_labor_details on project_id_lad = id_pro and deleted_lad != 1
            LEFT JOIN (
                SELECT
                    id_lac,
                    structure_code_bus,
                    activity_lac
                FROM
                    bui_labor_cost
                LEFT JOIN bui_building_structures on id_bus = building_structure_id_lac
                LEFT JOIN bui_labor_details on id_lad = labor_detail_id_lac  and deleted_lad !=1
                WHERE project_id_lad = ".$ci->db->escape($projectId)." and deleted_lac != 1 -- labor_detail_id_lac = 130
            ) labor_cost_filtered on labor_cost_filtered.activity_lac = activity_ptp and labor_cost_filtered.structure_code_bus = building_structure_code_ptp
            where project_id_lad = ".$ci->db->escape($projectId)." and deleted_ptp != 1
        ";

        $ci->db->query($sql);   
    }

    public static function linkStructuresToPoints($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        UPDATE bui_structure_by_points t1 
        LEFT JOIN bui_building_points t2 ON t1.label_sbp = t2.label_bpo and t1.project_id_sbp = t2.project_id_bpo
        SET t1.point_id_sbp = t2.id_bpo
        WHERE t1.project_id_sbp = ".$ci->db->escape($projectId)." and t1.deleted_sbp != 1 and t2.deleted_bpo != 1
        ";

        $ci->db->query($sql);   
    }
}
