<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_tracking_list_base extends MY_Model
{
    const TABLE_NAME = "wfl_tracking_list";
    const TABLE_ID = "id_trl";
    const ATTRIB_SUFIX = "_trl";

    protected $_listName;
    protected $_codeList;

    public function __construct($listName = "", $codeList = "")
    {
        parent::__construct();
        $this->_listName = $listName;
        $this->_codeList = $codeList;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_trl" => $this->_id,
            "list_name_trl" => $this->_listName,
            "code_list_trl" => $this->_codeList,
            "deleted_trl" => $this->_deleted,
            "createdon_trl" => $this->_createdOn,
            "createdby_trl" => $this->_createdBy,
            "editedon_trl" => $this->_editedOn,
            "editedby_trl" => $this->_editedBy
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
                $object->list_name_trl,
                $object->code_list_trl
            );
            $instance->_id = $object->id_trl;

            $instance->_deleted = $object->deleted_trl;
            $instance->_createdOn = $object->createdon_trl;
            $instance->_createdBy = $object->createdby_trl;
            $instance->_editedOn = $object->editedon_trl;
            $instance->_editedBy = $object->editedby_trl;
            $response = $instance;
        }
        return $response;
    }
    // setters
    public function setCodeList($codeList)
    {
        $this->_codeList = $codeList;
    }

}