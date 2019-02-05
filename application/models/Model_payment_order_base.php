<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 05/09/2018
 * Time: 2:35 PM
 */

class Model_payment_order_base extends MY_Model
{
    const TABLE_NAME = "wfl_payment_orders";
    const TABLE_ID = "id_pao";
    const ATTRIB_SUFIX = "_pao";

    protected $_orderNumber;
    protected $_status;
    protected $_invoiceNumber;
    protected $_entryDate;
    protected $_detail;
    protected $_invoiceDate;

    public function __construct($orderNumber = "", $status = 1, $invoiceNumber = NULL, $entryDate = "", $detail = "", $invoiceDate = NULL)
    {
        parent::__construct();
        $this->_orderNumber = $orderNumber;
        $this->_status = $status;
        $this->_invoiceNumber = $invoiceNumber;
        $this->_entryDate = $entryDate;
        $this->_detail = $detail;
        $this->_invoiceDate = $invoiceDate;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_pao" => $this->_id,
            "order_number_pao" => $this->_orderNumber,
            "status_pao" => $this->_status,
            "invoice_number_pao" => $this->_invoiceNumber,
            "entry_date_pao" => $this->_entryDate,
            "detail_pao" => $this->_detail,
            "invoice_date_pao" => $this->_invoiceDate,
            "deleted_pao" => $this->_deleted,
            "createdon_pao" => $this->_createdOn,
            "createdby_pao" => $this->_createdBy,
            "editedon_pao" => $this->_editedOn,
            "editedby_pao" => $this->_editedBy
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
                $object->order_number_pao,
                $object->status_pao,
                $object->invoice_number_pao,
                $object->entry_date_pao,
                $object->detail_pao,
                $object->invoice_date_pao
            );
            $instance->_id = $object->id_pao;

            $instance->_deleted = $object->deleted_pao;
            $instance->_createdOn = $object->createdon_pao;
            $instance->_createdBy = $object->createdby_pao;
            $instance->_editedOn = $object->editedon_pao;
            $instance->_editedBy = $object->editedby_pao;
            $response = $instance;
        }
        return $response;
    }

    public function setStatus($status)
    {
        $this->_status = $status;
    }

    public function setInvoiceNumber($invoiceNumber)
    {
        $this->_invoiceNumber = $invoiceNumber;
    }

    public function setInvoiceDate($invoiceDate)
    {
        $this->_invoiceDate = $invoiceDate;
    }

    public function getInvoiceNumber()
	{
		return $this->_invoiceNumber;
	}
}
