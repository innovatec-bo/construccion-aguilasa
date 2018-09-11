<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 11/09/20108
 * Time: 10:04 AM
 */
class Model_project_real_budget extends Model_project_real_budget_base
{
    public function __construct($statusLogId = NULL, $design = 0, $building = 0, $transportation = 0, $liveLine = 0, $rightOfWay)
    {
        parent::__construct($statusLogId, $design, $building, $transportation, $liveLine, $rightOfWay);
    }
}