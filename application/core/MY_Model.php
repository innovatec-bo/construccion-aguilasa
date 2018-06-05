<?php

/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 7/12/2017
 * Time: 4:32 PM
 */
class MY_Model
{
    const TABLE_NAME = "";
    const TABLE_ID = "";
    const ATTRIB_SUFIX = "";
    const DELETE_FIELD = 'deleted';

    protected $_id;
    protected $_deleted;
    protected $_createdOn;
    protected $_createdBy;
    protected $_editedOn;
    protected $_editedBy;

    public function __construct()
    {
        $this->_id = NULL;
        $this->_deleted = 0;
    }

    public function __clone()
    {
        $this->_id = NULL;
        $this->_createdOn = NULL;
        $this->_createdBy = NULL;
        $this->_editedOn = NULL;
        $this->_editedBy = NULL;
    }

    /**
     * Get a object
     *
     * @param int $id
     * @return object
     */
    public static function getById($id)
    {
        $ci=&get_instance();
        $ci->load->database();
        $sql = "
            select * from ".static::TABLE_NAME." where ".static::TABLE_ID." = ".$ci->db->escape($id)." and ".static::notDeleted()."
        ";
        $query = $ci->db->query($sql);
        $response = static::recast(get_called_class(),$query->row());
        return $response;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }
    public function __toString()
    {
        $jsonEncode = json_encode($this->toArray());
        return $jsonEncode;
    }

    public function toArray()
    {
        return array();
    }

    protected static function recastArray($className, $array)
    {
        $resultArray = array();
        foreach ($array as $stdObject)
        {
            $classObject = static::recast($className, $stdObject);
            $resultArray[$classObject->getId()] = $classObject;
        }
        return $resultArray;
    }

    public function save()
    {
        $ci=&get_instance();
        $ci->load->database();
        $ci->load->library("session");
        date_default_timezone_set('America/La_Paz');
        $now = new DateTime();
        $currentDate = $now->format( "Y-m-d H:i:s" );
        if ( $this->getId() !== null && $this->getId() !== "" )
        {
            $this->_editedOn = $currentDate;
            $ci->db->update( static::TABLE_NAME, $this->toArray(), array( static::TABLE_ID => $this->getId()));
        }
        else
        {
            $this->_createdOn = $currentDate;

            $result = $ci->db->insert( static::TABLE_NAME, $this->toArray() );
            if ( $result === true )
            {
                $this->_id = $ci->db->insert_id();
            }
        }
        return $this;
    }

    public function delete($makePhysicalDelete = FALSE)
    {
        $ci = &get_instance();
        $ci->load->database();
        if (!$makePhysicalDelete)
        {
            // Delete logically the row. Change the state.
            return $ci->db->update(static::TABLE_NAME, array(static::DELETE_FIELD . static::ATTRIB_SUFIX => 1), array(static::TABLE_ID => $this->getId()));
        }
        else
        {
            //Delete fisically the row.
            return $ci->db->delete(static::TABLE_NAME, array(static::TABLE_ID => $this->getId()));
        }
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

    public static function search($text, $limit, $offset, $orderBy = null, $orderType = 'asc', $colsArray = null)
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
        $sql .= ') group by '.static::TABLE_ID.' order by ' . $orderBy . ' ' . $orderType . ' limit ' . $limit . ' offset ' . $offset;

        $query = $ci->db->query($sql);
        return $query->result();
    }

    public static function searchTotalCount($text, $colsArray = null)
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
        $sql .= ')';

        $query = $ci->db->query($sql);
        $totalCount = $query->row()->total;
        return $totalCount;
    }

    private static function _dataTableColumns()
    {
        $columns = static::TABLE_NAME.".*";
        return $columns;
    }
    ################################################################################################# END - DATATABLE AJAX METHODS

    protected static function notDeleted()
    {
        return static::DELETE_FIELD.static::ATTRIB_SUFIX." != 1 ";
    }

}