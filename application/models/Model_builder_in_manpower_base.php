<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:19 PM
 */

class Model_builder_in_manpower_base extends MY_Model
{
    const TABLE_NAME = "bui_builders_in_manpower";
    const TABLE_ID = "id_bim";
    const ATTRIB_SUFIX = "_bim";

    protected $_laborCostLogId;
    protected $_userId;

    public function __construct($laborCostLogId = NULL, $userId = NULL)
    {
        parent::__construct();
        $this->_laborCostLogId = $laborCostLogId;
        $this->_userId = $userId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_bim" => $this->_id,
            "labor_cost_log_id_bim" => $this->_laborCostLogId,
            "user_id_bim" => $this->_userId,
            "deleted_bim" => $this->_deleted,
            "createdon_bim" => $this->_createdOn,
            "createdby_bim" => $this->_createdBy,
            "editedon_bim" => $this->_editedOn,
            "editedby_bim" => $this->_editedBy
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
                $object->labor_cost_log_id_bim,
                $object->user_id_bim
            );
            $instance->_id = $object->id_bim;

            $instance->_deleted = $object->deleted_bim;
            $instance->_createdOn = $object->createdon_bim;
            $instance->_createdBy = $object->createdby_bim;
            $instance->_editedOn = $object->editedon_bim;
            $instance->_editedBy = $object->editedby_bim;
            $response = $instance;
        }
        return $response;
    }
}