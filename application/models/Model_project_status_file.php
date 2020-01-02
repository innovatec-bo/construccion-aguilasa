<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 30/12/2019
 * Time: 10:29 AM
 */

class Model_project_status_file extends Model_project_status_file_base
{
    public function __construct($statusLogId = NULL, $projectId = NULL, $statusId = NULL, $fileId = NULL)
    {
        parent::__construct($statusLogId, $projectId, $statusId, $fileId);
    }

    public static function addFiles($statusLogId, $list, $projectId, $statusId)
    {
        $dataToSave = array();
        $now = new DateTime();
        $currentDate = $now->format( "Y-m-d H:i:s" );
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
        foreach ($list as $id) 
        {
            $dataToSave[] = array(
                'status_log_id_psf' => $statusLogId,
                'project_id_psf' => $projectId,
                'status_id_psf' => $statusId,
                'file_id_psf' => $id,
                'createdon_psf' => $currentDate,
                'createdby_psf' => $currentUserId
            );
        }
        
        if(count($dataToSave) > 0)
            Model_project_status_file::insertBatch($dataToSave);
    }
}