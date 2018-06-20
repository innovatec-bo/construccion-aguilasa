<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_stakes_team_leader_base extends MY_Model
{
    const TABLE_NAME = "wfl_stakes_team_leader";
    const TABLE_ID = "id_stl";
    const ATTRIB_SUFIX = "_stl";

    protected $_leader;

    public function __construct($leader = "")
    {
        parent::__construct();
        $this->_leader = $leader;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_stl" => $this->_id,
            "leader_stl" => $this->_leader,
            "deleted_stl" => $this->_deleted,
            "createdon_stl" => $this->_createdOn,
            "createdby_stl" => $this->_createdBy,
            "editedon_stl" => $this->_editedOn,
            "editedby_stl" => $this->_editedBy
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
                $object->leader_stl
            );
            $instance->_id = $object->id_stl;

            $instance->_deleted = $object->deleted_stl;
            $instance->_createdOn = $object->createdon_stl;
            $instance->_createdBy = $object->createdby_stl;
            $instance->_editedOn = $object->editedon_stl;
            $instance->_editedBy = $object->editedby_stl;
            $response = $instance;
        }
        return $response;
    }
}