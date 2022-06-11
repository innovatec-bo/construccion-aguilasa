<?php
class MaterialSummaryPaginationHandler extends BasePaginationHandler
{
	const TABLE_NAME = "mat_materials";
	const TABLE_ID = "project_material";
	const ATTRIB_SUFIX = "_mat";

	public function __construct(int $limit = 100, int $offset = 0, string $orderBy = "", string $orderType = 'asc', string $textToSearch = "", array $colsArray = array())
	{
		parent::__construct($limit, $offset, $orderBy, $orderType, $textToSearch, $colsArray);
		$this->_additionalParameters = array(
			'grouping-criteria' => ' project_id_msu, material_id_prm, tension_id_prm, status_id_prm '
		);
	}

	/**
	 * This method return the master detail table
	 * @return string
	 */
	protected function _coreQuery() : string
	{
		$coreQuery = "
			(
				select 
					working_materials.*,
					-- Filter by project
					IFNULL(assigned_materials.quantity,0) quantity_assigned_materials,
					IFNULL(materials_picked_up_from_cre.quantity,0) quantity_picked_up_from_cre,
					(IFNULL(materials_delivered_to_builder.quantity,0) + IFNULL(materials_delivered_to_builder_loan.quantity,0) )- IFNULL(non_used_materials.quantity,0) quantity_materials_delivered_to_builder,
					IFNULL(materials_delivered_to_cre.quantity,0) quantity_materials_delivered_to_cre,
					IFNULL(builder_returns_new_materials.quantity,0) quantity_new_materials_returned_by_builder,
					IFNULL(builder_returns_old_materials.quantity,0) quantity_old_materials_returned_by_builder,
					IFNULL(builder_returns_good_condition_materials.quantity,0) quantity_good_condition_materials_returned_by_builder,
					IFNULL(builder_returns_materials.quantity,0) quantity_materials_returned_by_builder,
					IFNULL(entry_by_conciliation_221.quantity,0) quantity_entry_by_conciliation_221,
					IFNULL(non_used_materials.quantity,0) quantity_non_used_materials,
					IFNULL(material_removed_from_construction.quantity,0) quantity_material_removed_from_construction,
					IFNULL(assigned_materials.quantity,0) - IFNULL(materials_picked_up_from_cre.quantity,0) pending_material_in_cre,
					IFNULL(request_materials.quantity,0) request_materials_quantity,
					
					(
						IFNULL(materials_picked_up_from_cre.quantity,0) +
						IFNULL(entry_by_conciliation_221.quantity,0) +
						IFNULL(non_used_materials.quantity,0) +
						IFNULL(material_removed_from_construction.quantity,0) + 
						IFNULL(builder_returns_new_materials.quantity,0) + 
						IFNULL(builder_returns_old_materials.quantity,0) +
						IFNULL(builder_returns_good_condition_materials.quantity,0) +
						IFNULL(builder_returns_materials.quantity,0)
					) -
					(
						IFNULL(materials_delivered_to_builder.quantity,0) +
						IFNULL(materials_delivered_to_builder_loan.quantity,0) +
						IFNULL(materials_delivered_to_cre.quantity,0)+
						IFNULL(request_materials.quantity,0)
					) quantity_in_warehouse,

					-- No project filter
					(IFNULL(all_materials_picked_up_from_cre.quantity,0) +
					IFNULL(all_entry_by_conciliation_221.quantity,0) +
					IFNULL(all_non_used_materials.quantity,0) +
					IFNULL(all_material_removed_from_construction.quantity,0)) -
					(IFNULL(all_materials_delivered_to_builder.quantity,0) +
					IFNULL(all_materials_delivered_to_cre.quantity,0)+
					IFNULL(all_request_materials.quantity,0)) all_quantity_in_warehouse,

					-- Responsibles
					assign_to.fiscal_responsible_id fiscal_responsible_id,
            		assign_to.fiscal_responsible fiscal_responsible
				from 
				(
					SELECT
						CONCAT(id_pro,'-',code_mat,'-',IFNULL(tension_id_prm,'indefinido'),'-',IFNULL(status_id_prm,'indefinido')) project_material,
						id_pro project_id,
						code_pro project_code,
						id_mat material_id,
						code_mat material_code,
						description_mat material_description,
						reservation_number_msu summary_reservation_number,
						tension_id_prm,
						status_id_prm
					FROM
						mat_projects_materials
					LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
					LEFT JOIN mat_materials on material_id_prm = id_mat
					LEFT JOIN wfl_projects on id_pro = project_id_msu
					where 
						deleted_prm != 1
						{project-id}
						{reservation-number}
						{material-ids}
						and deleted_msu != 1
						GROUP BY project_id_msu, material_id_prm
						ORDER BY createdby_msu
				) as working_materials
				LEFT JOIN (
					{$this->_subQueryQuantity('1,2')}
				) as assigned_materials on working_materials.material_id = assigned_materials.material_id and working_materials.project_id = assigned_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('3')}
				) materials_picked_up_from_cre on materials_picked_up_from_cre.material_id = working_materials.material_id and materials_picked_up_from_cre.project_id = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('3', FALSE, FAlSE)}
				) all_materials_picked_up_from_cre on all_materials_picked_up_from_cre.material_id = working_materials.material_id and all_materials_picked_up_from_cre.project_id = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('4', FALSE)}
				) materials_delivered_to_builder on materials_delivered_to_builder.material_id = working_materials.material_id and materials_delivered_to_builder.project_id = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('4', FALSE, FALSE)}
				) all_materials_delivered_to_builder on all_materials_delivered_to_builder.material_id = working_materials.material_id and all_materials_delivered_to_builder.project_id = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('6')}
				) builder_returns_new_materials on builder_returns_new_materials.material_id = working_materials.material_id and builder_returns_new_materials.project_id = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('5')}
				) builder_returns_old_materials on builder_returns_old_materials.material_id = working_materials.material_id and builder_returns_old_materials.project_id = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('8')}
				) materials_delivered_to_cre on materials_delivered_to_cre.material_id = working_materials.material_id and materials_delivered_to_cre.project_id = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('8', FALSE, FALSE)}
				) all_materials_delivered_to_cre on all_materials_delivered_to_cre.material_id = working_materials.material_id and all_materials_delivered_to_cre.project_id = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('7')}
				) builder_returns_good_condition_materials on builder_returns_good_condition_materials.material_id = working_materials.material_id and builder_returns_good_condition_materials.project_id = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('9')}
				) entry_by_conciliation_221 on entry_by_conciliation_221.material_id = working_materials.material_id and entry_by_conciliation_221.project_id = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('9', FALSE, FALSE)}
				) all_entry_by_conciliation_221 on all_entry_by_conciliation_221.material_id = working_materials.material_id and all_entry_by_conciliation_221.project_id = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('10')}
				) non_used_materials on non_used_materials.material_id = working_materials.material_id and non_used_materials.project_id = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('10', FALSE, FALSE)}
				) all_non_used_materials on all_non_used_materials.material_id = working_materials.material_id and all_non_used_materials.project_id = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('11')}
				) material_removed_from_construction on material_removed_from_construction.material_id = working_materials.material_id and material_removed_from_construction.project_id = working_materials.project_id	 
				LEFT JOIN (
					{$this->_subQueryQuantity('11', FALSE, FALSE)}
				) all_material_removed_from_construction on all_material_removed_from_construction.material_id = working_materials.material_id and all_material_removed_from_construction.project_id = working_materials.project_id	 
				LEFT JOIN (
					{$this->_subQueryQuantity('14', TRUE, TRUE, 1)}
				) request_materials on request_materials.material_id = working_materials.material_id and request_materials.project_id = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('14', FALSE, FALSE, 1)}
				) all_request_materials on all_request_materials.material_id = working_materials.material_id and all_request_materials.project_id = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('15')}
				) request_loans_materials on request_loans_materials.material_id = working_materials.material_id and request_loans_materials.project_id = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('17')}
				) materials_delivered_to_builder_loan on materials_delivered_to_builder_loan.material_id = working_materials.material_id and materials_delivered_to_builder_loan.project_id = working_materials.project_id
				LEFT JOIN (".Model_project::_statusDetailQuery(21).") assign_to on assign_to.project_id_psl = working_materials.project_id
				LEFT JOIN (
					{$this->_subQueryQuantity('18')}
				) builder_returns_materials on builder_returns_materials.material_id = working_materials.material_id and builder_returns_materials.project_id = working_materials.project_id
			) ".static::TABLE_NAME."_master_detail
		";
		return $this->_applyNestedFilters($coreQuery);
	}

	/**
	 * @param string $summaryTypeId
	 * @return string
	 */
	private function _subQueryQuantity(string $summaryTypeId, $reservationNumber = TRUE, $project = TRUE, $summaryStatus = "") : string
	{
		$reservationNumberFilter = "";
		//Include reservation number filter if the summary type is materials_initial_list, materials_additional_list, materials_picked_up_from_cre, materials_delivered_to_cre
		if($reservationNumber && in_array($summaryTypeId,[1,2,3,8]))
			$reservationNumberFilter = " {reservation-number} ";

		$projectFilter = "";
		if($project)
			$projectFilter = " {project-id} ";


		$summaryStatusFilter = "";
		if(is_numeric($summaryStatus))
			$summaryStatusFilter = " and status_id_msu = ".$summaryStatus;

		return "
		SELECT
			sum(quantity_prm) quantity,
			material_id_prm material_id,
			project_id_msu project_id
		FROM
			mat_projects_materials
		LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
		where 
			summary_type_id_msu in ({$summaryTypeId})
			{$projectFilter}
			{$reservationNumberFilter}
			{$summaryStatusFilter}
			and deleted_msu != 1
			and deleted_prm != 1
		GROUP BY {grouping-criteria}
		";
	}

	/**
	 * @param string $summaryTypeId
	 * @return string
	 */
	// private function _subQueryQuantityWithoutReservationNumber(string $summaryTypeId) : string
	// {

	// 	return "
	// 	SELECT
	// 		sum(quantity_prm) quantity,
	// 		material_id_prm material_id,
	// 		project_id_msu project_id
	// 	FROM
	// 		mat_projects_materials
	// 	LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
	// 	where 
	// 		summary_type_id_msu in ({$summaryTypeId})
	// 		{project-id}
	// 		and deleted_msu != 1
	// 		and deleted_prm != 1
	// 	GROUP BY {grouping-criteria}
	// 	";
	// }

	/**
	 * @param string $summaryTypeId
	 * @return string
	 */
	// private function _subQueryQuantityRequested(string $summaryTypeId) : string
	// {
	// 	return "
	// 	SELECT
	// 		sum(quantity_prm) quantity,
	// 		material_id_prm material_id,
	// 		project_id_msu project_id
	// 	FROM
	// 		mat_projects_materials
	// 	LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
	// 	where 
	// 		summary_type_id_msu in ({$summaryTypeId})
	// 		{project-id}
	// 		{reservation-number}
	// 		and status_id_msu = 1 -- pending
	// 		and deleted_msu != 1
	// 		and deleted_prm != 1
	// 	GROUP BY {grouping-criteria}
	// 	";
	// }

	/**
	 * This method define the columns that will be used from _coreQuery
	 * @return string
	 */
	protected function _dataTableColumns() : string
	{
		return static::TABLE_NAME."_master_detail.*";
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
					case "example-key":
						$sql .= " and example-column = ".$ci->db->escape($value)." ";
						break;
					case "show-material-pending-in-cre":
							// if($value == 1)
							// 	$sql .= " and pending_material_in_cre > 0 ";
							// elseif($value == 0)
							// 	$sql .= " and pending_material_in_cre = 0 ";
							$sql .= " and pending_material_in_cre > 0 ";
						break;
					case "fiscal-responsible-id":
						if(is_numeric($value))
						{
							$sql .= ' and fiscal_responsible_id = '.$ci->db->escape($value);
						}
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
				"id" => $row->project_material,
				"text" => "($row->material_code) ".$row->material_description,
				"material_id" => $row->material_id,
				"material_code" => $row->material_code,
				"project_code" => $row->project_code,
				"quantity_assigned" => $row->quantity_assigned_materials,
				"material_description" => $row->material_description,
				"quantity_picked_up_from_cre" => $row->quantity_picked_up_from_cre,
				"request_materials_quantity" => $row->request_materials_quantity,
				"pending_material_in_cre" => $row->pending_material_in_cre,
				"quantity_materials_delivered_to_builder" => $row->quantity_materials_delivered_to_builder,
				"quantity_materials_delivered_to_cre" => $row->quantity_materials_delivered_to_cre,
				"quantity_new_materials_returned_by_builder" => $row->quantity_new_materials_returned_by_builder,
				"quantity_old_materials_returned_by_builder" => $row->quantity_old_materials_returned_by_builder,
				"quantity_good_condition_materials_returned_by_builder" => $row->quantity_good_condition_materials_returned_by_builder,
				"quantity_in_warehouse" => $row->quantity_in_warehouse,
				"all_quantity_in_warehouse" => $row->all_quantity_in_warehouse
			);
		}

		$moreResults = ($page * $this->_limit) < $recordsFiltered;
		$resultArray['list'] = $list;
		$resultArray['pagination'] = array("more" => $moreResults);
		return $resultArray;
	}

	/**
	 * @param string $query
	 * @return string
	 */
	private function _applyNestedFilters(string $query) : string
	{
		$ci=&get_instance();
		$ci->load->database();
		if(is_array($this->_additionalParameters) && count($this->_additionalParameters) >= 1)
		{
			//Apply
			foreach($this->_additionalParameters as $parameter => $value)
			{
				$parameter = "{".$parameter."}";
				switch ($parameter)
				{
					case "{reservation-number}":
						$query = str_replace("{reservation-number}",' and reservation_number_msu = '.$ci->db->escape($value).' ', $query);
						break;
					case "{project-id}":
						if($value != "")
						{
							$query = str_replace("{project-id}",' and project_id_msu = '.$ci->db->escape($value).' ', $query);
						}
						
						break;
					case "{grouping-criteria}":
						$query = str_replace("{grouping-criteria}",$value, $query);
						break;
					case "{material-ids}":
							$idList = $value;
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
							$query = str_replace("{material-ids}",' and id_mat in ('.$idListFilter.') ', $query);
						break;
				}
			}
		}
		//Remove keywords that hasn't values to be replaced
		$query = preg_replace("/\{[^}]+\}/","", $query);
		return $query;
	}
}
