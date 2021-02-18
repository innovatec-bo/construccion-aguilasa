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

    protected int $_projectStatusLogId;
    protected string $_tensionLevel;
	protected int $_projectId;
	protected int $_applicantProjectId;
	protected string $_graphNumber;
	protected string $_destiny;
	protected string $_entryDate;
	protected string $_detail;
	protected int $_userResponsible;
	protected int $_summaryTypeId;
	protected ?int $_fileId;
	protected ?int $_parentSummaryId;

    public function __construct(int $projectStatusLogId, string $tensionLevel, int $projectId, int $applicantProjectId, string $graphNumber, string $destiny, string $entryDate, string $detail, int $userResponsible, int $summaryTypeId, ?int $fileId = NULL, ?int $parentSummaryId = NULL)
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
		$this->_userResponsible = $userResponsible;
		$this->_summaryTypeId = $summaryTypeId;
		$this->_fileId = $fileId;
		$this->_parentSummaryId = $parentSummaryId;
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
			"user_responsible_msu" => $this->_userResponsible,
			"summary_type_id_msu" => $this->_summaryTypeId,
			"file_id_msu" => $this->_fileId,
			"parent_summary_id_msu" => $this->_parentSummaryId,
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
				$object->user_responsible_msu,
				$object->summary_type_id_msu,
				$object->file_id_msu,
				$object->parent_summary_id_msu
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

	public function setUserResponsible($userResponsible)
	{
		$this->_userResponsible = $userResponsible;
	}

	public function setSummaryType($summaryTypeId)
	{
		$this->_summaryTypeId = $summaryTypeId;
	}

	public function setFileId($fileId)
	{
		$this->_fileId = $fileId;
	}

	public function setParentSummaryId($parentSummaryId)
	{
		$this->_parentSummaryId = $parentSummaryId;
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

	public function getUserResponsible()
	{
		return $this->_userResponsible;
	}

	public function getSummaryType()
	{
		return $this->_summaryTypeId;
	}

	public function getFileId()
	{
		return $this->_fileId;
	}

	public function getParentSummaryId()
	{
		return $this->_parentSummaryId;
	}
}
