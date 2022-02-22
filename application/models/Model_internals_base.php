<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2022-02-07
 * Time: 11:28:06
 */

class Model_internals_base extends MY_Model
{
    const TABLE_NAME = "mat_internals";
    const TABLE_ID = "id_int";
    const ATTRIB_SUFIX = "_int";

    protected int $_materialId;
	protected float $_quantity;
    protected int $_status;
    protected int $_tension;
    protected int $_operationId;

    public function __construct(int $materialId, float $quantity, int $status, int $tension, int $operationId)
    {
        parent::__construct();
        $this->_materialId = $materialId;
		$this->_quantity = $quantity;
        $this->_status = $status;
        $this->_tension = $tension;
        $this->_operationId = $operationId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_int" => $this->_id,
			"material_id_int" => $this->_materialId,
			"quantity_int" => $this->_quantity,
            "status_id_int" => $this->_status,
            "tension_id_int" => $this->_tension,
            "operation_id_int" => $this->_operationId,
			"deleted_int" => $this->_deleted,
			"createdon_int" => $this->_createdOn,
			"createdby_int" => $this->_createdBy,
			"editedon_int" => $this->_editedOn,
			"editedby_int" => $this->_editedBy
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
                $object->material_id_int,
				$object->quantity_int,
                $object->status_id_int,
                $object->tension_id_int,
                $object->operation_id_int
            );
            $instance->_id = $object->id_int;

            $instance->_deleted = $object->deleted_int;
            $instance->_createdOn = $object->createdon_int;
            $instance->_createdBy = $object->createdby_int;
            $instance->_editedOn = $object->editedon_int;
            $instance->_editedBy = $object->editedby_int;
            $response = $instance;
        }
        return $response;
    }

    //Setters
    public function setMaterialId($materialId)
	{
		$this->_materialId = $materialId;
	}

	public function setQuantity($quantity)
	{
		$this->_quantity = $quantity;
	}

    public function setStatus($status)
    {
        $this->_status = $status;
    }

    public function setTension($tension)
    {
        $this->_tension = $tension;
    }
    
    public function setOperationId($operationId)
    {
        $this->_operationId = $operationId;
    }

    //Getters
    public function getMaterialId()
	{
		return $this->_materialId;
	}

	public function getQuantity()
	{
		return $this->_quantity;
	}

    public function getStatus()
    {
        return $this->_status;
    }

    public function getTension()
    {
        return $this->_tension;
    }

    public function getOperationId()
    {
        return $this->_operationId;
    }
}