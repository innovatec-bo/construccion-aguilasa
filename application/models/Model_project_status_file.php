<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 30/12/2019
 * Time: 10:29 AM
 */

class Model_project_status_file extends Model_project_status_file_base
{
    public function __construct($projectId = NULL, $statusId = NULL, $fileId = NULL)
    {
        parent::__construct($projectId, $statusId, $fileId);
    }
}