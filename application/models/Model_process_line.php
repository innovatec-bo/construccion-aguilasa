<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2020-09-21
 * Time: 13:10:18
 */

class Model_process_line extends Model_process_line_base
{
    public function __construct($projectId = "", $userId = "", $startDate = "", $dueDate = "", $detail = "")
    {
        parent::__construct($projectId, $userId, $startDate, $dueDate, $detail);
    }
}