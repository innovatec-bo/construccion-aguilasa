<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2021-02-08
 * Time: 18:23:39
 */

class Model_material_summary_base extends MY_Model
{
    const TABLE_NAME = "mat_materials_summary";
    const TABLE_ID = "id_msu";
    const ATTRIB_SUFIX = "_msu";

	const STATUS_PENDING = 1;
	const STATUS_CANCELED_BY_FISCAL = 2;
	const STATUS_CANCELED_BY_SYSTEM = 3;
	const STATUS_WITHDRAWN = 4;

    protected ?int $_projectStatusLogId;
    protected string $_tensionLevel;
	protected int $_projectId;
	protected int $_applicantProjectId;
	protected string $_graphNumber;
	protected string $_destiny;
	protected string $_entryDate;
	protected string $_detail;
	protected ?int $_builderResponsible;
	protected int $_summaryTypeId;
	protected ?string $_reservationNumber;
	protected ?int $_fileId;
	protected ?int $_parentSummaryId;
	protected ?int $_isLoan;
	protected ?int $_loanClosed;
	protected ?string $_loanClosedDate;
	protected ?int $_correlativeCounter;
	protected ?int $_fiscalResponsible;
	protected ?int $_statusId;
	protected ?string $_canceledOn;
	protected ?string $_withrawnOn;
	protected ?int $_canceledBy;

