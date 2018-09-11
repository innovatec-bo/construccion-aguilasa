<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 11/09/2018
 * Time: 10:02 AM
 */

class Model_project_real_budget_base extends MY_Model
{
    const TABLE_NAME = "wfl_project_real_budgets";
    const TABLE_ID = "id_reb";
    const ATTRIB_SUFIX = "_reb";

    protected $_statusLogId;
    protected $_design;
    protected $_building;
    protected $_transportation;
    protected $_liveLine;
    protected $_rightOfWay;

    public function __construct($statusLogId = NULL, $design = 0, $building = 0, $transportation = 0, $liveLine = 0, $rightOfWay)
    {
        parent::__construct();
        $this->_statusLogId = $statusLogId;
        $this->_design = $design;
        $this->_building = $building;
        $this->_transportation = $transportation;
        $this->_liveLine = $liveLine;
        $this->_rightOfWay = $rightOfWay;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_reb" => $this->_id,
            "status_log_id_reb" => $this->_statusLogId,
            "design_reb" => $this->_design,
            "building_reb" => $this->_building,
            "transportation_reb" => $this->_transportation,
            "live_line_reb" => $this->_liveLine,
            "right_of_way_reb" => $this->_rightOfWay,
            "deleted_reb" => $this->_deleted,
            "createdon_reb" => $this->_createdOn,
            "createdby_reb" => $this->_createdBy,
            "editedon_reb" => $this->_editedOn,
            "editedby_reb" => $this->_editedBy
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
                $object->status_log_id_reb,
                $object->design_reb,
                $object->building_reb,
                $object->transportation_reb,
                $object->live_line_reb,
                $object->right_of_way_reb
            );
            $instance->_id = $object->id_reb;

            $instance->_deleted = $object->deleted_reb;
            $instance->_createdOn = $object->createdon_reb;
            $instance->_createdBy = $object->createdby_reb;
            $instance->_editedOn = $object->editedon_reb;
            $instance->_editedBy = $object->editedby_reb;
            $response = $instance;
        }
        return $response;
    }
}