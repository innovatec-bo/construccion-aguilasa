<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2020-08-27
 * Time: 04:10:02
 */

class Model_external_fiscal_observations extends Model_external_fiscal_observations_base
{
    public function __construct($projectId = NULL, $fiscalId = "", $observation = "", $fixedBy = NULL, $fixDetail = "", $fixedDate = NULL, $statusId = NULL, $entryDate = NULL)
	{
		parent::__construct($projectId, $fiscalId, $observation, $fixedBy, $fixDetail, $fixedDate, $statusId, $entryDate);
	}

	public static function getMasterDetail()
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = "
		select * from ".static::TABLE_NAME." where fixed_efo = 0 and ".static::notDeleted()."
		";

		$query = $ci->db->query($sql);
		return $query->result_array();
	}
}
