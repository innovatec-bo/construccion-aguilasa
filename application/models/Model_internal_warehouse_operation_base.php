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

    public function __construct($entryDate = "", $detail = "")
    {
        parent::__construct();
        $this->_entryDate = $entryDate;
		$this->_detail = $detail;
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
				$object->detail_iwo
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

    //Getters
    public function getEntryDate()
	{
		return $this->_entryDate;
	}

	public function getDetail()
	{
		return $this->_detail;
	}
}