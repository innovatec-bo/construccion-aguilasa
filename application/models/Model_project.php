<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_project extends Model_project_base
{
    public function __construct($projectCode = "", $projectName = "", $system = NULL, $address = "", $entryDate = "", $creFiscal = "", $status = NULL, $projectStart = "", $projectEnd = "", $points = 0, $distance = 0, $managementBy = NULL, $qualityLevel = 0, $creDesignCompletionDate = "", $creBuildingCompletionDate = "", $budgetaryPosition = 0, $secondaryCode = "", $folderDate = "", $contractId = NULL, $detail = "", $energized = 0, $projectPercentage = 0, $latitude = "",
        $longitude = "", $workArea = "", $projectYear = "")
    {
        parent::__construct($projectCode, $projectName, $system, $address, $entryDate, $creFiscal, $status, $projectStart, $projectEnd, $points, $distance, $managementBy, $qualityLevel, $creDesignCompletionDate, $creBuildingCompletionDate, $budgetaryPosition, $secondaryCode, $folderDate, $contractId, $detail, $energized, $projectPercentage, $latitude, $longitude, $workArea, $projectYear);
    }

    public function savePoints($points, $metersDistance, $statusId, $statusDetail, $manualEntryDate, $responsibleList = array(), $fileIds = array())
    {
        //Lets create a new log
        $projectStatus = new Model_project_status_log($this->_id, $statusId, $statusDetail, $manualEntryDate);
        $projectStatus->save();


        //Create the record about the points and distance and associate it to project status log
        $projectPoints = new Model_project_points($projectStatus->getId(), $points, $metersDistance);
        $projectPoints->save();

        //Each statusLog needs to have a o more responsible by log
        Model_status_log_responsible::addResponsible($projectStatus->getId(), $responsibleList);

        //If there is file ids added to status log, then let's save these        
        Model_project_status_file::addFiles($projectStatus->getId(), $fileIds, $this->_id, $statusId);
    }

	/**
	 * @param $design
	 * @param $building
	 * @param $graphNumber
	 * @param $reservationNumber
	 * @param $transportation
	 * @param $liveLine
	 * @param $rightOfWay
	 * @param $tentativeTotalBudget
	 * @param $statusId
	 * @param $statusDetail
	 * @param $manualEntryDate
	 * @param array $responsibleList
	 * @param null $manpowerFileId
	 * @param null $buildingStructureFileId
	 */
    public function saveBudget($design, $building, $graphNumber, $reservationNumber, $transportation, $liveLine, $rightOfWay, $tentativeTotalBudget, $statusId, $statusDetail, $manualEntryDate, $responsibleList = array(), $manpowerFileId = NULL, $buildingStructureFileId = NULL)
    {
        //Lets create a new log
        $projectStatus = new Model_project_status_log($this->_id, $statusId, $statusDetail, $manualEntryDate);
        $projectStatus->save();

        //Create the record about the design and building and associate it to project status log
        $projectBudget = new Model_project_budget($projectStatus->getId(), $design, $building, $graphNumber, $reservationNumber, $transportation, $liveLine, $rightOfWay, $tentativeTotalBudget,$manpowerFileId, $buildingStructureFileId);
        $projectBudget->save();

        //Each statusLog needs to have a o more responsible by log
        Model_status_log_responsible::addResponsible($projectStatus->getId(), $responsibleList);
    }

    public function saveRealBudget($design, $building, $transportation, $liveLine, $rightOfWay, $statusId, $statusDetail, $manualEntryDate, $responsibleList = array(), $fileIds = array())
    {
        //Lets create a new log
        $projectStatus = new Model_project_status_log($this->_id, $statusId, $statusDetail, $manualEntryDate);
        $projectStatus->save();

        //Create the record about the design and building and associate it to project status log
        $projectRealBudget = new Model_project_real_budget($projectStatus->getId(), $design, $building, $transportation, $liveLine, $rightOfWay);
        $projectRealBudget->save();

        //Each statusLog needs to have a o more responsible by log
        Model_status_log_responsible::addResponsible($projectStatus->getId(), $responsibleList);

        //If there is file ids added to status log, then let's save these        
        Model_project_status_file::addFiles($projectStatus->getId(), $fileIds, $this->_id, $statusId);
    }

    public function saveConstructionAssignments($startDate, $endDate, $estimatedTime, $liveLine, $powerDown, $maneuver, $statusId, $statusDetail, $manualEntryDate, $responsibleList = array(), $projectManager = NULL)
    {
        //Lets create a new log
        $projectStatus = new Model_project_status_log($this->_id, $statusId, $statusDetail, $manualEntryDate);
        $projectStatus->save();

        //Create the record about the design and building and associate it to project status log
        $constructionAssignment = new Model_construction_assignment($projectStatus->getId(), $startDate, $endDate, $estimatedTime, $liveLine, $powerDown, $maneuver, $projectManager);
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
    public function addStatusToLog($statusId, $detail = "", $manualEntryDate = "", $responsibleList = array(), $fileIds = array())
    {
        $getLastProjectStatus = Model_project_status_log::getLastProjectStatusLogByProjectId($this->_id);
        $currentResponsibleList = Model_status_log_responsible::getByStatusLogId($statusId);
        $responsibleDifference = array_diff($responsibleList,array_column($currentResponsibleList,"id_sre"));
        if(!$getLastProjectStatus instanceof Model_project_status_log || $getLastProjectStatus->getProjectStatus() != $this->_status || $getLastProjectStatus->getDetail() != $detail || count($responsibleDifference) > 0)
        {
            //Lets create a new log
            $projectStatus = new Model_project_status_log($this->_id, $statusId, $detail, $manualEntryDate);
            $projectStatus->save();
            $this->setStatus($statusId);
            $this->save();
            //Each statusLog needs to have a o more responsible by log
            Model_status_log_responsible::addResponsible($projectStatus->getId(), $responsibleList);
            //If there is file ids added to status log, then let's save these
            Model_project_status_file::addFiles($projectStatus->getId(), $fileIds, $this->_id, $statusId);
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

    public static function getByCodeList($codeList)
    {
        $ci = &get_instance();
        $ci->load->database();

        $escapedList = "";
        foreach ($codeList as $code) 
        {
            $escapedList .= $ci->db->escape($code).", ";
        }
        $escapedList = substr($escapedList, 0, -2);
        $sql = "
            select * from ".static::TABLE_NAME." where ".static::notDeleted()." and code_pro in(".$escapedList.")
        ";

        $query = $ci->db->query($sql);
        $result = static::recastArray(get_called_class(), $query->result());
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


    function approveThisProject($entryDate = "", $statusDetail = "", $design = 0, $building = 0, $graphNumber = 0, $reservationNumber = 0, $transportation = 0, $liveLine = 0,$rightOfWay = 0, $secondaryCode = "", $manpowerFileId = NULL, $buildingStructureFileId = NULL)
    {
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $seconds = 2;
        $entryDate = date("Y-m-d H:i:s", (strtotime(date($entryDate)) + $seconds));
        $statusId = 11;
        $design = str_replace(",","",$design);
        $building = str_replace(",","",$building);
        $transportation = str_replace(",","",$transportation);
        $liveLine = str_replace(",","",$liveLine);
        $rightOfWay = str_replace(",","",$rightOfWay);
        $responsibleList = Model_status_responsible::getUsersResponsible("approved");
        $responsibleList = $responsibleList[0];//array_column($responsibleList,'id_sre');
        $responsibleList = array($responsibleList['id_sre']);

//        $responsibleList = Model_status_responsible::getUsersResponsible("approved");
//        $responsibleList = array_column($responsibleList,"id_sre");

        $this->setStatus($statusId);
        $this->_secondaryCode = $secondaryCode;
        $this->save();
        $this->saveBudget($design, $building, $graphNumber, $reservationNumber, $transportation, $liveLine, $rightOfWay, 0,$statusId, $statusDetail, $entryDate, $responsibleList, $manpowerFileId, $buildingStructureFileId);
        $wareHouse = Model_warehouse::getByProjectId($this->_id);
        if(!$wareHouse instanceof Model_warehouse)
        {
            $this->startWarehouseProcess($entryDate);
        }
    }


    public static function getWorkflowDetail($additionalFilters = array())
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        SELECT
            id_pro,
            IF(energized_pro = 1, 'Si', 'No') energized_pro,
            project_energized.entry_date project_energized_entry_date,
            last_week_percentage,
            work_area_pro,
            previous_percentage,
            previous_manual_entry_date,
            percentage_inc,
            last_three_incidents,
            detail_inc,
            status_name_pst,
            keyword_pst,
            project_percentage_pro,
            contract_number_con,
            TIMESTAMPDIFF(DAY, status_log_manual_entry_date.manual_entry_date_psl, now()) static_days,
            status_log_manual_entry_date.manual_entry_date_psl status_log_manual_entry_date,
            code_pro,
            secondary_code_pro,
            detail_pro,
            budgetary_position_pro,
            entry_date_pro,
            folder_date_pro,
            concat(firstname_usr,' ', lastname_usr) cre_fiscal_pro,
            id_usr cre_fiscal_id,
            CASE
                WHEN system_pro = 1 then 'Sistema Santa Cruz'
                WHEN system_pro = 2 then 'Sistema Velasco'
                WHEN system_pro = 3 then 'Sistema Misiones'
                WHEN system_pro = 4 then 'Sistema Camiri'
                WHEN system_pro = 5 then 'Sistema German bush'
                WHEN system_pro = 6 then 'Sistema Robore'
                WHEN system_pro = 7 then 'Sistema Valles'
            END system_pro,
            CASE
                WHEN management_by_pro = 1 then 'Sistema Santa Cruz'
                WHEN management_by_pro = 2 then 'Sistema Velasco'
                WHEN management_by_pro = 3 then 'Sistema Misiones'
                WHEN management_by_pro = 4 then 'Sistema Camiri'
                WHEN management_by_pro = 5 then 'Sistema German bush'
                WHEN management_by_pro = 6 then 'Sistema Robore'
                WHEN management_by_pro = 7 then 'Sistema Valles'
            END management_by_pro,
            address_pro,
            points_pro,
            distance_pro,
            quality_level_pro,
            budgetary_position_pro,
            cre_design_completion_date_pro,
            cre_building_completion_date_pro,
            stakes.entry_date stake_date,	
            stakes.responsible_user_id stake_responsible_user_id,
            stakes.responsible stake_responsible,
            digitization.points_quantity_prp digitization_points_quantity,
            digitization.distance_prp digitization_distance,
            rd_digitization.points_quantity_prp rd_digitization_points_quantity,
            rd_digitization.distance_prp rd_digitization_distance,
            returned.entry_date returned_date,
            digitization.entry_date digitization_date,
            drawing.entry_date drawing_date,
            schedulee.entry_date schedule_date,
            schedulee.design_prb schedule_design_budget,
            project_start_pro schedule_start,
            project_end_pro schedule_end,
            already_sent.entry_date already_sent_date,
            approved.entry_date approved_date,
            canceled.entry_date canceled_date,
            rectify_design.entry_date rectify_design_date,
            rectify_illustration.entry_date rectify_illustration_date,
            approved.design_prb design_budget,
            approved.building_prb building_budget,
            approved.transportation_prb transportation_budget,
            approved.live_line_prb live_line_budget,
            approved.right_of_way_prb right_of_way_budget,
            approved.total_budget total_approved,               
            record_building_materials.entry_date record_building_materials_date,
            get_materials.entry_date get_materials_date,
            deliver_materials.entry_date deliver_materials_date,
            materials_reception.entry_date materials_reception_date,
            assign_to.entry_date assign_to_date,
            assign_to.responsible assign_to_responsible,
            in_progress.builder_responsible builder_responsible,
            in_progress.responsible_user_id builder_responsible_user_id,
            assign_to.fiscal_responsible_id fiscal_responsible_id,
            assign_to.fiscal_responsible fiscal_responsible,
            -- if(assign_to.live_line_cas,'Si','No') live_line_assigned,
            if(status_pro >= 35,if(conciliation_shipment.live_line_reb > 0,'Si','No'),if(approved.live_line_prb > 0,'Si','No')) live_line_assigned,
            if(assign_to.power_down_cas, 'Si','No') power_down_assigned,
            if(assign_to.maneuver_cas, 'Si','No') maneuver_assigned,
            assign_to.start_date_cas start_date_assigned,
            assign_to.end_date_cas end_date_assigned,
            assign_to.estimated_time_cas estimated_time_assigned,
            assign_to.project_manager_full_name project_manager_assigned,
            in_progress.entry_date in_progress_date,
            completed.entry_date completed_date,
            paused.entry_date paused_date,
            paused.percentage_paused percentage_paused,
            stopped.entry_date stopped_date,
            stopped.percentage_stopped percentage_stopped,
            as_built.entry_date as_built_date,
            as_built.points_quantity_prp as_built_points_quantity,
            as_built.distance_prp as_built_distance,
            conciliation_reception.entry_date conciliation_reception_date,
            conciliation_shipment.entry_date conciliation_shipment_date,
            cre_return_order.entry_date cre_return_order_date,
            project_return_materials.entry_date project_return_materials_date,
            payment_order_registered.entry_date payment_order_registered_date,
            payment_order_registered.order_number_pao payment_order_registered_order_number,
            conciliation_shipment.design_reb payment_order_registered_design_budget,
            conciliation_shipment.building_reb payment_order_registered_building_budget,
            conciliation_shipment.transportation_reb payment_order_registered_transportation_budget,
            conciliation_shipment.live_line_reb payment_order_registered_live_line_budget,
            conciliation_shipment.right_of_way_reb payment_order_registered_right_of_way_budget,
            conciliation_shipment.total_real_budget payment_order_registered_total_real_budget,
            payment_order_registered.invoice_number_pao payment_order_registered_invoice_number,
            payment_order_invoice_sent.entry_date payment_order_invoice_sent_date,
            payment_order_has_been_settled.entry_date payment_order_has_been_settled_date
        FROM
            wfl_projects
        LEFT JOIN (".static::_statusDetailQuery(2).") stakes on stakes.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(16).") rd_digitization on rd_digitization.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(20).") returned on returned.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(3).") digitization on digitization.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(5).") drawing on drawing.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(6).") schedulee on schedulee.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(10).") already_sent on already_sent.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(11).") approved on approved.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(12).") canceled on canceled.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(13).") rectify_design on rectify_design.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(14).") rectify_illustration on rectify_illustration.project_id_psl = id_pro
        LEFT JOIN (".static::_warehouseStatusDetailQuery(23).") record_building_materials on record_building_materials.project_id_war = id_pro
        LEFT JOIN (".static::_warehouseStatusDetailQuery(24).") get_materials on get_materials.project_id_war = id_pro
        LEFT JOIN (".static::_warehouseStatusDetailQuery(25).") deliver_materials on deliver_materials.project_id_war = id_pro
        LEFT JOIN (".static::_warehouseStatusDetailQuery(26).") materials_reception on materials_reception.project_id_war = id_pro
        LEFT JOIN (".static::_statusDetailQuery(21).") assign_to on assign_to.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(29).") in_progress on in_progress.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(32).") completed on completed.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(31).") paused on paused.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(30).") stopped on stopped.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(33).") as_built on as_built.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(34).") conciliation_reception on conciliation_reception.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(35).") conciliation_shipment on conciliation_shipment.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(37).") cre_return_order on cre_return_order.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(38).") project_return_materials on project_return_materials.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(47).") project_energized on project_energized.project_id_psl = id_pro
        LEFT JOIN (".static::_paymentOrderStatusDetailQuery(42).") payment_order_registered on payment_order_registered.project_id_pop = id_pro
        LEFT JOIN (".static::_paymentOrderStatusDetailQuery(43).") payment_order_invoice_sent on payment_order_invoice_sent.project_id_pop = id_pro
        LEFT JOIN (".static::_paymentOrderStatusDetailQuery(44).") payment_order_has_been_settled on payment_order_has_been_settled.project_id_pop = id_pro
        LEFT JOIN wfl_project_status on status_pro = id_pst
        left join sec_users cre_fiscal on id_usr = cre_fiscal_pro
        left join wfl_contracts on contract_id_pro = id_con
        LEFT JOIN (
		    select * from (
                select
                    project_id_psl project_id, max(manual_entry_date_psl) max_date
                    from (
                        SELECT
                            project_id_psl,
                            manual_entry_date_psl
                        FROM
                            wfl_project_status_log
                        LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                        where deleted_psl != 1 and deleted_slr != 1
                        GROUP BY id_psl
                    ) statusLogAndResponsible group by project_id_psl
            ) as max_entry
            LEFT JOIN (
                        SELECT
                            id_psl,
                            project_id_psl,
                            log_detail_psl,
                            manual_entry_date_psl,
                            GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
                            GROUP_CONCAT(id_usr) responsible_ids
                        FROM
                            wfl_project_status_log
                        LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                        LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
                        LEFT JOIN sec_users on id_usr = user_id_sre
                        where deleted_psl != 1  and deleted_slr != 1
                        GROUP BY id_psl
                        ) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
        ) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro
        LEFT JOIN (
            select inc.*
            from (
               select 
                    project_id_inc,
                    max(manual_entry_date_inc) manual_entry_date_inc
                    from wfl_incidents
                    where status_id_inc in (29) -- in_progress 
                    GROUP BY project_id_inc
            ) as filtered inner join wfl_incidents as inc on inc.project_id_inc = filtered.project_id_inc and inc.manual_entry_date_inc = filtered.manual_entry_date_inc
        ) wfl_incidents on project_id_inc = id_pro
        LEFT JOIN ( 
            select           
            IFNULL(percentage_inc,0) last_week_percentage,
            project_id_inc last_week_project_id
            from (
               select 
                    project_id_inc last_week_project_id,
                    max(manual_entry_date_inc) last_week_manual_entry_date
                    from wfl_incidents
                    where status_id_inc in (29) -- in_progress 
                    and manual_entry_date_inc >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
                    AND manual_entry_date_inc < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY     
                    GROUP BY project_id_inc
            ) as filtered_last_week inner join wfl_incidents as inc on inc.project_id_inc = filtered_last_week.last_week_project_id and inc.manual_entry_date_inc = filtered_last_week.last_week_manual_entry_date
        ) wfl_incidents_last_week on last_week_project_id = id_pro
        LEFT JOIN (
            select
            current.project_id_inc project_id,
            current.percentage_inc current_percentage,
            current.manual_entry_date_inc current_manual_entry_date,
            IFNULL(previous.percentage_inc,0) previous_percentage,
            previous.manual_entry_date_inc previous_manual_entry_date
            from (
                SELECT
                    t1.project_id_inc project_id,   
                    max( t1.manual_entry_date_inc ) current_update, 
                    max( t2.manual_entry_date_inc ) previous_update
                FROM
                    wfl_incidents t1
                    LEFT JOIN wfl_incidents t2 ON t1.project_id_inc = t2.project_id_inc AND t2.manual_entry_date_inc < t1.manual_entry_date_inc 
                GROUP BY
                    t1.project_id_inc
            ) current_and_previous
            LEFT JOIN wfl_incidents previous on previous.project_id_inc = current_and_previous.project_id and previous.manual_entry_date_inc = current_and_previous.previous_update
            LEFT JOIN wfl_incidents current on current.project_id_inc = current_and_previous.project_id and current.manual_entry_date_inc = current_and_previous.current_update
        ) previous_incident on previous_incident.project_id = id_pro
        LEFT JOIN ( 
            SELECT
                project_id_inc,
                SUBSTRING_INDEX(GROUP_CONCAT(CONCAT(percentage_inc,' (',DATE_FORMAT(manual_entry_date_inc,'%d-%m-%Y'),')') ORDER BY manual_entry_date_inc desc SEPARATOR '\n'), '\n', 3) last_three_incidents
            FROM
                wfl_incidents
            where deleted_inc != 1
            GROUP BY project_id_inc
        ) wfl_incidents_last_three_incidents on wfl_incidents_last_three_incidents.project_id_inc = id_pro
        where 
        deleted_pro != 1
        ".static::_workflowAdditionalFilter($additionalFilters)."
        ";
        // echo"<pre>";var_dump($sql);exit;
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    /**
     * This method is a complement of getWorkflowDetail method.
     * @param $statusId
     * @return string
     */
    private static function _statusDetailQuery($statusId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        select 
			id_psl,
			project_id_psl,
			status_id_psl,	
			filter.entry_date,
			GROUP_CONCAT(CONCAT(responsible.id_usr)) responsible_user_id,
			GROUP_CONCAT(CONCAT(responsible.firstname_usr,' ',responsible.lastname_usr)) responsible,
			GROUP_CONCAT(CONCAT(builder.builder_firstname,' ',builder.builder_lastname)) builder_responsible,
			-- fiscal.fiscal_id fiscal_responsible_id,
			GROUP_CONCAT(CONCAT(fiscal.fiscal_id)) fiscal_responsible_id,
			GROUP_CONCAT(CONCAT(fiscal.fiscal_firstname,' ',fiscal.fiscal_lastname)) fiscal_responsible,
			design_prb,
			building_prb,			
			transportation_prb,
			live_line_prb,
			right_of_way_prb,
			(IFNULL(design_prb,0) + IFNULL(building_prb,0) + IFNULL(transportation_prb,0) + IFNULL(live_line_prb,0) + IFNULL(right_of_way_prb,0)) as total_budget,
			design_reb,
			building_reb,			
			transportation_reb,
			live_line_reb,
			right_of_way_reb,
			(IFNULL(design_reb,0) + IFNULL(building_reb,0) + IFNULL(transportation_reb,0) + IFNULL(live_line_reb,0) + IFNULL(right_of_way_reb,0)) as total_real_budget,
			start_date_cas,
			end_date_cas,
			estimated_time_cas,
			live_line_cas,
			power_down_cas,
			maneuver_cas,
            CONCAT(project_manager.firstname_usr,' ',project_manager.lastname_usr) project_manager_full_name,
			pauseOnIncident.percentage_inc percentage_paused,
			stopOnIncident.percentage_inc percentage_stopped,
			points_quantity_prp,
			distance_prp
		from 
			wfl_project_status_log
		RIGHT JOIN(
            SELECT			
                project_id_psl project_id,
                max(manual_entry_date_psl) entry_date
            FROM
                wfl_project_status_log
            WHERE		
            status_id_psl = ".$ci->db->escape($statusId)."
            and deleted_psl != 1
            
            GROUP BY project_id_psl
		) as filter on filter.entry_date = manual_entry_date_psl and filter.project_id = project_id_psl
		LEFT JOIN wfl_projects on id_pro = project_id_psl
		LEFT JOIN (
                    select 
                        wfl_incidents.* 
                    from 
                        wfl_incidents
                    RIGHT JOIN 
                    (
                        SELECT
                            project_id_inc project_id,
                            MAX(manual_entry_date_inc) AS entry_date
                        FROM
                            wfl_incidents
                        where 
                            paused_inc = 1
                        and deleted_inc != 1
                        GROUP BY
                            project_id_inc
                    ) last_incidents on last_incidents.project_id = project_id_inc and last_incidents.entry_date = manual_entry_date_inc
                ) pauseOnIncident on pauseOnIncident.project_id_inc = id_pro
        LEFT JOIN (
            select 
                wfl_incidents.* 
            from 
                wfl_incidents
            RIGHT JOIN 
            (
                SELECT
                    project_id_inc project_id,
                    MAX(manual_entry_date_inc) AS entry_date
                FROM
                    wfl_incidents
                where 
                    stopped_inc = 1
                and deleted_inc != 1
                GROUP BY
                    project_id_inc
            ) last_incidents on last_incidents.project_id = project_id_inc and last_incidents.entry_date = manual_entry_date_inc
        ) stopOnIncident on stopOnIncident.project_id_inc = id_pro
		LEFT JOIN wfl_status_log_responsibles on wfl_status_log_responsibles.status_log_id_slr = id_psl
		LEFT JOIN wfl_status_responsibles on responsible_id_slr = id_sre		
		LEFT JOIN sec_users responsible on user_id_sre = responsible.id_usr
		LEFT JOIN (
                SELECT
                    id_usr builder_id,
                    firstname_usr builder_firstname,
                    lastname_usr builder_lastname
                FROM
                    sec_users
                right JOIN sec_userroles on userid_uro = id_usr
                where 
                    roleid_uro = 9
                and deleted_uro != 1
            ) as builder on builder.builder_id = user_id_sre
		LEFT JOIN (
                SELECT
                    id_usr fiscal_id,
                    firstname_usr fiscal_firstname,
                    lastname_usr fiscal_lastname
                FROM
                    sec_users
                right JOIN sec_userroles on userid_uro = id_usr
                where 
                    roleid_uro = 8
                and deleted_uro != 1
            ) as fiscal on fiscal.fiscal_id = user_id_sre		
		LEFT JOIN wfl_project_budgets on status_log_id_prb = id_psl
		LEFT JOIN wfl_project_real_budgets on status_log_id_reb = id_psl
		LEFT JOIN wfl_construction_assignments on status_log_id_cas = id_psl
		left join wfl_project_points on status_log_id_prp = id_psl
        left join sec_users project_manager on project_manager_cas = project_manager.id_usr
		where deleted_pro != 1 and deleted_slr != 1
		GROUP BY id_psl
        ";
        return $sql;
    }

    /**
     * @param $statusId
     * @return string
     */
    private static function _warehouseStatusDetailQuery($statusId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        		select 
			id_wsl,
			project_id_war,
			log_detail_wsl,
			warehouse_id_wsl,
			status_id_wsl,	
			filter.entry_date
		from 
			wfl_warehouse_status_log
		RIGHT JOIN(
				SELECT			
					warehouse_id_wsl warehouse_id,
					max(manual_entry_date_wsl) entry_date
				FROM
					wfl_warehouse_status_log
				WHERE		
				status_id_wsl = ".$ci->db->escape($statusId)."
				and deleted_wsl != 1				
				GROUP BY warehouse_id_wsl
		) as filter on filter.entry_date = manual_entry_date_wsl and filter.warehouse_id = warehouse_id_wsl
		LEFT JOIN wfl_warehouses on id_war = warehouse_id_wsl		
		where deleted_war != 1
		GROUP BY id_wsl
        ";
        return $sql;
    }

	/**
	 * @param $statusId
	 * @return string
	 */
	private static function _paymentOrderStatusDetailQuery($statusId)
	{
		$ci = &get_instance();
		$ci->load->database();
		$sql = "
		select 
			id_pos,
            order_number_pao,
            filter.entry_date,
			project_id_pop,
            design_budget_pop,
            transportation_budget_pop,
            live_line_budget_pop,
			building_budget_pop,
            right_of_way_budget_pop,
            ifnull(design_budget_pop, 0) + ifnull(transportation_budget_pop, 0) + ifnull(live_line_budget_pop,0) + ifnull(building_budget_pop, 0) + ifnull(right_of_way_budget_pop, 0) total_real_budget,
            invoice_number_pao,			
            log_detail_pos,
			payment_order_id_pos,
			status_id_pos
			
		from 
			wfl_payment_orders_status_log
		RIGHT JOIN(
				SELECT			
					payment_order_id_pos payment_order_id,
					max(manual_entry_date_pos) entry_date
				FROM
					wfl_payment_orders_status_log
				WHERE		
				status_id_pos = ".$ci->db->escape($statusId)."
				and deleted_pos != 1				
				GROUP BY payment_order_id_pos
		) as filter on filter.entry_date = manual_entry_date_pos and filter.payment_order_id = payment_order_id_pos
		LEFT JOIN wfl_payment_orders on id_pao = payment_order_id_pos		
        left join wfl_payment_orders_projects on order_id_pop = id_pao 
		where 
			deleted_pao != 1
            and deleted_pop != 1		
        ";
		return $sql;
	}

	private static function _workflowAdditionalFilter($filters = array())
    {
        $ci = &get_instance();
        $ci->load->database();
//        echo "<pre>";var_dump($filters);exit;
        $keywordDateRange = isset($filters["keyword"]) && $filters["keyword"] != ""?$filters["keyword"]:"";
        $contractId = isset($filters["contract-id"]) && $filters["contract-id"] != ""?$filters["contract-id"]:"";
        $year = isset($filters["year"]) && $filters["year"] != ""?$filters["year"]:"";
        $rowKey = isset($filters["rowKey"]) && $filters["rowKey"] != ""?$filters["rowKey"]:"";
        $month = isset($filters["month"]) && $filters["month"] != ""?$filters["month"]:"";
        $startMonth = $month;
        $endMonth = $month;
        if($month == "")
        {
            $startMonth = "01";
            $endMonth = "12";
        }
        $sql = "";
        switch ($keywordDateRange)
        {
            case 'project_has_been_created':
                $sql = " and entry_date_pro BETWEEN '".$year."-".$startMonth."-01 00:00:00' and '".$year."-".$endMonth."-31 23:59:59' ";
                break;
            case 'already_sent':
                $sql = " and already_sent.entry_date BETWEEN '".$year."-".$startMonth."-01 00:00:00' and '".$year."-".$endMonth."-31 23:59:59' ";
                break;
            case 'approved':
                $sql = " and approved.entry_date BETWEEN '".$year."-".$startMonth."-01 00:00:00' and '".$year."-".$endMonth."-31 23:59:59' ";
                break;
            case 'completed':
                $sql = " and completed.entry_date BETWEEN '".$year."-".$startMonth."-01 00:00:00' and '".$year."-".$endMonth."-31 23:59:59' ";
                break;
            case 'as_built':
                $sql = " and as_built.entry_date BETWEEN '".$year."-".$startMonth."-01 00:00:00' and '".$year."-".$endMonth."-31 23:59:59' ";
                break;
            case 'conciliation_shipment':
                $sql = " and conciliation_shipment.entry_date BETWEEN '".$year."-".$startMonth."-01 00:00:00' and '".$year."-".$endMonth."-31 23:59:59' ";
                break;
            case 'project_real_budget_confirmation':
                $sql = " and payment_order_registered.entry_date BETWEEN '".$year."-".$startMonth."-01 00:00:00' and '".$year."-".$endMonth."-31 23:59:59' ";
                break;
        }

        switch($rowKey)
        {
            case "countId":
                $sql .= "";
                break;
            case "countDigitizationPoints":
                $sql .= " and digitization.points_quantity_prp is not null and digitization.distance_prp is not null ";
                break;
            case "countWithoutDigitizationPoints":
                $sql .= " and digitization.points_quantity_prp is null and digitization.distance_prp is null ";
                // echo"<pre>";var_dump($sql);exit;
                break;
            case "countAsBuiltPoints":
                $sql .= " and as_built.points_quantity_prp is not null and as_built.distance_prp is not null ";
                break;
            case "countWithoutAsBuiltPoints":
                $sql .= " and as_built.points_quantity_prp is null and as_built.distance_prp is null ";
                break;
            case "countBudgets":
                $sql .= " and approved.total_budget is not null and approved.total_budget is not null ";
                break;
            case "countWithoutBudgets":
                $sql .= " and approved.total_budget is null and approved.total_budget is null ";
                break;
            case "countRealBudgets":
                $sql .= " and conciliation_shipment.total_real_budget is not null and conciliation_shipment.total_real_budget is not null ";
                break;
            case "countWithoutRealBudgets":
                $sql .= " and conciliation_shipment.total_real_budget is null and conciliation_shipment.total_real_budget is null ";
                break;
        }

        if(isset($filters["code-list"]))
        {
            $codeList = $filters["code-list"];
            $codeList = str_replace("\r\n"," ", $codeList);
            $codeList = str_replace(" ",PHP_EOL, $codeList);
            $codeList = explode(PHP_EOL, $codeList);
            $codeList = array_values(array_filter($codeList));
            $codeListFilter = "";
            foreach ($codeList as $code)
            {
                $codeListFilter .= $ci->db->escape($code).", ";
            }
            $codeListFilter = substr($codeListFilter,0, -2);
            if($codeListFilter != "")
            {
                $sql .= " and code_pro in (".$codeListFilter.") ";
            }
        }
        if(isset($filters["status-keyword"]) && $filters["status-keyword"] != "")
        {
            $statusKeyword = $filters["status-keyword"];
            if(strpos($statusKeyword,",") !== FALSE)
            {
                $statusList = explode(",", $statusKeyword);
                $statusKeyword = "";
                foreach ($statusList as $status)
                {
                    $statusKeyword .= $ci->db->escape(trim($status)).", ";
                }
                $statusKeyword = substr($statusKeyword,0, -2);
            }
            else
            {
                $statusKeyword = $ci->db->escape($statusKeyword);
            }
            $sql .= " and keyword_pst in( ".$statusKeyword." )";
        }
        if(isset($filters["contract-id"]) && $filters["contract-id"] != "")
        {
            $contractId = $filters["contract-id"];
            $sql .= " and id_con = ".$ci->db->escape($contractId)." ";
        }
       // echo"<pre>";var_dump($sql);exit;
        return $sql;
    }

	public static function getNewProjectsByYearAndMonth()
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        SELECT 	
            projects.year 'year',	
            count(CASE WHEN month = 1 THEN id_pro END) 'january',
            count(CASE WHEN month = 2 THEN id_pro END) 'february',
            count(CASE WHEN month = 3 THEN id_pro END) 'march',
            count(CASE WHEN month = 4 THEN id_pro END) 'april',
            count(CASE WHEN month = 5 THEN id_pro END) 'may',
            count(CASE WHEN month = 6 THEN id_pro END) 'june',
            count(CASE WHEN month = 7 THEN id_pro END) 'july',
            count(CASE WHEN month = 8 THEN id_pro END) 'august',
            count(CASE WHEN month = 9 THEN id_pro END) 'september',
            count(CASE WHEN month = 10 THEN id_pro END) 'october',
            count(CASE WHEN month = 11 THEN id_pro END) 'november',
            count(CASE WHEN month = 12 THEN id_pro END) 'december'
        FROM (
            SELECT 
                wfl_projects.*,
            EXTRACT(YEAR  FROM entry_date_pro) year,
            EXTRACT(MONTH FROM entry_date_pro) month
                  FROM wfl_projects
          ) projects
        WHERE
        deleted_pro != 1
        GROUP BY EXTRACT(YEAR FROM entry_date_pro)
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
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

    public static function getApprovedProjectsByYearAndMonth()
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        SELECT 	
            projects.year 'year',	
            count(CASE WHEN month = 1 THEN id_pro END) 'january',
            count(CASE WHEN month = 2 THEN id_pro END) 'february',
            count(CASE WHEN month = 3 THEN id_pro END) 'march',
            count(CASE WHEN month = 4 THEN id_pro END) 'april',
            count(CASE WHEN month = 5 THEN id_pro END) 'may',
            count(CASE WHEN month = 6 THEN id_pro END) 'june',
            count(CASE WHEN month = 7 THEN id_pro END) 'july',
            count(CASE WHEN month = 8 THEN id_pro END) 'august',
            count(CASE WHEN month = 9 THEN id_pro END) 'september',
            count(CASE WHEN month = 10 THEN id_pro END) 'october',
            count(CASE WHEN month = 11 THEN id_pro END) 'november',
            count(CASE WHEN month = 12 THEN id_pro END) 'december'
        from 
        (
        SELECT 
            wfl_projects.*,
            EXTRACT(YEAR  FROM approved_log.entry_date) year,
          EXTRACT(MONTH FROM approved_log.entry_date) month	
        from 
            wfl_projects
        RIGHT JOIN (
                select 
                    id_psl,
                    project_id_psl,
                    status_id_psl,	
                    filter.entry_date,
                    GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
                    design_prb,
                    building_prb,			
                    transportation_prb,
                    live_line_prb,
                    right_of_way_prb,
                    (IFNULL(design_prb,0) + IFNULL(building_prb,0) + IFNULL(transportation_prb,0) + IFNULL(live_line_prb,0) + IFNULL(right_of_way_prb,0)) as total_budget		
                from 
                    wfl_project_status_log
                RIGHT JOIN(
                    SELECT			
                        project_id_psl project_id,
                        max(manual_entry_date_psl) entry_date
                    FROM
                        wfl_project_status_log
                    WHERE		
                    status_id_psl = 11
                    and deleted_psl != 1
                    
                    GROUP BY project_id_psl
                ) as filter on filter.entry_date = manual_entry_date_psl and filter.project_id = project_id_psl
                LEFT JOIN wfl_projects on id_pro = project_id_psl		
                LEFT JOIN wfl_status_log_responsibles on wfl_status_log_responsibles.status_log_id_slr = id_psl
                LEFT JOIN wfl_status_responsibles on responsible_id_slr = id_sre		
                LEFT JOIN sec_users on user_id_sre = id_usr
                LEFT JOIN wfl_project_budgets on status_log_id_prb = id_psl
                where deleted_pro != 1
                GROUP BY id_psl
        ) approved_log on approved_log.project_id_psl = id_pro
        WHERE
        deleted_pro != 1					
        ) projects
        WHERE
        deleted_pro != 1
        GROUP BY projects.year
        ";

        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public static function getConciliatedProjectsByYearAndMonth()
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        SELECT 	
            projects.year 'year',	
            count(CASE WHEN month = 1 THEN id_pro END) 'january',
            count(CASE WHEN month = 2 THEN id_pro END) 'february',
            count(CASE WHEN month = 3 THEN id_pro END) 'march',
            count(CASE WHEN month = 4 THEN id_pro END) 'april',
            count(CASE WHEN month = 5 THEN id_pro END) 'may',
            count(CASE WHEN month = 6 THEN id_pro END) 'june',
            count(CASE WHEN month = 7 THEN id_pro END) 'july',
            count(CASE WHEN month = 8 THEN id_pro END) 'august',
            count(CASE WHEN month = 9 THEN id_pro END) 'september',
            count(CASE WHEN month = 10 THEN id_pro END) 'october',
            count(CASE WHEN month = 11 THEN id_pro END) 'november',
            count(CASE WHEN month = 12 THEN id_pro END) 'december'
        from 
        (
                SELECT 
            wfl_projects.*,
            EXTRACT(YEAR  FROM conciliated_log.entry_date) year,
          EXTRACT(MONTH FROM conciliated_log.entry_date) month	
        from 
            wfl_projects
        RIGHT JOIN (
                select 
                    id_psl,
                    project_id_psl,
                    status_id_psl,	
                    filter.entry_date,
                    GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
                    design_prb,
                    building_prb,			
                    transportation_prb,
                    live_line_prb,
                    right_of_way_prb,
                    (IFNULL(design_prb,0) + IFNULL(building_prb,0) + IFNULL(transportation_prb,0) + IFNULL(live_line_prb,0) + IFNULL(right_of_way_prb,0)) as total_budget		
                from 
                    wfl_project_status_log
                RIGHT JOIN(
                    SELECT			
                        project_id_psl project_id,
                        max(manual_entry_date_psl) entry_date
                    FROM
                        wfl_project_status_log
                    WHERE		
                    status_id_psl = 35
                    and deleted_psl != 1
                    
                    GROUP BY project_id_psl
                ) as filter on filter.entry_date = manual_entry_date_psl and filter.project_id = project_id_psl
                LEFT JOIN wfl_projects on id_pro = project_id_psl		
                LEFT JOIN wfl_status_log_responsibles on wfl_status_log_responsibles.status_log_id_slr = id_psl
                LEFT JOIN wfl_status_responsibles on responsible_id_slr = id_sre		
                LEFT JOIN sec_users on user_id_sre = id_usr
                LEFT JOIN wfl_project_budgets on status_log_id_prb = id_psl
                where deleted_pro != 1
                GROUP BY id_psl
        ) conciliated_log on conciliated_log.project_id_psl = id_pro
        WHERE
        deleted_pro != 1					
        ) projects
        WHERE
        deleted_pro != 1
        GROUP BY projects.year
        ";

        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public static function getAsBuiltProjectsByYearAndMonth()
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            SELECT 	
                projects.year 'year',	
                count(CASE WHEN month = 1 THEN id_pro END) 'january',
                count(CASE WHEN month = 2 THEN id_pro END) 'february',
                count(CASE WHEN month = 3 THEN id_pro END) 'march',
                count(CASE WHEN month = 4 THEN id_pro END) 'april',
                count(CASE WHEN month = 5 THEN id_pro END) 'may',
                count(CASE WHEN month = 6 THEN id_pro END) 'june',
                count(CASE WHEN month = 7 THEN id_pro END) 'july',
                count(CASE WHEN month = 8 THEN id_pro END) 'august',
                count(CASE WHEN month = 9 THEN id_pro END) 'september',
                count(CASE WHEN month = 10 THEN id_pro END) 'october',
                count(CASE WHEN month = 11 THEN id_pro END) 'november',
                count(CASE WHEN month = 12 THEN id_pro END) 'december'
            from 
            (
                SELECT 
                    wfl_projects.*,
                    EXTRACT(YEAR  FROM as_built_log.entry_date) year,
                    EXTRACT(MONTH FROM as_built_log.entry_date) month	
                from 
                    wfl_projects
                RIGHT JOIN (
                        select 
                            id_psl,
                            project_id_psl,
                            status_id_psl,	
                            filter.entry_date,
                            GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
                            design_prb,
                            building_prb,			
                            transportation_prb,
                            live_line_prb,
                            right_of_way_prb,
                            (IFNULL(design_prb,0) + IFNULL(building_prb,0) + IFNULL(transportation_prb,0) + IFNULL(live_line_prb,0) + IFNULL(right_of_way_prb,0)) as total_budget		
                        from 
                            wfl_project_status_log
                        RIGHT JOIN(
                            SELECT			
                                project_id_psl project_id,
                                max(manual_entry_date_psl) entry_date
                            FROM
                                wfl_project_status_log
                            WHERE		
                            status_id_psl = 33
                            and deleted_psl != 1
                            
                            GROUP BY project_id_psl
                        ) as filter on filter.entry_date = manual_entry_date_psl and filter.project_id = project_id_psl
                        LEFT JOIN wfl_projects on id_pro = project_id_psl		
                        LEFT JOIN wfl_status_log_responsibles on wfl_status_log_responsibles.status_log_id_slr = id_psl
                        LEFT JOIN wfl_status_responsibles on responsible_id_slr = id_sre		
                        LEFT JOIN sec_users on user_id_sre = id_usr
                        LEFT JOIN wfl_project_budgets on status_log_id_prb = id_psl
                        where deleted_pro != 1
                        GROUP BY id_psl
                ) as_built_log on as_built_log.project_id_psl = id_pro
                WHERE
                deleted_pro != 1					
            ) projects
            WHERE
            deleted_pro != 1
            GROUP BY projects.year
        ";

        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public static function getOrderNumberAndTotalsByYearAndMonth()
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            SELECT
            DATE_FORMAT(entry_date_pao, '%Y-%m') date,
            id_pro,
            code_pro,
            approved_log.id_psl,
            approved_log.design_prb design_budget,
            approved_log.building_prb building_budget,			
            approved_log.transportation_prb transportation_budget,
            approved_log.live_line_prb live_line_budget,
            approved_log.right_of_way_prb right_of_way_budget,
            real_budget_log.design_reb design_real_budget,
            real_budget_log.building_reb building_real_budget,			
            real_budget_log.transportation_reb transportation_real_budget,
            real_budget_log.live_line_reb live_line_real_budget,
            real_budget_log.right_of_way_reb right_of_way_real_budget
        FROM
            wfl_payment_orders
        LEFT JOIN wfl_payment_orders_projects on id_pao = order_id_pop and deleted_pop != 1
        LEFT JOIN wfl_projects on id_pro = project_id_pop
        LEFT JOIN (
                select 
                    id_psl,
                    project_id_psl,
                    status_id_psl,	
                    filter.entry_date,
                    GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
                    design_prb,
                    building_prb,			
                    transportation_prb,
                    live_line_prb,
                    right_of_way_prb,
                    (IFNULL(design_prb,0) + IFNULL(building_prb,0) + IFNULL(transportation_prb,0) + IFNULL(live_line_prb,0) + IFNULL(right_of_way_prb,0)) as total_budget,
                    design_reb,
                    building_reb,			
                    transportation_reb,
                    live_line_reb,
                    right_of_way_reb,
                    (IFNULL(design_reb, 0) + IFNULL(building_reb,0) + IFNULL(transportation_reb,0) + IFNULL(live_line_reb,0) + IFNULL(right_of_way_reb,0)) as total_real_budget
                from 
                    wfl_project_status_log
                RIGHT JOIN(
                    SELECT			
                        project_id_psl project_id,
                        max(manual_entry_date_psl) entry_date
                    FROM
                        wfl_project_status_log
                    WHERE		
                    status_id_psl = 11
                    and deleted_psl != 1
                    
                    GROUP BY project_id_psl
                ) as filter on filter.entry_date = manual_entry_date_psl and filter.project_id = project_id_psl
                LEFT JOIN wfl_projects on id_pro = project_id_psl		
                LEFT JOIN wfl_status_log_responsibles on wfl_status_log_responsibles.status_log_id_slr = id_psl
                LEFT JOIN wfl_status_responsibles on responsible_id_slr = id_sre		
                LEFT JOIN sec_users on user_id_sre = id_usr
                LEFT JOIN wfl_project_budgets on status_log_id_prb = id_psl
                LEFT JOIN wfl_project_real_budgets on status_log_id_reb = id_psl
                where deleted_pro != 1
                GROUP BY id_psl
        ) approved_log on approved_log.project_id_psl = id_pro
        LEFT JOIN (
                select 
                    id_psl,
                    project_id_psl,
                    status_id_psl,	
                    filter.entry_date,
                    GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
                    design_prb,
                    building_prb,			
                    transportation_prb,
                    live_line_prb,
                    right_of_way_prb,
                    (IFNULL(design_prb,0) + IFNULL(building_prb,0) + IFNULL(transportation_prb,0) + IFNULL(live_line_prb,0) + IFNULL(right_of_way_prb,0)) as total_budget,
                    design_reb,
                    building_reb,			
                    transportation_reb,
                    live_line_reb,
                    right_of_way_reb,
                    (IFNULL(design_reb, 0) + IFNULL(building_reb,0) + IFNULL(transportation_reb,0) + IFNULL(live_line_reb,0) + IFNULL(right_of_way_reb,0)) as total_real_budget
                from 
                    wfl_project_status_log
                RIGHT JOIN(
                    SELECT			
                        project_id_psl project_id,
                        max(manual_entry_date_psl) entry_date
                    FROM
                        wfl_project_status_log
                    WHERE		
                    status_id_psl = 40
                    and deleted_psl != 1
                    
                    GROUP BY project_id_psl
                ) as filter on filter.entry_date = manual_entry_date_psl and filter.project_id = project_id_psl
                LEFT JOIN wfl_projects on id_pro = project_id_psl		
                LEFT JOIN wfl_status_log_responsibles on wfl_status_log_responsibles.status_log_id_slr = id_psl
                LEFT JOIN wfl_status_responsibles on responsible_id_slr = id_sre		
                LEFT JOIN sec_users on user_id_sre = id_usr
                LEFT JOIN wfl_project_budgets on status_log_id_prb = id_psl
                LEFT JOIN wfl_project_real_budgets on status_log_id_reb = id_psl
                where deleted_pro != 1
                GROUP BY id_psl
        ) real_budget_log on real_budget_log.project_id_psl = id_pro
        ORDER BY date
        ";

        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public static function getPaymentSettledAndTotalsByYearAndMonth()
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
                SELECT
                    DATE_FORMAT(entry_date_pao, '%Y-%m') date,
                    id_pro,
                    code_pro,
                    approved_log.id_psl,
                    approved_log.design_prb design_budget,
                    approved_log.building_prb building_budget,			
                    approved_log.transportation_prb transportation_budget,
                    approved_log.live_line_prb live_line_budget,
                    approved_log.right_of_way_prb right_of_way_budget,
                    real_budget_log.design_reb design_real_budget,
                    real_budget_log.building_reb building_real_budget,			
                    real_budget_log.transportation_reb transportation_real_budget,
                    real_budget_log.live_line_reb live_line_real_budget,
                    real_budget_log.right_of_way_reb right_of_way_real_budget
                FROM
                    wfl_payment_orders
                LEFT JOIN wfl_payment_orders_projects on id_pao = order_id_pop and deleted_pop != 1
                LEFT JOIN wfl_projects on id_pro = project_id_pop
                LEFT JOIN (
                        select 
                            id_psl,
                            project_id_psl,
                            status_id_psl,	
                            filter.entry_date,
                            GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
                            design_prb,
                            building_prb,			
                            transportation_prb,
                            live_line_prb,
                            right_of_way_prb,
                            (IFNULL(design_prb,0) + IFNULL(building_prb,0) + IFNULL(transportation_prb,0) + IFNULL(live_line_prb,0) + IFNULL(right_of_way_prb,0)) as total_budget,
                            design_reb,
                            building_reb,			
                            transportation_reb,
                            live_line_reb,
                            right_of_way_reb,
                            (IFNULL(design_reb, 0) + IFNULL(building_reb,0) + IFNULL(transportation_reb,0) + IFNULL(live_line_reb,0) + IFNULL(right_of_way_reb,0)) as total_real_budget
                        from 
                            wfl_project_status_log
                        RIGHT JOIN(
                            SELECT			
                                project_id_psl project_id,
                                max(manual_entry_date_psl) entry_date
                            FROM
                                wfl_project_status_log
                            WHERE		
                            status_id_psl = 11
                            and deleted_psl != 1
                            
                            GROUP BY project_id_psl
                        ) as filter on filter.entry_date = manual_entry_date_psl and filter.project_id = project_id_psl
                        LEFT JOIN wfl_projects on id_pro = project_id_psl		
                        LEFT JOIN wfl_status_log_responsibles on wfl_status_log_responsibles.status_log_id_slr = id_psl
                        LEFT JOIN wfl_status_responsibles on responsible_id_slr = id_sre		
                        LEFT JOIN sec_users on user_id_sre = id_usr
                        LEFT JOIN wfl_project_budgets on status_log_id_prb = id_psl
                        LEFT JOIN wfl_project_real_budgets on status_log_id_reb = id_psl
                        where deleted_pro != 1
                        GROUP BY id_psl
                ) approved_log on approved_log.project_id_psl = id_pro
                LEFT JOIN (
                        select 
                            id_psl,
                            project_id_psl,
                            status_id_psl,	
                            filter.entry_date,
                            GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
                            design_prb,
                            building_prb,			
                            transportation_prb,
                            live_line_prb,
                            right_of_way_prb,
                            (IFNULL(design_prb,0) + IFNULL(building_prb,0) + IFNULL(transportation_prb,0) + IFNULL(live_line_prb,0) + IFNULL(right_of_way_prb,0)) as total_budget,
                            design_reb,
                            building_reb,			
                            transportation_reb,
                            live_line_reb,
                            right_of_way_reb,
                            (IFNULL(design_reb, 0) + IFNULL(building_reb,0) + IFNULL(transportation_reb,0) + IFNULL(live_line_reb,0) + IFNULL(right_of_way_reb,0)) as total_real_budget
                        from 
                            wfl_project_status_log
                        RIGHT JOIN(
                            SELECT			
                                project_id_psl project_id,
                                max(manual_entry_date_psl) entry_date
                            FROM
                                wfl_project_status_log
                            WHERE		
                            status_id_psl = 44
                            and deleted_psl != 1
                            
                            GROUP BY project_id_psl
                        ) as filter on filter.entry_date = manual_entry_date_psl and filter.project_id = project_id_psl
                        LEFT JOIN wfl_projects on id_pro = project_id_psl		
                        LEFT JOIN wfl_status_log_responsibles on wfl_status_log_responsibles.status_log_id_slr = id_psl
                        LEFT JOIN wfl_status_responsibles on responsible_id_slr = id_sre		
                        LEFT JOIN sec_users on user_id_sre = id_usr
                        LEFT JOIN wfl_project_budgets on status_log_id_prb = id_psl
                        LEFT JOIN wfl_project_real_budgets on status_log_id_reb = id_psl
                        where deleted_pro != 1
                        GROUP BY id_psl
                ) real_budget_log on real_budget_log.project_id_psl = id_pro
                ORDER BY date
        ";

        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    /**
     * @param $keyword
     * @param string $year
     * @param string $columnType
     * @param string $mainList
     * @param string $contractId
     * @return mixed
     */
    public static function getStatusQuantityDetailByYear($keyword, $year = "", $columnType = "countId", $mainList = "allProjects", $contractId = "")
    {
        $ci = &get_instance();
        $ci->load->database();

        $yearFilter = $year == ""?"":" and projects.year = ".$ci->db->escape($year)." ";
        $contractIdFilter  = $contractId == ""?"":" and contract_id_pro = ".$ci->db->escape($contractId)." ";
        $columns = static::_getStatusQuantityDetailByYearColumns($columnType);
        $mainList = static::_mainListFromFilter($mainList);
        $sql = "
            SELECT 	
                projects.year 'year',	
                ".$columns."
            from 
            (
            SELECT 
                wfl_projects.*,
                status_log.*,
                EXTRACT(YEAR  FROM wfl_projects.entry_date_main_list) year,
	            EXTRACT(MONTH FROM wfl_projects.entry_date_main_list) month	
            from 
                ".$mainList."
            RIGHT JOIN (
                    select 
                        id_psl,
                        project_id_psl,
                        status_id_psl,	
                        filter.entry_date,
                        GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
                        id_prb,
                        design_prb,
                        building_prb,			
                        transportation_prb,
                        live_line_prb,
                        right_of_way_prb,
                        (IFNULL(design_prb,0) + IFNULL(building_prb,0) + IFNULL(transportation_prb,0) + IFNULL(live_line_prb,0) + IFNULL(right_of_way_prb,0)) as total_budget,
                        id_reb,
                        design_reb,
                        building_reb,			
                        transportation_reb,
                        live_line_reb,
                        right_of_way_reb,
                        (IFNULL(design_reb,0) + IFNULL(building_reb,0) + IFNULL(transportation_reb,0) + IFNULL(live_line_reb,0) + IFNULL(right_of_way_reb,0)) as total_real_budget,
						id_prp,
						points_quantity_prp,
						distance_prp
                    from 
                        wfl_project_status_log
                    RIGHT JOIN(
                        SELECT			
                            project_id_psl project_id,
                            max(manual_entry_date_psl) entry_date
                        FROM
                            wfl_project_status_log
                        LEFT JOIN wfl_project_status on id_pst = status_id_psl
                        WHERE
                        keyword_pst = ".$ci->db->escape($keyword)."
                        and deleted_psl != 1
                        
                        GROUP BY project_id_psl
                    ) as filter on filter.entry_date = manual_entry_date_psl and filter.project_id = project_id_psl
                    LEFT JOIN wfl_projects on id_pro = project_id_psl		
                    LEFT JOIN wfl_status_log_responsibles on wfl_status_log_responsibles.status_log_id_slr = id_psl
                    LEFT JOIN wfl_status_responsibles on responsible_id_slr = id_sre		
                    LEFT JOIN sec_users on user_id_sre = id_usr
                    LEFT JOIN wfl_project_budgets on status_log_id_prb = id_psl
                    LEFT JOIN wfl_project_real_budgets on status_log_id_reb = id_psl
                    LEFT JOIN wfl_project_status on id_pst = status_id_psl
                    left join wfl_project_points on status_log_id_prp = id_psl
                    where deleted_pro != 1
                    and keyword_pst = ".$ci->db->escape($keyword)."
                    GROUP BY id_psl
            ) status_log on status_log.project_id_psl = id_pro
            WHERE
            deleted_pro != 1
            
            ) projects
            WHERE
            deleted_pro != 1
            ".$contractIdFilter."
            ".$yearFilter."
            GROUP BY projects.year
        ";
//         echo"<pre>";var_dump($sql);exit;
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    private static function _getStatusQuantityDetailByYearColumns($columnType)
    {
        $monthList = array(
            1 => 'january',
            2 => 'february',
            3 => 'march',
            4 => 'april',
            5 => 'may',
            6 => 'june',
            7 => 'july',
            8 => 'august',
            9 => 'september',
            10 => 'october',
            11 => 'november',
            12 => 'december'
        );
        $response = '';
        switch($columnType)
        {
            case 'countId':
                $col = "count(CASE WHEN month = {monthInt} THEN id_pro END) '{monthString}'";
                break;
            case 'entryPoints':
                $col = "IFNULL(sum(CASE WHEN month = {monthInt} THEN IFNULL(points_pro, 0) END), 0) '{monthString}'";
                break;
            case 'entryDistance':
                $col = "IFNULL(sum(CASE WHEN month = {monthInt} THEN IFNULL(distance_pro, 0) END), 0) '{monthString}'";
                break;
            case 'countAsBuiltPoints':
            case 'countDigitizationPoints':
                $col = "count(CASE WHEN month = {monthInt} THEN id_prp END) '{monthString}'";
                break;
            case 'asBuiltPoints':
            case 'digitizationPoints':
                $col = "IFNULL(sum(CASE WHEN month = {monthInt} THEN IFNULL(points_quantity_prp, 0) END), 0) '{monthString}'";
                break;
            case 'asBuiltDistance':
            case 'digitizationDistance':
                $col = "IFNULL(sum(CASE WHEN month = {monthInt} THEN IFNULL(distance_prp, 0) END), 0) '{monthString}'";
                break;
            case 'countBudgets':
                $col = "count(CASE WHEN month = {monthInt} THEN projects.id_prb END) '{monthString}'";
                break;
            case 'sumDesignBudget':
                $col = "IFNULL(sum(CASE WHEN month = {monthInt} THEN IFNULL(projects.design_prb,0) END), 0) '{monthString}'";
                break;
            case 'sumBuildingBudget':
                $col = "IFNULL(sum(CASE WHEN month = {monthInt} THEN IFNULL(projects.building_prb,0) END), 0) '{monthString}'";
                break;
            case 'sumTransportationBudget':
                $col = "IFNULL(sum(CASE WHEN month = {monthInt} THEN IFNULL(projects.transportation_prb,0) END), 0) '{monthString}'";
                break;
            case 'sumLiveLineBudget':
                $col = "IFNULL(sum(CASE WHEN month = {monthInt} THEN IFNULL(projects.live_line_prb,0) END), 0) '{monthString}'";
                break;
            case 'sumRightOfWayBudget':
                $col = "IFNULL(sum(CASE WHEN month = {monthInt} THEN IFNULL(projects.right_of_way_prb,0) END), 0) '{monthString}'";
                break;
            case 'sumBudget':
                $col = "IFNULL(sum(CASE WHEN month = {monthInt} THEN IFNULL(projects.total_budget,0) END), 0) '{monthString}'";
                break;
            case 'countRealBudgets':
                $col = "count(CASE WHEN month = {monthInt} THEN projects.id_reb END) '{monthString}'";
                break;
            case 'sumDesignRealBudget':
                $col = "IFNULL(sum(CASE WHEN month = {monthInt} THEN IFNULL(projects.design_reb,0) END), 0) '{monthString}'";
                break;
            case 'sumBuildingRealBudget':
                $col = "IFNULL(sum(CASE WHEN month = {monthInt} THEN IFNULL(projects.building_reb,0) END), 0) '{monthString}'";
                break;
            case 'sumTransportationRealBudget':
                $col = "IFNULL(sum(CASE WHEN month = {monthInt} THEN IFNULL(projects.transportation_reb,0) END), 0) '{monthString}'";
                break;
            case 'sumLiveLineRealBudget':
                $col = "IFNULL(sum(CASE WHEN month = {monthInt} THEN IFNULL(projects.live_line_reb,0) END), 0) '{monthString}'";
                break;
            case 'sumRightOfWayRealBudget':
                $col = "IFNULL(sum(CASE WHEN month = {monthInt} THEN IFNULL(projects.right_of_way_reb,0) END), 0) '{monthString}'";
                break;
            case 'sumRealBudget':
                $col = "IFNULL(sum(CASE WHEN month = {monthInt} THEN IFNULL(projects.total_real_budget,0) END), 0) '{monthString}'";
                break;
            default:
                exit('column type needs to be passed.');
        }
        foreach($monthList as $int => $string)
        {
            $currentColumn = $col;
            $currentColumn = str_replace("{monthInt}", $int, $currentColumn);
            $currentColumn = str_replace("{monthString}", $string, $currentColumn);
            $response .= $int == 12?$currentColumn:$currentColumn.",\n";
        }
        return $response;
    }

    private static function _mainListFromFilter($list)
    {
        $ci = &get_instance();
        $ci->load->database();
        $mainList = " wfl_projects ";
        if($list != "allProjects")
        {
            $mainList = " (
							select 		
							    entry_date entry_date_main_list,				
                                wfl_projects.*
							from 
                                wfl_project_status_log
							RIGHT JOIN(
                                SELECT			
                                    project_id_psl project_id,
                                    max(manual_entry_date_psl) entry_date
                                FROM
                                    wfl_project_status_log
                                LEFT JOIN wfl_project_status on id_pst = status_id_psl
                                WHERE
                                keyword_pst = ".$ci->db->escape($list)."
                                and deleted_psl != 1
                                
                                GROUP BY project_id_psl
							) as filter on filter.entry_date = manual_entry_date_psl and filter.project_id = project_id_psl
							LEFT JOIN wfl_projects on id_pro = project_id_psl				
							LEFT JOIN wfl_project_status on id_pst = status_id_psl				
							where deleted_pro != 1
							and keyword_pst = ".$ci->db->escape($list)."
							GROUP BY id_psl
							)
							wfl_projects ";
        }

        return $mainList;
    }

    public static function getAllProject()
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        select * from wfl_projects where ".static::notDeleted()."
        ";
        $query = $ci->db->query($sql);
        $result = static::recastArray(get_called_class(), $query->result());
        return $result;
    }

    public static function projectCurrentStatusSummary($system = "", $management = "", $contractId = "")
    {
        $ci = &get_instance();
        $ci->load->database();

        $systemFilter = $system == ""?"":" and system_pro = ".$ci->db->escape($system);
        $managementFilter = $management == ""?"":" and management_by_pro = ".$ci->db->escape($management);
        $contractIdFilter = $contractId == ""?"":" and contract_id_pro = ".$ci->db->escape($contractId);

        $sql = "
        SELECT
            -- order_pst,
            status_name_pst status_name,
            keyword_pst keyword,
            count(id_pro) total_projects,	
            sum(IFNULL(design_prb,0) + IFNULL(building_prb,0) + IFNULL(transportation_prb,0) + IFNULL(live_line_prb,0) + IFNULL(right_of_way_prb,0)) approved_budgets,
	        sum(IFNULL(design_reb,0) + IFNULL(building_reb,0) + IFNULL(transportation_reb,0) + IFNULL(live_line_reb,0) + IFNULL(right_of_way_reb,0)) real_budgets
        FROM
            wfl_projects
        LEFT JOIN wfl_project_status on id_pst = status_pro
        LEFT JOIN (
        SELECT
            wfl_project_status_log.*
        FROM
            wfl_project_status_log
        RIGHT JOIN (
            SELECT
                project_id_psl project_id,
                max(manual_entry_date_psl) entry_date
            FROM
                wfl_project_status_log
            LEFT JOIN wfl_project_status ON id_pst = status_id_psl
            WHERE
                keyword_pst in ('approved', 'schedule')
            AND deleted_psl != 1
            GROUP BY
                project_id_psl
        ) AS filter ON filter.entry_date = manual_entry_date_psl
            AND filter.project_id = project_id_psl
        ) log_approved_budget on log_approved_budget.project_id_psl = id_pro
        LEFT JOIN wfl_project_budgets on log_approved_budget.id_psl = status_log_id_prb
        
        LEFT JOIN (
        SELECT
            wfl_project_status_log.*
        FROM
            wfl_project_status_log
        RIGHT JOIN (
            SELECT
                project_id_psl project_id,
                max(manual_entry_date_psl) entry_date
            FROM
                wfl_project_status_log
            LEFT JOIN wfl_project_status ON id_pst = status_id_psl
            WHERE
                keyword_pst = 'conciliation_shipment'
            AND deleted_psl != 1
            GROUP BY
                project_id_psl
        ) AS filter ON filter.entry_date = manual_entry_date_psl
            AND filter.project_id = project_id_psl
        ) log_conciliation_shipment_budget on log_conciliation_shipment_budget.project_id_psl = id_pro
        LEFT JOIN wfl_project_real_budgets on log_conciliation_shipment_budget.id_psl = status_log_id_reb
        
        WHERE
        deleted_pro != 1
        ".$systemFilter."
        ".$managementFilter."
        ".$contractIdFilter."
        GROUP BY keyword_pst
        ORDER BY order_pst
        ";
//        echo"<pre>";var_dump($sql);exit;
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public static function getProjectFullDetail($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            select 
              ".static::TABLE_NAME.".*,
              cre_fiscal.*,
              keyword_pst
            from
              ".static::TABLE_NAME."
            left join sec_users cre_fiscal on id_usr = cre_fiscal_pro
            left join wfl_project_status on id_pst = status_pro
            where
            id_pro = ".$ci->db->escape($projectId)."            
            and ".static::notDeleted()."
        ";

        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result;
    }

    private function _setProjectPercentageProgress($status)
    {
        $statusProgress = array(
            46 => 0,
            2 => 10,
            10 => 20,
            11 => 25,
            21 => 30,
            29 => 40,
            32 => 70,
            47 => 80,
            33 => 85,
            35 => 90,
            39 => 95,
            44 => 100
        );

        if(isset($statusProgress[$status]))
        {
            $this->_projectPercentage = $statusProgress[$status];
        }
    }

    public function setStatus($statusId)
    {
        parent::setStatus($statusId);
        $this->_setProjectPercentageProgress($statusId);
    }
    
    public static function prepareCurrentStatusSummaryArray($system = "", $management = "", $contract = "")
    {
        $currentStatusSummary = Model_project::projectCurrentStatusSummary($system, $management, $contract);
        $arrayData = array();
        $totalApprovedBudget = 0;
        $totalRealBudget = 0;
        $totalProjects = 0;
        $ignoredKeywordsBudgets = array("canceled", "ready_to_send", "already_sent");
        foreach ($currentStatusSummary as $summary)
        {
            $totalApprovedBudget += array_search($summary["keyword"], $ignoredKeywordsBudgets) === FALSE?$summary["approved_budgets"]:"0";
            $totalRealBudget += array_search($summary["keyword"], $ignoredKeywordsBudgets) === FALSE?$summary["real_budgets"]:"0";
            $totalProjects += $summary["total_projects"];
            $arrayData[] = array(
                "keyword" => $summary["keyword"],
                "statusName" => $summary["status_name"],
                "totalProjects" => $summary["total_projects"],
                "approvedBudgets" => number_format($summary["approved_budgets"],2),
                "realBudgets" => number_format($summary["real_budgets"],2)
            );
        }
        $response["success"] = 1;
        $response["data"]["list"] = $arrayData;
        $response["data"]["totalApprovedBudgets"] = number_format($totalApprovedBudget,2);
        $response["data"]["totalRealBudgets"] = number_format($totalRealBudget,2);
        $response["data"]["totalProjects"] = $totalProjects;

        return $response;
    }
    
    public static function prepareExecutiveSummaryArray($system = "", $management = "", $contract = "")
    {
        $contractAmount = 0;
        $contractList = Model_contract::getAll(100, 0);
        foreach ($contractList as $stdClass)
        {
            $contractAmount += $stdClass->amount_con;
            if($stdClass->id_con == $contract)
            {
                $contractAmount = $stdClass->amount_con;
                break;
            }
        }
        $currentStatusSummary = Model_project::projectCurrentStatusSummary($system, $management, $contract);
        $reportSections = array(
//            "recentlyCreated" => array("title" => "Solo registro", "section" => "recentlyCreated", "keywords" => array("project_has_been_created")),
//            "readyToDesign" => array("title" => "Listo para diseño", "section" => "readyToDesign", "keywords" => array("design"), "keywordStringList" => "design"),
            "design" => array("title" => "Diseño", "section" => "design", "keywords" => array("stakes", "digitization", "drawing"), "keywordStringList" => "stakes,digitization,drawing"),
            "alreadySent" => array("title" => "Aprobacion", "section" => "alreadySent",  "keywords" => array("schedule", "ready_to_send", "already_sent"), "keywordStringList" => "schedule,ready_to_send,already_sent"),
            "inProgress" => array("title" => "Construccion", "section" => "inProgress", "keywords" => array("assign_to", "approved", "in_progress", "paused","stopped"), "keywordStringList" => "assign_to,approved,in_progress,paused,stopped"),
            "closure" => array("title" =>"Cierre", "section" => "closure", "keywords" => array("completed", "project_energized", "as_built","conciliation_reception", "conciliation_shipment","cre_return_order"), "keywordStringList" => "completed,project_energized,as_built,conciliation_reception,conciliation_shipment, cre_return_order"),
            "closed" => array("title" => "Cerrado", "section" => "closed", "keywords" => array("project_return_materials","project_real_budget_confirmation", "project_closed", "payment_order_has_been_settled"), "keywordStringList" => "project_return_materials,project_real_budget_confirmation,project_closed,payment_order_has_been_settled")
        );
        $groupList = array();
        $totalProjects = 0;
        $totalApprovedBudget = 0;
        $totalApprovedBudgetBySection = 0;
        $totalRealBudget = 0;
        $totalProjectsBySection = 0;
        $ignoredKeywordsBudgets = array("canceled", "ready_to_send", "already_sent");
        foreach ($reportSections as $groupKey => $data)
        {
            $groupKeywords =  $data["keywords"];
            for($i = 0; $i < count($groupKeywords); $i++)
            {
                for($j = 0; $j < count($currentStatusSummary); $j++)
                {
                    if($groupKeywords[$i] == $currentStatusSummary[$j]["keyword"])
                    {
                        $groupList[] = $currentStatusSummary[$j];
                        $totalProjectsBySection += $currentStatusSummary[$j]["total_projects"];
                        $totalProjects += $currentStatusSummary[$j]["total_projects"];
                        $totalApprovedBudgetBySection += $currentStatusSummary[$j]["keyword"] !="canceled"?$currentStatusSummary[$j]["approved_budgets"]:"0";
                        $totalApprovedBudget += array_search($currentStatusSummary[$j]["keyword"],$ignoredKeywordsBudgets) === FALSE?$currentStatusSummary[$j]["approved_budgets"]:"0";
                        $totalRealBudget += array_search($currentStatusSummary[$j]["keyword"],$ignoredKeywordsBudgets) === FALSE?$currentStatusSummary[$j]["real_budgets"]:"0";
                    }
                }
            }

            $reportSections[$groupKey]["list"] = $groupList;
            $reportSections[$groupKey]["totalProjectsBySection"] = $totalProjectsBySection;
            $reportSections[$groupKey]["totalApprovedBudgetBySection"] = $totalApprovedBudgetBySection;
            $reportSections[$groupKey]["totalRealBudget"] = $totalRealBudget;

            $groupList = array();
            $totalProjectsBySection = 0;
            $totalApprovedBudgetBySection = 0;
            $totalRealBudget = 0;
        }

        $totalPercentageProjects = 0;
        $totalPercentageApprovedBudget = 0;
        $totalContractAmountPercentage = 0;
        $ignoredSectionBudgets = array("alreadySent");
        foreach ($reportSections as $groupKey => $data)
        {
            $totalProjectsBySection = $reportSections[$groupKey]["totalProjectsBySection"];
            $totalPercentageProjectsBySection = $totalProjectsBySection <= 0?0:($totalProjectsBySection*100) / $totalProjects;
            $reportSections[$groupKey]["totalPercentageProjectsBySection"] = number_format($totalPercentageProjectsBySection,2);
            $totalPercentageProjects += $totalPercentageProjectsBySection;

            $totalApprovedBudgetBySection = $reportSections[$groupKey]["totalApprovedBudgetBySection"];
            $reportSections[$groupKey]["totalApprovedBudgetBySection"] = number_format($reportSections[$groupKey]["totalApprovedBudgetBySection"],2);
            $totalPercentageApprovedBudgetBySection = $totalApprovedBudgetBySection <= 0?0:($totalApprovedBudgetBySection*100) / $totalApprovedBudget;
            //No sum alreadySent section
            $totalPercentageApprovedBudgetBySection = array_search($reportSections[$groupKey]["section"],$ignoredSectionBudgets) === FALSE?$totalPercentageApprovedBudgetBySection:0;
            $reportSections[$groupKey]["totalPercentageApprovedBudgetBySection"] = number_format($totalPercentageApprovedBudgetBySection,2);
            $totalPercentageApprovedBudget += $totalPercentageApprovedBudgetBySection;

            $contractAmountPercentageBySection = $totalApprovedBudgetBySection <= 0?0:($totalApprovedBudgetBySection*100) / $contractAmount;
            //No sum alreadySent section
            $contractAmountPercentageBySection = array_search($reportSections[$groupKey]["section"],$ignoredSectionBudgets) === FALSE?$contractAmountPercentageBySection:0;
            $totalContractAmountPercentage += $contractAmountPercentageBySection;
            $reportSections[$groupKey]["contractAmountPercentageBySection"] = number_format($contractAmountPercentageBySection, 2);
        }
        $response["success"] = 1;
        $response["totalProjects"] = $totalProjects;
        $response["totalPercentageProjects"] = $totalPercentageProjects;
        $response["totalApprovedBudget"] = number_format($totalApprovedBudget, 2);
        $response["totalPercentageApprovedBudget"] = $totalPercentageApprovedBudget;
        $response["totalContractAmountPercentage"] = number_format($totalContractAmountPercentage, 2);
        $response["totalContractAmount"] = number_format($contractAmount);
        $response["list"] = array_values($reportSections);

        return $response;
    }

    public static function prepareProjectTotalsTableArray($year = "", $dataType = "", $contractId = "")
    {
        $response = array();
        $statusList = array(
            'project_has_been_created' => 'INGRESADOS',
            'already_sent' => 'DISEÑADOS',
            'approved' => 'APROBADOS',
            'completed' => 'CONSTRUIDOS', 
            'as_built' => 'AS BUILT',
            'conciliation_shipment' => 'CONCILIADOS',
            'project_real_budget_confirmation' => 'CON # ORDEN');
        $projectTotalsList = array();
        foreach ($statusList as $keyword => $criteria)
        {
            $keywordFilter = $dataType == "countId"?$keyword:"approved";
            $data = Model_project::getStatusQuantityDetailByYear($keywordFilter, $year, $dataType, $keyword, $contractId);
            //this method eval if the response has more than 1 result, if so then the result are stored in an unique array

            $data = static::_sumData($data);
            if(count($data) >= 1)
            {
                $data = PublicController::array_unshift_assoc($data[0], 'criteria', $criteria);
                $data = PublicController::array_unshift_assoc($data, 'criteriaKeyword', $keyword);
            }
            else
            {
                $data[0] = array('january' => 0, 'february' => 0, 'march' => 0, 'april' => 0, 'may' => 0, 'june' => 0, 'july' => 0, 'august' => 0, 'september' => 0, 'october' => 0, 'november' => 0, 'december' => 0);
                $data = PublicController::array_unshift_assoc($data[0], 'criteria', $criteria);
                $data = PublicController::array_unshift_assoc($data, 'criteriaKeyword', $keyword);
            }
            $data['total'] = $data['january'] + $data['february'] + $data['march'] + $data['april'] + $data['may'] + $data['june'] + $data['july'] + $data['august'] + $data['september'] + $data['october'] + $data['november'] + $data['december'];
            $projectTotalsList[] = static::_formatTotalTable($data, $dataType);
        }
        $response["success"] = 1;
        $response["data"] = $projectTotalsList;
        return $response;
    }

    private static function _sumData($data = array())
    {

        if(count($data) > 1)
        {
            $result = array();
            $result["year"] = "";
            $result['january'] = 0;
            $result['february'] = 0;
            $result['march'] = 0;
            $result['april'] = 0;
            $result['may'] = 0;
            $result['june'] = 0;
            $result['july'] = 0;
            $result['august'] = 0;
            $result['september'] = 0;
            $result['october'] = 0;
            $result['november'] = 0;
            $result['december'] = 0;

            foreach ($data as $key => $value)
            {
                $result['january'] += $value['january'];
                $result['february'] += $value['february'];
                $result['march'] += $value['march'];
                $result['april']  += $value['april'];
                $result['may'] += $value['may'];
                $result['june'] += $value['june'];
                $result['july'] += $value['july'];
                $result['august'] += $value['august'];
                $result['september'] += $value['september'];
                $result['october'] += $value['october'];
                $result['november'] += $value['november'];
                $result['december'] += $value['december'];
            }
            $data = array($result);
        }

        return $data;
    }

    private static function _formatTotalTable($result = array(), $dataType)
    {
        if($dataType == "sumBudget")
        {
            foreach ($result as $key => $value)
            {
                if($key != "criteriaKeyword" && $key != "criteria" && $key != "year")
                {
                    $result[$key] = number_format($result[$key], 2);
                }
            }
        }
        return $result;
    }

    public static function creFiscalProjectStatusReminder()
    {
        $statusList = array("already_sent", "as_built", "conciliation_shipment");
        $workFlowDetail = Model_project::getWorkflowDetail();
        $creFiscalList = Model_user::getByRoleKeyword('cre_fiscal');


        $reminderList = array();
        foreach ($workFlowDetail as $row)
        {
            $isInArray = array_search($row["keyword_pst"], $statusList);

            if($isInArray !== FALSE)
            {
//                            echo"<pre>";var_dump($isInArray);exit;
                foreach ($creFiscalList as $user)
                {
                    /** @var  $user Model_user */
                    if ($user->getId() == $row["cre_fiscal_id"])
                    {
                        $reminderList[$user->getId()]['creFiscalFullName'] = $user->getFullName();
                        $reminderList[$user->getId()]['creFiscalEmail'] = $user->getEmail();
                        $reminderList[$user->getId()]['statusListToNotify'][$row['keyword_pst']][] = $row;
                    }
                }
            }
        }
        return $reminderList;
    }

    public static function sereboFiscalProjectStatusReminder()
    {
        $statusList = array("assign_to","in_progress","paused","completed", "project_energized","cre_return_order","project_return_materials","conciliation_reception");
        $workFlowDetail = Model_project::getWorkflowDetail();
        $sereboFiscalList = Model_user::getByRoleKeyword('fiscal');

        $reminderList = array();
        foreach ($workFlowDetail as $row)
        {
            $isInArray = array_search($row["keyword_pst"], $statusList);

            if($isInArray !== FALSE)
            {

                foreach ($sereboFiscalList as $user)
                {
//                    echo"<pre>";var_dump($isInArray,$row);exit;
                    /** @var  $user Model_user */
                    if ($user->getId() == $row["fiscal_responsible_id"])
                    {
                        $reminderList[$user->getId()]['sereboFiscalFullName'] = $user->getFullName();
                        $reminderList[$user->getId()]['sereboFiscalEmail'] = $user->getEmail();
                        //If the project is on status energized then let's put it in completed group.
                        switch ($row['keyword_pst'])
                        {
                            case "project_energized"://Energized projects will be attached to completed
                                if(!isset($reminderList[$user->getId()]['statusListToNotify']['completed']))
                                    $reminderList[$user->getId()]['statusListToNotify']['completed'] = array();
                                $reminderList[$user->getId()]['statusListToNotify']['completed'][] = $row;
                                break;
                            case "project_return_materials":
                                $reminderList["allReturnedMaterials"]['sereboFiscalFullName'][$user->getId()] = $user->getFullName();
                                $reminderList["allReturnedMaterials"]['sereboFiscalEmail'][$user->getId()] = $user->getEmail();
                                if(!isset($reminderList["allReturnedMaterials"]['statusListToNotify']['project_return_materials']))
                                    $reminderList["allReturnedMaterials"]['statusListToNotify']['project_return_materials'] = array();
                                $reminderList["allReturnedMaterials"]['statusListToNotify']['project_return_materials'][] = $row;
                                break;
                            case "paused":
                                $reminderList["allPaused"]['sereboFiscalFullName'][$user->getId()] = $user->getFullName();
                                $reminderList["allPaused"]['sereboFiscalEmail'][$user->getId()] = $user->getEmail();
                                if(!isset($reminderList["allPaused"]['statusListToNotify']['paused']))
                                    $reminderList["allPaused"]['statusListToNotify']['paused'] = array();
                                $reminderList["allPaused"]['statusListToNotify']['paused'][] = $row;
                                break;
                            default:
                                $reminderList[$user->getId()]['statusListToNotify'][$row['keyword_pst']][] = $row;
                                break;
                        }
                    }
                }
            }
        }
        return $reminderList;
    }

    public static function getAllByCreFiscalId($creFiscalId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
            select 
            wfl_projects.*, 
            wfl_project_status.*
            from 
            wfl_projects 
            left join wfl_project_status on status_pro = id_pst
            where 
            cre_fiscal_pro = ".$ci->db->escape($creFiscalId)." 
            and deleted_pro != 1
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;       
    }

    public static function getProjectsWithCoordinates()
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
            select
            wfl_projects.*, 
            wfl_project_status.*
            from 
            wfl_projects 
            left join wfl_project_status on status_pro = id_pst
            where 
            latitude_pro is not null
            and deleted_pro != 1
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;       
    }

    public static function getProductivityBaseReport($logDateRange = array(), $builderId = NULL)
    {
        $ci = &get_instance();
        $ci->load->database();
        //log date filter
        $filterLogDateFrom = "";
        if(isset($logDateRange['from']))
            $filterLogDateFrom = " and manual_entry_date_lal >= ".$ci->db->escape($logDateRange['from'])." ";
        $filterLogDateTo = "";
        if(isset($logDateRange['to']))
            $filterLogDateTo = " and manual_entry_date_lal <= ".$ci->db->escape($logDateRange['to'])." ";
        //builder filter
        $filterBuilder = "";
        if(!is_null($builderId))
		{
			$filterBuilder = " and builders_in_manpower.builders like '%".$builderId."%' ";
		}
        $sql = "
            SELECT
                id_lad,
                project_id_lad,
                code_pro,
                address_pro,
                latitude_pro,
                longitude_pro,
                id_lac,
                id_lal,
                manual_entry_date_lal,
                building_responsibles.fiscal_responsible_id,
                building_responsibles.fiscal_responsible,
                building_responsibles.builder_responsible_id,
                building_responsibles.builder_responsible,
                builders_in_manpower.builders,
                builders_in_manpower.total_builders,
                ROUND(worked_up_wus * price_wus,2) total_amount_worked_to_split,
                ROUND((worked_up_wus * price_wus)/builders_in_manpower.total_builders,2) total_amount_worked_by_builder,
                id_bpo point_id,
				label_bpo point_label,
                structure_code_bus structure_code,
                unit_of_measurement_bus structure_unit_of_measurement,
				description_bus structure_description,
				activity_lac labor_cost_activity,
				execution_lac labor_cost_execution,
                bui_worked_up_structures.*
            FROM
                bui_worked_up_structures
            LEFT JOIN bui_labor_cost on id_lac = labor_cost_id_wus
            LEFT JOIN bui_building_structures on building_structure_id_lac = id_bus
            LEFT JOIN bui_labor_details on id_lad = labor_detail_id_lac
            LEFT JOIN bui_labor_cost_log on id_lal = labor_cost_log_id_wus
            LEFT JOIN bui_building_points on point_id_lal = id_bpo
            LEFT JOIN wfl_projects on id_pro = project_id_lad
            LEFT JOIN(
                select 
                        id_psl,
                        project_id_psl,
                        status_id_psl,  
                        filter.entry_date,
                        GROUP_CONCAT(CONCAT(responsible.id_usr)) responsible_user_id,
                        GROUP_CONCAT(CONCAT(responsible.firstname_usr,' ',responsible.lastname_usr)) responsible,
                        GROUP_CONCAT(CONCAT(builder.builder_id)) builder_responsible_id,
                        GROUP_CONCAT(CONCAT(builder.builder_firstname,' ',builder.builder_lastname)) builder_responsible,
                        GROUP_CONCAT(CONCAT(fiscal.fiscal_id)) fiscal_responsible_id,
                        GROUP_CONCAT(CONCAT(fiscal.fiscal_firstname,' ',fiscal.fiscal_lastname)) fiscal_responsible
                    from 
                        wfl_project_status_log
                    RIGHT JOIN(
                        SELECT          
                            project_id_psl project_id,
                            max(manual_entry_date_psl) entry_date
                        FROM
                            wfl_project_status_log
                        WHERE       
                        status_id_psl = 29
                        and deleted_psl != 1
                        
                        GROUP BY project_id_psl
                    ) as filter on filter.entry_date = manual_entry_date_psl and filter.project_id = project_id_psl
                    
                    LEFT JOIN wfl_projects on id_pro = project_id_psl
                    LEFT JOIN wfl_status_log_responsibles on wfl_status_log_responsibles.status_log_id_slr = id_psl
                    LEFT JOIN wfl_status_responsibles on responsible_id_slr = id_sre        
                    LEFT JOIN sec_users responsible on user_id_sre = responsible.id_usr
                    LEFT JOIN (
                            SELECT
                                id_usr builder_id,
                                firstname_usr builder_firstname,
                                lastname_usr builder_lastname
                            FROM
                                sec_users
                            right JOIN sec_userroles on userid_uro = id_usr
                            where 
                                roleid_uro = 9
                            and deleted_uro != 1
                        ) as builder on builder.builder_id = user_id_sre
                    LEFT JOIN (
                            SELECT
                                id_usr fiscal_id,
                                firstname_usr fiscal_firstname,
                                lastname_usr fiscal_lastname
                            FROM
                                sec_users
                            right JOIN sec_userroles on userid_uro = id_usr
                            where 
                                roleid_uro = 8
                            and deleted_uro != 1
                        ) as fiscal on fiscal.fiscal_id = user_id_sre       
                    LEFT JOIN wfl_construction_assignments on status_log_id_cas = id_psl
                    where deleted_pro != 1 and deleted_slr != 1 -- and id_pro = 653
                    GROUP BY id_psl
            ) building_responsibles on building_responsibles.project_id_psl = project_id_lad
            LEFT JOIN (
                        select 
                            labor_cost_log_id_bim,
                            count(DISTINCT user_id_bim) total_builders,
                            GROUP_CONCAT(DISTINCT user_id_bim) builders
                        from 
                        bui_builders_in_manpower where deleted_bim != 1
                        GROUP BY labor_cost_log_id_bim
            ) builders_in_manpower on builders_in_manpower.labor_cost_log_id_bim = id_lal
            
            where 
            deleted_wus != 1
            and deleted_lal != 1
            ".$filterLogDateFrom."
            ".$filterLogDateTo."
            -- and project_id_lad = 653
            ".$filterBuilder."
            order by project_id_lad, manual_entry_date_lal
        ";
        $query = $ci->db->query($sql);//echo"<pre>";var_dump($sql);exit;
        $result = $query->result_array();
        return $result;
    }

    public static function getBuilderIndividualReport($startDate, $endDate)
    {
        $logDateRange = array('from' => $startDate, 'to' => $endDate);
        $productivityBaseReport =Model_project::getProductivityBaseReport($logDateRange);
        
        $projectList = array();
        $totalWorkedUpAmount = 0;
        $totalBuilderProductivity = 0;
        $totalDates = array();
        $totalBuilderDates = array();
        $buildersInProject = array();
        for ($i=0; $i < count($productivityBaseReport); $i++) 
        { 
            $responsibleFiscalId = $productivityBaseReport[$i]["fiscal_responsible_id"];
            $responsibleBuilderId = $productivityBaseReport[$i]["builder_responsible_id"];
            $builderIds = $productivityBaseReport[$i]["builders"];

            $builderIds = explode(",",$builderIds);
            //if($builderId == $responsibleBuilderId && array_search($responsibleBuilderId, $builderIds) !== FALSE)
            //{
                $projectId = $productivityBaseReport[$i]["project_id_lad"];
                $projectCode = $productivityBaseReport[$i]["code_pro"];
                $projectAddress = $productivityBaseReport[$i]["address_pro"];
                $projectLatitude = $productivityBaseReport[$i]["latitude_pro"];
                $projectLongitude = $productivityBaseReport[$i]["longitude_pro"];
                $logId = $productivityBaseReport[$i]["id_lal"];
                $totalAmountWorkedToSplit = $productivityBaseReport[$i]["total_amount_worked_to_split"];
                $totalAmountWorkedByBuilder = $productivityBaseReport[$i]["total_amount_worked_by_builder"];
                $manualEntryDate = $productivityBaseReport[$i]["manual_entry_date_lal"];
                $projectList[$projectId] = array(
                                "id" => $projectId,
                                "code" => $projectCode,
                                "address"=> $projectAddress,
                                "latitude" => $projectLatitude,
                                "longitude" => $projectLongitude,
                                "fiscalIdAssigned" => $responsibleFiscalId,
                                "builderIdAssigned" => $responsibleBuilderId
                                );
                $totalWorkedUpAmount += $totalAmountWorkedToSplit;
                $totalBuilderProductivity += $totalAmountWorkedByBuilder;
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $manualEntryDate);
                $date = $date->format('Y-m-d');
                $totalDates[$date] = $date;
                foreach ($builderIds as $id) 
                {
                    if(!isset($buildersInProject[$id]))
                    {
                        $buildersInProject[$id]['totalWorked'] = 0;
                        $buildersInProject[$id]['totalWorkedAsSupport'] = 0;
                        // $buildersInProject[$id]['totalDatesInProject'][] = array();
                    }
                    if($id == $responsibleBuilderId)
                        $buildersInProject[$id]['totalWorked'] += $totalAmountWorkedByBuilder;
                    else
                        $buildersInProject[$id]['totalWorkedAsSupport'] += $totalAmountWorkedByBuilder;
                    $buildersInProject[$id]['totalDatesInProject'][$date] = $date;
                }
                
                if(!isset($productivityBaseReport[$i+1]) || $projectId != $productivityBaseReport[$i+1]['project_id_lad'])
                {
                    $projectList[$projectId]['totalWorkedUpAmount'] = $totalWorkedUpAmount;
                    $projectList[$projectId]['totalBuilderProductivity'] = $totalBuilderProductivity;
                    $projectList[$projectId]['totalDates'] = count(array_values($totalDates));
                    $projectList[$projectId]['allBuilders'] = $buildersInProject;
                    $totalWorkedUpAmount = 0;
                    $totalAmountWorkedByBuilder = 0;
                    $totalDates = array();
                    $buildersInProject = array();
                }
            //}
        }

        return $projectList;
    }    

    public static function productionGeneralSummary($logDateRange = array())
    {
        $ci = &get_instance();
        $ci->load->database();
        //log date filter
        $filterLogDateFrom = "";
        if(isset($logDateRange['from']))
            $filterLogDateFrom = " and manual_entry_date_lal >= ".$ci->db->escape($logDateRange['from'])." ";
        $filterLogDateTo = "";
        if(isset($logDateRange['to']))
            $filterLogDateTo = " and manual_entry_date_lal <= ".$ci->db->escape($logDateRange['to'])." ";
        $sql = "
            SELECT
                code_pro codigo,
                status_name_pst estado,
                sum(ROUND(worked_up_wus * price_wus,2)) produccion_actual,
                IFNULL(design_prb,0) design_prb,
                (IFNULL(design_prb,0) + IFNULL(building_prb,0) + IFNULL(transportation_prb,0) + IFNULL(live_line_prb,0) + IFNULL(right_of_way_prb,0)) as importe_aprobado,
                IFNULL(design_reb,0) design_reb,
                (IFNULL(design_reb,0) + IFNULL(building_reb,0) + IFNULL(transportation_reb,0) + IFNULL(live_line_reb,0) + IFNULL(right_of_way_reb,0)) as importe_real,
                in_progress_responsible.fiscal_responsible,
                in_progress_responsible.builder_responsible
            FROM
                bui_worked_up_structures
            LEFT JOIN bui_labor_cost on id_lac = labor_cost_id_wus
            LEFT JOIN bui_building_structures on building_structure_id_lac = id_bus
            LEFT JOIN bui_labor_details on id_lad = labor_detail_id_lac
            LEFT JOIN bui_labor_cost_log on id_lal = labor_cost_log_id_wus
            LEFT JOIN bui_building_points on point_id_lal = id_bpo
            LEFT JOIN wfl_projects on id_pro = project_id_lad
            LEFT JOIN (
                select 
                    wfl_project_status_log.* 
                from 
                (
                    SELECT          
                        project_id_psl project_id,
                        status_id_psl,
                        max(manual_entry_date_psl) entry_date
                    FROM
                        wfl_project_status_log
                    WHERE       
                        1=1
                        and status_id_psl = 11
                        and deleted_psl != 1
                    GROUP BY project_id_psl
                ) as approved_status 
                LEFT JOIN wfl_project_status_log on approved_status.entry_date = manual_entry_date_psl and approved_status.project_id = project_id_psl
            ) approved_budget on approved_budget.project_id_psl = id_pro
            left join wfl_project_budgets on status_log_id_prb = approved_budget.id_psl
            LEFT JOIN (
                select 
                    wfl_project_status_log.* 
                from 
                (
                    SELECT          
                        project_id_psl project_id,
                        status_id_psl,
                        max(manual_entry_date_psl) entry_date
                    FROM
                            wfl_project_status_log
                    WHERE       
                    1=1
                    and status_id_psl = 45
                    and deleted_psl != 1
                    GROUP BY project_id_psl
                ) as rb_status 
                LEFT JOIN wfl_project_status_log on rb_status.entry_date = manual_entry_date_psl and rb_status.project_id = project_id_psl                   
            ) real_budget on real_budget.project_id_psl = id_pro
                        LEFT JOIN (
                            select 
                                id_psl,
                                project_id_psl,
                                filter.entry_date,
                                GROUP_CONCAT(CONCAT(fiscal.fiscal_firstname,' ',fiscal.fiscal_lastname)) fiscal_responsible,
                                GROUP_CONCAT(CONCAT(builder.builder_firstname,' ',builder.builder_lastname)) builder_responsible
                            from 
                                wfl_project_status_log
                            RIGHT JOIN(
                                            SELECT          
                                                    project_id_psl project_id,
                                                    max(manual_entry_date_psl) entry_date
                                            FROM
                                                    wfl_project_status_log
                                            WHERE       
                                            status_id_psl = 29
                                            and deleted_psl != 1
                                            
                                            GROUP BY project_id_psl
                            ) as filter on filter.entry_date = manual_entry_date_psl and filter.project_id = project_id_psl
                            LEFT JOIN wfl_projects on id_pro = project_id_psl
                            LEFT JOIN wfl_status_log_responsibles on wfl_status_log_responsibles.status_log_id_slr = id_psl
                            LEFT JOIN wfl_status_responsibles on responsible_id_slr = id_sre        
                            LEFT JOIN sec_users responsible on user_id_sre = responsible.id_usr
                            LEFT JOIN (
                                                    SELECT
                                                            id_usr builder_id,
                                                            firstname_usr builder_firstname,
                                                            lastname_usr builder_lastname
                                                    FROM
                                                            sec_users
                                                    right JOIN sec_userroles on userid_uro = id_usr
                                                    where 
                                                            roleid_uro = 9
                                                    and deleted_uro != 1
                                            ) as builder on builder.builder_id = user_id_sre
                            LEFT JOIN (
                                                    SELECT
                                                            id_usr fiscal_id,
                                                            firstname_usr fiscal_firstname,
                                                            lastname_usr fiscal_lastname
                                                    FROM
                                                            sec_users
                                                    right JOIN sec_userroles on userid_uro = id_usr
                                                    where 
                                                            roleid_uro = 8
                                                    and deleted_uro != 1
                                            ) as fiscal on fiscal.fiscal_id = user_id_sre
                            where deleted_pro != 1 and deleted_slr != 1
                            GROUP BY id_psl
                            ORDER BY project_id_psl
                        ) as in_progress_responsible on in_progress_responsible.project_id_psl = id_pro
            left join wfl_project_real_budgets on status_log_id_reb = real_budget.id_psl
            left join wfl_project_status on status_pro = id_pst
            where 
             deleted_wus != 1
            and deleted_lal != 1
            ".$filterLogDateFrom."
            ".$filterLogDateTo."
            GROUP BY project_id_lad
        ";
        $query = $ci->db->query($sql);//echo"<pre>";var_dump($sql);exit;
        $result = $query->result_array();
        return $result;
    }

    public static function allProjectsLog()
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
            SELECT
                code_pro project_code,
                DATE_FORMAT(manual_entry_date_psl,'%d-%m-%Y') log_entry_date,
                status_name_pst status_name,
                log_detail_psl log_detail
            FROM
                wfl_project_status_log
            LEFT JOIN wfl_project_status ON status_id_psl = id_pst
            LEFT JOIN wfl_project_points on id_psl = status_log_id_prp
            LEFT JOIN wfl_projects on id_pro = project_id_psl
            LEFT JOIN wfl_project_budgets on id_psl = status_log_id_prb
            LEFT JOIN wfl_project_real_budgets on id_psl = status_log_id_reb
            LEFT JOIN wfl_construction_assignments on id_psl = status_log_id_cas
            LEFT JOIN sys_files mpf on manpower_file_id_prb = mpf.id_fil
            LEFT JOIN (
                SELECT
                    status_log_id_psf,
                    CONCAT('[',
                            GROUP_CONCAT(
                                CONCAT('{','\"fileName\":\"',uploadfilename_fil,'\",\"fileUrl\":\"',url_fil,'\",\"extension\":\"',extension_fil,'\"}')
                            )
                    ,']')
                     images_list
                FROM
                    wfl_project_status_files
                LEFT JOIN sys_files on id_fil = file_id_psf
                where extension_fil != 'PDF'
                GROUP BY status_log_id_psf
                ) images on id_psl = images.status_log_id_psf
            LEFT JOIN (
                SELECT
                    status_log_id_psf,
                    CONCAT('[',
                            GROUP_CONCAT(
                                CONCAT('{','\"fileName\":\"',uploadfilename_fil,'\",\"fileUrl\":\"',url_fil,'\",\"extension\":\"',extension_fil,'\"}')
                            )
                    ,']')
                     documents_list
                FROM
                    wfl_project_status_files
                LEFT JOIN sys_files on id_fil = file_id_psf
                where extension_fil = 'PDF'
                GROUP BY status_log_id_psf
                ) documents on id_psl = documents.status_log_id_psf
            LEFT JOIN (
                SELECT
                    status_log_id_slr,
                    firstname_usr,
                    lastname_usr,
                    CONCAT(firstname_usr,' ',lastname_usr) full_name
                FROM
                    wfl_status_log_responsibles
                LEFT JOIN wfl_status_responsibles on responsible_id_slr = id_sre
                LEFT JOIN sec_users on user_id_sre = id_usr 
                and deleted_slr != 1
            ) responsible on responsible.status_log_id_slr = id_psl
            WHERE
                1 = 1
                and deleted_psl != 1 and keyword_pst not in ('approvement','schedule') and deleted_pro != 1
            GROUP BY project_id_psl, log_entry_date, status_id_psl
            ORDER BY project_id_psl, log_entry_date DESC, id_psl DESC
        ";
        $query = $ci->db->query($sql);//echo"<pre>";var_dump($sql);exit;
        $result = $query->result_array();
        return $result;   
    }
}
