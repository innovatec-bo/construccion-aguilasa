<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/11/06
 * Time: 2:35 PM
 */

class Model_work_plan_date extends Model_work_plan_date_base
{

    public function __construct($workPlanId = NULL, $projectId = NULL, $date = NULL, $detail = "", $observation = "")
    {
        parent::__construct($workPlanId, $projectId, $date, $detail, $observation);
    }

    public static function deleteDatesToWork($workPlanId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $now = new DateTime();
        $currentDate = $now->format( "Y-m-d H:i:s" );
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
        $sql = "
        update ".static::TABLE_NAME."
        set deleted_wpd = 1, 
        deleted_at = now(), 
        deleted_by = ".$currentUserId.",
        editedby_wpd = ".$currentUserId.",
        editedon_wpd = ".$ci->db->escape($currentDate)."
        where work_plan_id_wpd = ".$ci->db->escape($workPlanId)."
        ";
//        echo"<pre>";var_dump($sql);exit;
        $ci->db->query($sql);
    }
}