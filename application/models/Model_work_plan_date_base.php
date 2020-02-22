<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/11/06
 * Time: 2:35 PM
 */

class Model_work_plan_date_base extends MY_Model
{
    const TABLE_NAME = "wfl_work_plan_date";
    const TABLE_ID = "id_wpd";
    const ATTRIB_SUFIX = "_wpd";

    protected $_workPlanId;
    protected $_projectId;
    protected $_date;
    protected $_detail;
    protected $_observation;

    public function __construct($workPlanId = NULL, $projectId = NULL, $date = NULL, $detail = "", $observation = "")
    {
        parent::__construct();
        $this->_workPlanId = $workPlanId;
        $this->_projectId = $projectId;
        $this->_date = $date;
        $this->_detail = $detail;
        $this->_observation = $observation;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_wpd" => $this->_id,
            "work_plan_id_wpd" => $this->_workPlanId,
            "project_id_wpd" => $this->_projectId,
            "date_wpd" => $this->_date,
            "detail_wpd" => $this->_detail,
            "observation_wpl" => $this->_observation,
            "deleted_wpd" => $this->_deleted,
            "createdon_wpd" => $this->_createdOn,
            "createdby_wpd" => $this->_createdBy,
            "editedon_wpd" => $this->_editedOn,
            "editedby_wpd" => $this->_editedBy
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
                $object->work_plan_id_wpd,
                $object->project_id_wpd,
                $object->date_wpd,
                $object->detail_wpd,
                $object->observation_wpl
            );
            $instance->_id = $object->id_wpd;

            $instance->_deleted = $object->deleted_wpd;
            $instance->_createdOn = $object->createdon_wpd;
            $instance->_createdBy = $object->createdby_wpd;
            $instance->_editedOn = $object->editedon_wpd;
            $instance->_editedBy = $object->editedby_wpd;
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