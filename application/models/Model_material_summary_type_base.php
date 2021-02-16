<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2021-02-15
 * Time: 17:45:31
 */

class Model_material_summary_type_base extends MY_Model
{
    const TABLE_NAME = "mat_materials_summary_types";
    const TABLE_ID = "id_mqt";
    const ATTRIB_SUFIX = "_mqt";

    protected string $_name;
	protected string $_keyword;
	protected string $_movementType;
	protected ?string $_icon;

    public function __construct(string $name = "", string $keyword = "", string $movementType = "", ?string $icon = NULL)
    {
        parent::__construct();
        $this->_name = $name;
		$this->_keyword = $keyword;
		$this->_movementType = $movementType;
		$this->_icon = $icon;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
		return array(
			"id_mqt" => $this->_id,
			"name_mqt" => $this->_name,
			"keyword_mqt" => $this->_keyword,
			"movement_type_mqt" => $this->_movementType,
			"icon_mqt" => $this->_icon,
			"deleted_mqt" => $this->_deleted,
			"createdon_mqt" => $this->_createdOn,
			"createdby_mqt" => $this->_createdBy,
			"editedon_mqt" => $this->_editedOn,
			"editedby_mqt" => $this->_editedBy
		);
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
                $object->name_mqt,
				$object->keyword_mqt,
				$object->movement_type_mqt,
				$object->icon_mqt
            );
            $instance->_id = $object->id_mqt;

            $instance->_deleted = $object->deleted_mqt;
            $instance->_createdOn = $object->createdon_mqt;
            $instance->_createdBy = $object->createdby_mqt;
            $instance->_editedOn = $object->editedon_mqt;
            $instance->_editedBy = $object->editedby_mqt;
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

	public function setMovementType($movementType)
	{
		$this->_movementType = $movementType;
	}

	public function setIcon($icon)
	{
		$this->_icon = $icon;
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

	public function getMovementType()
	{
		return $this->_movementType;
	}

	public function getIcon()
	{
		return $this->_icon;
	}
}
