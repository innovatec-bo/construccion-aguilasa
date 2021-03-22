<?php
class MaterialPaginationHandler extends BasePaginationHandler
{
	const TABLE_NAME = "mat_materials";
	const TABLE_ID = "project_material";
	const ATTRIB_SUFIX = "_mat";

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
				select 
					assigned_materials.*,
					IFNULL(materials_picked_up_from_cre.quantity,0) quantity_picked_up_from_cre,
					IFNULL(materials_delivered_to_builder.quantity,0) quantity_materials_delivered_to_builder,
					IFNULL(materials_delivered_to_cre.quantity,0) quantity_materials_delivered_to_cre,
					IFNULL(builder_returns_new_materials.quantity,0) quantity_new_materials_returned_by_builder,
					IFNULL(builder_returns_old_materials.quantity,0) quantity_old_materials_returned_by_builder,
					IFNULL(builder_returns_good_condition_materials.quantity,0) quantity_good_condition_materials_returned_by_builder
				from 
				(
					SELECT
						CONCAT(id_pro,'-',code_mat) project_material,
						id_pro project_id,
						code_pro project_code,
						id_mat material_id,
						code_mat material_code,
						description_mat material_description,
						sum(quantity_prm) quantity_assigned
						
					FROM
						mat_projects_materials
					LEFT JOIN mat_materials on id_mat = material_id_prm
					LEFT JOIN mat_materials_summary on materials_summary_id_prm = id_msu
					LEFT JOIN wfl_projects on id_pro = project_id_msu
					where 
					 summary_type_id_msu in (1,2)
					GROUP BY project_id_msu, id_mat
				) as assigned_materials
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
					GROUP BY project_id_msu, material_id_prm
				) materials_picked_up_from_cre on materials_picked_up_from_cre.material_id = assigned_materials.material_id and materials_picked_up_from_cre.project_id = assigned_materials.project_id
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
					GROUP BY project_id_msu, material_id_prm
				) materials_delivered_to_builder on materials_delivered_to_builder.material_id = assigned_materials.material_id and materials_delivered_to_builder.project_id = assigned_materials.project_id
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
					GROUP BY project_id_msu, material_id_prm
				) builder_returns_new_materials on builder_returns_new_materials.material_id = assigned_materials.material_id and builder_returns_new_materials.project_id = assigned_materials.project_id
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
					GROUP BY project_id_msu, material_id_prm
				) builder_returns_old_materials on builder_returns_old_materials.material_id = assigned_materials.material_id and builder_returns_old_materials.project_id = assigned_materials.project_id
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
					GROUP BY project_id_msu, material_id_prm
				) materials_delivered_to_cre on materials_delivered_to_cre.material_id = assigned_materials.material_id and materials_delivered_to_cre.project_id = assigned_materials.project_id
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
					GROUP BY project_id_msu, material_id_prm
				) builder_returns_good_condition_materials on builder_returns_good_condition_materials.material_id = assigned_materials.material_id and builder_returns_good_condition_materials.project_id = assigned_materials.project_id	 
			) ".static::TABLE_NAME."_master_detail
		";
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
		return "";
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
				"material_code" => $row->material_code,
				"project_code" => $row->project_code,
				"quantity_assigned" => $row->quantity_assigned,
				"material_description" => $row->material_description,
				"quantity_picked_up_from_cre" => $row->quantity_picked_up_from_cre,
				"quantity_materials_delivered_to_builder" => $row->quantity_materials_delivered_to_builder,
				"quantity_materials_delivered_to_cre" => $row->quantity_materials_delivered_to_cre,
				"quantity_new_materials_returned_by_builder" => $row->quantity_new_materials_returned_by_builder,
				"quantity_old_materials_returned_by_builder" => $row->quantity_old_materials_returned_by_builder,
				"quantity_good_condition_materials_returned_by_builder" => $row->quantity_good_condition_materials_returned_by_builder
			);
		}

		$moreResults = ($page * $this->_limit) < $recordsFiltered;
		$resultArray['list'] = $list;
		$resultArray['pagination'] = array("more" => $moreResults);
		return $resultArray;
	}
}
