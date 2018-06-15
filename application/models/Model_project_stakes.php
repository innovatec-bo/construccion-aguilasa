<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_project_stakes extends Model_project_stakes_base
{
    public function __construct($roleName = "", $keyWord = "")
    {
        parent::__construct($roleName, $keyWord);
    }

    public static function getByLeaderIdAndProjectId($leaderId, $projectId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            select ".static::TABLE_NAME.".* 
            from ".static::TABLE_NAME."
            where 
            project_id_prs = ".$ci->db->escape($projectId)."
            and stakes_leader_id_prs = ".$ci->db->escape($leaderId)."
            and ".static::notDeleted()."
        ";
        $result = $ci->db->query($sql);
        return static::recastArray(get_called_class(), $result->result());
    }
}