<?php
class WorkflowPaginationHandler extends BasePaginationHandler
{
	const TABLE_NAME = "workflow";
	const TABLE_ID = "id_pro";
	const ATTRIB_SUFIX = "_pro";

	public function __construct(int $limit = 100, int $offset = 0, string $orderBy = "", string $orderType = 'asc', string $textToSearch = "", array $colsArray = array())
	{
		parent::__construct($limit, $offset, $orderBy, $orderType, $textToSearch, $colsArray);
	}

	/**
	 * This method return the master detail table
	 * @return string
	 */
	protected function _coreQuery() : string
	{
		return "
			(
			
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
            status_pro project_status_id,
            status_name_pst,
            keyword_pst,
            order_pst,
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
            email_usr cre_fiscal_email,
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
               ready_to_send.entry_date ready_to_send_date,
            already_sent.entry_date already_sent_date,
            schedulee.tentative_total_budget_prb schedulee_tentative_total_budget,
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
            approved.manpower_file_id,
            '' as record_building_materials_date,
		   	'' as get_materials_date,
		   	'' as deliver_materials_date,
		   	'' as materials_reception_date,               
            assign_to.entry_date assign_to_date,
            assign_to.responsible assign_to_responsible,
            in_progress.builder_responsible builder_responsible,
            in_progress.builder_responsible_id builder_responsible_id,
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
            assign_to.project_manager_id project_manager_user_id,
            assign_to.project_manager_full_name project_manager_assigned,
            in_progress.entry_date in_progress_date,
            in_progress_first_detail.entry_date in_progress_first_detail_date,
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
            project_return_materials2.entry_date project_return_materials2_date,
            payment_order_registered.entry_date payment_order_registered_date,
            payment_order_registered.order_number_pao payment_order_registered_order_number,
            if(payment_order_registered.order_number_pao != '','Pagado','Pendiente de pago') payment_status,
            if(payment_order_registered.order_number_pao != '',payment_order_registered.design_budget_pop, conciliation_shipment.design_reb) payment_order_registered_design_budget,
            if(payment_order_registered.order_number_pao != '',payment_order_registered.building_budget_pop, conciliation_shipment.building_reb) payment_order_registered_building_budget,
            if(payment_order_registered.order_number_pao != '',payment_order_registered.transportation_budget_pop, conciliation_shipment.transportation_reb) payment_order_registered_transportation_budget,
            if(payment_order_registered.order_number_pao != '',payment_order_registered.live_line_budget_pop, conciliation_shipment.live_line_reb) payment_order_registered_live_line_budget,
            if(payment_order_registered.order_number_pao != '',payment_order_registered.right_of_way_budget_pop, conciliation_shipment.right_of_way_reb) payment_order_registered_right_of_way_budget,
            if(payment_order_registered.order_number_pao != '',payment_order_registered.total_real_budget, conciliation_shipment.total_real_budget) payment_order_registered_total_real_budget,
            payment_order_registered.invoice_number_pao payment_order_registered_invoice_number,
            payment_order_invoice_sent.entry_date payment_order_invoice_sent_date,
            payment_order_has_been_settled.entry_date payment_order_has_been_settled_date,
            CASE 
				WHEN keyword_pst in('schedule','ready_to_send','already_sent','rectify_design','rectify_illustration','rd_stakes','rd_digitization','rd_drawing','ri_digitization','ri_drawing','canceled') then if(schedulee.tentative_total_budget_prb is not null && schedulee.tentative_total_budget_prb > 0,schedulee.tentative_total_budget_prb,schedulee.design_prb)
				WHEN keyword_pst in('approved','assign_to','in_progress','paused','stopped','completed','project_energized','as_built','conciliation_reception') then approved.total_budget
				WHEN keyword_pst in('conciliation_shipment','cre_return_order','project_return_materials','project_real_budget_confirmation') then if(payment_order_registered.order_number_pao != '',payment_order_registered.total_real_budget, conciliation_shipment.total_real_budget)
			END project_current_budget,
			CASE 
				WHEN keyword_pst in('schedule','ready_to_send','already_sent','rectify_design','rectify_illustration','rd_stakes','rd_digitization','rd_drawing','ri_digitization','ri_drawing','canceled') then schedulee.design_prb
				WHEN keyword_pst in('approved','assign_to','in_progress','paused','stopped','completed','project_energized','as_built','conciliation_reception') then approved.design_prb
				WHEN keyword_pst in('conciliation_shipment','cre_return_order','project_return_materials','project_real_budget_confirmation') then if(payment_order_registered.order_number_pao != '',payment_order_registered.design_budget_pop, conciliation_shipment.design_reb)
			END project_current_design_budget,
			CASE 
				WHEN keyword_pst in('project_has_been_created','drawing','stakes','digitization','returned','schedule','ready_to_send','already_sent','rectify_design','rectify_illustration','rd_stakes','rd_digitization','rd_drawing','ri_digitization','ri_drawing','canceled') 
					then 0.00
				WHEN keyword_pst in('approved','assign_to','in_progress','paused','stopped','completed')
					then 
					FORMAT(
						(((IFNULL(production.total_bs,0) + approved.design_prb) * 100)/ approved.total_budget)
					, 2)
				WHEN keyword_pst in('project_energized','as_built','conciliation_reception','conciliation_shipment','cre_return_order','project_return_materials','project_real_budget_confirmation') 
					then 100.00
			END production_percentage,
			production.total_bs production_total_bs
        FROM
            wfl_projects
        LEFT JOIN (".Model_project::_statusDetailQuery(2).") stakes on stakes.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(16).") rd_digitization on rd_digitization.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(20).") returned on returned.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(3).") digitization on digitization.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(5).") drawing on drawing.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(6).") schedulee on schedulee.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(9).") ready_to_send on ready_to_send.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(10).") already_sent on already_sent.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(11).") approved on approved.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(12).") canceled on canceled.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(13).") rectify_design on rectify_design.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(14).") rectify_illustration on rectify_illustration.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(21).") assign_to on assign_to.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(29).") in_progress on in_progress.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(29, TRUE).") in_progress_first_detail on in_progress_first_detail.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(32).") completed on completed.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(31).") paused on paused.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(30).") stopped on stopped.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(33).") as_built on as_built.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(34).") conciliation_reception on conciliation_reception.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(35).") conciliation_shipment on conciliation_shipment.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(37).") cre_return_order on cre_return_order.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(38).") project_return_materials on project_return_materials.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(39).") project_return_materials2 on project_return_materials2.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_statusDetailQuery(47).") project_energized on project_energized.project_id_psl = id_pro
        LEFT JOIN (".Model_project::_paymentOrderStatusDetailQuery(42).") payment_order_registered on payment_order_registered.project_id_pop = id_pro
        LEFT JOIN (".Model_project::_paymentOrderStatusDetailQuery(43).") payment_order_invoice_sent on payment_order_invoice_sent.project_id_pop = id_pro
        LEFT JOIN (".Model_project::_paymentOrderStatusDetailQuery(44).") payment_order_has_been_settled on payment_order_has_been_settled.project_id_pop = id_pro
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
        LEFT JOIN (
        	SELECT
        		project_id_lad,
				sum(ROUND(worked_up_wus * price_wus,2)) total_bs
			FROM
				bui_worked_up_structures
			LEFT JOIN bui_labor_cost on id_lac = labor_cost_id_wus
			LEFT JOIN bui_building_structures on building_structure_id_lac = id_bus
			LEFT JOIN bui_labor_details on id_lad = labor_detail_id_lac
			LEFT JOIN bui_labor_cost_log on id_lal = labor_cost_log_id_wus
			LEFT JOIN bui_building_points on point_id_lal = id_bpo
			where 
			 	deleted_wus != 1
				and deleted_lal != 1 
			GROUP BY project_id_lad
        ) production on production.project_id_lad = id_pro
        where 
        deleted_pro != 1
				) ".static::TABLE_NAME."
		";
	}

	/**
	 * This method define the columns that will be used from _coreQuery
	 * @return string
	 */
	protected function _dataTableColumns() : string
	{
		return static::TABLE_NAME.".*
        ";
	}

	/**
	 * Handle the additional parameters.
	 * @return string
	 */
	protected function _additionalParameters() : string
	{
		$ci=&get_instance();
		$ci->load->database();
		$filters = $this->_additionalParameters;
		$keywordDateRange = isset($filters["keyword"]) && $filters["keyword"] != ""?$filters["keyword"]:"";
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
		if(isset($filters["id-list"]))
		{
			$idList = $filters["id-list"];
			$idList = str_replace("\r\n"," ", $idList);
			$idList = str_replace(" ",PHP_EOL, $idList);
			$idList = explode(PHP_EOL, $idList);
			$idList = array_values(array_filter($idList));
			$idListFilter = "";
			foreach ($idList as $id)
			{
				$idListFilter .= $ci->db->escape($id).", ";
			}
			$idListFilter = substr($idListFilter,0, -2);
			if($idListFilter != "")
			{
				$sql .= " and id_pro in (".$idListFilter.") ";
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
		if(isset($filters["system"]) && $filters["system"] != "")
		{
			$system = $filters["system"];
			$sql .= " and system_pro = ".$ci->db->escape($system)." ";
		}
		if(isset($filters["management-by"]) && $filters["management-by"] != "")
		{
			$management = $filters["management-by"];
			$sql .= " and management_by_pro = ".$ci->db->escape($management)." ";
		}
		// echo"<pre>";var_dump($sql);exit;
		return $sql;
	}

	/**
	 * Return the single data to draw the Select2 component
	 * @param int $page
	 * @return array
	 */
	public function getResponseForSelect2(int $page) : array
	{
		$objects = $this->search();
		$recordsFiltered = $this->searchTotalCount();
		$resultArray = array();
		$list = array();

		foreach ($objects as $row)
		{
			$list[] = array(
				"id" => $row->id_pro,
				"text" => $row->code_pro
			);
		}

		$moreResults = ($page * $this->_limit) < $recordsFiltered;
		$resultArray['list'] = $list;
		$resultArray['pagination'] = array("more" => $moreResults);
		return $resultArray;
	}
}
