<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/11/06
 * Time: 2:35 PM
 */

class Model_work_plan extends Model_work_plan_base
{

    public function __construct($title = "", $fiscalId = NULL, $builderId = NULL)
    {
        parent::__construct($title, $fiscalId, $builderId);
    }

    public static function getWorkPlanMasterDetail($workPlanId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
            SELECT
                id_wpl work_plan_id,
                title_wpl title,
                fiscal_id_wpl fiscal_id,
                CONCAT(uf.firstname_usr,' ',uf.lastname_usr) fiscal_full_name,
                builder_id_wpl builder_id,
                CONCAT(ub.firstname_usr,' ',ub.lastname_usr) builder_full_name,
                project_id_wpd project_id,
                code_pro project_code,
                address_pro project_address,	
                GROUP_CONCAT(date_wpd) date_list,
                COUNT(id_wpd) total_dates,
                detail_wpd work_detail,
                observation_wpd work_observation
            FROM
                wfl_work_plans
            LEFT JOIN wfl_work_plan_dates on work_plan_id_wpd = id_wpl
            LEFT JOIN wfl_projects on project_id_wpd = id_pro
            LEFT JOIN sec_users uf on fiscal_id_wpl = uf.id_usr
            LEFT JOIN sec_users ub on builder_id_wpl = ub.id_usr
            WHERE
                id_wpl = ".$ci->db->escape($workPlanId)."
                and deleted_wpl != 1
                and deleted_wpd != 1
                GROUP BY project_id_wpd
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();

        $objectiveList = array();
        $singleList = array();
        for ($i = 0; $i < count($result); $i++)
        {
            $workPlanId = $result[$i]["work_plan_id"];
            $projectId = $result[$i]["project_id"];
//            if($result[$i]["work_date_wpl"] != "")
//            {
                $singleList[$projectId]['projectCode'] = $result[$i]["project_code"];
                $singleList[$projectId]['projectAddress'] = $result[$i]["project_address"];
                $singleList[$projectId]['projectTotalDates'] = $result[$i]["total_dates"];
                $singleList[$projectId]['projectDateList'] = explode(",",$result[$i]["date_list"]);
//            }

            if(isset($result[$i+1]))
            {
                if($result[$i]["work_plan_id"] != $result[$i+1]["work_plan_id"])
                {
                    $objectiveList[$workPlanId]['id'] = $result[$i]["work_plan_id"];
                    $objectiveList[$workPlanId]['title'] = $result[$i]["title"];
                    $objectiveList[$workPlanId]['fiscalId'] = $result[$i]["fiscal_id"];
                    $objectiveList[$workPlanId]['fiscalFullName'] = $result[$i]["fiscal_full_name"];
                    $objectiveList[$workPlanId]['builderId'] = $result[$i]["builder_id"];
                    $objectiveList[$workPlanId]['builderFullName'] = $result[$i]["builder_full_name"];
                    $objectiveList[$workPlanId]['projectList'] = array_values($singleList);
                    $singleList = array();
                }
            }
            else
            {
                $objectiveList[$workPlanId]['id'] = $result[$i]["work_plan_id"];
                $objectiveList[$workPlanId]['title'] = $result[$i]["title"];
                $objectiveList[$workPlanId]['fiscalId'] = $result[$i]["fiscal_id"];
                $objectiveList[$workPlanId]['fiscalFullName'] = $result[$i]["fiscal_full_name"];
                $objectiveList[$workPlanId]['builderId'] = $result[$i]["builder_id"];
                $objectiveList[$workPlanId]['builderFullName'] = $result[$i]["builder_full_name"];
                $objectiveList[$workPlanId]['projectList'] = array_values($singleList);
            }
        }
        return array_values($objectiveList);
    }

    public static function getByProjectIdsAndDateRange($projectIds, $startDate, $endDate)
    {
        $ci = &get_instance();
        $ci->load->database();

        $scapedIds = "";
    	foreach ($projectIds as $id) 
    	{
    		$scapedIds .= $ci->db->escape($id).",";
    	}
    	$scapedIds = substr($scapedIds, 0, -1);
        $sql = "
			SELECT
				id_pro,
				code_pro,
				work_date_wpl
			FROM
				wfl_projects
			LEFT JOIN	wfl_work_plan on id_pro = project_id_wpl
			where id_pro in (".$scapedIds.")
			ORDER BY id_pro, work_date_wpl
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        $objectiveList = array();
        $singleList = array();
        for ($i = 0; $i < count($result); $i++)
        {
            $projectId = $result[$i]["id_pro"];
            if($result[$i]["work_date_wpl"] != "")
            	$singleList[] = $result[$i]["work_date_wpl"];
            if(isset($result[$i+1]))
            {
                if($result[$i]["id_pro"] != $result[$i+1]["id_pro"])
                {
                    $objectiveList[$projectId]['id'] = $result[$i]["id_pro"];
                    $objectiveList[$projectId]['code'] = $result[$i]["code_pro"];
                    $objectiveList[$projectId]['totalDates'] = count($singleList);
                    $objectiveList[$projectId]['dateList'] = array_values($singleList);
                    $singleList = array();
                }
            }
            else
            {
                $objectiveList[$projectId]['id'] = $result[$i]["id_pro"];
                $objectiveList[$projectId]['code'] = $result[$i]["code_pro"];
                $objectiveList[$projectId]['totalDates'] = count($singleList);
                $objectiveList[$projectId]['dateList'] = array_values($singleList);
            }
        }
        return array_values($objectiveList);
    }
}