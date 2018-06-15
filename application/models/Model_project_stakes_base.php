<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_project_stakes_base extends MY_Model
{
    const TABLE_NAME = "wfl_project_stakes";
    const TABLE_ID = "id_prs";
    const ATTRIB_SUFIX = "_prs";

    protected $_projectId;
    protected $_stakesLeaderId;

    public function __construct($projectId = "", $stakesLeaderId = "")
    {
        parent::__construct();
        $this->_projectId = $projectId;
        $this->_stakesLeaderId = $stakesLeaderId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_prs" => $this->_id,
            "project_id_prs" => $this->_projectId,
            "stakes_leader_id_prs" => $this->_stakesLeaderId,
            "deleted_prs" => $this->_deleted,
            "createdon_prs" => $this->_createdOn,
            "createdby_prs" => $this->_createdBy,
            "editedon_prs" => $this->_editedOn,
            "editedby_prs" => $this->_editedBy
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
                $object->project_id_prs,
                $object->stakes_leader_id_prs
            );
            $instance->_id = $object->id_prs;

            $instance->_deleted = $object->deleted_prs;
            $instance->_createdOn = $object->createdon_prs;
            $instance->_createdBy = $object->createdby_prs;
            $instance->_editedOn = $object->editedon_prs;
            $instance->_editedBy = $object->editedby_prs;
            $response = $instance;
        }
        return $response;
    }
}