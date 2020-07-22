<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_structure_by_point extends Model_structure_by_point_base
{
    public function __construct($projectId = NULL, $label = "", $pointId = NULL, $quantityToUse = 0, $laborCostId = NULL, $isAdditional = 0)
	{
		parent::__construct($projectId, $label, $pointId, $quantityToUse, $laborCostId, $isAdditional);
	}

	public static function getByProjectId($projectId)
    {
    	$ci = &get_instance();
    	$ci->load->database();
    	$sql = "
			select * from ".static::TABLE_NAME." where project_id_sbp = ".$ci->db->escape($projectId)." and deleted_sbp != 1
    	";

    	$query = $ci->db->query($sql);
    	$response = static::recastArray(get_called_class(), $query->result());
    	return $response;
    }

	public static function getByPointId($pointId)
	{
		$ci = &get_instance();
		$ci->load->database();
		$sql = "
			select * from ".static::TABLE_NAME." where point_id_sbp = ".$ci->db->escape($pointId)." and deleted_sbp != 1
    	";

		$query = $ci->db->query($sql);
		$response = static::recastArray(get_called_class(), $query->result());
		return $response;
	}


}
