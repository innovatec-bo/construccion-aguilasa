<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 */

class Model_default_structure_material_base extends MY_Model
{
    const TABLE_NAME = "bui_default_structure_materials";
    const TABLE_ID = "id_dsm";
    const ATTRIB_SUFIX = "_dsm";

    protected $_structureId;
	protected $_materialId;
	protected $_quantity;

    public function __construct($structureId = "", $materialId = "", $quantity = "")
    {
        parent::__construct();
        $this->_structureId = $structureId;
		$this->_materialId = $materialId;
		$this->_quantity = $quantity;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_dsm" => $this->_id,
			"structure_id_dsm" => $this->_structureId,
			"material_id_dsm" => $this->_materialId,
			"quantity_dsm" => $this->_quantity,
			"deleted_dsm" => $this->_deleted,
			"createdon_dsm" => $this->_createdOn,
			"createdby_dsm" => $this->_createdBy,
			"editedon_dsm" => $this->_editedOn,
			"editedby_dsm" => $this->_editedBy
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
                $object->structure_id_dsm,
				$object->material_id_dsm,
				$object->quantity_dsm
            );
            $instance->_id = $object->id_dsm;

            $instance->_deleted = $object->deleted_dsm;
            $instance->_createdOn = $object->createdon_dsm;
            $instance->_createdBy = $object->createdby_dsm;
            $instance->_editedOn = $object->editedon_dsm;
            $instance->_editedBy = $object->editedby_dsm;
            $response = $instance;
        }
        return $response;
    }

    //Setters
    public function setStructureId($structureId)
	{
		$this->_structureId = $structureId;
	}

	public function setMaterialId($materialId)
	{
		$this->_materialId = $materialId;
	}

	public function setQuantity($quantity)
	{
		$this->_quantity = $quantity;
	}

    //Getters
    public function getStructureId()
	{
		return $this->_structureId;
	}

	public function getMaterialId()
	{
		return $this->_materialId;
	}

	public function getQuantity()
	{
		return $this->_quantity;
	}
}
