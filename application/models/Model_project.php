<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_project extends Model_project_base
{
    public function __construct($projectCode = "", $projectName = "", $system = NULL, $address = "", $entryDate = "", $creFiscal = "", $status = NULL, $projectStart = "", $projectEnd = "", $points = 0, $distance = 0, $managementBy = NULL, $qualityLevel = 0, $creDesignCompletionDate = "", $creBuildingCompletionDate = "", $budgetaryPosition = 0, $secondaryCode = "")
    {
        parent::__construct($projectCode, $projectName, $system, $address, $entryDate, $creFiscal, $status, $projectStart, $projectEnd, $points, $distance, $managementBy, $qualityLevel, $creDesignCompletionDate, $creBuildingCompletionDate, $budgetaryPosition, $secondaryCode);
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

    public static function getWorkflowDetail()
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        SELECT
            id_pro,
            code_pro,
            entry_date_pro,
            cre_fiscal_pro,
            system_pro,
            management_by_pro,
            points_pro,
            distance_pro,
            quality_level_pro,
            cre_design_completion_date_pro,
            cre_building_completion_date_pro,
            stakes.entry_date stake_date,	
            stakes.responsible stake_responsible,
            returned.entry_date returned_date,
            digitization.entry_date digitization_date,
            drawing.entry_date drawing_date,
            schedulee.entry_date schedule_date,
            already_sent.entry_date already_sent_date,
            approved.entry_date approved_date,
            canceled.entry_date canceled_date,
            'TO DO' rectification_date,
            approved.design_prb design_budget,
            approved.building_prb building_budget,
            approved.transportation_prb transportation_budget,
            approved.live_line_prb live_line_budget,
            approved.right_of_way_prb right_of_way_budget,
            record_building_materials.entry_date record_building_materials_date,                      
            get_materials.entry_date get_materials_date,
            deliver_materials.entry_date deliver_materials_date,
            materials_reception.entry_date materials_reception_date,
            assign_to.entry_date assign_to_date,
            assign_to.responsible assign_to_responsible,
            assign_to.live_line_cas live_line_assigned,
            assign_to.power_down_cas power_down_assigned,
            assign_to.maneuver_cas maneuver_assigned,
            assign_to.start_date_cas start_date_assigned,
            assign_to.end_date_cas end_date_assigned,
            assign_to.estimated_time_cas estimated_time_assigned,
            in_progress.entry_date in_progress_date,
            paused.entry_date paused_date,
            paused.percentage_paused percentage_paused,
            stopped.entry_date stopped_date,
            stopped.percentage_stopped percentage_stopped,
            as_built.entry_date as_built_date,
            conciliation_reception.entry_date conciliation_reception_date,
            cre_return_order.entry_date cre_return_order_date,
            project_return_materials.entry_date project_return_materials_date,
            payment_order_registered.entry_date payment_order_registered_date,
            payment_order_registered.order_number_pao payment_order_registered_order_number,
            payment_order_registered.design_budget_pop payment_order_registered_design_budget,
            payment_order_registered.transportation_budget_pop payment_order_registered_transportation_budget,
            payment_order_registered.live_line_budget_pop payment_order_registered_live_line_budget,
			payment_order_registered.building_budget_pop payment_order_registered_building_budget,
            payment_order_registered.right_of_way_budget_pop payment_order_registered_right_of_way_budget,
            payment_order_registered.total_real_budget payment_order_registered_total_real_budget,
            payment_order_registered.invoice_number_pao payment_order_registered_invoice_number,
            payment_order_invoice_sent.entry_date payment_order_invoice_sent_date,
            payment_order_has_been_settled.entry_date payment_order_has_been_settled_date
        FROM
            wfl_projects
        LEFT JOIN (".static::_statusDetailQuery(2).") stakes on stakes.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(20).") returned on returned.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(3).") digitization on digitization.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(5).") drawing on drawing.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(6).") schedulee on schedulee.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(10).") already_sent on already_sent.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(11).") approved on approved.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(12).") canceled on canceled.project_id_psl = id_pro
        LEFT JOIN (".static::_warehouseStatusDetailQuery(23).") record_building_materials on record_building_materials.project_id_war = id_pro
        LEFT JOIN (".static::_warehouseStatusDetailQuery(24).") get_materials on get_materials.project_id_war = id_pro
        LEFT JOIN (".static::_warehouseStatusDetailQuery(25).") deliver_materials on deliver_materials.project_id_war = id_pro
        LEFT JOIN (".static::_warehouseStatusDetailQuery(26).") materials_reception on materials_reception.project_id_war = id_pro
        LEFT JOIN (".static::_statusDetailQuery(21).") assign_to on assign_to.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(27).") in_progress on in_progress.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(31).") paused on paused.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(30).") stopped on stopped.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(33).") as_built on as_built.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(34).") conciliation_reception on conciliation_reception.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(35).") conciliation_shipment on conciliation_shipment.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(37).") cre_return_order on cre_return_order.project_id_psl = id_pro
        LEFT JOIN (".static::_statusDetailQuery(38).") project_return_materials on project_return_materials.project_id_psl = id_pro
        LEFT JOIN (".static::_paymentOrderStatusDetailQuery(42).") payment_order_registered on payment_order_registered.project_id_pop = id_pro
        LEFT JOIN (".static::_paymentOrderStatusDetailQuery(43).") payment_order_invoice_sent on payment_order_invoice_sent.project_id_pop = id_pro
        LEFT JOIN (".static::_paymentOrderStatusDetailQuery(44).") payment_order_has_been_settled on payment_order_has_been_settled.project_id_pop = id_pro
        ";
        echo "<pre>";var_dump($sql);exit;
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
			GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
			design_prb,
			building_prb,			
			transportation_prb,
			live_line_prb,
			right_of_way_prb,
			(IFNULL(design_prb,0) + IFNULL(building_prb,0) + IFNULL(transportation_prb,0) + IFNULL(live_line_prb,0) + IFNULL(right_of_way_prb,0)) as total_budget,
			start_date_cas,
			end_date_cas,
			estimated_time_cas,
			live_line_cas,
			power_down_cas,
			maneuver_cas,
			pauseOnIncident.percentage_inc percentage_paused,
			stopOnIncident.percentage_inc percentage_stopped
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
		LEFT JOIN sec_users on user_id_sre = id_usr
		LEFT JOIN wfl_project_budgets on status_log_id_prb = id_psl
		LEFT JOIN wfl_construction_assignments on status_log_id_cas = id_psl
		where deleted_pro != 1
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
}
