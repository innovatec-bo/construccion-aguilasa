<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2021-02-08
 * Time: 18:23:39
 */

class Model_material_summary extends Model_material_summary_base
{
    public function __construct(int $projectStatusLogId, string $tensionLevel, int $projectId, int $applicantProjectId, string $graphNumber, string $destiny, string $entryDate, string $detail, int $userResponsible, int $summaryTypeId, ?string $reservationNumber, ?int $fileId = NULL, ?int $parentSummaryId = NULL, ?int $isLoan = 0, ?int $loanClosed = NULL, ?string $loanClosedDate = NULL, ?int $correlativeCounter = NULL)
	{
		parent::__construct($projectStatusLogId, $tensionLevel, $projectId, $applicantProjectId, $graphNumber, $destiny, $entryDate, $detail, $userResponsible, $summaryTypeId, $reservationNumber, $fileId, $parentSummaryId, $isLoan, $loanClosed, $loanClosedDate, $correlativeCounter);
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
	 * Return Model_material_summary instance or null
	 * @param string
	 * @return object
	 */
	public static function getByReservationNumber(string $reservationNumber) : object
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
	public function getMasterDetailByListId(int $listId) : array
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = "
            select * from ".static::TABLE_NAME." where project_id_msu = ".$ci->db->escape($listId)." and ".static::notDeleted()."
        ";

		$query = $ci->db->query($sql);
		return $query->result_array();
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
				$dataToSave[] = array(
					'materials_summary_id_prm' => $this->_id,
					'material_id_prm' => $material['id'],
					'quantity_prm' => $quantity,
					'status_id_prm' => $material['status'],
					'createdon_prm' => $currentDate,
					'createdby_prm' => $currentUserId
				);
			}
		}
		if(count($dataToSave) > 0)
		{
			Model_project_material::insertBatch($dataToSave);
		}
	}

	public function getSummariesByProjectAndType($project, $type)
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = "
            select * from ".static::TABLE_NAME." where project_id_msu = ".$ci->db->escape($project)." and summary_type_id_msu = ".$ci->db->escape($type)." and ".static::notDeleted()."
        ";

		$query = $ci->db->query($sql);
		return $query->result_array();
	}
}
