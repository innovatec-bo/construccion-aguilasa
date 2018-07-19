<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_status_log_responsible_base extends MY_Model
{
    const TABLE_NAME = "wfl_status_log_responsibles";
    const TABLE_ID = "id_slr";
    const ATTRIB_SUFIX = "_slr";

    protected $_statusLogId;
    protected $_responsibleId;

    public function __construct($statusLogId = NULL, $responsibleId = NULL)
    {
        parent::__construct();
        $this->_statusLogId = $statusLogId;
        $this->_responsibleId = $responsibleId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_slr" => $this->_id,
            "status_log_id_slr" => $this->_statusLogId,
            "responsible_id_slr" => $this->_responsibleId,
            "deleted_slr" => $this->_deleted,
            "createdon_slr" => $this->_createdOn,
            "createdby_slr" => $this->_createdBy,
            "editedon_slr" => $this->_editedOn,
            "editedby_slr" => $this->_editedBy
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
                $object->status_log_id_slr,
                $object->responsible_id_slr
            );
            $instance->_id = $object->id_slr;

            $instance->_deleted = $object->deleted_slr;
            $instance->_createdOn = $object->createdon_slr;
            $instance->_createdBy = $object->createdby_slr;
            $instance->_editedOn = $object->editedon_slr;
            $instance->_editedBy = $object->editedby_slr;
            $response = $instance;
        }
        return $response;
    }
}