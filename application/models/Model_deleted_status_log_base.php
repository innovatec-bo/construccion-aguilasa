<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2020-11-05
 * Time: 11:48:01
 */

class Model_deleted_status_log_base extends MY_Model
{
    const TABLE_NAME = "sec_deleted_status_logs";
    const TABLE_ID = "id_dsl";
    const ATTRIB_SUFIX = "_dsl";

    protected $_deletedBy;
	protected $_statusLogId;
	protected string $_detail;

    public function __construct($deletedBy = NULL, $statusLogId = NULL, $detail = "")
    {
        parent::__construct();
        $this->_deletedBy = $deletedBy;
		$this->_statusLogId = $statusLogId;
		$this->_detail = $detail;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_dsl" => $this->_id,
			"deleted_by_dsl" => $this->_deletedBy,
			"status_log_id_dsl" => $this->_statusLogId,
			"detail_dsl" => $this->_detail,
			"deleted_dsl" => $this->_deleted,
			"createdon_dsl" => $this->_createdOn,
			"createdby_dsl" => $this->_createdBy,
			"editedon_dsl" => $this->_editedOn,
			"editedby_dsl" => $this->_editedBy
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
                $object->deleted_by_dsl,
				$object->status_log_id_dsl,
				$object->detail_dsl
            );
            $instance->_id = $object->id_dsl;

            $instance->_deleted = $object->deleted_dsl;
            $instance->_createdOn = $object->createdon_dsl;
            $instance->_createdBy = $object->createdby_dsl;
            $instance->_editedOn = $object->editedon_dsl;
            $instance->_editedBy = $object->editedby_dsl;
            $response = $instance;
        }
        return $response;
    }

    //Setters
    public function setDeletedBy($deletedBy)
	{
		$this->_deletedBy = $deletedBy;
	}

	public function setStatusLogId($statusLogId)
	{
		$this->_statusLogId = $statusLogId;
	}

	public function setDetail($detail)
	{
		$this->_detail = $detail;
	}

    //Getters
    public function getDeletedBy()
	{
		return $this->_deletedBy;
	}

	public function getStatusLogId()
	{
		return $this->_statusLogId;
	}

	public function getDetail()
	{
		return $this->_detail;
	}
}
