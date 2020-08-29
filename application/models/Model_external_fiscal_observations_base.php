<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2020-08-27
 * Time: 04:10:02
 */

class Model_external_fiscal_observations_base extends MY_Model
{
    const TABLE_NAME = "wfl_external_fiscal_observations";
    const TABLE_ID = "id_efo";
    const ATTRIB_SUFIX = "_efo";

    protected $_projectId;
    protected $_fiscalId;
	protected $_observation;
	protected $_fixedBy;
	protected $_fixDetail;
	protected $_fixedDate;
	protected $_statusId;
	protected $_entryDate;
	protected $_fixed;

    public function __construct($projectId = NULL, $fiscalId = "", $observation = "", $fixedBy = NULL, $fixDetail = "", $fixedDate = NULL, $statusId = NULL, $entryDate = NULL, $fixed = 0)
    {
        parent::__construct();
        $this->_projectId = $projectId;
        $this->_fiscalId = $fiscalId;
		$this->_observation = $observation;
		$this->_fixedBy = $fixedBy;
		$this->_fixDetail = $fixDetail;
		$this->_fixedDate = $fixedDate;
		$this->_statusId = $statusId;
		$this->_entryDate = $entryDate;
		$this->_fixed = $fixed;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_efo" => $this->_id,
			"project_id_efo" => $this->_projectId,
			"fiscal_id_efo" => $this->_fiscalId,
			"observation_efo" => $this->_observation,
			"fixed_by_efo" => $this->_fixedBy,
			"fix_detail_efo" => $this->_fixDetail,
			"fixed_date_efo" => $this->_fixedDate,
			"status_id_efo" => $this->_statusId,
			"entry_date_efo" => $this->_entryDate,
			"fixed_efo" => $this->_fixed,
			"deleted_efo" => $this->_deleted,
			"createdon_efo" => $this->_createdOn,
			"createdby_efo" => $this->_createdBy,
			"editedon_efo" => $this->_editedOn,
			"editedby_efo" => $this->_editedBy
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
                $object->project_id_efo,
                $object->fiscal_id_efo,
				$object->observation_efo,
				$object->fixed_by_efo,
				$object->fix_detail_efo,
				$object->fixed_date_efo,
				$object->status_id_efo,
				$object->entry_date_efo,
				$object->fixed_efo
            );
            $instance->_id = $object->id_efo;

            $instance->_deleted = $object->deleted_efo;
            $instance->_createdOn = $object->createdon_efo;
            $instance->_createdBy = $object->createdby_efo;
            $instance->_editedOn = $object->editedon_efo;
            $instance->_editedBy = $object->editedby_efo;
            $response = $instance;
        }
        return $response;
    }

    //Setters
	public function setProjectId($projectId)
	{
		$this->_projectId = $projectId;
	}

	public function setFiscalId($fiscalId)
	{
		$this->_fiscalId = $fiscalId;
	}

	public function setObservation($observation)
	{
		$this->_observation = $observation;
	}

	public function setFixedBy($fixedBy)
	{
		$this->_fixedBy = $fixedBy;
	}

	public function setFixDetail($fixDetail)
	{
		$this->_fixDetail = $fixDetail;
	}

	public function setFixedDate($fixedDate)
	{
		$this->_fixedDate = $fixedDate;
	}

	public function setStatusId($statusId)
	{
		$this->_statusId = $statusId;
	}

	public function setEntryDate($entryDate)
	{
		$this->_entryDate = $entryDate;
	}

	public function setFixed($fixed)
	{
		$this->_fixed = $fixed;
	}

    //Getters
	public function getProjectId()
	{
		return $this->_projectId;
	}

	public function getFiscalId()
	{
		return $this->_fiscalId;
	}

	public function getObservation()
	{
		return $this->_observation;
	}

	public function getFixedBy()
	{
		return $this->_fixedBy;
	}

	public function getFixDetail()
	{
		return $this->_fixDetail;
	}

	public function getFixedDate()
	{
		return $this->_fixedDate;
	}

	public function getStatusId()
	{
		return $this->_statusId;
	}

	public function getEntryDate()
	{
    	return $this->_entryDate;
	}

	public function getFixed()
	{
    	return $this->_fixed;
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
