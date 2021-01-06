<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 */

class Model_custom_structure_material_base extends MY_Model
{
    const TABLE_NAME = "bui_custom_structure_materials";
    const TABLE_ID = "id_csm";
    const ATTRIB_SUFIX = "_csm";

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
            "id_csm" => $this->_id,
			"structure_id_csm" => $this->_structureId,
			"material_id_csm" => $this->_materialId,
			"quantity_csm" => $this->_quantity,
			"deleted_csm" => $this->_deleted,
			"createdon_csm" => $this->_createdOn,
			"createdby_csm" => $this->_createdBy,
			"editedon_csm" => $this->_editedOn,
			"editedby_csm" => $this->_editedBy
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
                $object->structure_id_csm,
				$object->material_id_csm,
				$object->quantity_csm
            );
            $instance->_id = $object->id_csm;

            $instance->_deleted = $object->deleted_csm;
            $instance->_createdOn = $object->createdon_csm;
            $instance->_createdBy = $object->createdby_csm;
            $instance->_editedOn = $object->editedon_csm;
            $instance->_editedBy = $object->editedby_csm;
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
