<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2022-02-08
 * Time: 14:03:07
 */

class Model_internal_warehouse_operation_base extends MY_Model
{
    const TABLE_NAME = "mat_internal_warehouse_operations";
    const TABLE_ID = "id_iwo";
    const ATTRIB_SUFIX = "_iwo";

    protected $_entryDate;
	protected $_detail;
    protected $_operationTypeId;
    protected $_fiscalId;
    protected $_builderId;
    protected $_projectId;

    public function __construct($entryDate = "", $detail = "", $operationTypeId = "", $fiscalId = NULL, $builderId = NULL, $projectId = NULL)
    {
        parent::__construct();
        $this->_entryDate = $entryDate;
		$this->_detail = $detail;
        $this->_operationTypeId = $operationTypeId;
        $this->_fiscalId = $fiscalId;
        $this->_builderId = $builderId;
        $this->_projectId = $projectId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_iwo" => $this->_id,
			"entry_date_iwo" => $this->_entryDate,
			"detail_iwo" => $this->_detail,
            "operation_type_id_iwo" => $this->_operationTypeId,
			"fiscal_id_iwo" => $this->_fiscalId,
            "builder_id_iwo" => $this->_builderId,
            "project_id_iwo" => $this->_projectId,
            "deleted_iwo" => $this->_deleted,
			"createdon_iwo" => $this->_createdOn,
			"createdby_iwo" => $this->_createdBy,
			"editedon_iwo" => $this->_editedOn,
			"editedby_iwo" => $this->_editedBy
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
                $object->entry_date_iwo,
				$object->detail_iwo,
                $object->operation_type_id_iwo,
                $object->fiscal_id_iwo,
                $object->builder_id_iwo,
                $object->project_id_iwo
            );
            $instance->_id = $object->id_iwo;

            $instance->_deleted = $object->deleted_iwo;
            $instance->_createdOn = $object->createdon_iwo;
            $instance->_createdBy = $object->createdby_iwo;
            $instance->_editedOn = $object->editedon_iwo;
            $instance->_editedBy = $object->editedby_iwo;
            $response = $instance;
        }
        return $response;
    }

    //Setters
    public function setEntryDate($entryDate)
	{
		$this->_entryDate = $entryDate;
	}

	public function setDetail($detail)
	{
		$this->_detail = $detail;
	}

    public function setOperationTypeId($operationTypeId)
    {
        $this->_operationTypeId = $operationTypeId;
    }

    public function setFiscalId($fiscalId)
    {
        $this->_fiscalId = $fiscalId;
    }

    public function setBuilderId($builderId)
    {
        $this->_builderId = $builderId;
    }

    public function setProjectId($projectId)
    {
        $this->_projectId = $projectId;
    }

    //Getters
    public function getEntryDate()
	{
		return $this->_entryDate;
	}

	public function getDetail()
	{
		return $this->_detail;
	}

    public function getOperationTypeId()
    {
        return $this->_operationTypeId;
    }

    public function getFiscalId()
    {
        return $this->_fiscalId;
    }

    public function getBuilderId()
    {
        return $this->_builderId;
    }

    public function getProjectId()
    {
        return $this->_projectId;
    }
}