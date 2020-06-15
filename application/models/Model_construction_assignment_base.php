<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 14/08/2018
 * Time: 09:49 AM
 */

class Model_construction_assignment_base extends MY_Model
{
    const TABLE_NAME = "wfl_construction_assignments";
    const TABLE_ID = "id_cas";
    const ATTRIB_SUFIX = "_cas";

    protected $_statusLogId;
    protected $_startDate;
    protected $_endDate;
    protected $_estimatedTime;
    protected $_liveLine;
    protected $_powerDown;
    protected $_maneuver;
    protected $_projectManager;

    public function __construct($statusLogId = NULL, $startDate = "", $endDate = "", $estimatedTime = 0, $liveLine = 0, $powerDown = 0, $maneuver = 0, $projectManager = NULL)
    {
        parent::__construct();
        $this->_statusLogId = $statusLogId;
        $this->_startDate = $startDate;
        $this->_endDate = $endDate;
        $this->_estimatedTime = $estimatedTime;
        $this->_liveLine = $liveLine;
        $this->_powerDown = $powerDown;
        $this->_maneuver = $maneuver;
        $this->_projectManager = $projectManager;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_cas" => $this->_id,
            "status_log_id_cas" => $this->_statusLogId,
            "start_date_cas" => $this->_startDate,
            "end_date_cas" => $this->_endDate,
            "estimated_time_cas" => $this->_estimatedTime,
            "live_line_cas" => $this->_liveLine,
            "power_down_cas" => $this->_powerDown,
            "maneuver_cas" => $this->_maneuver,
            "project_manager_cas" => $this->_projectManager,
            "deleted_cas" => $this->_deleted,
            "createdon_cas" => $this->_createdOn,
            "createdby_cas" => $this->_createdBy,
            "editedon_cas" => $this->_editedOn,
            "editedby_cas" => $this->_editedBy
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
                $object->status_log_id_cas,
                $object->start_date_cas,
                $object->end_date_cas,
                $object->estimated_time_cas,
                $object->live_line_cas,
                $object->power_down_cas,
                $object->maneuver_cas,
                $object->project_manager_cas
            );
            $instance->_id = $object->id_cas;

            $instance->_deleted = $object->deleted_cas;
            $instance->_createdOn = $object->createdon_cas;
            $instance->_createdBy = $object->createdby_cas;
            $instance->_editedOn = $object->editedon_cas;
            $instance->_editedBy = $object->editedby_cas;
            $response = $instance;
        }
        return $response;
    }
}