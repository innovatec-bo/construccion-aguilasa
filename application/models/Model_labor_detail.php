<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:04 PM
*/

class Model_labor_detail extends Model_labor_detail_base
{
    public function __construct($projectId = NULL, $graphNumber = "", $levelOfTension = "", $destiny = "")
    {
        parent::__construct($projectId, $graphNumber, $levelOfTension, $destiny);
    }

    public static function getByProjectId($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            select * from ".static::TABLE_NAME." where project_id_lad = ".$ci->db->escape($projectId)." and ".static::notDeleted()."
        ";

        $query = $ci->db->query($sql);
        $response = static::recast(get_called_class(), $query->row());
        return $response;
    }
}