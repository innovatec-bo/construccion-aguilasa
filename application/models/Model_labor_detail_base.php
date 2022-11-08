<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:04 PM
 */

class Model_labor_detail_base extends MY_Model
{
    const TABLE_NAME = "bui_labor_details";
    const TABLE_ID = "id_lad";
    const ATTRIB_SUFIX = "_lad";

    protected $_projectId;
    protected $_graphNumber;
    protected $_levelOfTension;
    protected $_destiny;
    protected $_statusId;

    public function __construct($projectId = NULL, $graphNumber = "", $levelOfTension = "", $destiny = "", $statusId = "")
    {
        parent::__construct();
        $this->_projectId = $projectId;
        $this->_graphNumber = $graphNumber;
        $this->_levelOfTension = $levelOfTension;
        $this->_destiny = $destiny;
        $this->_statusId = $statusId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_lad" => $this->_id,
            "project_id_lad" => $this->_projectId,
            "graph_number_lad" => $this->_graphNumber,
            "level_of_tension_lad" => $this->_levelOfTension,
            "destiny_lad" => $this->_destiny,
            "status_id_lad" => $this->_statusId,
            "deleted_lad" => $this->_deleted,
            "createdon_lad" => $this->_createdOn,
            "createdby_lad" => $this->_createdBy,
            "editedon_lad" => $this->_editedOn,
            "editedby_lad" => $this->_editedBy
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
                $object->project_id_lad,
                $object->graph_number_lad,
                $object->level_of_tension_lad,
                $object->destiny_lad,
                $object->status_id_lad
            );
            $instance->_id = $object->id_lad;

            $instance->_deleted = $object->deleted_lad;
            $instance->_createdOn = $object->createdon_lad;
            $instance->_createdBy = $object->createdby_lad;
            $instance->_editedOn = $object->editedon_lad;
            $instance->_editedBy = $object->editedby_lad;
            $response = $instance;
        }
        return $response;
    }
}