<?php
class Model_material_summary extends Model_material_summary_base
{
    public function __construct(?int $projectStatusLogId, string $tensionLevel, int $projectId, int $applicantProjectId, string $graphNumber, string $destiny, string $entryDate, string $detail, ?int $builderResponsible, int $summaryTypeId, ?string $reservationNumber, ?int $fileId = NULL, ?int $parentSummaryId = NULL, ?int $isLoan = 0, ?int $loanClosed = NULL, ?string $loanClosedDate = NULL, ?int $correlativeCounter = NULL, ?int $fiscalResponsible = NULL, ?int $statusId = NULL, ?string $canceledOn = NULL, ?string $withrawnOn = NULL, ?int $canceledBy = NULL)
	{
		parent::__construct($projectStatusLogId, $tensionLevel, $projectId, $applicantProjectId, $graphNumber, $destiny, $entryDate, $detail, $builderResponsible, $summaryTypeId, $reservationNumber, $fileId, $parentSummaryId, $isLoan, $loanClosed, $loanClosedDate, $correlativeCounter, $fiscalResponsible, $statusId, $canceledOn, $withrawnOn, $canceledBy);
	}

	/**
	 * Return an object list
	 * @param int $projectId
	 * @return array
	 */
	public static function getByProjectId(int $projectId) : array
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = "
            select * from ".static::TABLE_NAME." where project_id_msu = ".$ci->db->escape($projectId)." and summary_type_id_msu in(1,2) and ".static::notDeleted()."
        ";

		$query = $ci->db->query($sql);
		return static::recastArray(get_called_class(), $query->result());
	}

	/**
	 * @param string $reservationNumber
	 * @return object|null
	 */
	public static function getByReservationNumber(string $reservationNumber) : ?object
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = "
            select * from ".static::TABLE_NAME." where reservation_number_msu = ".$ci->db->escape($reservationNumber)." and ".static::notDeleted()."
        ";

		$query = $ci->db->query($sql);
		return static::recast(get_called_class(), $query->row());
	}

	/**
	 * Return an array
	 * @param int $listId
	 * @return array
	 */
	public static function getMasterDetailByListId(int $listId) : array
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = "
            select 
            	id_msu summary_id,
                entry_date_msu summary_entry_date,
                correlative_counter_msu summary_correlative_counter,
                fiscal.id_usr fiscal_id,
                concat(fiscal.firstname_usr,' ',fiscal.lastname_usr) fiscal_full_name,
			   	builder.id_usr builder_id,
                concat(builder.firstname_usr,' ',builder.lastname_usr) builder_full_name,
                summary_type_id_msu summary_type,
				name_mqt summary_type_name,
                id_pro project_id,
                code_pro project_code
            from 
			".static::TABLE_NAME." 
			left join sec_users fiscal on fiscal.id_usr = fiscal_responsible_msu
			left join sec_users builder on builder.id_usr = builder_responsible_msu
			left join mat_materials_summary_types on id_mqt = summary_type_id_msu
			left join wfl_projects on id_pro = project_id_msu
			where 
				id_msu = ".$ci->db->escape($listId)."
				and ".static::notDeleted()."
        ";

		$query = $ci->db->query($sql);
		return $query->row_array();
	}

	/**
	 * @param array $materials
	 */
	public function saveMaterials(array $materials) : void
	{
		$dataToSave = array();
		$now = new DateTime();
		$currentDate = $now->format( "Y-m-d H:i:s" );
		$currentUser = PrivateController::getSessionUser();
		$currentUserId = isset($currentUser) ? $currentUser->id:NULL;
		foreach ($materials as $material)
		{
			$quantity = str_replace(',','',$material['quantity']);
			$quantity = floatval($quantity);
			if($quantity > 0)
			{
				$projectMaterial = new Model_project_material($this->_id,$material['id'],$quantity,$material['status'],$material['tension']);
				if(isset($material['pto']))
				{
					$projectMaterial->setRequestCrePto($material['pto']);	
				}
				if(isset($material['detail-request-additiona-to-cre']))
				{
					$projectMaterial->setRequestCreDetail($material['detail-request-additiona-to-cre']);	
				}
				if(isset($material['delivered-to-builder-detail']))
				{
					$projectMaterial->setDeliveredToBuilderDetail($material['delivered-to-builder-detail']);
				}
				$projectMaterial->setCreatedOn($currentDate);
				$projectMaterial->setCreatedBy($currentUserId);
				$dataToSave[] = $projectMaterial->toArray();

				// $dataToSave[] = array(
				// 	'materials_summary_id_prm' => $this->_id,
				// 	'material_id_prm' => $material['id'],
				// 	'quantity_prm' => $quantity,
				// 	'status_id_prm' => $material['status'],
				// 	'tension_id_prm' => $material['tension'],
				// 	'createdon_prm' => $currentDate,
				// 	'createdby_prm' => $currentUserId
				// );
			}
		}
		if(count($dataToSave) > 0)
		{
			Model_project_material::insertBatch($dataToSave);
		}
	}

	public static function getSummariesByProjectAndType($project, $type)
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = "
            select * from ".static::TABLE_NAME." where project_id_msu = ".$ci->db->escape($project)." and summary_type_id_msu = ".$ci->db->escape($type)." and ".static::notDeleted()."
        ";

		$query = $ci->db->query($sql);
		return $query->result_array();
	}

	public static function getRequestsList(int $id = NULL, int $fiscalId = NULL, int $builderId = NULL)
	{
		$ci = &get_instance();
		$ci->load->database();

		$idFilter = "";
		if(is_numeric($id))
			$idFilter = " and id_msu = ".$ci->db->escape($id)." ";

		$fiscalFilter = "";
		if(is_numeric($fiscalId))
			$fiscalFilter = " and fiscal_responsible_msu = ".$ci->db->escape($fiscalId)." ";

		$builderFilter = "";
		if(is_numeric($builderId))
			$builderFilter = " and builder_responsible_msu = ".$ci->db->escape($builderId)." ";

		$sql = "
            select 
			".static::TABLE_NAME.".*,
			concat(fiscal.firstname_usr,' ',fiscal.lastname_usr) fiscal_full_name,
			concat(builder.firstname_usr,' ',builder.lastname_usr) builder_full_name 
			from ".static::TABLE_NAME." 
			left join sec_users fiscal on fiscal.id_usr = fiscal_responsible_msu
			left join sec_users builder on builder.id_usr = builder_responsible_msu
			where 
			summary_type_id_msu = 14
			{$idFilter}
			{$fiscalFilter}
			{$builderFilter}
			and ".static::notDeleted()."
        ";

		$query = $ci->db->query($sql);//echo"<pre>";var_dump($sql);exit;
		return $query->result_array();
	}
}
