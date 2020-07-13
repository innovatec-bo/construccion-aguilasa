<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_role_base extends MY_Model
{
    const TABLE_NAME = "sec_roles";
    const TABLE_ID = "id_rol";
    const ATTRIB_SUFIX = "_rol";

    protected $_roleName;
    protected $_keyWord;

    public function __construct($roleName = "", $keyWord = "")
    {
        parent::__construct();
        $this->_roleName = $roleName;
        $this->_keyWord = $keyWord;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_rol" => $this->_id,
            "rolename_rol" => $this->_roleName,
            "keyword_rol" => $this->_keyWord,
            "deleted_rol" => $this->_deleted,
            "createdon_rol" => $this->_createdOn,
            "createdby_rol" => $this->_createdBy,
            "editedon_rol" => $this->_editedOn,
            "editedby_rol" => $this->_editedBy
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
                $object->rolename_rol,
                $object->keyword_rol
            );
            $instance->_id = $object->id_rol;

            $instance->_deleted = $object->deleted_rol;
            $instance->_createdOn = $object->createdon_rol;
            $instance->_createdBy = $object->createdby_rol;
            $instance->_editedOn = $object->editedon_rol;
            $instance->_editedBy = $object->editedby_rol;
            $response = $instance;
        }
        return $response;
    }

    public function setRoleName($roleName)
    {
        $this->_roleName = $roleName;
    }

    public function getKeyword()
	{
		return $this->_keyWord;
	}
}
