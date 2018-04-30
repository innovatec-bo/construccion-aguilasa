<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_permission_base extends MY_Model
{
    const TABLE_NAME = "sec_permissions";
    const TABLE_ID = "id_per";
    const ATTRIB_SUFIX = "_per";

    protected $_roleId;
    protected $_featureId;

    public function __construct($roleId, $featureId)
    {
        parent::__construct();
        $this->_roleId = $roleId;
        $this->_featureId = $featureId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_per" => $this->_id,
            "roleid_per" => $this->_roleId,
            "featureid_per" => $this->_featureId,
            "deleted_per" => $this->_deleted,
            "createdon_per" => $this->_createdOn,
            "createdby_per" => $this->_createdBy,
            "editedon_per" => $this->_editedOn,
            "editedby_per" => $this->_editedBy
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
                $object->roleid_per,
                $object->featureid_per
            );
            $instance->_id = $object->id_per;

            $instance->_deleted = $object->deleted_per;
            $instance->_createdOn = $object->createdon_per;
            $instance->_createdBy = $object->createdby_per;
            $instance->_editedOn = $object->editedon_per;
            $instance->_editedBy = $object->editedby_per;
            $response = $instance;
        }
        return $response;
    }
}