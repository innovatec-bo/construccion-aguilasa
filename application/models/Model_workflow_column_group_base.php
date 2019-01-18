<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 18/01/2019
 * Time: 12:07 P.M.
 */

class Model_workflow_column_group_base extends MY_Model
{
    const TABLE_NAME = "wfl_workflow_column_groups";
    const TABLE_ID = "id_wcg";
    const ATTRIB_SUFIX = "_wcg";

    protected $_columnGroupName;
    protected $_columnList;

    public function __construct($columnGroupName = "", $columnList = "")
    {
        parent::__construct();
        $this->_columnGroupName = $columnGroupName;
        $this->_columnList = $columnList;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_wcg" => $this->_id,
            "column_group_name_wcg" => $this->_columnGroupName,
            "column_list_wcg" => $this->_columnList,
            "deleted_wcg" => $this->_deleted,
            "createdon_wcg" => $this->_createdOn,
            "createdby_wcg" => $this->_createdBy,
            "editedon_wcg" => $this->_editedOn,
            "editedby_wcg" => $this->_editedBy
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
                $object->column_group_name_wcg,
                $object->column_list_wcg
            );
            $instance->_id = $object->id_wcg;

            $instance->_deleted = $object->deleted_wcg;
            $instance->_createdOn = $object->createdon_wcg;
            $instance->_createdBy = $object->createdby_wcg;
            $instance->_editedOn = $object->editedon_wcg;
            $instance->_editedBy = $object->editedby_wcg;
            $response = $instance;
        }
        return $response;
    }
}