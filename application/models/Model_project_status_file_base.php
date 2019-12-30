<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 30/12/2019
 * Time: 10:23 AM
 */

class Model_project_status_file_base extends MY_Model
{
    const TABLE_NAME = "wfl_project_status_file";
    const TABLE_ID = "id_psf";
    const ATTRIB_SUFIX = "_psf";

    protected $_projectId;
    protected $_statusId;
    protected $_fileId;

    public function __construct($projectId = NULL, $statusId = NULL, $fileId = NULL)
    {
        parent::__construct();
        $this->_projectId = $projectId;
        $this->_statusId = $statusId;
        $this->_fileId = $fileId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_psf" => $this->_id,
            "project_id_psf" => $this->_projectId,
            "status_id_psf" => $this->_statusId,
            "file_id_psf" => $this->_fileId,
            "deleted_psf" => $this->_deleted,
            "createdon_psf" => $this->_createdOn,
            "createdby_psf" => $this->_createdBy,
            "editedon_psf" => $this->_editedOn,
            "editedby_psf" => $this->_editedBy
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
                $object->project_id_psf,
                $object->status_id_psf,
                $object->file_id_psf
            );
            $instance->_id = $object->id_psf;

            $instance->_deleted = $object->deleted_psf;
            $instance->_createdOn = $object->createdon_psf;
            $instance->_createdBy = $object->createdby_psf;
            $instance->_editedOn = $object->editedon_psf;
            $instance->_editedBy = $object->editedby_psf;
            $response = $instance;
        }
        return $response;
    }
}