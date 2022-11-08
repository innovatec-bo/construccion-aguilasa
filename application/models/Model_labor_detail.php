<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:04 PM
*/

class Model_labor_detail extends Model_labor_detail_base
{
    public function __construct($projectId = NULL, $graphNumber = "", $levelOfTension = "", $destiny = "", $statusId = "")
    {
        parent::__construct($projectId, $graphNumber, $levelOfTension, $destiny, $statusId);
    }

    public static function getByProjectId($projectId, $statusId = 11)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            select * from ".static::TABLE_NAME." where project_id_lad = ".$ci->db->escape($projectId)." and status_id_lad = ".$statusId." and ".static::notDeleted()."
        ";

        $query = $ci->db->query($sql);
        $response = static::recast(get_called_class(), $query->row());
        return $response;
    }

    public function delete($makePhysicalDelete = FALSE)
    {
        Model_labor_cost::removeAllByLaborDetailId($this->_id);
        parent::delete();
    }
}