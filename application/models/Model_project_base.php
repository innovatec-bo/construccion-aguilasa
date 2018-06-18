<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 04/06/2018
 * Time: 10:21 AM
 */

class Model_project_base extends MY_Model
{
    const TABLE_NAME = "wfl_projects";
    const TABLE_ID = "id_pro";
    const ATTRIB_SUFIX = "_pro";

    protected $_projectCode;
    protected $_projectName;
    protected $_address;
    protected $_entryDate;
    protected $_creFiscal;
    protected $_status;

    public function __construct($projectCode = "", $projectName = "", $address = "", $entryDate = "", $creFiscal = "", $status = NULL)
    {
        parent::__construct();
        $this->_projectCode = $projectCode;
        $this->_projectName = $projectName;
        $this->_address = $address;
        $this->_entryDate = $entryDate;
        $this->_creFiscal = $creFiscal;
        $this->_status = $status;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_pro" => $this->_id,
            "code_pro" => $this->_projectCode,
            "project_name_pro" => $this->_projectName,
            "address_pro" => $this->_address,
            "entry_date_pro" => $this->_entryDate,
            "cre_fiscal_pro" => $this->_creFiscal,
            "status_pro" => $this->_status,
            "deleted_pro" => $this->_deleted,
            "createdon_pro" => $this->_createdOn,
            "createdby_pro" => $this->_createdBy,
            "editedon_pro" => $this->_editedOn,
            "editedby_pro" => $this->_editedBy
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
                $object->code_pro,
                $object->project_name_pro,
                $object->address_pro,
                $object->entry_date_pro,
                $object->cre_fiscal_pro,
                $object->status_pro
            );
            $instance->_id = $object->id_pro;

            $instance->_deleted = $object->deleted_pro;
            $instance->_createdOn = $object->createdon_pro;
            $instance->_createdBy = $object->createdby_pro;
            $instance->_editedOn = $object->editedon_pro;
            $instance->_editedBy = $object->editedby_pro;
            $response = $instance;
        }
        return $response;
    }

    public function setProjectName($projectName)
    {
        $this->_projectName = $projectName;
    }

    public function setStatus($statusId)
    {
        $this->_status = $statusId;
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
                from ' . static::TABLE_NAME .' where '.static::notDeleted();

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

        $sql = 'select '.static::_dataTableColumns().' from ' . static::TABLE_NAME . ' where '.static::notDeleted().'             
                group by '.static::TABLE_ID.' order by ' . $orderBy . ' ' . $orderType . ' limit ' . $limit . ' offset ' . $offset;
        $query = $ci->db->query($sql);
        $result = $query->result();
        return $result;
    }

    /**
     * @param $text
     * @param $limit
     * @param $offset
     * @param null $orderBy
     * @param string $orderType
     * @param null $colsArray
     * @param array $additionalParameters
     * @return mixed
     */
    public static function search($text, $limit, $offset, $orderBy = null, $orderType = 'asc', $colsArray = null, $additionalParameters = array())
    {
        if ($orderBy === null)
        {
            $orderBy = static::TABLE_ID;
        }
        $ci = &get_instance();
        $ci->load->database();

        $sql = 'select '.static::_dataTableColumns().' from ' . static::TABLE_NAME;
        $sql .= ' where '.static::notDeleted().' and (';
        foreach ($colsArray as $var)
        {
            $sql .= ' ' . $var . ' like \'%' . $text . '%\' or ';
        }

        $sql = substr($sql, 0, -3);
        $sql .= ') '.static::_additionalParameters($additionalParameters).' group by '.static::TABLE_ID.' order by ' . $orderBy . ' ' . $orderType . ' limit ' . $limit . ' offset ' . $offset;

        $query = $ci->db->query($sql);
        return $query->result();
    }

    /**
     * @param $text
     * @param null $colsArray
     * @param array $additionalParameters
     * @return mixed
     */
    public static function searchTotalCount($text, $colsArray = null, $additionalParameters = array())
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = 'select count(' . static::TABLE_ID . ') as total from ' . static::TABLE_NAME;
        $sql .= ' where '.static::notDeleted().' and (';

        foreach ($colsArray as $var)
        {
            $sql .= ' ' . $var . ' like \'%' . $text . '%\' or ';
        }

        $sql = substr($sql, 0, -3);
        $sql .= ') '.static::_additionalParameters($additionalParameters);

        $query = $ci->db->query($sql);
        $totalCount = $query->row()->total;
        return $totalCount;
    }

    private static function _dataTableColumns()
    {
        $columns = static::TABLE_NAME.".*";
        return $columns;
    }

    private static function _additionalParameters($list = array())
    {
        $ci=&get_instance();
        $ci->load->database();
        $sql = "";
        if(is_array($list) && count($list) >= 1)
        {
            foreach($list as $parameter => $value)
            {
                switch ($parameter)
                {
                    case "status":
                        $sql .= " and status_pro = ".$ci->db->escape($value);
                        break;
                }
            }
        }

        return $sql;
    }
    ################################################################################################# END - DATATABLE AJAX METHODS
}