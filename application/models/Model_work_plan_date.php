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
}