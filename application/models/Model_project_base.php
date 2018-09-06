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
    protected $_system;
    protected $_address;
    protected $_entryDate;
    protected $_creFiscal;
    protected $_status;
    protected $_projectStart;
    protected $_projectEnd;
    protected $_points;
    protected $_distance;
    protected $_managementBy;
    protected $_qualityLevel;
    protected $_creDesignCompletionDate;
    protected $_creBuildingCompletionDate;

    public function __construct($projectCode = "", $projectName = "", $system = NULL, $address = "", $entryDate = "", $creFiscal = "", $status = NULL, $projectStart = "", $projectEnd = "", $points = 0, $distance = 0,
                                $managementBy = NULL, $qualityLevel = 0, $creDesignCompletionDate = "", $creBuildingCompletionDate = "")
    {
        parent::__construct();
        $this->_projectCode = $projectCode;
        $this->_projectName = $projectName;
        $this->_system = $system;
        $this->_address = $address;
        $this->_entryDate = $entryDate;
        $this->_creFiscal = $creFiscal;
        $this->_status = $status;
        $this->_projectStart = $projectStart;
        $this->_projectEnd = $projectEnd;
        $this->_points = $points;
        $this->_distance = $distance;
        $this->_managementBy = $managementBy;
        $this->_qualityLevel = $qualityLevel;
        $this->_creDesignCompletionDate = $creDesignCompletionDate;
        $this->_creBuildingCompletionDate = $creBuildingCompletionDate;
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
            "system_pro" => $this->_system,
            "address_pro" => $this->_address,
            "entry_date_pro" => $this->_entryDate,
            "cre_fiscal_pro" => $this->_creFiscal,
            "status_pro" => $this->_status,
            "project_start_pro" => $this->_projectStart,
            "project_end_pro" => $this->_projectEnd,
            "points_pro" => $this->_points,
            "distance_pro" => $this->_distance,
            "management_by_pro" => $this->_managementBy,
            "quality_level_pro" => $this->_qualityLevel,
            "cre_design_completion_date_pro" => $this->_creDesignCompletionDate,
            "cre_building_completion_date_pro" => $this->_creBuildingCompletionDate,
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
                $object->system_pro,
                $object->address_pro,
                $object->entry_date_pro,
                $object->cre_fiscal_pro,
                $object->status_pro,
                $object->project_start_pro,
                $object->project_end_pro,
                $object->points_pro,
                $object->distance_pro,
                $object->management_by_pro,
                $object->quality_level_pro,
                $object->cre_design_completion_date_pro,
                $object->cre_building_completion_date_pro
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

    public function setCode($code)
    {
        $this->_projectCode = $code;
    }

    public function setStatus($statusId)
    {
        $this->_status = $statusId;
    }

    public function setSystem($system)
    {
        $this->_system = $system;
    }

    public function setAddress($address)
    {
        $this->_address = $address;
    }

    public function setCREFiscal($creFiscal)
    {
        $this->_creFiscal = $creFiscal;
    }

    public function setStart($start)
    {
        $this->_projectStart = $start;
    }

    public function setEnd($end)
    {
        $this->_projectEnd = $end;
    }

    public function setManagementBy($managementBy)
    {
        $this->_managementBy = $managementBy;
    }

    public function setQualityLevel($qualityLevel)
    {
        $this->_qualityLevel = $qualityLevel;
    }

    public function setCreDesignCompletionDate($creDesignCompletionDate)
    {
        $this->_creDesignCompletionDate = $creDesignCompletionDate;
    }

    public function setCreBuildingCompletionDate($creBuildingCompletionDate)
    {
        $this->_creBuildingCompletionDate = $creBuildingCompletionDate;
    }

    public function getCode()
    {
        return $this->_projectCode;
    }
    ################################################################################################# BEGIN - DATATABLE AJAX METHODS

    /**
     * @return mixed
     */
    public static function countAll_deprecated()
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
    public static function getAll_deprecated($limit, $offset, $orderBy = null, $orderType = 'asc')
    {
        if ($orderBy === null)
        {
            $orderBy = static::TABLE_ID;
        }
        $ci = &get_instance();
        $ci->load->database();

        $sql = 'select '.static::_dataTableColumns().' 
                from ' . static::TABLE_NAME . '
                LEFT JOIN wfl_project_stakes on project_id_prs = id_pro
                LEFT JOIN wfl_stakes_team_leader on id_stl = stakes_leader_id_prs
                where '.static::notDeleted().'             
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
    public static function search_deprecated($text, $limit, $offset, $orderBy = null, $orderType = 'asc', $colsArray = null, $additionalParameters = array())
    {
        if ($orderBy === null)
        {
            $orderBy = static::TABLE_ID;
        }
        $ci = &get_instance();
        $ci->load->database();

        $sql = 'select '.static::_dataTableColumns().' from ' . static::TABLE_NAME;
        $sql.='
            LEFT JOIN wfl_project_stakes on project_id_prs = id_pro
            LEFT JOIN wfl_stakes_team_leader on id_stl = stakes_leader_id_prs
        ';
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
    public static function searchTotalCount_deprecated($text, $colsArray = null, $additionalParameters = array())
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = 'select count(' . static::TABLE_ID . ') as total from ' . static::TABLE_NAME;
        $sql.='
            LEFT JOIN wfl_project_stakes on project_id_prs = id_pro
            LEFT JOIN wfl_stakes_team_leader on id_stl = stakes_leader_id_prs
        ';
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
        $columns = static::TABLE_NAME.".*, GROUP_CONCAT(DISTINCT leader_stl) leader_stl";
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
                        $statusList = explode(",",$value);
                        $statusScape = "";
                        foreach ($statusList as $status)
                        {
                            $statusScape .= $ci->db->escape($status).", ";
                        }
                        $statusScape = substr($statusScape,0,-2);
                        $sql .= " and status_pro in ( ".$statusScape." )";
                        break;
                }
            }
        }

        return $sql;
    }
    ################################################################################################# END - DATATABLE AJAX METHODS

    ################################################################################################# BEGIN - DATATABLE AJAX METHODS

    /**
     * @param string $statusId
     * @return mixed
     */
    public static function countAll($statusId = "", $userId = "")
    {
        $ci = &get_instance();
        $ci->load->database();

        //check definition on Model_project_sp.txt
        $sql = 'CALL project_count_all('.$ci->db->escape($statusId).','.$ci->db->escape($userId).')';
        $query = $ci->db->query($sql);
        $totalCount = $query->row()->total;
        $ci->db->close();
        return $totalCount;
    }

    /**
     * @param string $statusId
     * @param string $userId
     * @param $limit
     * @param $offset
     * @param null $orderBy
     * @param string $orderType
     * @return mixed
     */
    public static function getAllProjects($statusId = "", $userId = "", $limit, $offset, $orderBy = null, $orderType = 'asc')
    {
        if ($orderBy === null)
        {
            $orderBy = static::TABLE_ID;
        }
        $ci = &get_instance();
        $ci->load->database();

        //check definition on Model_project_sp.txt
        $sql = 'CALL project_get_all('.$ci->db->escape($statusId).','.$ci->db->escape($userId).','.$limit.','.$offset.','.$ci->db->escape($orderBy).', '.$ci->db->escape($orderType).')';
        $query = $ci->db->query($sql);
        $result = $query->result();
        $ci->db->close();
        return $result;
    }

    /**
     * @param $statusId
     * @param $text
     * @param $limit
     * @param null $offset
     * @param null $orderBy
     * @param string $orderType
     * @param null $colsArray
     * @return mixed
     */
    public static function searchProject($statusId = "", $userId = "", $text, $limit, $offset, $orderBy = null, $orderType = 'asc', $colsArray = null)
    {
        if ($orderBy === null)
        {
            $orderBy = static::TABLE_ID;
        }
        $ci = &get_instance();
        $ci->load->database();

        //check definition on Model_project_sp.txt
        $sql = 'CALL project_search('.$ci->db->escape($statusId).','.$ci->db->escape($userId).','.$limit.','.$offset.','.$ci->db->escape($orderBy).', '.$ci->db->escape($orderType).','.$ci->db->escape($text).')';
        $query = $ci->db->query($sql);
        $result = $query->result();
        $ci->db->close();
        return $result;
    }

    public static function searchTotalCount($statusId = "", $userId = "", $text = "", $colsArray = null)
    {
        $ci = &get_instance();
        $ci->load->database();

        //check definition on Model_project_sp.txt
        $sql = 'CALL project_search_total_count('.$ci->db->escape($statusId).','.$ci->db->escape($userId).','.$ci->db->escape($text).')';
        $query = $ci->db->query($sql);
        $totalCount = $query->row()->total;
        $ci->db->close();
        return $totalCount;
    }
    ################################################################################################# END - DATATABLE AJAX METHODS
}
