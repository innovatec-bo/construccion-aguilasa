<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:04 PM
*/

class Model_labor_cost_log extends Model_labor_cost_log_base
{
    public function __construct($userId = NULL, $detail = "", $manualEntryDate = "", $pointId = NULL)
    {
        parent::__construct($userId, $detail, $manualEntryDate, $pointId);
    }

    public static function addLog($userId, $detail, $manualEntryDate, $workedUp, $builders, $pointId = NULL)
    {
        $laborCostLog = New Model_labor_cost_log($userId, $detail, $manualEntryDate, $pointId);
        $laborCostLog->save();
        $laborCostLog->addWorkedUpStructures($workedUp);
        $laborCostLog->addBuildersToManpower($builders);
    }

    public function addWorkedUpStructures($list = array())
    {
        $ci = &get_instance();
        $ci->load->database();
        $dataToSave = array();
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
        foreach($list as $row)
        {
            $quantity = str_replace(",","",$row['quantity']);
            $price = str_replace(",","",$row['unit-price']);
            if($quantity > 0 && $price >= 0)
            {
                $dataToSave[] = array(
                    'labor_cost_log_id_wus' => $this->_id,
                    'labor_cost_id_wus' => $row['labor-cost-id'],
                    'worked_up_wus' => $quantity,
                    'price_wus' => $price,
                    'deleted_wus' => 0,
                    'createdon_wus' => date('Y-m-d H:i:s'),
                    'createdby_wus' => $currentUserId
                );
            }
            
        }
        //Delete existing structures after add the new structures
        Model_labor_cost_log::deleteWorkedUpStructuresByLaborCostLogId($this->_id);
        if(count($dataToSave) > 0)
        {
            Model_worked_up_structure::insertBatch($dataToSave);
        }
    }

    public function addBuildersToManpower($list = array())
    {
        $ci = &get_instance();
        $ci->load->database();
        $dataToSave = array();
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
        foreach($list as $id)
        {
            $dataToSave[] = array(
                'labor_cost_log_id_bim' => $this->_id,
                'user_id_bim' => $id,
                'deleted_bim' => 0,
                'createdon_bim' => date('Y-m-d H:i:s'),
                'createdby_bim' => $currentUserId
            );
        }
        //Delete existing builders after add new builders
        Model_labor_cost_log::deleteBuildersFromManpowerByLaborCostLogId($this->_id);
        if(count($dataToSave) > 0)
        {
            Model_builder_in_manpower::insertBatch($dataToSave);
        }
    }

    public static function deleteBuildersFromManpowerByLaborCostLogId($laborCostLogId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
        $sql = "
        update bui_builders_in_manpower set 
        deleted_bim = 1,
        editedon_bim = ".$ci->db->escape(date('Y-m-d H:i:s')).",
        editedby_bim = ".$currentUserId."
        where labor_cost_log_id_bim = ".$ci->db->escape($laborCostLogId)."
        ";

        $ci->db->query($sql);
    }

    public static function deleteWorkedUpStructuresByLaborCostLogId($laborCostLogId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
        $sql = "
        update bui_worked_up_structures set 
        deleted_wus = 1,
        editedon_wus = ".$ci->db->escape(date('Y-m-d H:i:s')).",
        editedby_wus = ".$currentUserId."
        where labor_cost_log_id_wus = ".$ci->db->escape($laborCostLogId)."
        ";

        $ci->db->query($sql);
    }

