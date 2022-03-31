<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_construction_assignment extends Model_construction_assignment_base
{
    public function __construct($statusLogId = NULL, $startDate = NULL, $endDate = NULL, $estimatedTime = 0, $liveLine = 0, $powerDown = 0, $maneuver = 0, $projectManager = NULL)
    {
        parent::__construct($statusLogId, $startDate, $endDate, $estimatedTime, $liveLine, $powerDown, $maneuver, $projectManager);
    }

	/**
	 * @param int $projectId
	 * @return array
	 */
    public static function getAssignmentRecords(int $projectId) : array
	{
		$ci = &get_instance();
		$ci->load->database();
		$sql = "
		SELECT
			wfl_construction_assignments.* 
		FROM
			wfl_project_status_log 
		LEFT JOIN wfl_construction_assignments on status_log_id_cas = id_psl
		WHERE
			project_id_psl = ".$ci->db->escape($projectId)." 
			AND (status_id_psl = 21 or status_id_psl = 11)
			and deleted_cas != 1
			and deleted_psl != 1
		";

		$query = $ci->db->query($sql);
		return static::recastArray(get_called_class(),$query->result());
	}
}
