<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2020-11-05
 * Time: 11:53 AM
 */

class AjaxDeletedStatusLog extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function add()
    {
        $this->_validateFeature('deleted_status_log_add');
        /** Server Side Validations **/
        $this->form_validation->set_rules('project-status-log-id', 'Status Log ID', 'trim|required');
        $this->form_validation->set_rules('detail', 'Detail', 'trim|required');

        if($this->form_validation->run() === FALSE)
        {
			$validationErrors = validation_errors();
			$validationErrors = str_replace("<p>","",$validationErrors);
			$validationErrors = str_replace("</p>","<br>",$validationErrors);
			$response = array("success" => 0, "message" => $validationErrors);
			$success = $validationErrors != ""?0:1;
			$response["success"] = $success;
			$response["message"] = $validationErrors;
        }
        else
        {
            $formData = $this->input->post();
            $projectStatusLogId = $formData["project-status-log-id"];

            //Let's get and delete the status log ID
            /** @var Model_project_status_log $projectStatusLog */
			$projectStatusLog = Model_project_status_log::getById($projectStatusLogId);
			$projectStatusLog->delete();

			//Let's get the current project log after deleted project status log
			$projectLog = Model_project_status_log::getLogByProjectId($projectStatusLog->getProjectId());

			//Update the project with the first status in Project Log
			/** @var Model_project $project */
			$project = Model_project::getById($projectStatusLog->getProjectId());
			if($project->getStatus() != $projectLog[0]['status_id_psl'])
			{
                //If the previous status is 'approvement' then let's also delete it.
                if($projectLog[0]['status_id_psl'] == 8)
                {
                    $projectStatusLog = Model_project_status_log::getById($projectLog[0]['id_psl']);
			        $projectStatusLog->delete();
                    $project->setStatus($projectLog[1]['status_id_psl']);
				    $project->save();
                }
                else
                {
                    $project->setStatus($projectLog[0]['status_id_psl']);
				    $project->save();
                }
				
			}

            $detail = $formData["detail"];
			$currentUser = PrivateController::getSessionUser();
			$currentUserId = isset($currentUser) ? $currentUser->id:NULL;
            $deletedStatusLog = new Model_deleted_status_log($currentUserId, $projectStatusLogId, $detail);
			$deletedStatusLog->save();
            $response["success"] = 1;
            $response["message"] = "Se elimino un registro del log";
        }
        echo json_encode($response);exit;
    }
}
