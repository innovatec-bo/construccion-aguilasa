<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2022-02-13
 * Time: 20:59:51
 */

class Model_production_limit_base extends MY_Model
{
    const TABLE_NAME = "wfl_production_limits";
    const TABLE_ID = "id_prl";
    const ATTRIB_SUFIX = "_prl";

    protected int $_projectId;
    protected float $_limit;
	protected string $_startDate;
	protected ?string $_endDate;

    public function __construct(int $projectId, float $limit, string $startDate, string $endDate = NULL)
    {
        parent::__construct();
        $this->_projectId = $projectId;
        $this->_limit = $limit;
		$this->_startDate = $startDate;
		$this->_endDate = $endDate;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_prl" => $this->_id,
			"project_id_prl" => $this->_projectId,
            "limit_prl" => $this->_limit,
			"start_date_prl" => $this->_startDate,
			"end_date_prl" => $this->_endDate,
			"deleted_prl" => $this->_deleted,
			"createdon_prl" => $this->_createdOn,
			"createdby_prl" => $this->_createdBy,
			"editedon_prl" => $this->_editedOn,
			"editedby_prl" => $this->_editedBy
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
                $object->project_id_prl,
                $object->limit_prl,
				$object->start_date_prl,
				$object->end_date_prl
            );
            $instance->_id = $object->id_prl;

            $instance->_deleted = $object->deleted_prl;
            $instance->_createdOn = $object->createdon_prl;
            $instance->_createdBy = $object->createdby_prl;
            $instance->_editedOn = $object->editedon_prl;
            $instance->_editedBy = $object->editedby_prl;
            $response = $instance;
        }
        return $response;
    }

    //Setters
    public function setProjectId($projectId)
	{
		$this->_projectId = $projectId;
	}

    public function setLimit($limit)
	{
		$this->_limit = $limit;
	}

	public function setStartDate($startDate)
	{
		$this->_startDate = $startDate;
	}

	public function setEndDate($endDate)
	{
		$this->_endDate = $endDate;
	}

    //Getters
    public function getProjectId()
	{
		return $this->_projectId;
	}

    public function getLimit()
	{
		return $this->_limit;
	}

	public function getStartDate()
	{
		return $this->_startDate;
	}

	public function getEndDate()
	{
		return $this->_endDate;
	}
}