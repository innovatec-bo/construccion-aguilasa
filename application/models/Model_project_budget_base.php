<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_project_budget_base extends MY_Model
{
    const TABLE_NAME = "wfl_project_budgets";
    const TABLE_ID = "id_prb";
    const ATTRIB_SUFIX = "_prb";

    protected $_statusLogId;
    protected $_design;
    protected $_building;
    protected $_graphNumber;
    protected $_reservationNumber;

    public function __construct($statusLogId = NULL, $design = 0, $building = 0, $graphNumber = 0, $reservationNumber = 0)
    {
        parent::__construct();
        $this->_statusLogId = $statusLogId;
        $this->_design = $design;
        $this->_building = $building;
        $this->_graphNumber = $graphNumber;
        $this->_reservationNumber = $reservationNumber;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_prb" => $this->_id,
            "status_log_id_prb" => $this->_statusLogId,
            "design_prb" => $this->_design,
            "building_prb" => $this->_building,
            "graph_number_prb" => $this->_graphNumber,
            "reservation_number_prb" => $this->_reservationNumber,
            "deleted_prb" => $this->_deleted,
            "createdon_prb" => $this->_createdOn,
            "createdby_prb" => $this->_createdBy,
            "editedon_prb" => $this->_editedOn,
            "editedby_prb" => $this->_editedBy
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
                $object->status_log_id_prb,
                $object->design_prb,
                $object->building_prb,
                $object->graph_number_prb,
                $object->reservation_number_prb
            );
            $instance->_id = $object->id_prb;

            $instance->_deleted = $object->deleted_prb;
            $instance->_createdOn = $object->createdon_prb;
            $instance->_createdBy = $object->createdby_prb;
            $instance->_editedOn = $object->editedon_prb;
            $instance->_editedBy = $object->editedby_prb;
            $response = $instance;
        }
        return $response;
    }
}