<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_project_points_base extends MY_Model
{
    const TABLE_NAME = "wfl_project_points";
    const TABLE_ID = "id_prp";
    const ATTRIB_SUFIX = "_prp";

    protected $_projectId;
    protected $_pointsQuantity;
    protected $_metersDistance;

    public function __construct($projectId = NULL, $pointsQuantity = 0, $metersDistance = 0)
    {
        parent::__construct();
        $this->_projectId = $projectId;
        $this->_pointsQuantity = $pointsQuantity;
        $this->_metersDistance = $metersDistance;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_prp" => $this->_id,
            "project_id_prp" => $this->_projectId,
            "points_quantity_prp" => $this->_pointsQuantity,
            "meters_distance_prp" => $this->_metersDistance,
            "deleted_prp" => $this->_deleted,
            "createdon_prp" => $this->_createdOn,
            "createdby_prp" => $this->_createdBy,
            "editedon_prp" => $this->_editedOn,
            "editedby_prp" => $this->_editedBy
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
                $object->project_id_prp,
                $object->points_quantity_prp,
                $object->meters_distance_prp
            );
            $instance->_id = $object->id_prp;

            $instance->_deleted = $object->deleted_prp;
            $instance->_createdOn = $object->createdon_prp;
            $instance->_createdBy = $object->createdby_prp;
            $instance->_editedOn = $object->editedon_prp;
            $instance->_editedBy = $object->editedby_prp;
            $response = $instance;
        }
        return $response;
    }
}