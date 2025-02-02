<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_status_responsible_base extends MY_Model
{
    const TABLE_NAME = "wfl_status_responsibles";
    const TABLE_ID = "id_sre";
    const ATTRIB_SUFIX = "_sre";

    protected $_userId;
    protected $_statusId;
    protected $_active;

    public function __construct($userId = "", $statusId = "", $active = TRUE)
    {
        parent::__construct();
        $this->_userId = $userId;
        $this->_statusId = $statusId;
        $this->_active = $active;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_sre" => $this->_id,
            "user_id_sre" => $this->_userId,
            "status_id_sre" => $this->_statusId,
            "active_sre" => $this->_active,
            "deleted_sre" => $this->_deleted,
            "createdon_sre" => $this->_createdOn,
            "createdby_sre" => $this->_createdBy,
            "editedon_sre" => $this->_editedOn,
            "editedby_sre" => $this->_editedBy
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
                $object->user_id_sre,
                $object->status_id_sre,
                $object->active_sre
            );
            $instance->_id = $object->id_sre;

            $instance->_deleted = $object->deleted_sre;
            $instance->_createdOn = $object->createdon_sre;
            $instance->_createdBy = $object->createdby_sre;
            $instance->_editedOn = $object->editedon_sre;
            $instance->_editedBy = $object->editedby_sre;
            $response = $instance;
        }
        return $response;
    }
}