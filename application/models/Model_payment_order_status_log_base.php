<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 30/08/2018
 * Time: 10:31 AM
 */

class Model_payment_order_status_log_base extends MY_Model
{
    const TABLE_NAME = "wfl_payment_order_status_log";
    const TABLE_ID = "id_pos";
    const ATTRIB_SUFIX = "_pos";

    protected $_paymentOrderId;
    protected $_statusId;
    protected $_logDetail;
    protected $_manualEntryDate;

    public function __construct($paymentOrderId = NULL, $statusId = NULL, $logDetail = "", $manualEntryDate = "")
    {
        parent::__construct();
        $this->_paymentOrderId = $paymentOrderId;
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
            "id_pos" => $this->_id,
            "payment_order_id_pos" => $this->_paymentOrderId,
            "status_id_pos" => $this->_statusId,
            "log_detail_pos" => $this->_logDetail,
            "manual_entry_date_pos" => $this->_manualEntryDate,
            "deleted_pos" => $this->_deleted,
            "createdon_pos" => $this->_createdOn,
            "createdby_pos" => $this->_createdBy,
            "editedon_pos" => $this->_editedOn,
            "editedby_pos" => $this->_editedBy
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
                $object->payment_order_id_pos,
                $object->status_id_pos,
                $object->log_detail_pos,
                $object->manual_entry_date_pos
            );
            $instance->_id = $object->id_pos;

            $instance->_deleted = $object->deleted_pos;
            $instance->_createdOn = $object->createdon_pos;
            $instance->_createdBy = $object->createdby_pos;
            $instance->_editedOn = $object->editedon_pos;
            $instance->_editedBy = $object->editedby_pos;
            $response = $instance;
        }
        return $response;
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
