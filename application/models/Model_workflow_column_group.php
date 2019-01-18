<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 18/01/2019
 * Time: 12:10 P.M.
  */

class Model_workflow_column_group extends Model_workflow_column_group_base
{
    public function __construct($columnGroupName = "", $columnList = "")
    {
        parent::__construct($columnGroupName, $columnList);
    }
}