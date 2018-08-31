<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 28/08/2018
 * Time: 12:07 PM
 */

class Model_warehouse_base extends MY_Model
{
    const TABLE_NAME = "wfl_warehouses";
    const TABLE_ID = "id_war";
    const ATTRIB_SUFIX = "_war";

    protected $_projectId;
    protected $_statusId;

    //22 => warehouse status
    public function __construct($projectId = NULL, $statusId = 22)
    {
        parent::__construct();
        $this->_projectId = $projectId;
        $this->_statusId = $statusId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_war" => $this->_id,
            "project_id_war" => $this->_projectId,
            "status_id_war" => $this->_statusId,
            "deleted_war" => $this->_deleted,
            "createdon_war" => $this->_createdOn,
            "createdby_war" => $this->_createdBy,
            "editedon_war" => $this->_editedOn,
            "editedby_war" => $this->_editedBy
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
                $object->project_id_war,
                $object->status_id_war
            );
            $instance->_id = $object->id_war;

            $instance->_deleted = $object->deleted_war;
            $instance->_createdOn = $object->createdon_war;
            $instance->_createdBy = $object->createdby_war;
            $instance->_editedOn = $object->editedon_war;
            $instance->_editedBy = $object->editedby_war;
            $response = $instance;
        }
        return $response;
    }
    //getters
    public function getProjectId()
    {
        return $this->_projectId;
    }
    //setters
    public function setStatus($status)
    {
        $this->_statusId = $status;
    }

    ################################################################################################# BEGIN - DATATABLE AJAX METHODS

    /**
     * @param string $statusId
     * @return mixed
     */
    public static function countAll($statusId = "")
    {
        $ci = &get_instance();
        $ci->load->database();

        //check definition on Model_warehouse_sp.txt
        $sql = 'CALL warehouse_count_all('.$ci->db->escape($statusId).')';
        $query = $ci->db->query($sql);
        $totalCount = $query->row()->total;
        $ci->db->close();
        return $totalCount;
    }

    /**
     * @param string $statusId
     * @param $limit
     * @param null $offset
     * @param null $orderBy
     * @param string $orderType
     * @return mixed
     */
    public static function getAllProjects($statusId = "", $limit, $offset, $orderBy = null, $orderType = 'asc')
    {
        if ($orderBy === null)
        {
            $orderBy = static::TABLE_ID;
        }
        $ci = &get_instance();
        $ci->load->database();

        //check definition on Model_warehouse_sp.txt
        $sql = 'CALL warehouse_get_all('.$ci->db->escape($statusId).','.$limit.','.$offset.','.$ci->db->escape($orderBy).', '.$ci->db->escape($orderType).')';
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
    public static function searchProject($statusId = "", $text, $limit, $offset, $orderBy = null, $orderType = 'asc', $colsArray = null)
    {
        if ($orderBy === null)
        {
            $orderBy = static::TABLE_ID;
        }
        $ci = &get_instance();
        $ci->load->database();

        //check definition on Model_warehouse_sp.txt
        $sql = 'CALL warehouse_search('.$ci->db->escape($statusId).','.$limit.','.$offset.','.$ci->db->escape($orderBy).', '.$ci->db->escape($orderType).','.$ci->db->escape($text).')';
        $query = $ci->db->query($sql);
        $result = $query->result();
        $ci->db->close();
        return $result;
    }

    public static function searchTotalCount($statusId = "", $text = "", $colsArray = null)
    {
        $ci = &get_instance();
        $ci->load->database();

        //check definition on Model_warehouse_sp.txt
        $sql = 'CALL warehouse_search_total_count('.$ci->db->escape($statusId).','.$ci->db->escape($text).')';
        $query = $ci->db->query($sql);
        $totalCount = $query->row()->total;
        $ci->db->close();
        return $totalCount;
    }
    ################################################################################################# END - DATATABLE AJAX METHODS
}