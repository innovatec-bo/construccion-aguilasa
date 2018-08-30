<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 30/08/2018
 * Time: 10:31 AM
 */

class Model_warehouse_status_log_base extends MY_Model
{
    const TABLE_NAME = "wfl_warehouse_status_log";
    const TABLE_ID = "id_wsl";
    const ATTRIB_SUFIX = "_wsl";

    protected $_warehouseId;
    protected $_statusId;
    protected $_logDetail;
    protected $_manualEntryDate;

    public function __construct($warehouseId = NULL, $statusId = NULL, $logDetail = "", $manualEntryDate = "")
    {
        parent::__construct();
        $this->_warehouseId = $warehouseId;
        $this->_statusId = $statusId;
        $this->_logDetail = $logDetail;
        $this->_manualEntryDate = $manualEntryDate == ""?date("Y-m-d H:i:s"):$manualEntryDate;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_wsl" => $this->_id,
            "warehouse_id_wsl" => $this->_warehouseId,
            "status_id_wsl" => $this->_statusId,
            "log_detail_wsl" => $this->_logDetail,
            "manual_entry_date_wsl" => $this->_manualEntryDate,
            "deleted_wsl" => $this->_deleted,
            "createdon_wsl" => $this->_createdOn,
            "createdby_wsl" => $this->_createdBy,
            "editedon_wsl" => $this->_editedOn,
            "editedby_wsl" => $this->_editedBy
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
                $object->warehouse_id_wsl,
                $object->status_id_wsl,
                $object->log_detail_wsl,
                $object->manual_entry_date_wsl
            );
            $instance->_id = $object->id_wsl;

            $instance->_deleted = $object->deleted_wsl;
            $instance->_createdOn = $object->createdon_wsl;
            $instance->_createdBy = $object->createdby_wsl;
            $instance->_editedOn = $object->editedon_wsl;
            $instance->_editedBy = $object->editedby_wsl;
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

    public function setManualEntryDate($manualEntryDate)
    {
        $this->_manualEntryDate = $manualEntryDate;
    }
}