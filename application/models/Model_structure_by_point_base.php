<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_structure_by_point_base extends MY_Model
{
    const TABLE_NAME = "bui_structure_by_points";
    const TABLE_ID = "id_sbp";
    const ATTRIB_SUFIX = "_sbp";

    protected $_pointId;
    protected $_quantityToUse;
    protected $_laborCostId;

    public function __construct($pointId = NULL, $quantityToUse = 0, $laborCostId = NULL)
    {
        parent::__construct();
        $this->_pointId = $pointId;
        $this->_quantityToUse = $quantityToUse;
        $this->_laborCostId = $laborCostId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_sbp" => $this->_id,
            "point_id_sbp" => $this->_pointId,
            "quantity_to_use_sbp" => $this->_quantityToUse,
            "labor_cost_id_sbp" => $this->_laborCostId,
            "deleted_sbp" => $this->_deleted,
            "createdon_sbp" => $this->_createdOn,
            "createdby_sbp" => $this->_createdBy,
            "editedon_sbp" => $this->_editedOn,
            "editedby_sbp" => $this->_editedBy
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
                $object->point_id_sbp,
                $object->quantity_to_use_sbp,
                $object->labor_cost_id_sbp
            );
            $instance->_id = $object->id_sbp;

            $instance->_deleted = $object->deleted_sbp;
            $instance->_createdOn = $object->createdon_sbp;
            $instance->_createdBy = $object->createdby_sbp;
            $instance->_editedOn = $object->editedon_sbp;
            $instance->_editedBy = $object->editedby_sbp;
            $response = $instance;
        }
        return $response;
    }
}