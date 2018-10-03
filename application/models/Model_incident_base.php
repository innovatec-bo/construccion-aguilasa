<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 22/08/2018
 * Time: 09:42 AM
 */

class Model_incident_base extends MY_Model
{
    const TABLE_NAME = "wfl_incidents";
    const TABLE_ID = "id_inc";
    const ATTRIB_SUFIX = "_inc";

    protected $_statusLogId;
    protected $_percentage;
    protected $_detail;
    protected $_manualEntryDate;
    protected $_projectId;
    protected $_paused;
    protected $_stopped;

    public function __construct($statusLogId = NULL, $percentage = 0, $detail = "", $manualEntryDate = "", $projectId = NULL, $paused = 0, $stopped = 0)
    {
        parent::__construct();
        $this->_statusLogId = $statusLogId;
        $this->_percentage = $percentage;
        $this->_detail = $detail;
        $this->_manualEntryDate = $manualEntryDate;
        $this->_projectId = $projectId;
        $this->_paused = $paused;
        $this->_stopped = $stopped;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_inc" => $this->_id,
            "status_id_inc" => $this->_statusLogId,
            "percentage_inc" => $this->_percentage,
            "detail_inc" => $this->_detail,
            "manual_entry_date_inc" => $this->_manualEntryDate,
            "project_id_inc" => $this->_projectId,
            "paused_inc" => $this->_paused,
            "stopped_inc" => $this->_stopped,
            "deleted_inc" => $this->_deleted,
            "createdon_inc" => $this->_createdOn,
            "createdby_inc" => $this->_createdBy,
            "editedon_inc" => $this->_editedOn,
            "editedby_inc" => $this->_editedBy
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
                $object->status_id_inc,
                $object->percentage_inc,
                $object->detail_inc,
                $object->manual_entry_date_inc,
                $object->project_id_inc,
                $object->paused_inc,
                $object->stopped_inc
            );
            $instance->_id = $object->id_inc;

            $instance->_deleted = $object->deleted_inc;
            $instance->_createdOn = $object->createdon_inc;
            $instance->_createdBy = $object->createdby_inc;
            $instance->_editedOn = $object->editedon_inc;
            $instance->_editedBy = $object->editedby_inc;
            $response = $instance;
        }
        return $response;
    }

    public function setPaused($paused)
    {
        $this->_paused = $paused;
    }

    public function setStopped($stopped)
    {
        $this->_stopped = $stopped;
    }
}