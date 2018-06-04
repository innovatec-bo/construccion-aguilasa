<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 04/06/2018
 * Time: 10:21 AM
 */

class Model_project_base extends MY_Model
{
    const TABLE_NAME = "wfl_projects";
    const TABLE_ID = "id_pro";
    const ATTRIB_SUFIX = "_pro";

    protected $_projectName;

    public function __construct($projectName = "")
    {
        parent::__construct();
        $this->_projectName = $projectName;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_pro" => $this->_id,
            "project_name_pro" => $this->_projectName,
            "deleted_pro" => $this->_deleted,
            "createdon_pro" => $this->_createdOn,
            "createdby_pro" => $this->_createdBy,
            "editedon_pro" => $this->_editedOn,
            "editedby_pro" => $this->_editedBy
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
                $object->project_name_pro
            );
            $instance->_id = $object->id_pro;

            $instance->_deleted = $object->deleted_pro;
            $instance->_createdOn = $object->createdon_pro;
            $instance->_createdBy = $object->createdby_pro;
            $instance->_editedOn = $object->editedon_pro;
            $instance->_editedBy = $object->editedby_pro;
            $response = $instance;
        }
        return $response;
    }

    public function setProjectName($projectName)
    {
        $this->_projectName = $projectName;
    }
}