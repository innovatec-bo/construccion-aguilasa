<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:04 PM
 */

class Model_building_material_base extends MY_Model
{
    const TABLE_NAME = "bui_building_materials";
    const TABLE_ID = "id_bum";
    const ATTRIB_SUFIX = "_bum";

    protected $_structure;
    protected $_description;
    protected $_unit;

    public function __construct($structure = "", $description = "", $unit = "")
    {
        parent::__construct();
        $this->_structure = $structure;
        $this->_description = $description;
        $this->_unit = $unit;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_bum" => $this->_id,
            "structure_bum" => $this->_structure,
            "description_bum" => $this->_description,
            "unit_bum" => $this->_unit,
            "deleted_bum" => $this->_deleted,
            "createdon_bum" => $this->_createdOn,
            "createdby_bum" => $this->_createdBy,
            "editedon_bum" => $this->_editedOn,
            "editedby_bum" => $this->_editedBy
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
                $object->structure_bum,
                $object->description_bum,
                $object->unit_bum
            );
            $instance->_id = $object->id_bum;

            $instance->_deleted = $object->deleted_bum;
            $instance->_createdOn = $object->createdon_bum;
            $instance->_createdBy = $object->createdby_bum;
            $instance->_editedOn = $object->editedon_bum;
            $instance->_editedBy = $object->editedby_bum;
            $response = $instance;
        }
        return $response;
    }
}