<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2021-02-08
 * Time: 18:23:39
 */

class Model_material_summary extends Model_material_summary_base
{
    public function __construct(int $projectStatusLogId, string $tensionLevel, int $projectId, int $applicantProjectId, string $graphNumber, string $destiny, string $entryDate, string $detail, int $userResponsible, int $summaryTypeId, ?int $fileId = NULL, ?int $parentSummaryId = NULL)
	{
		parent::__construct($projectStatusLogId, $tensionLevel, $projectId, $applicantProjectId, $graphNumber, $destiny, $entryDate, $detail, $userResponsible, $summaryTypeId, $fileId, $parentSummaryId);
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
            select * from ".static::TABLE_NAME." where project_id_msu = ".$ci->db->escape($projectId)." and ".static::notDeleted()."
        ";

		$query = $ci->db->query($sql);
		return static::recastArray(get_called_class(), $query->result());
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
}
