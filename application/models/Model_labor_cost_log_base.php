<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:19 PM
 */

class Model_labor_cost_log_base extends MY_Model
{
    const TABLE_NAME = "bui_labor_cost_log";
    const TABLE_ID = "id_lal";
    const ATTRIB_SUFIX = "_lal";

    protected $_userId;
    protected $_detail;
    protected $_manualEntryDate;
    protected $_pointId;

    public function __construct($userId = NULL, $detail = "", $manualEntryDate = "", $pointId = NULL)
    {
        parent::__construct();
        $this->_userId = $userId;
        $this->_detail = $detail;
        $this->_manualEntryDate = $manualEntryDate;
        $this->_pointId = $pointId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_lal" => $this->_id,
            "user_id_lal" => $this->_userId,
            "detail_lal" => $this->_detail,
            "manual_entry_date_lal" => $this->_manualEntryDate,
            "point_id_lal" => $this->_pointId,
            "deleted_lal" => $this->_deleted,
            "createdon_lal" => $this->_createdOn,
            "createdby_lal" => $this->_createdBy,
            "editedon_lal" => $this->_editedOn,
            "editedby_lal" => $this->_editedBy
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
                $object->user_id_lal,
                $object->detail_lal,
                $object->manual_entry_date_lal,
                $object->point_id_lal
            );
            $instance->_id = $object->id_lal;

            $instance->_deleted = $object->deleted_lal;
            $instance->_createdOn = $object->createdon_lal;
            $instance->_createdBy = $object->createdby_lal;
            $instance->_editedOn = $object->editedon_lal;
            $instance->_editedBy = $object->editedby_lal;
            $response = $instance;
        }
        return $response;
    }

    public function delete($makePhysicalDelete = false)
    {
        parent::delete($makePhysicalDelete);
        static::deleteBuildersFromManpowerByLaborCostLogId($this->_id);
        static::deleteWorkedUpStructuresByLaborCostLogId($this->_id);
    }

    //setters
    public function setDetail($detail)
    {
        $this->_detail = $detail;
    }

    public function setManualEntryDate($manualEntryDate)
    {
        $this->_manualEntryDate = $manualEntryDate;
    }

    //getters

    public function getPointId()
    {
        return $this->_pointId;
    }
}