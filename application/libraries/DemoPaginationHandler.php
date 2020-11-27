<?php
class DemoPaginationHandler extends BasePaginationHandler
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
	private function _coreQuery() : string
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
	private function _dataTableColumns() : string
	{
		return static::TABLE_NAME.".*";
	}

	/**
	 * Handle the additional parameters.
	 * @return string
	 */
	private function _additionalParameters() : string
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
