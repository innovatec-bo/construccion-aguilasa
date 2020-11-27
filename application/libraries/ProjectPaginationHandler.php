<?php
class ProjectPaginationHandler extends BasePaginationHandler
{
	const TABLE_NAME = "wfl_projects";
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
					wfl_projects.*,
					status_name_pst,
					keyword_pst,
					IFNULL(percentage_inc,0) percentage_inc,
					detail_inc,
					order_pst,
					status_log_manual_entry_date.manual_entry_date_psl,
					status_log_manual_entry_date.responsible,
					status_log_manual_entry_date.responsible_ids,
					status_log_manual_entry_date.fiscal_responsible,
					status_log_manual_entry_date.fiscal_responsible_id,
					status_log_manual_entry_date.builder_responsible,
					status_log_manual_entry_date.builder_responsible_ids,
					manpower.manpower_file_id,
					status_log_manual_entry_date.id_psl,
					id_war,
					design_prb design_budget,
					building_prb building_budget,			
					transportation_prb transportation_budget,
					live_line_prb live_line_budget,
					right_of_way_prb right_of_way_budget,
					(IFNULL(design_prb,0) + IFNULL(building_prb,0) + IFNULL(transportation_prb,0) + IFNULL(live_line_prb,0) + IFNULL(right_of_way_prb,0)) as total_budget,
					design_reb design_real_budget,
					building_reb building_real_budget,
					transportation_reb transportation_real_budget,
					live_line_reb live_line_real_budget,
					right_of_way_reb right_of_way_real_budget,
					(IFNULL(design_reb,0) + IFNULL(building_reb,0) + IFNULL(transportation_reb,0) + IFNULL(live_line_reb,0) + IFNULL(right_of_way_reb,0)) as total_real_budget	
				FROM
					wfl_projects
					LEFT JOIN (
					SELECT
						* 
					FROM
						(
						SELECT
							project_id_psl project_id,
							max( manual_entry_date_psl ) max_date 
						FROM
							( SELECT project_id_psl, manual_entry_date_psl FROM wfl_project_status_log LEFT JOIN wfl_status_log_responsibles ON status_log_id_slr = id_psl WHERE deleted_psl != 1 AND deleted_slr != 1 GROUP BY id_psl ) statusLogAndResponsible 
						GROUP BY
							project_id_psl 
						) AS max_entry
						LEFT JOIN (
						SELECT
							id_psl,
							project_id_psl,
							log_detail_psl,
							manual_entry_date_psl,
							GROUP_CONCAT( CONCAT( firstname_usr, ' ', lastname_usr ) ) responsible,
							GROUP_CONCAT( id_usr ) responsible_ids 
						FROM
							wfl_project_status_log
							LEFT JOIN wfl_status_log_responsibles ON status_log_id_slr = id_psl
							LEFT JOIN wfl_status_responsibles ON id_sre = responsible_id_slr
							LEFT JOIN sec_users ON id_usr = user_id_sre 
						WHERE
							deleted_psl != 1 
							AND deleted_slr != 1 
						GROUP BY
							id_psl 
						) log ON log.project_id_psl = max_entry.project_id 
						AND log.manual_entry_date_psl = max_entry.max_date
						LEFT JOIN (
						SELECT
							id_psl fiscal_id_psl,
							project_id_psl fiscal_project_id_psl,
							log_detail_psl fiscal_log_detail_psl,
							manual_entry_date_psl fiscal_manual_entry_date_psl,
							GROUP_CONCAT( DISTINCT CONCAT( firstname_usr, ' ', lastname_usr ) ) fiscal_responsible,
							GROUP_CONCAT( DISTINCT id_usr ) fiscal_responsible_id 
						FROM
							wfl_project_status_log
							LEFT JOIN wfl_status_log_responsibles ON status_log_id_slr = id_psl
							LEFT JOIN wfl_status_responsibles ON id_sre = responsible_id_slr
							LEFT JOIN sec_users ON id_usr = user_id_sre
							LEFT JOIN sec_userroles ON userid_uro = user_id_sre 
						WHERE
							deleted_psl != 1 
							AND deleted_slr != 1 
							AND roleid_uro = 8 
						GROUP BY
							id_psl 
						) log_fiscal ON log_fiscal.fiscal_project_id_psl = max_entry.project_id 
						AND log_fiscal.fiscal_manual_entry_date_psl = max_entry.max_date
						LEFT JOIN (
						SELECT
							id_psl builder_id_psl,
							project_id_psl builder_project_id_psl,
							log_detail_psl builder_log_detail_psl,
							manual_entry_date_psl builder_manual_entry_date_psl,
							GROUP_CONCAT( DISTINCT CONCAT( firstname_usr, ' ', lastname_usr ) ) builder_responsible,
							GROUP_CONCAT( DISTINCT id_usr ) builder_responsible_ids 
						FROM
							wfl_project_status_log
							LEFT JOIN wfl_status_log_responsibles ON status_log_id_slr = id_psl
							LEFT JOIN wfl_status_responsibles ON id_sre = responsible_id_slr
							LEFT JOIN sec_users ON id_usr = user_id_sre
							LEFT JOIN sec_userroles ON userid_uro = user_id_sre 
						WHERE
							deleted_psl != 1 
							AND deleted_slr != 1 
							AND roleid_uro = 9 
						GROUP BY
							id_psl 
						) log_builder ON log_builder.builder_project_id_psl = max_entry.project_id 
						AND log_builder.builder_manual_entry_date_psl = max_entry.max_date 
					) AS status_log_manual_entry_date ON status_log_manual_entry_date.project_id_psl = id_pro
					LEFT JOIN wfl_project_status ON status_pro = id_pst
					LEFT JOIN wfl_warehouses ON project_id_war = id_pro 
					AND deleted_war != 1
					LEFT JOIN (
						SELECT
							inc.* 
						FROM
							( SELECT project_id_inc, max( manual_entry_date_inc ) manual_entry_date_inc FROM wfl_incidents WHERE status_id_inc IN ( 29 ) -- in_progress
							GROUP BY project_id_inc ) AS filtered
							INNER JOIN wfl_incidents AS inc ON inc.project_id_inc = filtered.project_id_inc 
							AND inc.manual_entry_date_inc = filtered.manual_entry_date_inc 
					) wfl_incidents ON project_id_inc = id_pro
					LEFT JOIN (
						SELECT
							id_pro mp_project_id,
							wfl_project_budgets.manpower_file_id_prb manpower_file_id 
						FROM
							wfl_project_budgets
							LEFT JOIN wfl_project_status_log ON id_psl = status_log_id_prb
							LEFT JOIN wfl_projects ON id_pro = project_id_psl 
						WHERE
							deleted_prb != 1 
							AND deleted_pro != 1 
							AND deleted_psl != 1 
							AND manpower_file_id_prb IS NOT NULL 
					) manpower ON manpower.mp_project_id = id_pro
					LEFT JOIN (
						SELECT
							psl.id_psl as_id_psl,
							psl.project_id_psl as_project_id_psl,
							psl.status_id_psl as_status_id_psl,
							psl.log_detail_psl as_log_detail_psl,
							psl.manual_entry_date_psl as_manual_entry_date_psl 
						FROM
							(
							SELECT
								project_id_psl project_id,
								status_id_psl,
								max( manual_entry_date_psl ) entry_date 
							FROM
								wfl_project_status_log 
							WHERE
								1 = 1 
								AND wfl_project_status_log.status_id_psl = 11 
								AND wfl_project_status_log.deleted_psl != 1 
							GROUP BY
								wfl_project_status_log.project_id_psl 
							) AS approved_status
							LEFT JOIN wfl_project_status_log psl ON approved_status.entry_date = psl.manual_entry_date_psl 
							AND approved_status.project_id = psl.project_id_psl 
							AND deleted_psl != 1 
					) approved_budget ON approved_budget.as_project_id_psl = id_pro
					LEFT JOIN wfl_project_budgets ON status_log_id_prb = approved_budget.as_id_psl
					LEFT JOIN (
					SELECT
						psl.id_psl rb_id_psl,
						psl.project_id_psl rb_project_id_psl,
						psl.status_id_psl rb_status_id_psl,
						psl.log_detail_psl rb_log_detail_psl,
						psl.manual_entry_date_psl rb_manual_entry_date_psl 
					FROM
						(
						SELECT
							project_id_psl project_id,
							status_id_psl,
							max( manual_entry_date_psl ) entry_date 
						FROM
							wfl_project_status_log 
						WHERE
							1 = 1 
							AND wfl_project_status_log.status_id_psl = 45 
							AND wfl_project_status_log.deleted_psl != 1 
						GROUP BY
							wfl_project_status_log.project_id_psl 
						) AS rb_status
						LEFT JOIN wfl_project_status_log psl ON rb_status.entry_date = psl.manual_entry_date_psl 
						AND rb_status.project_id = psl.project_id_psl 
						AND deleted_psl != 1 
					) real_budget ON real_budget.rb_project_id_psl = id_pro
					LEFT JOIN wfl_project_real_budgets ON status_log_id_reb = real_budget.rb_id_psl 
				WHERE
					deleted_pro != 1
				) ".static::TABLE_NAME."_master_detail
		";
	}

	/**
	 * This method define the columns that will be used from _coreQuery
	 * @return string
	 */
	protected function _dataTableColumns() : string
	{
		return static::TABLE_NAME."_master_detail.*
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
		$sql = "";
		if(is_array($this->_additionalParameters) && count($this->_additionalParameters) >= 1)
		{
			foreach($this->_additionalParameters as $parameter => $value)
			{
				switch ($parameter)
				{
					//For this parameter the ids are separated by comma
					case "status":
						$statusList = explode(",",$value);
						$statusScape = "";
						foreach ($statusList as $status)
						{
							$statusScape .= $ci->db->escape($status).", ";
							$includeFilter = TRUE;
						}
						$statusScape = substr($statusScape,0,-2);
						$sql .= " and status_pro in ( ".$statusScape." )";
						break;
					case "responsible-id":
						if($value != "")
							$sql .= " and responsible_ids like '%".$value."%'";
						break;
					case "work-area":
						$sql .= " and work_area_pro = ".$ci->db->escape($value)." ";
						break;
					case "fiscal-responsible-id":
						if($value != "")
							$sql .= " and fiscal_responsible_id = ".$ci->db->escape($value)." ";
						break;
					case "builder-responsible-id":
						if($value != "")
							$sql .= " and builder_responsible_ids like '%".$value."%'";
						break;
					case "manpower-uploaded":
						if($value == 1)
							$sql .= " and manpower_file_id is not null ";
						else if($value == 0)
							$sql .= " and manpower_file_id is null ";
						else
							$sql .= " ";
						break;
					case "has-location":
						if($value == 1)
							$sql .= " and latitude_pro is not null and latitude_pro != '' ";
						else if($value == 0)
							$sql .= " and latitude_pro is null or latitude_pro = '' ";
						else
							$sql .= " ";
						break;
				}
			}
		}
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
				"id" => "id",
				"text" => "text"
			);
		}

		$moreResults = ($page * $this->_limit) < $recordsFiltered;
		$resultArray['list'] = $list;
		$resultArray['pagination'] = array("more" => $moreResults);
		return $resultArray;
	}
}
