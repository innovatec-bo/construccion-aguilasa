<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 30/07/2018
 * Time: 2:35 PM
 */
class Model_project_budget extends Model_project_budget_base
{
    public function __construct($statusLogId = NULL, $design = 0.0, $building = 0, $graphNumber = 0, $reservationNumber = 0, $transportation = 0, $liveLine = 0, $rightOfWay = 0, $tentativeTotalBudget = 0, $manpowerFileId = NULL, $buildingStructureFileId = NULL, $materialsFileId = NULL, $trimTree = 0)
	{
		parent::__construct($statusLogId, $design, $building, $graphNumber, $reservationNumber, $transportation, $liveLine, $rightOfWay, $tentativeTotalBudget, $manpowerFileId, $buildingStructureFileId, $materialsFileId, $trimTree);
	}

	public static function getByStatusLogId($statusLogId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
            select ".static::TABLE_NAME.".* 
            from ".static::TABLE_NAME."
            where
                ".static::notDeleted()."
                and status_log_id_prb = ".$ci->db->escape($statusLogId)."
        ";
        $query = $ci->db->query($sql);//echo"<pre>";var_dump($sql);exit;
        $result = static::recast(get_called_class(), $query->row());
        return $result;
    }
}
