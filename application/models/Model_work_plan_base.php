<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/11/06
 * Time: 2:35 PM
 */

class Model_work_plan_base extends MY_Model
{
    const TABLE_NAME = "wfl_work_plans";
    const TABLE_ID = "id_wpl";
    const ATTRIB_SUFIX = "_wpl";

    protected $_title;
    protected $_fiscalId;
    protected $_builderId;
    protected $_weekNumber;

    public function __construct($title = "", $fiscalId = NULL, $builderId = NULL, $weekNumber = NULL)
    {
        parent::__construct();
        $this->_title = $title;
        $this->_fiscalId = $fiscalId;
        $this->_builderId = $builderId;
        $this->_weekNumber = $weekNumber;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_wpl" => $this->_id,
            "title_wpl" => $this->_title,
            "fiscal_id_wpl" => $this->_fiscalId,
            "builder_id_wpl" => $this->_builderId,
            "week_number_wpl" => $this->_weekNumber,
            "deleted_wpl" => $this->_deleted,
            "createdon_wpl" => $this->_createdOn,
            "createdby_wpl" => $this->_createdBy,
            "editedon_wpl" => $this->_editedOn,
            "editedby_wpl" => $this->_editedBy
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
                $object->title_wpl,
                $object->fiscal_id_wpl,
                $object->builder_id_wpl,
                $object->week_number_wpl
            );
            $instance->_id = $object->id_wpl;

            $instance->_deleted = $object->deleted_wpl;
            $instance->_createdOn = $object->createdon_wpl;
            $instance->_createdBy = $object->createdby_wpl;
            $instance->_editedOn = $object->editedon_wpl;
            $instance->_editedBy = $object->editedby_wpl;
            $response = $instance;
        }
        return $response;
    }

    //    setters - begin
    public function setTitle($title)
    {
        $this->_title = $title;
    }

    public function setFiscalId($fiscalId)
    {
        $this->_fiscalId = $fiscalId;
    }

    public function setBuilderId($builderId)
    {
        $this->_builderId = $builderId;
    }

    public function setWeekNumber($weekNumber)
    {
        $this->_weekNumber = $weekNumber;
    }
    //    setters - end

    // getters - begin

    public function getCreatedBy()
    {
        return $this->_createdBy;
    }

    // getters - end

    ################################################################################################# BEGIN - DATATABLE AJAX METHODS
    /**
     * @return mixed
     */
    public static function countAll($additionalParameters = array())
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = '
                select count(' . static::TABLE_ID. ') as total
                from ' . static::TABLE_NAME .' 
                LEFT JOIN sec_users uf on fiscal_id_wpl = uf.id_usr
                LEFT JOIN sec_users ub on builder_id_wpl = ub.id_usr
                where '.static::notDeleted().' '.static::_additionalParameters($additionalParameters);

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
    public static function getAll($limit, $offset, $orderBy = null, $orderType = 'asc', $additionalParameters = array())
    {
        if ($orderBy === null)
        {
            $orderBy = static::TABLE_ID;
        }
        $ci = &get_instance();
        $ci->load->database();

        $sql = 'select '.static::_dataTableColumns().' 
                from ' . static::TABLE_NAME . ' 
                LEFT JOIN wfl_work_plan_dates on work_plan_id_wpd = id_wpl
                LEFT JOIN wfl_projects on project_id_wpd = id_pro and deleted_wpd != 1
                LEFT JOIN sec_users uf on fiscal_id_wpl = uf.id_usr
                LEFT JOIN sec_users ub on builder_id_wpl = ub.id_usr
                where '.static::notDeleted().' '.static::_additionalParameters($additionalParameters).'           
                group by '.static::TABLE_ID.' order by ' . $orderBy . ' ' . $orderType . ' limit ' . $limit . ' offset ' . $offset;
        $query = $ci->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public static function search($text, $limit, $offset, $orderBy = null, $orderType = 'asc', $colsArray = null, $additionalParameters = array())
    {
        if ($orderBy === null)
        {
            $orderBy = static::TABLE_ID;
        }
        $ci = &get_instance();
        $ci->load->database();

        $sql = 'select '.static::_dataTableColumns().' 
        from ' . static::TABLE_NAME;
        $sql .= ' 
        LEFT JOIN wfl_work_plan_dates on work_plan_id_wpd = id_wpl
        LEFT JOIN wfl_projects on project_id_wpd = id_pro and deleted_wpd != 1
        LEFT JOIN sec_users uf on fiscal_id_wpl = uf.id_usr
        LEFT JOIN sec_users ub on builder_id_wpl = ub.id_usr
        where '.static::notDeleted().' and (';
        foreach ($colsArray as $var)
        {
            $sql .= ' ' . $var . ' like \'%' . $text . '%\' or ';
        }

        $sql = substr($sql, 0, -3);
        $sql .= ') '.static::_additionalParameters($additionalParameters).' group by '.static::TABLE_ID.' order by ' . $orderBy . ' ' . $orderType . ' limit ' . $limit . ' offset ' . $offset;

        $query = $ci->db->query($sql);
        return $query->result();
    }

    public static function searchTotalCount($text, $colsArray = null)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = 'select count(' . static::TABLE_ID . ') as total from ' . static::TABLE_NAME;
        $sql .= ' 
        LEFT JOIN sec_users uf on fiscal_id_wpl = uf.id_usr
        LEFT JOIN sec_users ub on builder_id_wpl = ub.id_usr
        where '.static::notDeleted().' and (';

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
        $columns = static::TABLE_NAME.".*, 
                CONCAT(uf.firstname_usr,' ',uf.lastname_usr) fiscal_full_name,
                CONCAT(ub.firstname_usr,' ',ub.lastname_usr) builder_full_name,
                GROUP_CONCAT(distinct code_pro) project_list";
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
                    case "fiscal":
                            $sql .= ' and uf.id_usr = '.$ci->db->escape($value).' ';
                        break;
                }
            }
        }
//        echo"<pre>";var_dump($sql);exit;
        return $sql;
    }
    ################################################################################################# END - DATATABLE AJAX METHODS
}