<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 28/03/2018
 * Time: 05:45 PM
 */

class Model_user_role_base extends MY_Model
{
    const TABLE_NAME = "sec_userroles";
    const TABLE_ID = "id_uro";
    const ATTRIB_SUFIX = "_uro";

    protected $_userId;
    protected $_roleId;

    public function __construct($userId = "", $roleId = "")
    {
        parent::__construct();
        $this->_userId = $userId;
        $this->_roleId = $roleId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_uro" => $this->_id,
            "userid_uro" => $this->_userId,
            "roleid_uro" => $this->_roleId,
            "deleted_uro" => $this->_deleted,
            "createdon_uro" => $this->_createdOn,
            "createdby_uro" => $this->_createdBy,
            "editedon_uro" => $this->_editedOn,
            "editedby_uro" => $this->_editedBy

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
                $object->userid_uro,
                $object->roleid_uro
            );
            $instance->_id = $object->id_uro;

            $instance->_deleted = $object->deleted_uro;
            $instance->_createdOn = $object->createdon_uro;
            $instance->_createdBy = $object->createdby_uro;
            $instance->_editedOn = $object->editedon_uro;
            $instance->_editedBy = $object->editedby_uro;
            $response = $instance;
        }
        return $response;
    }

}