<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:19 PM
 */

class Model_labor_cost_base extends MY_Model
{
    const TABLE_NAME = "bui_labor_cost";
    const TABLE_ID = "id_lac";
    const ATTRIB_SUFIX = "_lac";

    protected $_laborDetailId;
    protected $_buildingStructureId;
    protected $_activity;
    protected $_execution;
    protected $_quantity;
    protected $_unitPrice;

    public function __construct($laborDetailId = NULL, $buildingStructureId = NULL, $activity = "", $execution = "", $quantity = "", $unitPrice = 0)
    {
        parent::__construct();
        $this->_laborDetailId = $laborDetailId;
        $this->_buildingStructureId = $buildingStructureId;
        $this->_activity = $activity;
        $this->_execution = $execution;
        $this->_quantity = $quantity;
        $this->_unitPrice = $unitPrice;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_lac" => $this->_id,
            "labor_detail_id_lac" => $this->_laborDetailId,
            "building_structure_id_lac" => $this->_buildingStructureId,
            "activity_lac" => $this->_activity,
            "execution_lac" => $this->_execution,
            "quantity_lac" => $this->_quantity,
            "unit_price_lac" => $this->_unitPrice,
            "deleted_lac" => $this->_deleted,
            "createdon_lac" => $this->_createdOn,
            "createdby_lac" => $this->_createdBy,
            "editedon_lac" => $this->_editedOn,
            "editedby_lac" => $this->_editedBy
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
                $object->labor_detail_id_lac,
                $object->building_structure_id_lac,
                $object->activity_lac,
                $object->execution_lac,
                $object->quantity_lac,
                $object->unit_price_lac
            );
            $instance->_id = $object->id_lac;

            $instance->_deleted = $object->deleted_lac;
            $instance->_createdOn = $object->createdon_lac;
            $instance->_createdBy = $object->createdby_lac;
            $instance->_editedOn = $object->editedon_lac;
            $instance->_editedBy = $object->editedby_lac;
            $response = $instance;
        }
        return $response;
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
                LEFT JOIN bui_building_structures on building_structure_id_lac = id_bus
                LEFT JOIN bui_labor_details on labor_detail_id_lac = id_lad
                LEFT JOIN wfl_projects on id_pro = project_id_lad
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

        $sql = 'select '.static::_dataTableColumns().' from ' . static::TABLE_NAME . ' 
                LEFT JOIN bui_building_structures on building_structure_id_lac = id_bus
                LEFT JOIN bui_labor_details on labor_detail_id_lac = id_lad
                LEFT JOIN wfl_projects on id_pro = project_id_lad
                where '.static::notDeleted().'             
                group by '.static::TABLE_ID.' order by ' . $orderBy . ' ' . $orderType . ' limit ' . $limit . ' offset ' . $offset;
        $query = $ci->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public static function searchLaborCost($budgetaryPosition = "", $managementBy = "", $text, $limit, $offset, $orderBy = null, $orderType = 'asc', $colsArray = null)
    {
        if ($orderBy === null)
        {
            $orderBy = static::TABLE_ID;
        }
        $ci = &get_instance();
        $ci->load->database();

        $budgetaryPositionFilter = $budgetaryPosition == ""?"":" and budgetary_position_pro = ".$ci->db->escape($budgetaryPosition)." ";
        $managementBy = $managementBy == ""? "": " and management_by_pro = ".$ci->db->escape($managementBy)." ";

        $sql = 'select '.static::_dataTableColumns().' from ' . static::TABLE_NAME.' 
                LEFT JOIN bui_building_structures on building_structure_id_lac = id_bus
                LEFT JOIN bui_labor_details on labor_detail_id_lac = id_lad
                LEFT JOIN wfl_projects on id_pro = project_id_lad
        ';
        $sql .= ' where '.static::notDeleted().' and (';
        foreach ($colsArray as $var)
        {
            $sql .= ' ' . $var . ' like \'%' . $text . '%\' or ';
        }

        $sql = substr($sql, 0, -3);
        $sql .= ') '.$budgetaryPositionFilter.' '.$managementBy.' group by '.static::TABLE_ID.' order by ' . $orderBy . ' ' . $orderType . ' limit ' . $limit . ' offset ' . $offset;

        $query = $ci->db->query($sql);//echo"<pre>";var_dump($sql);exit;
        return $query->result();
    }

    public static function searchTotalCountLaborCost($budgetaryPosition = "", $managementBy = "", $text, $colsArray = null)
    {
        $ci = &get_instance();
        $ci->load->database();

        $budgetaryPositionFilter = $budgetaryPosition == ""?"":" and budgetary_position_pro = ".$ci->db->escape($budgetaryPosition)." ";
        $managementBy = $managementBy == ""? "": " and management_by_pro = ".$ci->db->escape($managementBy)." ";

        $sql = 'select count(' . static::TABLE_ID . ') as total from ' . static::TABLE_NAME;
        $sql .= '
        LEFT JOIN bui_building_structures on building_structure_id_lac = id_bus
        LEFT JOIN bui_labor_details on labor_detail_id_lac = id_lad
        LEFT JOIN wfl_projects on id_pro = project_id_lad
         where '.static::notDeleted().' and (';

        foreach ($colsArray as $var)
        {
            $sql .= ' ' . $var . ' like \'%' . $text . '%\' or ';
        }

        $sql = substr($sql, 0, -3);
        $sql .= ') '.$budgetaryPositionFilter.' '.$managementBy.' ';

        $query = $ci->db->query($sql);
        $totalCount = $query->row()->total;
        return $totalCount;
    }

    private static function _dataTableColumns()
    {
        $columns = static::TABLE_NAME.".*,structure_code_bus, description_bus, budgetary_position_pro,CASE
                WHEN management_by_pro = 1 then 'Sistema Santa Cruz'
                WHEN management_by_pro = 2 then 'Sistema Velasco'
                WHEN management_by_pro = 3 then 'Sistema Misiones'
                WHEN management_by_pro = 4 then 'Sistema Camiri'
                WHEN management_by_pro = 5 then 'Sistema German bush'
                WHEN management_by_pro = 6 then 'Sistema Robore'
                WHEN management_by_pro = 7 then 'Sistema Valles'
            END management_by_pro, code_pro";
        return $columns;
    }
    ################################################################################################# END - DATATABLE AJAX METHODS
}