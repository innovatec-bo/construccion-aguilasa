<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:04 PM
*/

class Model_labor_cost extends Model_labor_cost_base
{
    public function __construct($structure = "", $description = "", $unit = "")
    {
        parent::__construct($structure, $description, $unit);
    }
}