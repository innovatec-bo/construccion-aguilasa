<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 15/11/2018
 * Time: 10:25 AM
 */

class Model_contract_base extends MY_Model
{
    const TABLE_NAME = "wfl_contracts";
    const TABLE_ID = "id_con";
    const ATTRIB_SUFIX = "_con";

    protected $_contractNumber;
    protected $_amount;
    protected $_startDate;
    protected $_expirationDate;

    public function __construct($contractNumber = "", $amount = 0, $startDate = NULL, $expirationDate = NULL)
    {
        parent::__construct();
        $this->_contractNumber = $contractNumber;
        $this->_amount = $amount;
        $this->_startDate = $startDate;
        $this->_expirationDate = $expirationDate;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_con" => $this->_id,
            "contract_number_con" => $this->_contractNumber,
            "amount_con" => $this->_amount,
            "start_date_con" => $this->_startDate,
            "expiration_date_con" => $this->_expirationDate,
            "deleted_con" => $this->_deleted,
            "createdon_con" => $this->_createdOn,
            "createdby_con" => $this->_createdBy,
            "editedon_con" => $this->_editedOn,
            "editedby_con" => $this->_editedBy
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
                $object->contract_number_con,
                $object->amount_con,
                $object->start_date_con,
                $object->expiration_date_con
            );
            $instance->_id = $object->id_con;

            $instance->_deleted = $object->deleted_con;
            $instance->_createdOn = $object->createdon_con;
            $instance->_createdBy = $object->createdby_con;
            $instance->_editedOn = $object->editedon_con;
            $instance->_editedBy = $object->editedby_con;
            $response = $instance;
        }
        return $response;
    }
}