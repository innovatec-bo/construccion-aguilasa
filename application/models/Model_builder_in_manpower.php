<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:04 PM
*/

class Model_builder_in_manpower extends Model_builder_in_manpower_base
{
    public function __construct($laborCostLogId = NULL, $userId = NULL)
    {
        parent::__construct($laborCostLogId, $userId);
    }
}