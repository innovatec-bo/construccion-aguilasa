<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 */

class Model_material_base extends MY_Model
{
    const TABLE_NAME = "mat_materials";
    const TABLE_ID = "id_mat";
    const ATTRIB_SUFIX = "_mat";

    protected string $_code;
	protected ?string $_name;
	protected string $_description;
	protected ?string $_unitOfMeasurement;

	/**
	 * Model_material_base constructor.
	 * @param string $code
	 * @param string $name
	 * @param string $description
	 * @param string|null $unitOfMeasurement
	 */
    public function __construct(string $code, ?string $name, string $description, ?string $unitOfMeasurement = NULL)
    {
        parent::__construct();
        $this->_code = $code;
		$this->_name = $name;
		$this->_description = $description;
		$this->_unitOfMeasurement = $unitOfMeasurement;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
		return array(
			"id_mat" => $this->_id,
			"code_mat" => $this->_code,
			"name_mat" => $this->_name,
			"description_mat" => $this->_description,
			"unit_of_measurement_mat" => $this->_unitOfMeasurement,
			"deleted_mat" => $this->_deleted,
			"createdon_mat" => $this->_createdOn,
			"createdby_mat" => $this->_createdBy,
			"editedon_mat" => $this->_editedOn,
			"editedby_mat" => $this->_editedBy
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
                $object->code_mat,
				$object->name_mat,
				$object->description_mat,
				$object->unit_of_measurement_mat
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

	public function setUnitOfMeasurement($unitOfMeasurement)
	{
		$this->_unitOfMeasurement = $unitOfMeasurement;
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

	public function getUnitOfMeasurement()
	{
		return $this->_unitOfMeasurement;
	}
}
