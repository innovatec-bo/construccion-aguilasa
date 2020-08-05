<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2020-08-05
 * Time: 16:39:59
 */

class Model_user_supervisor_by_period extends Model_user_supervisor_by_period_base
{
    public function __construct($userId = NULL, $supervisorId = NULL, $from = NULl, $to = NULL)
	{
		parent::__construct($userId, $supervisorId, $from, $to);
	}
}
