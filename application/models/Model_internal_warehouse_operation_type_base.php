<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2022-03-04
 * Time: 11:16:16
 */

class Model_internal_warehouse_operation_type_base extends MY_Model
{
    const TABLE_NAME = "mat_internal_warehouse_operation_types";
    const TABLE_ID = "id_oty";
    const ATTRIB_SUFIX = "_oty";

    protected $_name;
	protected $_keyword;
	protected $_icon;
	protected $_operationType;

    public function __construct($name = "", $keyword = "", $icon = "", $operationType = "")
    {
        parent::__construct();
        $this->_name = $name;
		$this->_keyword = $keyword;
		$this->_icon = $icon;
		$this->_operationType = $operationType;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_oty" => $this->_id,
			"name_oty" => $this->_name,
			"keyword_oty" => $this->_keyword,
			"icon_oty" => $this->_icon,
			"operation_type_oty" => $this->_operationType,
			"deleted_oty" => $this->_deleted,
			"createdon_oty" => $this->_createdOn,
			"createdby_oty" => $this->_createdBy,
			"editedon_oty" => $this->_editedOn,
			"editedby_oty" => $this->_editedBy
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
                $object->name_oty,
				$object->keyword_oty,
				$object->icon_oty,
				$object->operation_type_oty
            );
            $instance->_id = $object->id_oty;

            $instance->_deleted = $object->deleted_oty;
            $instance->_createdOn = $object->createdon_oty;
            $instance->_createdBy = $object->createdby_oty;
            $instance->_editedOn = $object->editedon_oty;
            $instance->_editedBy = $object->editedby_oty;
            $response = $instance;
        }
        return $response;
    }

    //Setters
    public function setName($name)
	{
		$this->_name = $name;
	}

	public function setKeyword($keyword)
	{
		$this->_keyword = $keyword;
	}

	public function setIcon($icon)
	{
		$this->_icon = $icon;
	}

	public function setOperationType($operationType)
	{
		$this->_operationType = $operationType;
	}

    //Getters
    public function getName()
	{
		return $this->_name;
	}

	public function getKeyword()
	{
		return $this->_keyword;
	}

	public function getIcon()
	{
		return $this->_icon;
	}

	public function getOperationType()
	{
		return $this->_operationType;
	}
}