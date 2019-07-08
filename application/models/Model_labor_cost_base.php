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
}