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
					IFNULL(assigned_materials.quantity,0) quantity_assigned_materials,
					IFNULL(materials_picked_up_from_cre.quantity,0) quantity_picked_up_from_cre,
					IFNULL(materials_delivered_to_builder.quantity,0) quantity_materials_delivered_to_builder,
					IFNULL(materials_delivered_to_cre.quantity,0) quantity_materials_delivered_to_cre,
					IFNULL(builder_returns_new_materials.quantity,0) quantity_new_materials_returned_by_builder,
					IFNULL(builder_returns_old_materials.quantity,0) quantity_old_materials_returned_by_builder,
					IFNULL(builder_returns_good_condition_materials.quantity,0) quantity_good_condition_materials_returned_by_builder,
					IFNULL(entry_by_conciliation_221.quantity,0) quantity_entry_by_conciliation_221,
					IFNULL(non_used_materials.quantity,0) quantity_non_used_materials,
					IFNULL(material_removed_from_construction.quantity,0) quantity_material_removed_from_construction,
					IFNULL(assigned_materials.quantity,0) - IFNULL(materials_picked_up_from_cre.quantity,0) pending_material_in_cre,
					
					(IFNULL(materials_picked_up_from_cre.quantity,0) +
					IFNULL(entry_by_conciliation_221.quantity,0) +
					IFNULL(non_used_materials.quantity,0) +
					IFNULL(material_removed_from_construction.quantity,0)) -
					(IFNULL(materials_delivered_to_builder.quantity,0) +
					IFNULL(materials_delivered_to_cre.quantity,0)) quantity_in_warehouse
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
						and deleted_msu != 1
						{project-id}
						{reservation-number}
						GROUP BY project_id_msu, material_id_prm
						ORDER BY createdby_msu
				) as working_materials
				LEFT JOIN (
					SELECT
						sum(quantity_prm) quantity,
						material_id_prm material_id,
						project_id_msu project_id
					FROM
						mat_projects_materials
					LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
					where 
					 summary_type_id_msu in (1,2)
					 and deleted_prm != 1
					 {project-id}
					 {reservation-number}
					GROUP BY {grouping-criteria}
				) as assigned_materials on working_materials.material_id = assigned_materials.material_id and working_materials.project_id = assigned_materials.project_id
				LEFT JOIN (
					SELECT
						sum(quantity_prm) quantity,
						material_id_prm material_id,
						project_id_msu project_id
					FROM
						mat_projects_materials
					LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
					where 
						summary_type_id_msu = 3
						{project-id}
						{reservation-number}
					GROUP BY {grouping-criteria}
				) materials_picked_up_from_cre on materials_picked_up_from_cre.material_id = working_materials.material_id and materials_picked_up_from_cre.project_id = working_materials.project_id
				LEFT JOIN (
					SELECT
						sum(quantity_prm) quantity,
						material_id_prm material_id,
						project_id_msu project_id
					FROM
						mat_projects_materials
					LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
					where 
						summary_type_id_msu = 4
						{project-id}
						{reservation-number}
					GROUP BY {grouping-criteria}
				) materials_delivered_to_builder on materials_delivered_to_builder.material_id = working_materials.material_id and materials_delivered_to_builder.project_id = working_materials.project_id
				LEFT JOIN (
					SELECT
						sum(quantity_prm) quantity,
						material_id_prm material_id,
						project_id_msu project_id
					FROM
						mat_projects_materials
					LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
					where 
						summary_type_id_msu = 6
						{project-id}
						{reservation-number}
					GROUP BY {grouping-criteria}
				) builder_returns_new_materials on builder_returns_new_materials.material_id = working_materials.material_id and builder_returns_new_materials.project_id = working_materials.project_id
				LEFT JOIN (
					SELECT
						sum(quantity_prm) quantity,
						material_id_prm material_id,
						project_id_msu project_id
					FROM
						mat_projects_materials
					LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
					where 
						summary_type_id_msu = 5
						{project-id}
						{reservation-number}
					GROUP BY {grouping-criteria}
				) builder_returns_old_materials on builder_returns_old_materials.material_id = working_materials.material_id and builder_returns_old_materials.project_id = working_materials.project_id
				LEFT JOIN (
					SELECT
						sum(quantity_prm) quantity,
						material_id_prm material_id,
						project_id_msu project_id
					FROM
						mat_projects_materials
					LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
					where 
						summary_type_id_msu = 8
						{project-id}
						{reservation-number}
					GROUP BY {grouping-criteria}
				) materials_delivered_to_cre on materials_delivered_to_cre.material_id = working_materials.material_id and materials_delivered_to_cre.project_id = working_materials.project_id
				LEFT JOIN (
					SELECT
						sum(quantity_prm) quantity,
						material_id_prm material_id,
						project_id_msu project_id
					FROM
						mat_projects_materials
					LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
					where 
						summary_type_id_msu = 7
						{project-id}
						{reservation-number}
					GROUP BY {grouping-criteria}
				) builder_returns_good_condition_materials on builder_returns_good_condition_materials.material_id = working_materials.material_id and builder_returns_good_condition_materials.project_id = working_materials.project_id
				LEFT JOIN (
					SELECT
						sum(quantity_prm) quantity,
						material_id_prm material_id,
						project_id_msu project_id
					FROM
						mat_projects_materials
					LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
					where 
						summary_type_id_msu = 9
						{project-id}
						{reservation-number}
					GROUP BY {grouping-criteria}
				) entry_by_conciliation_221 on entry_by_conciliation_221.material_id = working_materials.material_id and entry_by_conciliation_221.project_id = working_materials.project_id
				LEFT JOIN (
					SELECT
						sum(quantity_prm) quantity,
						material_id_prm material_id,
						project_id_msu project_id
					FROM
						mat_projects_materials
					LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
					where 
						summary_type_id_msu = 10
						{project-id}
						{reservation-number}
					GROUP BY {grouping-criteria}
				) non_used_materials on non_used_materials.material_id = working_materials.material_id and non_used_materials.project_id = working_materials.project_id
				LEFT JOIN (
					SELECT
						sum(quantity_prm) quantity,
						material_id_prm material_id,
						project_id_msu project_id
					FROM
						mat_projects_materials
					LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
					where 
						summary_type_id_msu = 11
						{project-id}
						{reservation-number}
					GROUP BY {grouping-criteria}
				) material_removed_from_construction on material_removed_from_construction.material_id = working_materials.material_id and material_removed_from_construction.project_id = working_materials.project_id	 
			) ".static::TABLE_NAME."_master_detail
		";
		return $this->_applyNestedFilters($coreQuery);
	}

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
				"quantity_assigned" => $row->quantity_assigned,
				"material_description" => $row->material_description,
				"quantity_picked_up_from_cre" => $row->quantity_picked_up_from_cre,
				"pending_material_in_cre" => $row->pending_material_in_cre,
				"quantity_materials_delivered_to_builder" => $row->quantity_materials_delivered_to_builder,
				"quantity_materials_delivered_to_cre" => $row->quantity_materials_delivered_to_cre,
				"quantity_new_materials_returned_by_builder" => $row->quantity_new_materials_returned_by_builder,
				"quantity_old_materials_returned_by_builder" => $row->quantity_old_materials_returned_by_builder,
				"quantity_good_condition_materials_returned_by_builder" => $row->quantity_good_condition_materials_returned_by_builder,
				"quantity_in_warehouse" => $row->quantity_in_warehouse
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
						$query = str_replace("{project-id}",' and project_id_msu = '.$ci->db->escape($value).' ', $query);
						break;
					case "{grouping-criteria}":
						$query = str_replace("{grouping-criteria}",$value, $query);
						break;
				}
			}
		}
		//Remove keywords that hasn't values to be replaced
		$query = preg_replace("/\{[^}]+\}/","", $query);
		return $query;
	}
}