    public static function getLogByProjectId($projectId = NULL, $builderId = NULL, $startDate = NULL, $endDate = NULL)
    {
        $ci = &get_instance();
        $ci->load->database();

		$projectFilter = "";
		if(!is_null($projectId))
		{
			$projectFilter = " and project_id_lad = ".$ci->db->escape($projectId)." ";
		}

        $builderFilter = "";
        if(!is_null($builderId))
		{
			$builderFilter = "  and builders.id_usr = ".$ci->db->escape($builderId)." ";
		}

        $dateFilter = "";
        if(!is_null($startDate) && !is_null($endDate))
		{
			$dateFilter = " and manual_entry_date_lal BETWEEN ".$ci->db->escape($startDate)." and ".$ci->db->escape($endDate)." ";
		}
        $sql = "
        SELECT
            id_lal log_id,
            project_id_lad project_id,
            user_id_lal fiscal_id,
            fiscals.firstname_usr fiscal_first_name,
            fiscals.lastname_usr fiscal_last_name,
            CONCAT(fiscals.firstname_usr,' ',fiscals.lastname_usr) fiscal_full_name,
            detail_lal detail,
            manual_entry_date_lal manual_entry_date,
            GROUP_CONCAT(DISTINCT CONCAT(builders.firstname_usr,' ',builders.lastname_usr) SEPARATOR ', ') builders,
            GROUP_CONCAT(DISTINCT CONCAT(builders.id_usr,'-',builders.firstname_usr,' ',builders.lastname_usr) SEPARATOR ', ') builder_with_id,
            activity_lac activity,
            execution_lac execution,
            structure_code_bus structure_code,
            description_bus description,
            worked_up_wus worked_up,
            unit_price_lac unit_price,
               round(worked_up_wus*unit_price_lac,2) worked_up_bs,
            unit_of_measurement_bus unit_of_measurement,
            id_bpo point_id,
            label_bpo point_label,
            IF(id_bld is null, 1 , 0) allow_edit_log
        FROM
            bui_labor_cost_log
        LEFT JOIN bui_builders_in_manpower on id_lal = labor_cost_log_id_bim
        LEFT JOIN sec_users builders on builders.id_usr = user_id_bim
        LEFT JOIN sec_users fiscals on fiscals.id_usr = user_id_lal
        LEFT JOIN bui_worked_up_structures on id_lal = labor_cost_log_id_wus
        LEFT JOIN (
            select 
                id_lac,
                bui_labor_cost.labor_detail_id_lac,
                bui_labor_cost.execution_lac,		
                bui_labor_cost.activity_lac,
                bui_labor_cost.unit_price_lac,   
                bui_building_structures.structure_code_bus, 
                bui_building_structures.unit_of_measurement_bus,
                bui_building_structures.description_bus
            from bui_labor_cost 
            LEFT JOIN bui_building_structures on bui_labor_cost.building_structure_id_lac = id_bus
            where deleted_lac !=1 and deleted_bus != 1
        ) bui_labor_cost on id_lac = labor_cost_id_wus
        LEFT JOIN bui_labor_details on labor_detail_id_lac = id_lad
        LEFT JOIN bui_building_points on id_bpo = point_id_lal
        left join (
        	SELECT
				* 
			FROM
				bui_blocked_log_date_ranges
			WHERE deleted_bld != 1
			GROUP BY from_bld, to_bld 
        ) bui_blocked_log_date_ranges on manual_entry_date_lal between from_bld and to_bld 
        where deleted_lal != 1 and status_id_lad = 11 and (deleted_bim != 1 or deleted_bim is null) and deleted_wus != 1 ".$projectFilter."  ".$builderFilter." ".$dateFilter."
        GROUP BY id_lal, id_lac
        ORDER BY manual_entry_date_lal desc
        ";

        $query = $ci->db->query($sql);
        $response = $query->result_array();
        return $response;
    }

    public static function prepareArrayLog($projectId = NULL, $builderId = NULL)
    {
        $laborCostLog = Model_labor_cost_log::getLogByProjectId($projectId, $builderId);
        $singleList = array();//dd(array_column($laborCostLog,'worked_up_bs'));
        $arrayLog = array();
        for ($i = 0; $i < count($laborCostLog); $i++)
        {
            $logId = $laborCostLog[$i]["log_id"];
            $singleList[] = $laborCostLog[$i];

            if(isset($laborCostLog[$i+1]))
            {
                if($laborCostLog[$i]["log_id"] != $laborCostLog[$i+1]["log_id"])
                {
                    $arrayLog[$logId]['pointId'] = $laborCostLog[$i]["point_id"];
                    $arrayLog[$logId]['pointLabel'] = $laborCostLog[$i]["point_label"];
                    $arrayLog[$logId]['logId'] = $laborCostLog[$i]["log_id"];
                    $arrayLog[$logId]['fiscal'] = $laborCostLog[$i]["fiscal_full_name"];
                    $arrayLog[$logId]['detail'] = $laborCostLog[$i]["detail"];
                    $arrayLog[$logId]['manualEntryDate'] = $laborCostLog[$i]["manual_entry_date"];
                    $arrayLog[$logId]['builders'] = $laborCostLog[$i]["builders"];
                    $arrayLog[$logId]['builderWithId'] = $laborCostLog[$i]["builder_with_id"];
					$arrayLog[$logId]['allowEditLog'] = $laborCostLog[$i]["allow_edit_log"];
                    $arrayLog[$logId]['itemList'] = $singleList;
                    $singleList = array();
                }
            }
            else
            {
                $arrayLog[$logId]['pointId'] = $laborCostLog[$i]["point_id"];
                $arrayLog[$logId]['pointLabel'] = $laborCostLog[$i]["point_label"];
                $arrayLog[$logId]['logId'] = $laborCostLog[$i]["log_id"];
                $arrayLog[$logId]['fiscal'] = $laborCostLog[$i]["fiscal_full_name"];
                $arrayLog[$logId]['detail'] = $laborCostLog[$i]["detail"];
                $arrayLog[$logId]['manualEntryDate'] = $laborCostLog[$i]["manual_entry_date"];
                $arrayLog[$logId]['builders'] = $laborCostLog[$i]["builders"];
                $arrayLog[$logId]['builderWithId'] = $laborCostLog[$i]["builder_with_id"];
				$arrayLog[$logId]['allowEditLog'] = $laborCostLog[$i]["allow_edit_log"];
                $arrayLog[$logId]['itemList'] = $singleList;
            }
        }
        return $arrayLog;
    }

