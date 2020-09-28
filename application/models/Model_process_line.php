<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2020-09-21
 * Time: 13:10:18
 */

class Model_process_line extends Model_process_line_base
{
    public function __construct($projectId = NULL, $userId = NULL, $startDate = "", $dueDate = "", $detail = "")
	{
		parent::__construct($projectId, $userId, $startDate, $dueDate, $detail);
	}

	/**
	 * @param $userId
	 * @param $projectId
	 * @return array
	 */
	public static function getByUserIdAndProjectId($userId, $projectId) : array
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = "
		select 
			* 
		from wfl_process_line 
		where 
		    due_date_prl > now() 
			and deleted_prl != 1 
		  	and user_id_prl = ".$ci->db->escape($userId)."
		  	and project_id_prl = ".$ci->db->escape($projectId)."
		";

		$query = $ci->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
}
