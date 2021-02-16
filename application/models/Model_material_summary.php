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

	public static function getByProjectId($projectId)
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = "
            select * from ".static::TABLE_NAME." where project_id_msu = ".$ci->db->escape($projectId)." and ".static::notDeleted()."
        ";

		$query = $ci->db->query($sql);
		return static::recast(get_called_class(), $query->row());
	}

	public function getMasterDetailByProjectIdAndTypeKeyword($projectId)
	{

	}
}