    public static function deleteLogsByIdsArray($idsArray = array())
    {
        $ci = &get_instance();
        $ci->load->database();
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
        $escapedIds = "";
        foreach ($idsArray as $id) 
        {
            $escapedIds .= $ci->db->escape($id).", ";
        }
        $escapedIds = substr($escapedIds, 0, -2);
        
        //Deleting logs
        $sql = "
        update bui_labor_cost_log set 
        deleted_lal = 1,
        deleted_at = now(), 
        deleted_by = ".$currentUserId."  
        where id_lal in (".$escapedIds.")
        ";
        $ci->db->query($sql);

        //Deleting worked up structures
        $sql = "
        update bui_worked_up_structures set 
        deleted_wus = 1,
        deleted_at = now(), 
        deleted_by = ".$currentUserId."  
        where labor_cost_id_wus in (".$escapedIds.")
        ";
        $ci->db->query($sql);

        //Deleting builders in manpower
        $sql = "
        update bui_builders_in_manpower set 
        deleted_bim = 1,
        deleted_at = now(), 
        deleted_by = ".$currentUserId."  
        where labor_cost_id_bim in (".$escapedIds.")
        ";
        $ci->db->query($sql);
    }

    /*
    This method is only for point to point progress
    */
    public static function addMassiveLog($userId, $detail, $manualEntryDate, $builders, $pointsId, $projectId)
    {
        $buildingPoints = Model_building_point::getMasterDetail($projectId);
        $workedUp = array();
        $pointCounter = 0;
        $logMessage = "";
        foreach ($pointsId as $pointId) 
        {
            $pointToFinish = $buildingPoints[$pointId];
            $pointLabel = $pointToFinish['point_label'];
            foreach ($pointToFinish['structures'] as $structure)
            {
                $quantity = floatval($structure['quantity_to_use']) - floatval($structure['total_worked_up']);
                if($quantity > 0)
                {
                    $workedUp[] = array(
                                'quantity' => $quantity,
                                'unit-price' => $structure['unit_price'],
                                'labor-cost-id' => $structure['labor_cost_id']
                            );
                }
            }

            if(count($workedUp) > 0)
            {
                $laborCostLog = New Model_labor_cost_log($userId, $detail, $manualEntryDate, $pointId);
                $laborCostLog->save();
                if(is_numeric($laborCostLog->getId()))
                {
                    $laborCostLog->addWorkedUpStructures($workedUp);
                    $laborCostLog->addBuildersToManpower($builders);
                    $pointCounter++;    
                }
                else
                {
                    $logMessage .= "No se pudo guardar el registro del <strong>Punto ".$pointLabel.".</strong><br>";
                }
            }
            else
            {
                $logMessage .= "Nada pendiente en el <strong>Punto ".$pointLabel.".</strong><br>";
            }
            
            $workedUp = array();
        }
        switch ($pointCounter) 
        {
            case 0:
                $response['success'] = 0;
                $response['message'] = $logMessage;
                break;
            case 1:
                $response['success'] = 1;
                $response['message'] = "Se finaliz&oacute; un punto.";
                break;
            default:
                $response['success'] = 1;
                $response['message'] = "Se finalizaron ".$pointCounter." puntos.";
                break;
        }
        return $response;
    }

