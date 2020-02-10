<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/11/06
 * Time: 2:35 PM
 */

class Model_work_plan extends Model_work_plan_base
{

    public function __construct($workDate = NULL, $projectId = NULL, $detail = "")
    {
        parent::__construct($workDate, $projectId, $detail);
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