<?php
class SummaryPaginationHandler extends BasePaginationHandler
{
	const TABLE_NAME = Model_material_summary::TABLE_NAME;
	const TABLE_ID = Model_material_summary::TABLE_ID;
	const ATTRIB_SUFIX = Model_material_summary::ATTRIB_SUFIX;

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
					".static::TABLE_NAME.".*,
					concat(fiscal.firstname_usr,' ',fiscal.lastname_usr) fiscal_full_name,
					concat(builder.firstname_usr,' ',builder.lastname_usr) builder_full_name,
					keyword_mqt summary_type_keyword,
					code_pro project_code,
					CASE
						WHEN status_id_msu = 1 then 'Pendiente'
						WHEN status_id_msu = 2 then 'Cancelado por el fiscal'
						WHEN status_id_msu = 3 then 'Cancelado por el sistema'
						WHEN status_id_msu = 4 then 'Retirado de almacen'
					END material_summary_status
				FROM
					".static::TABLE_NAME."
				left join sec_users fiscal on fiscal_responsible_msu = fiscal.id_usr
				left join sec_users builder on builder_responsible_msu = builder.id_usr
				left join mat_materials_summary_types on id_mqt = summary_type_id_msu
				left join wfl_projects on id_pro = project_id_msu
				where deleted_msu != 1
				GROUP BY ".static::TABLE_ID."	 
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
		$ci=&get_instance();
		$ci->load->database();
		$sql = "";
		if(is_array($this->_additionalParameters) && count($this->_additionalParameters) >= 1)
		{
			foreach($this->_additionalParameters as $parameter => $value)
			{
				switch ($parameter)
				{
					case "summary-id":
						if($value != "")
							$sql .= " and ".static::TABLE_ID." = ".$ci->db->escape($value);
						break;
					case "fiscal-id":
						if($value != "")
							$sql .= " and fiscal_responsible_msu = ".$ci->db->escape($value);
						break;
					case "builder-id":
						if($value != "")
							$sql .= " and builder_responsible_msu = ".$ci->db->escape($value);
						break;
					case "summary-type-id":
						if($value != "")
							$sql .= " and summary_type_id_msu = ".$ci->db->escape($value);
						break;
					case 'summary-type-keyword':
						if($value != "")
						{
							$list = explode(",",$value);
							$scaped = "";
							foreach ($list as $status)
							{
								$scaped .= $ci->db->escape($status).", ";
								$includeFilter = TRUE;
							}
							$scaped = substr($scaped,0,-2);
							$sql .= " and summary_type_keyword in ({$scaped})";
						}
							
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
