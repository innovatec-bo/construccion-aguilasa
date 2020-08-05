<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2020-08-05
 * Time: 16:39:59
 */

class Model_user_supervisor_by_period_base extends MY_Model
{
    const TABLE_NAME = "sec_user_supervisor_by_period";
    const TABLE_ID = "id_usp";
    const ATTRIB_SUFIX = "_usp";

    protected $_userId;
	protected $_supervisorId;
	protected $_from;
	protected $_to;

    public function __construct($userId = NULL, $supervisorId = NULL, $from = NULl, $to = NULL)
    {
        parent::__construct();
        $this->_userId = $userId;
		$this->_supervisorId = $supervisorId;
		$this->_from = $from;
		$this->_to = $to;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_usp" => $this->_id,
			"user_id_usp" => $this->_userId,
			"supervisor_id_usp" => $this->_supervisorId,
			"from_usp" => $this->_from,
			"to_usp" => $this->_to,
			"deleted_usp" => $this->_deleted,
			"createdon_usp" => $this->_createdOn,
			"createdby_usp" => $this->_createdBy,
			"editedon_usp" => $this->_editedOn,
			"editedby_usp" => $this->_editedBy
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
                $object->user_id_usp,
				$object->supervisor_id_usp,
				$object->from_usp,
				$object->to_usp
            );
            $instance->_id = $object->id_usp;

            $instance->_deleted = $object->deleted_usp;
            $instance->_createdOn = $object->createdon_usp;
            $instance->_createdBy = $object->createdby_usp;
            $instance->_editedOn = $object->editedon_usp;
            $instance->_editedBy = $object->editedby_usp;
            $response = $instance;
        }
        return $response;
    }

    //Setters
    public function setUserId($userId)
	{
		$this->_userId = $userId;
	}

	public function setSupervisorId($supervisorId)
	{
		$this->_supervisorId = $supervisorId;
	}

	public function setFrom($from)
	{
		$this->_from = $from;
	}

	public function setTo($to)
	{
		$this->_to = $to;
	}

    //Getters
    public function getUserId()
	{
		return $this->_userId;
	}

	public function getSupervisorId()
	{
		return $this->_supervisorId;
	}

	public function getFrom()
	{
		return $this->_from;
	}

	public function getTo()
	{
		return $this->_to;
	}
}
