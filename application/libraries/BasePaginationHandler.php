<?php
class BasePaginationHandler
{
	const TABLE_NAME = "";
	const TABLE_ID = "";
	const ATTRIB_SUFIX = "";

	/**
	 * @var int
	 */
	protected int $_limit;
	/**
	 * @var int
	 */
	protected int $_offset;
	/**
	 * @var string
	 */
	protected string $_orderBy;
	/**
	 * @var string
	 */
	protected string $_orderType;
	/**
	 * @var array
	 */
	protected array $_colsArray;
	/**
	 * @var array
	 */
	protected array $_additionalParameters;
	/**
	 * @var string
	 */
	protected string $_textToSearch;

	protected bool $_returnAsObjectCollection;

	public function __construct(int $limit = 100, int $offset = 0, string $orderBy = "", string $orderType = 'asc', string $textToSearch = "", array $colsArray = array())
	{
		$this->_limit = $limit;
		$this->_offset = $offset;
		$this->_orderBy = $orderBy;
		$this->_orderType = $orderType;
		$this->_textToSearch = $textToSearch;
		$this->_colsArray = $colsArray;
		$this->_additionalParameters = array();
		$this->_returnAsObjectCollection = TRUE;
	}

	/**
	 * @param array $additionalParameters
	 * @return void
	 */
	public function setAdditionalParameters(array $additionalParameters) : void
	{
		$this->_additionalParameters = array_merge($this->_additionalParameters, $additionalParameters);
	}

	/**
	 * @param bool $flag
	 */
	public function setReturnAsObjectCollection(bool $flag = TRUE) : void
	{
		$this->_returnAsObjectCollection = $flag;
	}

	/**
	 * @return int
	 */
	public function countAll() : int
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = '
                select count(' . static::TABLE_ID. ') as total
                from ' . $this->_coreQuery() .' where 1=1 '.$this->_additionalParameters();

		$query = $ci->db->query($sql);
		return $query->row()->total;
	}

	/**
	 * @return array
	 */
	public function getAll() : array
	{
		if ($this->_orderBy === "")
		{
			$this->_orderBy = static::TABLE_ID;
		}
		$ci = &get_instance();
		$ci->load->database();

		$sql = 'select '.$this->_dataTableColumns().' from ' . $this->_coreQuery() . ' 
				where
				1 = 1
				'.$this->_additionalParameters().'                    
                group by '.static::TABLE_ID.' order by ' . $this->_orderBy . ' ' . $this->_orderType . ' limit ' . $this->_limit . ' offset ' . $this->_offset;
;
		$query = $ci->db->query($sql);
		if($this->_returnAsObjectCollection)
			return $query->result();
		else
			return $query->result_array();
	}

	/**
	 * @return array
	 */
	public function search() : array
	{
		if ($this->_orderBy === "")
		{
			$this->_orderBy = static::TABLE_ID;
		}
		$ci = &get_instance();
		$ci->load->database();

		$sql = 'select '.$this->_dataTableColumns().' from ' . $this->_coreQuery().'
		 where 1=1 and (';
		foreach ($this->_colsArray as $var)
		{
			$sql .= ' ' . $var . ' like \'%' . $ci->db->escape_like_str($this->_textToSearch) . '%\' ESCAPE \'!\' or ';
		}

		$sql = substr($sql, 0, -3);
		$sql .= ') '.$this->_additionalParameters().' group by '.static::TABLE_ID.' order by ' . $this->_orderBy . ' ' . $this->_orderType . ' limit ' . $this->_limit . ' offset ' . $this->_offset;
		$query = $ci->db->query($sql);//echo"<pre>";var_dump($sql);exit;
		if($this->_returnAsObjectCollection)
			return $query->result();
		else
			return $query->result_array();
	}

	/**
	 * @return int
	 */
	public function searchTotalCount() : int
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = 'select count('.static::TABLE_ID.') as total from ' . $this->_coreQuery().'
		 where 1=1 and (';
		foreach ($this->_colsArray as $var)
		{
			$sql .= ' ' . $var . ' like \'%' . $this->_textToSearch . '%\' or ';
		}

		$sql = substr($sql, 0, -3);
		$sql .= ') '.$this->_additionalParameters();

		$query = $ci->db->query($sql);
		return $query->row()->total;
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
		return "";
	}

	/**
	 * Return the single data to draw the jquery data table
	 * @return array
	 */
	public function getResponseForDataTable() : array
	{
		$recordsTotal = $this->countAll();
		$recordsFiltered = $recordsTotal;
		if ($this->_textToSearch === "")
		{
			$resultArray = $this->getAll();
		}
		else
		{
			$resultArray = $this->search();
			$recordsFiltered = $this->searchTotalCount();
		}
		$result['recordsTotal'] = $recordsTotal;
		$result['recordsFiltered'] = $recordsFiltered;
		$result['resultArray'] = $resultArray;
		return $result;
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
	protected static function notDeleted()
	{
		return " deleted".static::ATTRIB_SUFIX." != 1 ";
	}
}
