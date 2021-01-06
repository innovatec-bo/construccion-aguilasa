<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 */

class Model_material_base extends MY_Model
{
    const TABLE_NAME = "bui_materials";
    const TABLE_ID = "id_mat";
    const ATTRIB_SUFIX = "_mat";

    protected $_code;
	protected $_name;
	protected $_description;

    public function __construct($code = "", $name = "", $description = "")
    {
        parent::__construct();
        $this->_code = $code;
		$this->_name = $name;
		$this->_description = $description;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_mat" => $this->_id,
			"code_mat" => $this->_code,
			"name_mat" => $this->_name,
			"description_mat" => $this->_description,
			"deleted_mat" => $this->_deleted,
			"createdon_mat" => $this->_createdOn,
			"createdby_mat" => $this->_createdBy,
			"editedon_mat" => $this->_editedOn,
			"editedby_mat" => $this->_editedBy
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
                $object->code_mat,
				$object->name_mat,
				$object->description_mat
            );
            $instance->_id = $object->id_mat;

            $instance->_deleted = $object->deleted_mat;
            $instance->_createdOn = $object->createdon_mat;
            $instance->_createdBy = $object->createdby_mat;
            $instance->_editedOn = $object->editedon_mat;
            $instance->_editedBy = $object->editedby_mat;
            $response = $instance;
        }
        return $response;
    }

    //Setters
    public function setCode($code)
	{
		$this->_code = $code;
	}

	public function setName($name)
	{
		$this->_name = $name;
	}

	public function setDescription($description)
	{
		$this->_description = $description;
	}

    //Getters
    public function getCode()
	{
		return $this->_code;
	}

	public function getName()
	{
		return $this->_name;
	}

	public function getDescription()
	{
		return $this->_description;
	}
}
