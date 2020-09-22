<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2020-09-21
 * Time: 13:10:18
 */

class Model_process_line_base extends MY_Model
{
    const TABLE_NAME = "wfl_process_line";
    const TABLE_ID = "id_prl";
    const ATTRIB_SUFIX = "_prl";

    protected $_projectId;
	protected $_userId;
	protected $_startDate;
	protected $_dueDate;
	protected $_detail;

    public function __construct($projectId = "", $userId = "", $startDate = "", $dueDate = "", $detail = "")
    {
        parent::__construct();
        $this->_projectId = $projectId;
		$this->_userId = $userId;
		$this->_startDate = $startDate;
		$this->_dueDate = $dueDate;
		$this->_detail = $detail;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_prl" => $this->_id,
			"project_id_prl" => $this->_projectId,
			"user_id_prl" => $this->_userId,
			"start_date_prl" => $this->_startDate,
			"due_date_prl" => $this->_dueDate,
			"detail_prl" => $this->_detail,
			"deleted_prl" => $this->_deleted,
			"createdon_prl" => $this->_createdOn,
			"createdby_prl" => $this->_createdBy,
			"editedon_prl" => $this->_editedOn,
			"editedby_prl" => $this->_editedBy
        );
        return $tableAttributes;
    }

    /**
     * @param $className
     * @param $object
     * @return object
     */
    protected static function recast($className, $object)
    {
        $response =  null;
        if ($object instanceof stdClass)
        {
            if (!class_exists($className))
                throw new InvalidArgumentException(sprintf('Inexistant class %s.', $className));

            //Let's set the values to payment object using the data from stdObject
            $instance = new $className(
                $object->project_id_prl,
				$object->user_id_prl,
				$object->start_date_prl,
				$object->due_date_prl,
				$object->detail_prl
            );
            $instance->_id = $object->id_prl;

            $instance->_deleted = $object->deleted_prl;
            $instance->_createdOn = $object->createdon_prl;
            $instance->_createdBy = $object->createdby_prl;
            $instance->_editedOn = $object->editedon_prl;
            $instance->_editedBy = $object->editedby_prl;
            $response = $instance;
        }
        return $response;
    }

    //Setters
    public function setProjectId($projectId)
	{
		$this->_projectId = $projectId;
	}

	public function setUserId($userId)
	{
		$this->_userId = $userId;
	}

	public function setStartDate($startDate)
	{
		$this->_startDate = $startDate;
	}

	public function setDueDate($dueDate)
	{
		$this->_dueDate = $dueDate;
	}

	public function setDetail($detail)
	{
		$this->_detail = $detail;
	}

    //Getters
    public function getProjectId()
	{
		return $this->_projectId;
	}

	public function getUserId()
	{
		return $this->_userId;
	}

	public function getStartDate()
	{
		return $this->_startDate;
	}

	public function getDueDate()
	{
		return $this->_dueDate;
	}

	public function getDetail()
	{
		return $this->_detail;
	}

	################################################################################################# BEGIN - DATATABLE AJAX METHODS
	/**
	 * @return mixed
	 */
	public static function countAll()
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = '
                select count(' . static::TABLE_ID. ') as total
                from ' . static::TABLE_NAME .' 
                left join wfl_projects on id_pro = project_id_efo
                left join wfl_project_status on status_id_efo = id_pst
                left join sec_users external_fiscal on external_fiscal.id_usr = fiscal_id_efo
				left join sec_users created_by on created_by.id_usr = createdby_efo
				left join sec_users fixed_by on fixed_by.id_usr = fixed_by_efo
                where '.static::notDeleted();

		$query = $ci->db->query($sql);
		$totalCount = $query->row()->total;
		return $totalCount;
	}

	/**
	 * @param $limit
	 * @param $offset
	 * @param null $orderBy
	 * @param string $orderType
	 * @return mixed
	 */
	public static function getAll($limit, $offset, $orderBy = null, $orderType = 'asc')
	{
		if ($orderBy === null)
		{
			$orderBy = static::TABLE_ID;
		}
		$ci = &get_instance();
		$ci->load->database();

		$sql = 'select '.static::_dataTableColumns().' 
				from ' . static::TABLE_NAME . '
				left join wfl_projects on id_pro = project_id_efo 
				left join wfl_project_status on status_id_efo = id_pst
				left join sec_users external_fiscal on external_fiscal.id_usr = fiscal_id_efo
				left join sec_users created_by on created_by.id_usr = createdby_efo
				left join sec_users fixed_by on fixed_by.id_usr = fixed_by_efo 
				where '.static::notDeleted().'             
                group by '.static::TABLE_ID.' order by ' . $orderBy . ' ' . $orderType . ' limit ' . $limit . ' offset ' . $offset;
		$query = $ci->db->query($sql);
		$result = $query->result();
		return $result;
	}

	public static function search($text, $limit, $offset, $orderBy = null, $orderType = 'asc', $colsArray = null)
	{
		if ($orderBy === null)
		{
			$orderBy = static::TABLE_ID;
		}
		$ci = &get_instance();
		$ci->load->database();

		$sql = 'select '.static::_dataTableColumns().' 
		from ' . static::TABLE_NAME.' 
		left join wfl_projects on id_pro = project_id_efo
		left join wfl_project_status on status_id_efo = id_pst
		left join sec_users external_fiscal on external_fiscal.id_usr = fiscal_id_efo
		left join sec_users created_by on created_by.id_usr = createdby_efo
		left join sec_users fixed_by on fixed_by.id_usr = fixed_by_efo
		';
		$sql .= ' where '.static::notDeleted().' and (';
		foreach ($colsArray as $var)
		{
			if($var == "fiscal_fullname")
			{
				$sql .= ' concat( external_fiscal.firstname_usr, \' \', external_fiscal.lastname_usr ) like \'%' . $text . '%\' or ';
			}
			elseif($var == "created_by_fullname")
			{
				$sql .= ' concat( created_by.firstname_usr, \' \', created_by.lastname_usr ) like \'%' . $text . '%\' or ';
			}
			elseif($var == "fixed_by_fullname")
			{
				$sql .= ' concat( fixed_by.firstname_usr, \' \', fixed_by.lastname_usr ) like \'%' . $text . '%\' or ';
			}
			else
			{
				$sql .= ' ' . $var . ' like \'%' . $text . '%\' or ';
			}
		}
		$sql = substr($sql, 0, -3);
		$sql .= ') group by '.static::TABLE_ID.' order by ' . $orderBy . ' ' . $orderType . ' limit ' . $limit . ' offset ' . $offset;

		$query = $ci->db->query($sql);
		return $query->result();
	}

	public static function searchTotalCount($text, $colsArray = null)
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = 'select count(' . static::TABLE_ID . ') as total 
		from ' . static::TABLE_NAME.' 
		left join wfl_projects on id_pro = project_id_efo
		left join wfl_project_status on status_id_efo = id_pst
		left join sec_users external_fiscal on external_fiscal.id_usr = fiscal_id_efo
		left join sec_users created_by on created_by.id_usr = createdby_efo
		left join sec_users fixed_by on fixed_by.id_usr = fixed_by_efo
		';
		$sql .= ' where '.static::notDeleted().' and (';

		foreach ($colsArray as $var)
		{
			if($var == "fiscal_fullname")
			{
				$sql .= ' concat( external_fiscal.firstname_usr, \' \', external_fiscal.lastname_usr ) like \'%' . $text . '%\' or ';
			}
			elseif($var == "created_by_fullname")
			{
				$sql .= ' concat( created_by.firstname_usr, \' \', created_by.lastname_usr ) like \'%' . $text . '%\' or ';
			}
			elseif($var == "fixed_by_fullname")
			{
				$sql .= ' concat( fixed_by.firstname_usr, \' \', fixed_by.lastname_usr ) like \'%' . $text . '%\' or ';
			}
			else
			{
				$sql .= ' ' . $var . ' like \'%' . $text . '%\' or ';
			}
		}

		$sql = substr($sql, 0, -3);
		$sql .= ')';

		$query = $ci->db->query($sql);
		$totalCount = $query->row()->total;
		return $totalCount;
	}

	private static function _dataTableColumns()
	{
		$columns = static::TABLE_NAME.".*, 
		code_pro, 
		status_name_pst,
		concat(external_fiscal.firstname_usr,' ',external_fiscal.lastname_usr) fiscal_fullname,
		external_fiscal.firstname_usr fiscal_firstname,
		external_fiscal.lastname_usr fiscal_lastname,
		concat(created_by.firstname_usr,' ',created_by.lastname_usr) created_by_fullname,
		created_by.firstname_usr created_by_firstname,
		created_by.lastname_usr created_by_lastname,
		concat(fixed_by.firstname_usr,' ',fixed_by.lastname_usr) fixed_by_fullname,
		fixed_by.firstname_usr fixed_by_firstname,
		fixed_by.lastname_usr fixed_by_lastname
		";
		return $columns;
	}
	################################################################################################# END - DATATABLE AJAX METHODS
}
