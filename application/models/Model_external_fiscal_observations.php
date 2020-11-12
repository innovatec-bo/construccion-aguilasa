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
		select 
		       ".static::TABLE_NAME.".*,
		       code_pro,
		       concat(user.firstname_usr,' ',user.lastname_usr) user_fullname,
		       concat(fiscal.firstname_usr,' ',fiscal.lastname_usr) fiscal_fullname,
		       status_name_pst
		from 
		     ".static::TABLE_NAME."
		left join wfl_projects on id_pro = project_id_efo
		left join sec_users user on user.id_usr = createdby_efo
		left join sec_users fiscal on fiscal.id_usr = fiscal_id_efo
		left join wfl_project_status on id_pst = status_id_efo
		where 
		 fixed_efo = 0 
		 and ".static::notDeleted()."
		";

		$query = $ci->db->query($sql);
		return $query->result_array();
	}
}
