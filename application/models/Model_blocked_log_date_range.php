<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_blocked_log_date_range extends Model_blocked_log_date_range_base
{
    public function __construct($from = "", $to = "", $deletedBy = NULL)
	{
		parent::__construct($from, $to, $deletedBy);
	}
}
