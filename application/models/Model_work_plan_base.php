<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/11/06
 * Time: 2:35 PM
 */

class Model_work_plan_base extends MY_Model
{
    const TABLE_NAME = "wfl_work_plans";
    const TABLE_ID = "id_wpl";
    const ATTRIB_SUFIX = "_wpl";

    protected $_title;
    protected $_fiscalId;
    protected $_builderId;

    public function __construct($title = "", $fiscalId = NULL, $builderId = NULL)
    {
        parent::__construct();
        $this->_title = $title;
        $this->_fiscalId = $fiscalId;
        $this->_builderId = $builderId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_wpl" => $this->_id,
            "title_wpl" => $this->_title,
            "fiscal_id_wpl" => $this->_fiscalId,
            "builder_id_wpl" => $this->_builderId,
            "deleted_wpl" => $this->_deleted,
            "createdon_wpl" => $this->_createdOn,
            "createdby_wpl" => $this->_createdBy,
            "editedon_wpl" => $this->_editedOn,
            "editedby_wpl" => $this->_editedBy
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
                $object->title_wpl,
                $object->fiscal_id_wpl,
                $object->builder_id_wpl
            );
            $instance->_id = $object->id_wpl;

            $instance->_deleted = $object->deleted_wpl;
            $instance->_createdOn = $object->createdon_wpl;
            $instance->_createdBy = $object->createdby_wpl;
            $instance->_editedOn = $object->editedon_wpl;
            $instance->_editedBy = $object->editedby_wpl;
            $response = $instance;
        }
        return $response;
    }

    //    setters - begin
    public function setTitle($title)
    {
        $this->_title = $title;
    }

    public function setFiscalId($fiscalId)
    {
        $this->_fiscalId = $fiscalId;
    }

    public function setBuilderId($builderId)
    {
        $this->_builderId = $builderId;
    }
    //    setters - end

    // getters - begin

    public function getCreatedBy()
    {
        return $this->_createdBy;
    }

    // getters - end
}