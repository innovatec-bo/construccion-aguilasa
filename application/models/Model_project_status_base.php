<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_project_status_base extends MY_Model
{
    const TABLE_NAME = "wfl_project_status";
    const TABLE_ID = "id_pst";
    const ATTRIB_SUFIX = "_pst";

    protected $_name;
    protected $_icon;
    protected $_order;
    protected $_parentStatus;
    protected $_keyword;

    public function __construct($name = "", $icon = "", $order = "", $parentStatus = "", $keyword = "")
    {
        parent::__construct();
        $this->_name = $name;
        $this->_icon = $icon;
        $this->_order = $order;
        $this->_parentStatus = $parentStatus;
        $this->_keyword = $keyword;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_pst" => $this->_id,
            "status_name_pst" => $this->_name,
            "status_icon_pst" => $this->_icon,
            "order_pst" => $this->_order,
            "parent_status_pst" => $this->_parentStatus,
            "keyword_pst" => $this->_keyword,
            "deleted_pst" => $this->_deleted,
            "createdon_pst" => $this->_createdOn,
            "createdby_pst" => $this->_createdBy,
            "editedon_pst" => $this->_editedOn,
            "editedby_pst" => $this->_editedBy
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
                $object->status_name_pst,
                $object->status_icon_pst,
                $object->order_pst,
                $object->parent_status_pst,
                $object->keyword_pst
            );
            $instance->_id = $object->id_pst;

            $instance->_deleted = $object->deleted_pst;
            $instance->_createdOn = $object->createdon_pst;
            $instance->_createdBy = $object->createdby_pst;
            $instance->_editedOn = $object->editedon_pst;
            $instance->_editedBy = $object->editedby_pst;
            $response = $instance;
        }
        return $response;
    }
}