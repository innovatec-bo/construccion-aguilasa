<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:04 PM
*/

class Model_worked_up_structure extends Model_worked_up_structure_base
{
    public function __construct($laborCostLogId = NULL, $laborCostId = NULL, $workedUp = 0, $price = 0)
    {
        parent::__construct($laborCostLogId, $laborCostId, $workedUp, $price);
    }
}