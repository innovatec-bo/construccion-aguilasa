<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_construction_assignment extends Model_construction_assignment_base
{
    public function __construct($statusLogId = NULL, $startDate = "", $endDate = "", $estimatedTime = 0, $liveLine = 0, $powerDown = 0, $maneuver = 0)
    {
        parent::__construct($statusLogId, $startDate, $endDate, $estimatedTime, $liveLine, $powerDown, $maneuver);
    }
}