<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2021-02-08
 * Time: 18:22:50
 */

class Model_warehouse_material_withdrawal_log_base extends MY_Model
{
    const TABLE_NAME = "mat_warehouse_material_withdrawal_log";
    const TABLE_ID = "id_wmw";
    const ATTRIB_SUFIX = "_wmw";

    protected $_materialsSummaryId;
	protected $_userId;
	protected $_withdrawalDate;
	protected $_applicantProjectId;
	protected $_detail;

    public function __construct($materialsSummaryId = "", $userId = "", $withdrawalDate = "", $applicantProjectId = "", $detail = "")
    {
        parent::__construct();
        $this->_materialsSummaryId = $materialsSummaryId;
		$this->_userId = $userId;
		$this->_withdrawalDate = $withdrawalDate;
		$this->_applicantProjectId = $applicantProjectId;
		$this->_detail = $detail;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_wmw" => $this->_id,
			"materials_summary_id_wmw" => $this->_materialsSummaryId,
			"user_id_wmw" => $this->_userId,
			"withdrawal_date_wmw" => $this->_withdrawalDate,
			"applicant_project_id_wmw" => $this->_applicantProjectId,
			"detail_wmw" => $this->_detail,
			"deleted_wmw" => $this->_deleted,
			"createdon_wmw" => $this->_createdOn,
			"createdby_wmw" => $this->_createdBy,
			"editedon_wmw" => $this->_editedOn,
			"editedby_wmw" => $this->_editedBy
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
                $object->materials_summary_id_wmw,
				$object->user_id_wmw,
				$object->withdrawal_date_wmw,
				$object->applicant_project_id_wmw,
				$object->detail_wmw
            );
            $instance->_id = $object->id_wmw;

            $instance->_deleted = $object->deleted_wmw;
            $instance->_createdOn = $object->createdon_wmw;
            $instance->_createdBy = $object->createdby_wmw;
            $instance->_editedOn = $object->editedon_wmw;
            $instance->_editedBy = $object->editedby_wmw;
            $response = $instance;
        }
        return $response;
    }

    //Setters
    public function setMaterialsSummaryId($materialsSummaryId)
	{
		$this->_materialsSummaryId = $materialsSummaryId;
	}

	public function setUserId($userId)
	{
		$this->_userId = $userId;
	}

	public function setWithdrawalDate($withdrawalDate)
	{
		$this->_withdrawalDate = $withdrawalDate;
	}

	public function setApplicantProjectId($applicantProjectId)
	{
		$this->_applicantProjectId = $applicantProjectId;
	}

	public function setDetail($detail)
	{
		$this->_detail = $detail;
	}

    //Getters
    public function getMaterialsSummaryId()
	{
		return $this->_materialsSummaryId;
	}

	public function getUserId()
	{
		return $this->_userId;
	}

	public function getWithdrawalDate()
	{
		return $this->_withdrawalDate;
	}

	public function getApplicantProjectId()
	{
		return $this->_applicantProjectId;
	}

	public function getDetail()
	{
		return $this->_detail;
	}
}
