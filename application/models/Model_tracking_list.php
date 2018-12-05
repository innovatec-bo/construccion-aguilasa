<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_tracking_list extends Model_tracking_list_base
{
    public function __construct($listName = "", $codeList = "")
    {
        parent::__construct($listName, $codeList);
    }
}