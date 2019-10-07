<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_building_point_base extends MY_Model
{
    const TABLE_NAME = "bui_building_points";
    const TABLE_ID = "id_bpo";
    const ATTRIB_SUFIX = "_bpo";

    protected $_label;
    protected $_latitude;
    protected $_longitude;
    protected $_previousPoint;
    protected $_distance;
    protected $_angle;

    public function __construct($label = "", $latitude = "", $longitude = "", $previousPoint = "", $distance = "", $angle = "")
    {
        parent::__construct();
        $this->_label = $label;
        $this->_latitude = $latitude;
        $this->_longitude = $longitude;
        $this->_previousPoint = $previousPoint;
        $this->_distance = $distance;
        $this->_angle = $angle;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_bpo" => $this->_id,
            "label_bpo" => $this->_label,
            "latitude_bpo" => $this->_latitude,
            "longitude_bpo" => $this->_longitude,
            "previous_point_bpo" => $this->_previousPoint,
            "distance_bpo" => $this->_distance,
            "angle_bpo" => $this->_angle,
            "deleted_bpo" => $this->_deleted,
            "createdon_bpo" => $this->_createdOn,
            "createdby_bpo" => $this->_createdBy,
            "editedon_bpo" => $this->_editedOn,
            "editedby_bpo" => $this->_editedBy
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
                $object->label_bpo,
                $object->latitude_bpo,
                $object->longitude_bpo,
                $object->previous_point_bpo,
                $object->distance_bpo,
                $object->angle_bpo
            );
            $instance->_id = $object->id_bpo;

            $instance->_deleted = $object->deleted_bpo;
            $instance->_createdOn = $object->createdon_bpo;
            $instance->_createdBy = $object->createdby_bpo;
            $instance->_editedOn = $object->editedon_bpo;
            $instance->_editedBy = $object->editedby_bpo;
            $response = $instance;
        }
        return $response;
    }
}