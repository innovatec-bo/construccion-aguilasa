<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2021-02-08
 * Time: 18:21:46
 */

class Model_project_material_quantity_log_base extends MY_Model
{
    const TABLE_NAME = "bui_projects_materials_quantity_log";
    const TABLE_ID = "id_pmq";
    const ATTRIB_SUFIX = "_pmq";

    protected string $_projectMaterialId;
	protected int $_quantity;
	protected int $_isAdditional;
	protected ?int $_quantityType;

	/**
	 * Model_project_material_quantity_log_base constructor.
	 * @param string $projectMaterialId
	 * @param int $quantity
	 * @param int $isAdditional
	 * @param int|null $quantityType
	 */
    public function __construct(string $projectMaterialId = "", int $quantity = 0, int $isAdditional = 0, ?int $quantityType = NULL)
    {
        parent::__construct();
        $this->_projectMaterialId = $projectMaterialId;
		$this->_quantity = $quantity;
		$this->_isAdditional = $isAdditional;
		$this->_quantityType = $quantityType;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_pmq" => $this->_id,
			"project_material_id_pmq" => $this->_projectMaterialId,
			"quantity_pmq" => $this->_quantity,
			"is_additional_pmq" => $this->_isAdditional,
			"quantity_type_pmq" => $this->_quantityType,
			"deleted_pmq" => $this->_deleted,
			"createdon_pmq" => $this->_createdOn,
			"createdby_pmq" => $this->_createdBy,
			"editedon_pmq" => $this->_editedOn,
			"editedby_pmq" => $this->_editedBy
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
                $object->project_material_id_pmq,
				$object->quantity_pmq,
				$object->is_additional_pmq,
				$object->quantity_type_pmq
            );
            $instance->_id = $object->id_pmq;

            $instance->_deleted = $object->deleted_pmq;
            $instance->_createdOn = $object->createdon_pmq;
            $instance->_createdBy = $object->createdby_pmq;
            $instance->_editedOn = $object->editedon_pmq;
            $instance->_editedBy = $object->editedby_pmq;
            $response = $instance;
        }
        return $response;
    }

    //Setters
    public function setProjectMaterialId($projectMaterialId)
	{
		$this->_projectMaterialId = $projectMaterialId;
	}

	public function setQuantity($quantity)
	{
		$this->_quantity = $quantity;
	}

	public function setIsAdditional($isAdditional)
	{
		$this->_isAdditional = $isAdditional;
	}

	public function quantityType($quantityType)
	{
		$this->_quantityType = $quantityType;
	}

    //Getters
    public function getProjectMaterialId()
	{
		return $this->_projectMaterialId;
	}

	public function getQuantity()
	{
		return $this->_quantity;
	}

	public function getIsAdditional()
	{
		return $this->_isAdditional;
	}

	public function getQuantityType()
	{
		return $this->_quantityType;
	}
}
