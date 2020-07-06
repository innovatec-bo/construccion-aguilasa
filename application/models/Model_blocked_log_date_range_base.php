<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_blocked_log_date_range_base extends MY_Model
{
    const TABLE_NAME = "bui_blocked_log_date_ranges";
    const TABLE_ID = "id_bld";
    const ATTRIB_SUFIX = "_bld";

    protected $_from;
    protected $_to;
    protected $_deletedBy;

    public function __construct($from = "", $to = "", $deletedBy = NULL)
    {
        parent::__construct();
        $this->_from = $from;
        $this->_to = $to;
        $this->_deletedBy = $deletedBy;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_bld" => $this->_id,
            "from_bld" => $this->_from,
            "to_bld" => $this->_to,
			"deleted_by_bld" => $this->_deletedBy,
            "deleted_bld" => $this->_deleted,
            "createdon_bld" => $this->_createdOn,
            "createdby_bld" => $this->_createdBy,
            "editedon_bld" => $this->_editedOn,
            "editedby_bld" => $this->_editedBy
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
                $object->from_bld,
                $object->to_bld,
				$object->deleted_by_bld
            );
            $instance->_id = $object->id_bld;

            $instance->_deleted = $object->deleted_bld;
            $instance->_createdOn = $object->createdon_bld;
            $instance->_createdBy = $object->createdby_bld;
            $instance->_editedOn = $object->editedon_bld;
            $instance->_editedBy = $object->editedby_bld;
            $response = $instance;
        }
        return $response;
    }
}
