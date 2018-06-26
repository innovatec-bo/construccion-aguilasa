<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_project_status extends Model_project_status_base
{
    public function __construct($name = "", $icon = "", $order = "", $parentStatus = "", $keyword = "")
    {
        parent::__construct($name, $icon, $order, $parentStatus, $keyword);
    }

    public static function getChildrenByParentStatusId($parentStatusId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        select ".static::TABLE_NAME.".*
        from ".static::TABLE_NAME."
        where 
        ".static::notDeleted()."
        and parent_status_pst = ".$ci->db->escape($parentStatusId)."        
        ";
        $query = $ci->db->query($sql);
        $result = static::recastArray(get_called_class(), $query->result());
        return $result;
    }

    public function delete($makePhysicalDelete = FALSE)
    {
        //Delete all roles
//        Model_user_role::deleteByRoleId($this->_id);
        //Delete role
        parent::delete($makePhysicalDelete);
    }

    public static function getDigitizationStatus($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        SELECT
            project_id_psl project_id,
            manual_entry_date_psl manual_entry_date,
            log_detail_psl detail,
            project_points.points,
            project_points.distance
        FROM
            wfl_project_status_log
        LEFT JOIN wfl_project_status on id_pst = status_id_psl
        LEFT JOIN (
            SELECT 
                project_id_prp project_id,
                points_quantity_prp points,
                meters_distance_prp distance
            FROM 
            wfl_project_points
            WHERE 
            project_id_prp = ".$ci->db->escape($projectId)."
            and deleted_prp != 1
            ORDER BY id_prp DESC limit 1
        ) as project_points on project_points.project_id = project_id_psl
        where 
            project_id_psl = ".$ci->db->escape($projectId)."
            and keyword_pst = 'digitization'
            and deleted_psl != 1
        ORDER BY id_psl DESC limit 1;  
        ";
        $query = $ci->db->query($sql);
        $result = (array)$query->row();
        return $result;
    }

    public static function getDrawingStatus($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        SELECT
            project_id_psl project_id,
            manual_entry_date_psl manual_entry_date,
            log_detail_psl detail
        FROM
            wfl_project_status_log
        LEFT JOIN wfl_project_status on id_pst = status_id_psl
        where 
            project_id_psl = ".$ci->db->escape($projectId)."
            and keyword_pst = 'drawing'
            and deleted_psl != 1
        ORDER BY id_psl DESC limit 1;  
        ";
        $query = $ci->db->query($sql);
        $result = (array)$query->row();
        return $result;
    }

    public static function getScheduleStatus($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        SELECT
            project_id_psl project_id,
            manual_entry_date_psl manual_entry_date,
            log_detail_psl detail,
            project_start_pro project_start,
            project_end_pro project_end
        FROM
            wfl_project_status_log
        LEFT JOIN wfl_project_status on id_pst = status_id_psl
        LEFT JOIN wfl_projects on id_pro = project_id_psl
        where 
            project_id_psl = ".$ci->db->escape($projectId)."
            and keyword_pst = 'schedule'
            and deleted_psl != 1
        ORDER BY id_psl DESC limit 1;  
        ";
        $query = $ci->db->query($sql);
        $result = (array)$query->row();
        return $result;
    }
}