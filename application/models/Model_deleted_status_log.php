<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2020-11-05
 * Time: 11:48:01
 */

class Model_deleted_status_log extends Model_deleted_status_log_base
{
    public function __construct($deletedBy = NULL, $statusLogId = NULL, $detail = "")
	{
		parent::__construct($deletedBy, $statusLogId, $detail);
	}
}
