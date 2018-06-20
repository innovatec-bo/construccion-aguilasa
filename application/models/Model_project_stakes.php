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

    public static function getByProjectId($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            select 
              id_stl id,
	          leader_stl leader
            from 
              wfl_project_stakes
            LEFT JOIN wfl_stakes_team_leader on id_stl = stakes_leader_id_prs
            where 
            project_id_prs = ".$ci->db->escape($projectId)."
            and ".static::notDeleted()."
        ";
        $result = $ci->db->query($sql);
        return $result->result_array();
    }
}