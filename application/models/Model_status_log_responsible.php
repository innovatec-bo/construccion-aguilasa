<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_status_log_responsible extends Model_status_log_responsible_base
{
    public function __construct($statusLogId = NULL, $responsibleId = NULL)
    {
        parent::__construct($statusLogId, $responsibleId);
    }

    /**
     * @param $statusLogId
     * @param $responsibleList array ids referenced to status responsible
     */
    public static function addResponsible($statusLogId, $responsibleList)
    {
        $ci = &get_instance();
        $ci->load->database();

        $arrayToSave = array();
        foreach ($responsibleList as $responsibleId)
        {
            $arrayToSave[] = array(
                "status_log_id_slr" => $statusLogId,
                "responsible_id_slr" =>  $responsibleId,
                "deleted_slr" => 0,
                "createdon_slr" => date("Y-m-d -H:i:s"),
                "createdby_slr" => NULL,
                "editedon_slr" => NULL,
                "editedby_slr" => NULL
            );
        }

        if(count($arrayToSave) > 0)
        {
            $ci->db->insert_batch(Model_status_log_responsible::TABLE_NAME, $arrayToSave);
        }
    }

    public static function getByStatusLogId($statusLogId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            select * from ".static::TABLE_NAME." where status_log_id_slr = ".$ci->db->escape($statusLogId)."
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

	public static function getObjectsByStatusLogId($statusLogId)
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = "
            select * from ".static::TABLE_NAME." where status_log_id_slr = ".$ci->db->escape($statusLogId)."
        ";
		$query = $ci->db->query($sql);
		$result = static::recastArray(get_called_class(),$query->result());
		return $result;
	}

    public static function removeResponsibleByStatusLogId($statusLogId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            update ".static::TABLE_NAME." set deleted_slr = 1 where status_log_id_slr = ".$ci->db->escape($statusLogId)."
        ";
        $ci->db->query($sql);
    }

	/**
	 * Change responsible list in building process
	 * @param array $responsibleIds
	 * @param int $projectId
	 * @return array
	 */
    public static function reAssignResponsibleIds(array $responsibleIds, int $projectId) : array
	{
		$arrayKeywords = array(
			"assign_to",
			"building",
			"ready_to_start",
			"in_progress",
			"paused",
			"stopped",
			"completed",
			"as_built",
			"project_energized",
			"conciliation_reception",
			"conciliation_shipment",
			"cre_return_order",
			"project_return_materials");
		$log = Model_project_status_log::getLogByProjectId($projectId);

		foreach ($log as $record)
		{
			if(array_search($record["keyword_pst"], $arrayKeywords) !== FALSE)
			{
				$statusLogId = $record["id_psl"];
				//let's remove the current responsible
				Model_status_log_responsible::removeResponsibleByStatusLogId($statusLogId);
				//If the step is "assign_to" then let's remove the builder form responsible list. On assign_to only is defined the fiscal.
				// if($record["keyword_pst"] == "assign_to" || $record['keyword_pst'] == 'project_return_materials' || $record['keyword_pst'] == 'cre_return_order' || $record['keyword_pst'] == 'conciliation_reception' || $record['keyword_pst'] == 'conciliation_shipment')
				if($record["keyword_pst"] == "assign_to")
				{
					$responsibleIdsForAssignToStep = $responsibleIds;
					unset($responsibleIdsForAssignToStep[1]);
					//After remove the responsible let's assigns the new responsible
					Model_status_log_responsible::addResponsible($statusLogId, $responsibleIdsForAssignToStep);
				}
				else
				{
					//After remove the responsible let's assigns the new responsible
					Model_status_log_responsible::addResponsible($statusLogId, $responsibleIds);
				}
			}
		}
		$response["success"] = 1;
		$response["message"] = "Se asignaron nuevos responsables al proceso de construccion.";

		return $response;
	}
}
