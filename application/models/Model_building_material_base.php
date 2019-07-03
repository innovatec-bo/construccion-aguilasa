<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:04 PM
 */

class Model_building_structure_base extends MY_Model
{
    const TABLE_NAME = "bui_building_structures";
    const TABLE_ID = "id_bus";
    const ATTRIB_SUFIX = "_bus";

    protected $_structureCode;
    protected $_description;
    protected $_unit;
    protected $_budgetType;

    public function __construct($structureCode = "", $description = "", $unit = "", $budgetType = NULL)
    {
        parent::__construct();
        $this->_structureCode = $structureCode;
        $this->_description = $description;
        $this->_unit = $unit;
        $this->_budgetType = $budgetType;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_bus" => $this->_id,
            "structure_code_bus" => $this->_structureCode,
            "description_bus" => $this->_description,
            "unit_bus" => $this->_unit,
            "budget_type_bus" => $this->_budgetType,
            "deleted_bus" => $this->_deleted,
            "createdon_bus" => $this->_createdOn,
            "createdby_bus" => $this->_createdBy,
            "editedon_bus" => $this->_editedOn,
            "editedby_bus" => $this->_editedBy
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
                $object->structure_code_bus,
                $object->description_bus,
                $object->unit_bus,
                $object->budget_type_bus
            );
            $instance->_id = $object->id_bus;

            $instance->_deleted = $object->deleted_bus;
            $instance->_createdOn = $object->createdon_bus;
            $instance->_createdBy = $object->createdby_bus;
            $instance->_editedOn = $object->editedon_bus;
            $instance->_editedBy = $object->editedby_bus;
            $response = $instance;
        }
        return $response;
    }
}