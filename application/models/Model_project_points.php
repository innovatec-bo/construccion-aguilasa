<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_project_points extends Model_project_points_base
{
    public function __construct($projectId = NULL, $pointsQuantity = 0, $metersDistance = 0)
    {
        parent::__construct($projectId, $pointsQuantity, $metersDistance);
    }

    public static function getLastPointsByProjectId($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        select ".static::TABLE_NAME.".* 
        from ".static::TABLE_NAME."
        where
            ".static::notDeleted()."
            and project_id_prp = ".$ci->db->escape($projectId)."
            order by createdon_prp desc limit 1
        ";

        $query = $ci->db->query($sql);
        $result = static::recast(get_called_class(),$query->row());
        return $result;
    }
}