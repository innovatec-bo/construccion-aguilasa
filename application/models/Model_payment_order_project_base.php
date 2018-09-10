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
    protected $_designBudget;
    protected $_transportationBudget;
    protected $_buildingBudget;
    protected $_liveLineBudget;
    protected $_rightOfWayBudget;

    public function __construct($orderId = NULL, $projectId = NULL, $designBudget = 0, $transportationBudget = 0, $buildingBudget = 0, $liveLineBudget = 0, $rightOfWayBudget = 0)
    {
        parent::__construct();
        $this->_orderId = $orderId;
        $this->_projectId = $projectId;
        $this->_designBudget = $designBudget;
        $this->_transportationBudget = $transportationBudget;
        $this->_buildingBudget = $buildingBudget;
        $this->_liveLineBudget = $liveLineBudget;
        $this->_rightOfWayBudget = $rightOfWayBudget;
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
            "design_budget_pop" => $this->_designBudget,
            "transportation_budget_pop" => $this->_transportationBudget,
            "building_budget_pop" => $this->_buildingBudget,
            "live_line_budget_pop" => $this->_liveLineBudget,
            "right_of_way_budget_pop" => $this->_rightOfWayBudget,
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
                $object->project_id_pop,
                $object->design_budget_pop,
                $object->transportation_budget_pop,
                $object->building_budget_pop,
                $object->live_line_budget_pop,
                $object->right_of_way_budget_pop
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