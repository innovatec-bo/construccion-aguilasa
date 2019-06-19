<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:04 PM
*/

class Model_labor_detail_material extends Model_labor_detail_base
{
    public function __construct($projectId = NULL, $graphNumber = "", $levelOfTension = "", $destiny = "")
    {
        parent::__construct($projectId, $graphNumber, $levelOfTension, $destiny);
    }
}