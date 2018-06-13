<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_project_status_log extends Model_project_status_log_base
{
    public function __construct($projectId = NULL, $statusId = NULL, $logDetail = "")
    {
        parent::__construct($projectId, $statusId, $logDetail);
    }

    public static function getLastProjectStatusLogByProjectId($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
            select ".static::TABLE_NAME.".* 
            from ".static::TABLE_NAME."
            where
                ".static::notDeleted()."
                and project_id_psl = ".$ci->db->escape($projectId)."
                order by createdon_psl desc limit 1 
        ";
        $query = $ci->db->query($sql);//echo"<pre>";var_dump($sql);exit;
        $result = static::recast(get_called_class(), $query->row());
        return $result;
    }
}