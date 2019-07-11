<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:19 PM
 */

class Model_worked_up_structure_base extends MY_Model
{
    const TABLE_NAME = "bui_worked_up_structures";
    const TABLE_ID = "id_wus";
    const ATTRIB_SUFIX = "_wus";

    protected $_laborCostLogId;
    protected $_laborCostId;
    protected $_workedUp;

    public function __construct($laborCostLogId = NULL, $laborCostId = NULL, $workedUp = 0)
    {
        parent::__construct();
        $this->_laborCostLogId = $laborCostLogId;
        $this->_laborCostId = $laborCostId;
        $this->_workedUp = $workedUp;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_wus" => $this->_id,
            "labor_cost_log_id_wus" => $this->_laborCostLogId,
            "labor_cost_id_wus" => $this->_laborCostId,
            "worked_up_wus" => $this->_workedUp,
            "deleted_wus" => $this->_deleted,
            "createdon_wus" => $this->_createdOn,
            "createdby_wus" => $this->_createdBy,
            "editedon_wus" => $this->_editedOn,
            "editedby_wus" => $this->_editedBy
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
                $object->labor_cost_log_id_wus,
                $object->labor_cost_id_wus,
                $object->worked_up_wus
            );
            $instance->_id = $object->id_wus;

            $instance->_deleted = $object->deleted_wus;
            $instance->_createdOn = $object->createdon_wus;
            $instance->_createdBy = $object->createdby_wus;
            $instance->_editedOn = $object->editedon_wus;
            $instance->_editedBy = $object->editedby_wus;
            $response = $instance;
        }
        return $response;
    }
}