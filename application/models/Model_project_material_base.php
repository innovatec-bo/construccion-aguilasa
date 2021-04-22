<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2021-02-08
 * Time: 18:20:57
 */

class Model_project_material_base extends MY_Model
{
    const TABLE_NAME = "mat_projects_materials";
    const TABLE_ID = "id_prm";
    const ATTRIB_SUFIX = "_prm";

    protected int $_materialsSummaryId;
	protected int $_materialId;
	protected float $_quantity;
	protected int $_statusId;
	protected ?int $_tension;

    public function __construct(int $materialsSummaryId, int $materialId, float $quantity, int $statusId, ?int $tension = NULL)
    {
        parent::__construct();
        $this->_materialsSummaryId = $materialsSummaryId;
		$this->_materialId = $materialId;
		$this->_quantity = $quantity;
		$this->_statusId = $statusId;
		$this->_tension = $tension;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
		return array(
			"id_prm" => $this->_id,
			"materials_summary_id_prm" => $this->_materialsSummaryId,
			"material_id_prm" => $this->_materialId,
			"quantity_prm" => $this->_quantity,
			"status_id_prm" => $this->_statusId,
			"tension_id_prm" => $this->_tension,
			"deleted_prm" => $this->_deleted,
			"createdon_prm" => $this->_createdOn,
			"createdby_prm" => $this->_createdBy,
			"editedon_prm" => $this->_editedOn,
			"editedby_prm" => $this->_editedBy
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
                $object->materials_summary_id_prm,
				$object->material_id_prm,
				$object->quantity_prm,
				$object->status_id_prm,
				$object->tension_id_prm
            );
            $instance->_id = $object->id_prm;

            $instance->_deleted = $object->deleted_prm;
            $instance->_createdOn = $object->createdon_prm;
            $instance->_createdBy = $object->createdby_prm;
            $instance->_editedOn = $object->editedon_prm;
            $instance->_editedBy = $object->editedby_prm;
            $response = $instance;
        }
        return $response;
    }

    //Setters
    public function setMaterialsSummaryId($materialsSummaryId)
	{
		$this->_materialsSummaryId = $materialsSummaryId;
	}

	public function setMaterialId($materialId)
	{
		$this->_materialId = $materialId;
	}

	public function setQuantity($quantity)
	{
		$this->_quantity = $quantity;
	}

	public function setStatusId($statusId)
	{
		$this->_statusId = $statusId;
	}

	public function setTension($tensionId)
	{
		$this->_tension = $tensionId;
	}

    //Getters
    public function getMaterialsSummaryId()
	{
		return $this->_materialsSummaryId;
	}

	public function getMaterialId()
	{
		return $this->_materialId;
	}

	public function getQuantity()
	{
		return $this->_quantity;
	}

	public function getStatusId()
	{
		return $this->_statusId;
	}

	public function getTension()
	{
		return $this->_tension;
	}
}
