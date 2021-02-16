<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2021-02-08
 * Time: 18:22:14
 */

class Model_virtual_warehouse_base extends MY_Model
{
    const TABLE_NAME = "mat_virtual_warehouse";
    const TABLE_ID = "id_vwa";
    const ATTRIB_SUFIX = "_vwa";

    protected $_warehouseWithdrawalLogId;
	protected $_materialId;
	protected $_quantityId;

    public function __construct($warehouseWithdrawalLogId = "", $materialId = "", $quantityId = "")
    {
        parent::__construct();
        $this->_warehouseWithdrawalLogId = $warehouseWithdrawalLogId;
		$this->_materialId = $materialId;
		$this->_quantityId = $quantityId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_vwa" => $this->_id,
			"warehouse_withdrawal_log_id_vwa" => $this->_warehouseWithdrawalLogId,
			"material_id_vwa" => $this->_materialId,
			"quantity_id_vwa" => $this->_quantityId,
			"deleted_vwa" => $this->_deleted,
			"createdon_vwa" => $this->_createdOn,
			"createdby_vwa" => $this->_createdBy,
			"editedon_vwa" => $this->_editedOn,
			"editedby_vwa" => $this->_editedBy
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
                $object->warehouse_withdrawal_log_id_vwa,
				$object->material_id_vwa,
				$object->quantity_id_vwa
            );
            $instance->_id = $object->id_vwa;

            $instance->_deleted = $object->deleted_vwa;
            $instance->_createdOn = $object->createdon_vwa;
            $instance->_createdBy = $object->createdby_vwa;
            $instance->_editedOn = $object->editedon_vwa;
            $instance->_editedBy = $object->editedby_vwa;
            $response = $instance;
        }
        return $response;
    }

    //Setters
    public function setWarehouseWithdrawalLogId($warehouseWithdrawalLogId)
	{
		$this->_warehouseWithdrawalLogId = $warehouseWithdrawalLogId;
	}

	public function setMaterialId($materialId)
	{
		$this->_materialId = $materialId;
	}

	public function setQuantityId($quantityId)
	{
		$this->_quantityId = $quantityId;
	}

    //Getters
    public function getWarehouseWithdrawalLogId()
	{
		return $this->_warehouseWithdrawalLogId;
	}

	public function getMaterialId()
	{
		return $this->_materialId;
	}

	public function getQuantityId()
	{
		return $this->_quantityId;
	}
}