    public function __construct(?int $projectStatusLogId, string $tensionLevel, int $projectId, int $applicantProjectId, string $graphNumber, string $destiny, string $entryDate, string $detail, ?int $builderResponsible, int $summaryTypeId, ?string $reservationNumber, ?int $fileId = NULL, ?int $parentSummaryId = NULL, ?int $isLoan = 0, ?int $loanClosed = NULL, ?string $loanClosedDate = NULL, ?int $correlativeCounter = NULL, ?int $fiscalResponsible = NULL, ?int $statusId = NULL, ?string $canceledOn = NULL, ?string $withrawnOn = NULL, ?int $canceledBy = NULL)
    {
        parent::__construct();
        $this->_projectStatusLogId = $projectStatusLogId;
        $this->_tensionLevel = $tensionLevel;
		$this->_projectId = $projectId;
		$this->_applicantProjectId = $applicantProjectId;
		$this->_graphNumber = $graphNumber;
		$this->_destiny = $destiny;
		$this->_entryDate = $entryDate;
		$this->_detail = $detail;
		$this->_builderResponsible = $builderResponsible;
		$this->_summaryTypeId = $summaryTypeId;
		$this->_reservationNumber = $reservationNumber;
		$this->_fileId = $fileId;
		$this->_parentSummaryId = $parentSummaryId;
		$this->_isLoan = $isLoan;
		$this->_loanClosed = $loanClosed;
		$this->_loanClosedDate = $loanClosedDate;
		$this->_correlativeCounter = $correlativeCounter;
		$this->_fiscalResponsible = $fiscalResponsible;
		$this->_statusId = $statusId;
		$this->_canceledOn = $canceledOn;
		$this->_withrawnOn = $withrawnOn;
		$this->_canceledBy = $canceledBy;

    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
		return array(
			"id_msu" => $this->_id,
			"project_status_log_id_msu" => $this->_projectStatusLogId,
			"tension_level_msu" => $this->_tensionLevel,
			"project_id_msu" => $this->_projectId,
			"applicant_project_id_msu" => $this->_applicantProjectId,
			"graph_number_msu" => $this->_graphNumber,
			"destiny_msu" => $this->_destiny,
			"entry_date_msu" => $this->_entryDate,
			"detail_msu" => $this->_detail,
			"builder_responsible_msu" => $this->_builderResponsible,
			"summary_type_id_msu" => $this->_summaryTypeId,
			"reservation_number_msu" => $this->_reservationNumber,
			"file_id_msu" => $this->_fileId,
			"parent_summary_id_msu" => $this->_parentSummaryId,
			"is_loan_msu" => $this->_isLoan,
			"loan_closed_msu" => $this->_loanClosed,
			"loan_closed_date_msu" => $this->_loanClosedDate,
			"correlative_counter_msu" => $this->_correlativeCounter,
			"fiscal_responsible_msu" => $this->_fiscalResponsible,
			"status_id_msu" => $this->_statusId,
			"canceled_on_msu" => $this->_canceledOn,
			"withdrawn_on_msu" => $this->_withrawnOn,
			"canceledby_msu" => $this->_canceledBy,
			"deleted_msu" => $this->_deleted,
			"createdon_msu" => $this->_createdOn,
			"createdby_msu" => $this->_createdBy,
			"editedon_msu" => $this->_editedOn,
			"editedby_msu" => $this->_editedBy
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
                $object->project_status_log_id_msu,
                $object->tension_level_msu,
				$object->project_id_msu,
				$object->applicant_project_id_msu,
				$object->graph_number_msu,
				$object->destiny_msu,
				$object->entry_date_msu,
				$object->detail_msu,
				$object->builder_responsible_msu,
				$object->summary_type_id_msu,
				$object->reservation_number_msu,
				$object->file_id_msu,
				$object->parent_summary_id_msu,
				$object->is_loan_msu,
				$object->loan_closed_msu,
				$object->loan_closed_date_msu,
				$object->correlative_counter_msu,
				$object->fiscal_responsible_msu,
				$object->status_id_msu,
				$object->canceled_on_msu,
				$object->withdrawn_on_msu,
				$object->canceledby_msu
            );
            $instance->_id = $object->id_msu;

            $instance->_deleted = $object->deleted_msu;
            $instance->_createdOn = $object->createdon_msu;
            $instance->_createdBy = $object->createdby_msu;
            $instance->_editedOn = $object->editedon_msu;
            $instance->_editedBy = $object->editedby_msu;
            $response = $instance;
        }
        return $response;
    }

    //Setters
	public function setProjectStatusLogId($projectStatusLogId)
	{
		$this->_projectStatusLogId = $projectStatusLogId;
	}

    public function setTensionLevel($tensionLevel)
	{
		$this->_tensionLevel = $tensionLevel;
	}

	public function setProjectId($projectId)
	{
		$this->_projectId = $projectId;
	}

	public function setApplicantProjectId($applicantProjectId)
	{
		$this->_applicantProjectId = $applicantProjectId;
	}

	public function setGraphNumber($graphNumber)
	{
		$this->_graphNumber = $graphNumber;
	}

	public function setDestiny($destiny)
	{
		$this->_destiny = $destiny;
	}

	public function setEntryDate($entryDate)
	{
		$this->_entryDate = $entryDate;
	}

	public function setDetail($detail)
	{
		$this->_detail = $detail;
	}

	public function setBuilderResponsible($userResponsible)
	{
		$this->_builderResponsible = $userResponsible;
	}

	public function setSummaryType($summaryTypeId)
	{
		$this->_summaryTypeId = $summaryTypeId;
	}

	public function setReservationNumber($reservationNumber)
	{
		$this->_reservationNumber = $reservationNumber;
	}

	public function setFileId($fileId)
	{
		$this->_fileId = $fileId;
	}

	public function setParentSummaryId($parentSummaryId)
	{
		$this->_parentSummaryId = $parentSummaryId;
	}

	public function setIsLoan($isLoan)
	{
		$this->_isLoan = $isLoan;
	}

	public function setLoanClosed($loanClosed)
	{
		$this->_loanClosed = $loanClosed;
	}

	public function setLoanClosedDate($loanClosedDate)
	{
		$this->_loanClosedDate = $loanClosedDate;
	}

	public function setCorrelativeCounter($correlativeCounter)
	{
		$this->_correlativeCounter = $correlativeCounter;
	}

	public function setFiscalResponsible($fiscalResponsible)
	{
		$this->_fiscalResponsible = $fiscalResponsible;
	}

	public function setStatusId($statusId)
	{
		$this->_statusId = $statusId;
	}

	public function setCanceledOn($canceledOn)
	{
		$this->_canceledOn = $canceledOn;
	}

	public function setWithdrawnOn($withdrawnOn)
	{
		$this->_withrawnOn = $withdrawnOn;
	}

	public function setCanceledBy($canceledBy)
	{
		$this->_canceledBy = $canceledBy;
	}

    //Getters
    public function getProjectStatusLogId()
	{
		return $this->_projectStatusLogId;
	}

	public function getTensionLevel()
	{
		return $this->_tensionLevel;
	}

	public function getProjectId()
	{
		return $this->_projectId;
	}

	public function getApplicantProjectId()
	{
		return $this->_applicantProjectId;
	}

	public function getGraphNumber()
	{
		return $this->_graphNumber;
	}

	public function getDestiny()
	{
		return $this->_destiny;
	}

	public function getEntryDate()
	{
		return $this->_entryDate;
	}

	public function getDetail()
	{
		return $this->_detail;
	}

	public function getBuilderResponsible()
	{
		return $this->_builderResponsible;
	}

	public function getSummaryType()
	{
		return $this->_summaryTypeId;
	}

	public function getReservationNumber()
	{
		return $this->_reservationNumber;
	}

	public function getFileId()
	{
		return $this->_fileId;
	}

	public function getParentSummaryId()
	{
		return $this->_parentSummaryId;
	}

	public function getIsLoan()
	{
		return $this->_isLoan;
	}

	public function getLoanClosed()
	{
		return $this->_loanClosed;
	}

	public function getLoanClosedDate()
	{
		return $this->_loanClosedDate;
	}

	public function getCorrelativeCounter()
	{
		return $this->_correlativeCounter;
	}

	public function getFiscalResponsible()
	{
		return $this->_fiscalResponsible;
	}

	public function getCanceledBy()
	{
		return $this->_canceledBy;
	}
}
