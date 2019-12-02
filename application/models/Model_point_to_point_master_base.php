<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_point_to_point_master_base extends MY_Model
{
    const TABLE_NAME = "bui_point_to_point_master";
    const TABLE_ID = "id_ptp";
    const ATTRIB_SUFIX = "_ptp";

    protected $_projectCode;
    protected $_point;
    protected $_latitude;
    protected $_longitude;
    protected $_reg;
    protected $_previousPoint;
    protected $_distanceAT;
    protected $_angleAT;
    protected $_distanceMT;
    protected $_angleMT;
    protected $_distanceBT;
    protected $_angleBT;
    protected $_activity;
    protected $_quantity;
    protected $_buildingStructureCode;
    protected $_execution;
    protected $_unitOfMeasurement;
    protected $_buildingStructureDetail;

    public function __construct($projectCode = "", $point = "", $latitude = "", $longitude = "", $reg = "", $previousPoint = "", $distanceAT = 0, $angleAT = 0, 
        $distanceMT = 0, $angleMT = 0, $distanceBT = 0, $angleBT = 0, $activity = "", $quantity = 0, $buildingStructureCode = "", $execution = "", $unitOfMeasurement = "",
        $buildingStructureDetail = "")
    {
        parent::__construct();
        $this->_projectCode = $projectCode;
        $this->_point = $point;
        $this->_latitude = $latitude;
        $this->_longitude = $longitude;
        $this->_reg = $reg;
        $this->_previousPoint = $previousPoint;
        $this->_distanceAT = $distanceAT;
        $this->_angleAT = $angleAT;
        $this->_distanceMT = $distanceMT;
        $this->_angleMT = $angleMT;
        $this->_distanceBT = $distanceBT;
        $this->_activity = $activity;
        $this->_quantity = $quantity;
        $this->_buildingStructureCode = $buildingStructureCode;
        $this->_execution = $execution;
        $this->_unitOfMeasurement = $unitOfMeasurement;
        $this->_buildingStructureDetail = $buildingStructureDetail;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_ptp" => $this->_id,
            "project_code_ptp" => $this->_projectCode,
            "point_ptp" => $this->_point,
            "latitude_ptp" => $this->_latitude,
            "longitude_ptp" => $this->_longitude,
            "reg_ptp" => $this->_reg,
            "previous_point_ptp" => $this->_previousPoint,
            "distance_at_ptp" => $this->_distanceAT,
            "angle_at_ptp" => $this->_angleAT,
            "distance_mt_ptp" => $this->_distanceMT,
            "angle_mt_ptp" => $this->_angleMT,
            "distance_bt_ptp" => $this->_distanceBT,
            "angle_bt_ptp" => $this->_angleBT,
            "activity_ptp" => $this->_activity,
            "quantity_ptp" => $this->_quantity,
            "building_structure_code_ptp" => $this->_buildingStructureCode,
            "execution_ptp" => $this->_execution,
            "unit_of_measurement_ptp" => $this->_unitOfMeasurement,
            "building_structure_detail_ptp" => $this->_buildingStructureDetail,
            "deleted_ptp" => $this->_deleted,
            "createdon_ptp" => $this->_createdOn,
            "createdby_ptp" => $this->_createdBy,
            "editedon_ptp" => $this->_editedOn,
            "editedby_ptp" => $this->_editedBy
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
                $object->project_code_ptp,
                $object->point_ptp,
                $object->latitude_ptp,
                $object->longitude_ptp,
                $object->reg_ptp,
                $object->previous_point_ptp,
                $object->distance_at_ptp,
                $object->angle_at_ptp,
                $object->distance_mt_ptp,
                $object->angle_mt_ptp,
                $object->distance_bt_ptp,
                $object->angle_bt_ptp,
                $object->activity_ptp,
                $object->quantity_ptp,
                $object->building_structure_code_ptp,
                $object->execution_ptp,
                $object->unit_of_measurement_ptp,
                $object->building_structure_detail_ptp
            );
            $instance->_id = $object->id_ptp;

            $instance->_deleted = $object->deleted_ptp;
            $instance->_createdOn = $object->createdon_ptp;
            $instance->_createdBy = $object->createdby_ptp;
            $instance->_editedOn = $object->editedon_ptp;
            $instance->_editedBy = $object->editedby_ptp;
            $response = $instance;
        }
        return $response;
    }
}