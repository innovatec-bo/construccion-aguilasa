<?php
class MaterialPaginationHandler extends BasePaginationHandler
{
	const TABLE_NAME = "mat_materials";
	const TABLE_ID = "material_id";
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
		$coreQuery = "
			(
				select 
					id_mat material_id,
					code_mat material_code,
					name_mat material_name,
					description_mat material_description,
					unit_of_measurement_mat material_unit_of_measurement
				from
					mat_materials
				where deleted_mat != 1
					 
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
				"id" => $row->material_id,
				"text" => "($row->material_code) ".$row->material_description,
				"material_id" => $row->material_id,
				"material_code" => $row->material_code,
				"material_description" => $row->material_description,
				"material_code_micro_time" => $row->material_code."-".uniqid()
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
					case "{key-to-search-in-sql}":
						$query = str_replace("{key-to-search-in-sql}",' and filer_to_put_in_query = '.$ci->db->escape($value).' ', $query);
						break;
				}
			}
		}
		//Remove keywords that hasn't values to be replaced
		$query = preg_replace("/\{[^}]+\}/","", $query);
		return $query;
	}
}
