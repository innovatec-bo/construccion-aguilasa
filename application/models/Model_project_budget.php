<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 30/07/2018
 * Time: 2:35 PM
 */
class Model_project_budget extends Model_project_budget_base
{
    public function __construct($statusLogId = NULL, $design = 0, $building = 0, $graphNumber = 0, $reservationNumber = 0, $transportation = 0, $liveLine = 0, $rightOfWay = 0, $manpowerFileId = NULL, $buildingStructureFileId = NULL)
    {
        parent::__construct($statusLogId, $design, $building, $graphNumber, $reservationNumber, $transportation, $liveLine, $rightOfWay, $manpowerFileId, $buildingStructureFileId);
    }
}