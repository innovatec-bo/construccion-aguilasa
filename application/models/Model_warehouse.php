<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 28/08/2018
 * Time: 12:12 PM
 */

class Model_warehouse extends Model_warehouse_base
{
    public function __construct($projectId = NULL, $statusId = 22)
    {
        parent::__construct($projectId, $statusId);
    }
}