    public static function getMasterDetailById($logId = NULL)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        SELECT
            id_lal log_id,
            project_id_lad project_id,
            user_id_lal fiscal_id,
            fiscals.firstname_usr fiscal_first_name,
            fiscals.lastname_usr fiscal_last_name,
            CONCAT(fiscals.firstname_usr,' ',fiscals.lastname_usr) fiscal_full_name,
            detail_lal detail,
            manual_entry_date_lal manual_entry_date,
            GROUP_CONCAT(DISTINCT CONCAT(builders.firstname_usr,' ',builders.lastname_usr) SEPARATOR ', ') builders,
            GROUP_CONCAT(DISTINCT CONCAT(builders.id_usr,'-',builders.firstname_usr,' ',builders.lastname_usr) SEPARATOR ', ') builder_with_id,
            id_lac labor_cost_id,
            activity_lac activity,
            execution_lac execution,
            quantity_lac quantity,
            structure_code_bus structure_code,
            description_bus description,
            wus.worked_up_wus worked_up,
            wus.price_wus worked_up_price,
            unit_of_measurement_bus unit_of_measurement,
            id_bpo point_id,
            label_bpo point_label,
            IFNULL(bui_worked_up_structures.worked_up_wus,0) total_worked_up,
            IFNULL(bui_worked_up_structures_by_point.worked_up_wus,0) total_worked_up_by_point,
            quantity_to_use_sbp quantity_to_use_in_point 
        FROM
            bui_labor_cost_log
        LEFT JOIN bui_builders_in_manpower on id_lal = labor_cost_log_id_bim
        LEFT JOIN sec_users builders on builders.id_usr = user_id_bim
        LEFT JOIN sec_users fiscals on fiscals.id_usr = user_id_lal
        LEFT JOIN bui_worked_up_structures wus on id_lal = wus.labor_cost_log_id_wus
        LEFT JOIN (
            select 
                id_lac,
                bui_labor_cost.labor_detail_id_lac,
                bui_labor_cost.execution_lac,       
                bui_labor_cost.activity_lac,
                bui_labor_cost.quantity_lac,
                bui_building_structures.structure_code_bus, 
                bui_building_structures.unit_of_measurement_bus,
                bui_building_structures.description_bus
            from bui_labor_cost 
            LEFT JOIN bui_building_structures on bui_labor_cost.building_structure_id_lac = id_bus
            where deleted_lac !=1 and deleted_bus != 1
        ) bui_labor_cost on id_lac = wus.labor_cost_id_wus
        LEFT JOIN bui_labor_details on labor_detail_id_lac = id_lad
        LEFT JOIN bui_building_points on id_bpo = point_id_lal
        LEFT JOIN bui_structure_by_points on point_id_sbp = point_id_lal 
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
				GROUP BY labor_cost_id_wus
		) bui_worked_up_structures on id_lac = bui_worked_up_structures.labor_cost_id_wus
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
				GROUP BY labor_cost_id_wus, point_id_lal
		) bui_worked_up_structures_by_point on id_lac = bui_worked_up_structures_by_point.labor_cost_id_wus
        where deleted_lal != 1 and status_id_lad = 11 and (deleted_bim != 1 or deleted_bim is null) and wus.deleted_wus != 1 and id_lal = ".$ci->db->escape($logId)."
        GROUP BY id_lal, id_lac
        ORDER BY manual_entry_date_lal desc
        ";

        $query = $ci->db->query($sql);
        $response = $query->result_array();
        return $response;
    }

    public static function prepareArrayLogMasterDetal($logId = NULL)
    {
        $laborCostLog = Model_labor_cost_log::getMasterDetailById($logId);
        $singleList = [];
        $arrayLog = [];
        $index = 1;
        for ($i = 0; $i < count($laborCostLog); $i++)
        {
            $logId = $laborCostLog[$i]["log_id"];
            $laborCostLog[$i]['index'] = $index;
            $index++;
            $singleList[] = $laborCostLog[$i];
            if(isset($laborCostLog[$i+1]))
            {
                if($laborCostLog[$i]["log_id"] != $laborCostLog[$i+1]["log_id"])
                {
                    $arrayLog[$logId]['projectId'] = $laborCostLog[$i]['project_id'];
                    $arrayLog[$logId]['pointId'] = $laborCostLog[$i]["point_id"];
                    $arrayLog[$logId]['pointLabel'] = $laborCostLog[$i]["point_label"];
                    $arrayLog[$logId]['logId'] = $laborCostLog[$i]["log_id"];
                    $arrayLog[$logId]['fiscalId'] = $laborCostLog[$i]['fiscal_id'];
                    $arrayLog[$logId]['fiscal'] = $laborCostLog[$i]["fiscal_full_name"];
                    $arrayLog[$logId]['detail'] = $laborCostLog[$i]["detail"];
                    $arrayLog[$logId]['manualEntryDate'] = $laborCostLog[$i]["manual_entry_date"];
                    $arrayLog[$logId]['builders'] = $laborCostLog[$i]["builders"];
                    $arrayLog[$logId]['builderWithId'] = $laborCostLog[$i]["builder_with_id"];
                    $arrayLog[$logId]['itemList'] = $singleList;
                    $singleList = [];
                    $index = 0;
                }
            }
            else
            {
                $arrayLog[$logId]['projectId'] = $laborCostLog[$i]['project_id'];
                $arrayLog[$logId]['pointId'] = $laborCostLog[$i]["point_id"];
                $arrayLog[$logId]['pointLabel'] = $laborCostLog[$i]["point_label"];
                $arrayLog[$logId]['logId'] = $laborCostLog[$i]["log_id"];
                $arrayLog[$logId]['fiscalId'] = $laborCostLog[$i]['fiscal_id'];
                $arrayLog[$logId]['fiscal'] = $laborCostLog[$i]["fiscal_full_name"];
                $arrayLog[$logId]['detail'] = $laborCostLog[$i]["detail"];
                $arrayLog[$logId]['manualEntryDate'] = $laborCostLog[$i]["manual_entry_date"];
                $arrayLog[$logId]['builders'] = $laborCostLog[$i]["builders"];
                $arrayLog[$logId]['builderWithId'] = $laborCostLog[$i]["builder_with_id"];
                $arrayLog[$logId]['itemList'] = $singleList;
            }
        }

        return $arrayLog[$logId];
    }

    public static function updatePrices($projectId = null)
    {
        $ci = &get_instance();
        $ci->load->database();
        $projectFilter1 = "";
        $projectFilter2 = "";
        if(!is_null($projectId))
        {
            $projectFilter1 = " and id_pro = {$projectId} ";
            $projectFilter2 = " and wfl_projects.id_pro = {$projectId} ";
        }
        $dataToUpdate = "
        SELECT
            wfl_projects.id_pro,
            wfl_projects.code_pro,
            id_wus,
            bui_labor_cost.building_structure_id_lac,
            price_wus 'current_price',
            conciliation.unit_price_lac 'new_price'
            -- bui_worked_up_structures.*
        FROM
            bui_worked_up_structures
        LEFT JOIN bui_labor_cost ON bui_labor_cost.id_lac = bui_worked_up_structures.labor_cost_id_wus
        left join bui_labor_details on bui_labor_details.id_lad = bui_labor_cost.labor_detail_id_lac
        left join wfl_projects on id_pro = bui_labor_details.project_id_lad
        left join (
            SELECT
                id_pro,
                code_pro,
                bui_labor_cost.building_structure_id_lac,
                bui_labor_cost.unit_price_lac
            FROM
                bui_labor_details
            left join bui_labor_cost on bui_labor_details.id_lad = bui_labor_cost.labor_detail_id_lac
            left join wfl_projects on id_pro = bui_labor_details.project_id_lad
            where 
            1=1
            -- and code_pro = 'ra.23.0885'
            {$projectFilter1}
            and bui_labor_details.deleted_lad != 1
            and bui_labor_cost.deleted_lac != 1
            and wfl_projects.deleted_pro != 1
            and bui_labor_details.status_id_lad = 34
            order by building_structure_id_lac
        ) conciliation on conciliation.id_pro = wfl_projects.id_pro and conciliation.building_structure_id_lac = bui_labor_cost.building_structure_id_lac
        where 
            1=1
            -- and wfl_projects.code_pro = 'ra.23.0885'
            {$projectFilter2}
            and bui_labor_cost.deleted_lac != 1
            and bui_labor_details.deleted_lad != 1
            and bui_worked_up_structures.deleted_wus != 1
            and wfl_projects.deleted_pro != 1
            and conciliation.unit_price_lac is not null
            and conciliation.unit_price_lac != price_wus
        order by wfl_projects.id_pro, building_structure_id_lac;
        ";

        $query = $ci->db->query($dataToUpdate);
        $response = $query->result_array();
        $sql = "";
        $idsToUpdate = '';
        foreach ($response as $value) 
        {
            $idsToUpdate .= "{$value['id_wus']},";
            $sql .= " WHEN {$value['id_wus']} THEN {$value['new_price']}\n";
        }
        $idsToUpdate = substr($idsToUpdate,0,-1);
        if ($idsToUpdate != "") 
        {
            $updatePrices = "
            UPDATE bui_worked_up_structures
                SET price_wus = (CASE id_wus 
                                -- WHEN 1 THEN 'val1'
                                -- WHEN 2 THEN 'val2'
                                -- WHEN 3 THEN 'val3'
                                {$sql}
                        END)
                WHERE id_wus IN({$idsToUpdate});
            ";
            
            $ci->db->query($updatePrices);
        }

        if ($projectId) 
        {
            $project = Model_project::getById($projectId);
            $currentContract = Model_contract::getActiveContract();
            if($currentContract instanceof Model_contract)
            {
                $project->setEndContract($currentContract->getId());
                $project->save();
            }
        }
    }
}   
