<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_project_status_log_base extends MY_Model
{
    const TABLE_NAME = "wfl_project_status_log";
    const TABLE_ID = "id_psl";
    const ATTRIB_SUFIX = "_psl";

    protected $_projectId;
    protected $_statusId;
    protected $_logDetail;
    protected $_manualEntryDate;

    public function __construct($projectId = NULL, $statusId = NULL, $logDetail = "", $manualEntryDate = "")
    {
        parent::__construct();
        $this->_projectId = $projectId;
        $this->_statusId = $statusId;
        $this->_logDetail = $logDetail;
        $this->_manualEntryDate = date("Y-m-d H:i:s");
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_psl" => $this->_id,
            "project_id_psl" => $this->_projectId,
            "status_id_psl" => $this->_statusId,
            "log_detail_psl" => $this->_logDetail,
            "manual_entry_date_psl" => $this->_manualEntryDate,
            "deleted_psl" => $this->_deleted,
            "createdon_psl" => $this->_createdOn,
            "createdby_psl" => $this->_createdBy,
            "editedon_psl" => $this->_editedOn,
            "editedby_psl" => $this->_editedBy
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
                $object->project_id_psl,
                $object->status_id_psl,
                $object->log_detail_psl,
                $object->manual_entry_date_psl
            );
            $instance->_id = $object->id_psl;

            $instance->_deleted = $object->deleted_psl;
            $instance->_createdOn = $object->createdon_psl;
            $instance->_createdBy = $object->createdby_psl;
            $instance->_editedOn = $object->editedon_psl;
            $instance->_editedBy = $object->editedby_psl;
            $response = $instance;
        }
        return $response;
    }

    public function getProjectStatus()
    {
        return $this->_statusId;
    }

    public function getDetail()
    {
        return $this->_logDetail;
    }
}