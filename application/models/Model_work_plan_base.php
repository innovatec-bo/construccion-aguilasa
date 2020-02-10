<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/11/06
 * Time: 2:35 PM
 */

class Model_work_plan_base extends MY_Model
{
    const TABLE_NAME = "wfl_work_plan";
    const TABLE_ID = "id_wpl";
    const ATTRIB_SUFIX = "_wpl";

    protected $_workDate;
    protected $_projectId;
    protected $_detail;

    public function __construct($workDate = NULL, $projectId = NULL, $detail = "")
    {
        parent::__construct();
        $this->_workDate = $workDate;
        $this->_endTime = $endTime;
        $this->_projectId = $projectId;
        $this->_detail = $detail;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_wpl" => $this->_id,
            "work_date_wpl" => $this->_workDate,
            "project_id_wpl" => $this->_projectId,
            "detail_wpl" => $this->_detail,
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
                $object->work_date_wpl,
                $object->project_id_wpl,
                $object->detail_wpl
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

    public function setWorkDate($workDate)
    {
        $this->_workDate = $workDate;
    }

    public function setProjectId($projectId)
    {
        $this->_projectId = $projectId;
    }

    public function setDetail($detail)
    {
        $this->_detail = $detail;
    }
    //    setters - end

    // getters - begin

    public function getCreatedBy()
    {
        return $this->_createdBy;
    }

    // getters - end
}