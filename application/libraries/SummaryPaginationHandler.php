<?php
class SummaryPaginationHandler extends BasePaginationHandler
{
	const TABLE_NAME = "";
	const TABLE_ID = "";
	const ATTRIB_SUFIX = "";

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
					".static::TABLE_NAME.".*
				FROM
					".static::TABLE_NAME."
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
		return static::TABLE_NAME.".*";
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
					case "id":
						if($value != "")
							$sql .= " and ".static::TABLE_ID." = ".$ci->db->escape($value);
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
