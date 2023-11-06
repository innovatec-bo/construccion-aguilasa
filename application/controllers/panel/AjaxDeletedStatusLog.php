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
            if($projectStatusLog->getProjectStatus() == 11 && $this->sessionUser->id != 1)
            {
                $response["success"] = 0;
                $response["message"] = "No tiene permiso para borrar el estado de 'Aprobado'";
                echo json_encode($response);exit;
            }
			
            $projectStatusLog->delete();

			//Let's get the current project log after deleted project status log
			$projectLog = Model_project_status_log::getLogByProjectId($projectStatusLog->getProjectId());
			//Update the project with the first status in Project Log
			/** @var Model_project $project */
			$project = Model_project::getById($projectStatusLog->getProjectId());
			if($project->getStatus() != $projectLog[0]['status_id_psl'])
			{
                switch ($projectLog[0]['status_id_psl']) 
                {
                    case 8:
                        $projectStatusLog = Model_project_status_log::getById($projectLog[0]['id_psl']);//Delete approvement
                        $projectStatusLog->delete();
                        $projectStatusLog = Model_project_status_log::getById($projectLog[1]['id_psl']);//Delete Schedule
                        $projectStatusLog->delete();
                        $project->setStatus($projectLog[2]['status_id_psl']);
                        $project->save();
                        break;
                    default:
                        $project->setStatus($projectLog[0]['status_id_psl']);
                        $project->save();
                        if ($projectLog[0]['status_id_psl'] == 10) //Approved status
                        {
                            //Deleting labor cost logs
                            $logIdsToDelete = Model_labor_cost_log::getLogByProjectId($project->getId());
                            if(count($logIdsToDelete) > 0)
                            {
                                Model_labor_cost_log::deleteLogsByIdsArray($logIdsToDelete);
                            }
                            
                            //Deleting labor details and its costs
                            $laborDetail = Model_labor_detail::getByProjectId($project->getId());
                            $laborDetail->delete();
                            //Deleting points
                            Model_building_point::deleteByProjectId($project->getId());
                            //Deleting point to point master
                            Model_point_to_point_master::deleteByProjectCode($project->getCode());
                        }
                        break;
                }
			}

            $detail = $formData["detail"];
			$currentUser = PrivateController::getSessionUser();
			$currentUserId = isset($currentUser) ? $currentUser->id:NULL;
            $deletedStatusLog = new Model_deleted_status_log($currentUserId, $projectStatusLogId, $detail);
			$deletedStatusLog->save();
            $response["success"] = 1;
            $response['data']['projectId'] = $projectStatusLog->getProjectId();
            $response['data']['projectStatusId'] = $projectStatusLog->getProjectStatus();
            $response["message"] = "Se elimino un registro del log";
        }
        echo json_encode($response);exit;
    }
}
