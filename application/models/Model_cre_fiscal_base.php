<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_cre_fiscal_base extends MY_Model
{
    const TABLE_NAME = "wfl_cre_fiscal";
    const TABLE_ID = "id_cfi";
    const ATTRIB_SUFIX = "_cfi";

    protected $_firstName;
    protected $_lastName;

    public function __construct($firstName = "", $lastName = "")
    {
        parent::__construct();
        $this->_firstName = $firstName;
        $this->_lastName = $lastName;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_cfi" => $this->_id,
            "firstname_cfi" => $this->_firstName,
            "lastname_cfi" => $this->_lastName,
            "deleted_cfi" => $this->_deleted,
            "createdon_cfi" => $this->_createdOn,
            "createdby_cfi" => $this->_createdBy,
            "editedon_cfi" => $this->_editedOn,
            "editedby_cfi" => $this->_editedBy
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
                $object->firstname_cfi,
                $object->lastname_cfi
            );
            $instance->_id = $object->id_cfi;

            $instance->_deleted = $object->deleted_cfi;
            $instance->_createdOn = $object->createdon_cfi;
            $instance->_createdBy = $object->createdby_cfi;
            $instance->_editedOn = $object->editedon_cfi;
            $instance->_editedBy = $object->editedby_cfi;
            $response = $instance;
        }
        return $response;
    }
//getters
    public function getFullName()
    {
        return $this->_firstName." ".$this->_lastName;
    }
}