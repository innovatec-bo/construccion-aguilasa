<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/11/06
 * Time: 2:35 PM
 */

class Model_work_plan extends Model_work_plan_base
{

    public function __construct($title = "", $fiscalId = NULL, $builderId = NULL, $weekNumber = NULL)
    {
        parent::__construct($title, $fiscalId, $builderId, $weekNumber);
    }

    public static function getWorkPlanMasterDetail($workPlanId = NULL)
    {
        $ci = &get_instance();
        $ci->load->database();

        $startDate = date('Y-m-01');
        $endDate  = date('Y-m-t');
        $dateRangeFilter = "";
        if(is_null($workPlanId))
        {
            $dateRangeFilter = " and date_wpd between ".$ci->db->escape($startDate)." and ".$ci->db->escape($endDate)." ";
        }
        $workPlanIdFilter = "";
        if(!is_null($workPlanId))
        {
            $workPlanIdFilter = " and id_wpl = ".$ci->db->escape($workPlanId)." ";
        }

        $sql = "
            SELECT
                id_wpl work_plan_id,
                title_wpl title,
                fiscal_id_wpl fiscal_id,
                CONCAT(uf.firstname_usr,' ',uf.lastname_usr) fiscal_full_name,
                builder_id_wpl builder_id,
                CONCAT(ub.firstname_usr,' ',ub.lastname_usr) builder_full_name,
                week_number_wpl week_number,
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
                1 = 1
                ".$workPlanIdFilter."
                and deleted_wpl != 1
                and deleted_wpd != 1
                ".$dateRangeFilter."
                GROUP BY project_id_wpd
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();

        $objectiveList = array();
        $singleList = array();
        $index = 1;
        for ($i = 0; $i < count($result); $i++)
        {
            $workPlanId = $result[$i]["work_plan_id"];
            $projectId = $result[$i]["project_id"];
//            if($result[$i]["work_date_wpl"] != "")
//            {
                $singleList[$projectId]['index'] = $index;
                $singleList[$projectId]['projectId'] = $result[$i]["project_id"];
                $singleList[$projectId]['projectCode'] = $result[$i]["project_code"];
                $singleList[$projectId]['projectAddress'] = $result[$i]["project_address"];
                $singleList[$projectId]['workDetail'] = $result[$i]["work_detail"];
                $singleList[$projectId]['workObservation'] = $result[$i]["work_observation"];
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
                    $objectiveList[$workPlanId]['weekNumber'] = $result[$i]["week_number"];
                    $objectiveList[$workPlanId]['projectList'] = array_values($singleList);
                    $singleList = array();
                    $index = 1;
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
                $objectiveList[$workPlanId]['weekNumber'] = $result[$i]["week_number"];
                $objectiveList[$workPlanId]['projectList'] = array_values($singleList);
            }
            $index++;
        }
        return array_values($objectiveList);
    }

    public static function getByProjectIdsAndDateRange_deprecated($projectIds, $startDate, $endDate)
    {
        $ci = &get_instance();
        $ci->load->database();

        $escapedIds = "";
    	foreach ($projectIds as $id) 
    	{
            $escapedIds .= $ci->db->escape($id).",";
    	}
        $escapedIds = substr($escapedIds, 0, -1);
        $sql = "
			SELECT
				id_pro,
				code_pro,
				work_date_wpl
			FROM
				wfl_projects
			LEFT JOIN	wfl_work_plan on id_pro = project_id_wpl
			where id_pro in (".$escapedIds.")
			ORDER BY id_pro, work_date_wpl
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        $objectiveList = array();
        $singleList = array();
        for ($i = 0; $i < count($result); $i++)
        {
            $projectId = $result[$i]["id_pro"];

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

    public function updateDatesToWork($list = array())
    {
        $ci = &get_instance();
        $ci->load->database();
        $dataToSave = array();
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
        foreach($list as $row)
        {
            $projectId = $row['projectId'];
            $date = $row['date'];
            $detail = $row['detail'];
            $observation = $row['observation'];
            
            $dataToSave[] = array(
                'work_plan_id_wpd' => $this->_id,
                'project_id_wpd' => $projectId,
                'date_wpd' => $date,
                'detail_wpd' => $detail,
                'observation_wpd' => $observation,
                'deleted_wpd' => 0,
                'createdon_wpd' => date('Y-m-d H:i:s'),
                'createdby_wpd' => $currentUserId
            );
        }
        $this->save();
        // echo"<pre>";var_dump($updateStockSale, $dataToSave);exit;
        Model_work_plan_date::deleteDatesToWork($this->_id);
        if(count($dataToSave) > 0)
        {
            Model_work_plan_date::insertBatch($dataToSave);
        }
    }

    public static function getMonthlySummary($startDate = "", $endDate = "")
    {
        $ci = &get_instance();
        $ci->load->database();
        $dateFilter = "";
        if($startDate != "" && $endDate != "")
        {
            $dateFilter = " and date_wpd between ".$ci->db->escape($startDate)." and ".$ci->db->escape($endDate)." ";
        }
        $sql = "
            SELECT
                id_wpl,
                f.id_usr fiscal_id,
                CONCAT(f.firstname_usr, ' ', f.lastname_usr) fiscal_full_name,
                b.id_usr builder_id,
                CONCAT(b.firstname_usr, ' ', b.lastname_usr) builder_full_name,
                -- wfl_work_plans.*,
                project_id_wpd project_id,
                code_pro project_code,
                address_pro project_address,
                GROUP_CONCAT(DISTINCT date_wpd) dates,
                detail_wpd date_detail,
                observation_wpd date_observation
                
            FROM
                wfl_work_plans 
                LEFT JOIN sec_users f on f.id_usr = fiscal_id_wpl
                LEFT JOIN sec_users b on b.id_usr = builder_id_wpl
                LEFT JOIN wfl_work_plan_dates on id_wpl = work_plan_id_wpd
                LEFT JOIN wfl_projects on id_pro = project_id_wpd
            WHERE
                deleted_wpl != 1
                ".$dateFilter."
                GROUP BY fiscal_id, builder_id, project_id_wpd
        ";

        $query = $ci->db->query($sql);
        $result = $query->result_array();

        $fiscalList = array();
        $builderList = array();
        $projectList = array();
        $index = 1;
        for ($i = 0; $i < count($result); $i++)
        {
            $fiscalId = $result[$i]["fiscal_id"];
            $builderId = $result[$i]["builder_id"];
            $projectId = $result[$i]["project_id"];

            $projectList[$projectId]['index'] = $index;
            $projectList[$projectId]['id'] = $result[$i]["project_id"];
            $projectList[$projectId]['code'] = $result[$i]["project_code"];
            $projectList[$projectId]['address'] = $result[$i]["project_address"];
            $projectList[$projectId]['dateList'] = explode(",",$result[$i]["dates"]);
            $projectList[$projectId]['dateDetail'] = $result[$i]["date_detail"];
            $projectList[$projectId]['dateObservation'] = $result[$i]["date_observation"];

            $builderList[$builderId]['index'] = $index;
            $builderList[$builderId]['id'] = $result[$i]["builder_id"];
            $builderList[$builderId]['fullName'] = $result[$i]["builder_full_name"];
            if(isset($result[$i+1]))
            {
                if($result[$i]["builder_id"] != $result[$i+1]["builder_id"])
                {
                    $builderList[$builderId]['projectList'] = array_values($projectList);
                    $projectList = array();
                }
                if($result[$i]["fiscal_id"] != $result[$i+1]["fiscal_id"])
                {
                    $fiscalList[$fiscalId]['id'] = $result[$i]["fiscal_id"];
                    $fiscalList[$fiscalId]['fullName'] = $result[$i]["fiscal_full_name"];
                    $fiscalList[$fiscalId]['builderList'] = array_values($builderList);
                    $builderList = array();
                    $index ++;
                }
            }
            else
            {
                $fiscalList[$fiscalId]['id'] = $result[$i]["fiscal_id"];
                $fiscalList[$fiscalId]['fullName'] = $result[$i]["fiscal_full_name"];
                $builderList[$builderId]['projectList'] = array_values($projectList);
                $fiscalList[$fiscalId]['builderList'] = array_values($builderList);
            }
            $index ++;
        }
        return array_values($fiscalList);
    }
}