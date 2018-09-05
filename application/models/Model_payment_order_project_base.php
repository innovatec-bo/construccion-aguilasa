<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 05/09/2018
 * Time: 11:54 AM
 */

class Model_payment_order_project_base extends MY_Model
{
    const TABLE_NAME = "wfl_payment_orders_projects";
    const TABLE_ID = "id_pop";
    const ATTRIB_SUFIX = "_pop";

    protected $_orderId;
    protected $_projectId;

    public function __construct($orderId = NULL, $projectId = NULL)
    {
        parent::__construct();
        $this->_orderId = $orderId;
        $this->_projectId = $projectId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_pop" => $this->_id,
            "order_id_pop" => $this->_orderId,
            "project_id_pop" => $this->_projectId,
            "deleted_pop" => $this->_deleted,
            "createdon_pop" => $this->_createdOn,
            "createdby_pop" => $this->_createdBy,
            "editedon_pop" => $this->_editedOn,
            "editedby_pop" => $this->_editedBy
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
                $object->order_id_pop,
                $object->project_id_pop
            );
            $instance->_id = $object->id_pop;

            $instance->_deleted = $object->deleted_pop;
            $instance->_createdOn = $object->createdon_pop;
            $instance->_createdBy = $object->createdby_pop;
            $instance->_editedOn = $object->editedon_pop;
            $instance->_editedBy = $object->editedby_pop;
            $response = $instance;
        }
        return $response;
    }
}