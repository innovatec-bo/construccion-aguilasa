<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 11/04/2020
 * Time: 15:00
 */


class AjaxLaborCostLog extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function edit($laborCostLogId)
    {
        /** Server Side Validations **/
        $this->form_validation->set_rules('detail', 'Detalle', 'trim');
        $this->form_validation->set_rules('entry-date', 'Detalle', 'trim|required');

        if ($this->form_validation->run() === FALSE) 
        {
            $validationErrors = validation_errors();
            $validationErrors = str_replace("<p>", "", $validationErrors);
            $validationErrors = str_replace("</p>", "<br>", $validationErrors);
            $response = array("success" => 0, "message" => $validationErrors);
            $success = $validationErrors != "" ? 0 : 1;

			$dateRangesToBlock = Model_blocked_log_date_range::getAll(100, 0);
            $logMasterDetail = Model_labor_cost_log::prepareArrayLogMasterDetal($laborCostLogId);
            $fiscals = Model_user::getByRoleKeyword('fiscal');
            $arrayFiscal = [];
            foreach($fiscals as $fiscal)
            {
                $fiscal = $fiscal->toArray();
                $arrayFiscal[] = [
                    'id' => $fiscal['id_usr'],
                    'firstName' => $fiscal['firstname_usr'],
                    'lastName' => $fiscal['lastname_usr']
                ];
            }
            $builders = Model_user::getByRoleKeyword('builder');
            $arrayBuilder = array();
            foreach($builders as $builder)
            {
                $builder = $builder->toArray();
                $arrayBuilder[] = array(
                    'id' => $builder['id_usr'],
                    'firstName' => $builder['firstname_usr'],
                    'lastName' => $builder['lastname_usr']
                );
            }

            $projectId = $logMasterDetail['projectId'];
            $workflowPagination = new WorkflowPaginationHandler(1);
            $workflowPagination->setAdditionalParameters(['id-list'=>$projectId]);
            $workflowPagination->setColumnsToShow(['fiscal_responsible_id','fiscal_responsible','keyword_pst','production_total_bs','project_current_design_budget','production_percentage','project_current_budget']);
            $productionLimit = Model_production_limit::getByProjectId($projectId);
            if(!$productionLimit instanceof Model_production_limit)
            {
                $productionLimit = new Model_production_limit($projectId, 110, date('Y-m-d H:i:s'), null);
                $productionLimit->save();
            }
            $project = $workflowPagination->getAll();

            $response["data"]["fiscals"] = $arrayFiscal;
            $response["data"]["builders"] = $arrayBuilder;
            $response["success"] = $success;
            $response["message"] = $validationErrors;
            $response["data"]["logMasterDetail"] = $logMasterDetail;
            $template = $this->loadView('panel/content/project/ManpowerHandler', array(), TRUE);
            $response["data"]["template"] = $template;
            $response["data"]["templateName"] = "#ht-modal-form-edit-point-to-point-progress";
            $response["data"]["dateRangesToBlock"] = $dateRangesToBlock;
            $response['data']['project'] = $project[0];
        } 
        else
        {
            $formData = $this->input->post();
            // echo"<pre>";var_dump($formData);exit;
            $manualEntryDate = $formData["entry-date"];
            $manualEntryDate = DateTime::createFromFormat('d-m-Y', $manualEntryDate);
            $manualEntryDate = date_format($manualEntryDate, 'Y-m-d');
            $manualEntryDate = $manualEntryDate." ".date("H:i:s");
            $detail = $formData["detail"];
            $workedUp = $formData["worked-up"];
            $builders = $formData["builders"];
            $fiscalId = $formData['fiscal'];
            $laborCostLog = Model_labor_cost_log::getById($laborCostLogId);
            $laborCostLog->setFiscalId($fiscalId);
            $laborCostLog->setDetail($detail);
            $laborCostLog->setManualEntryDate($manualEntryDate);
            $laborCostLog->save();
            $laborCostLog->addWorkedUpStructures($workedUp);
            $laborCostLog->addBuildersToManpower($builders);
            $response["success"] = 1;
            $response["message"] = "Avance editado correctamente.";
            $response["data"]['pointId'] = $laborCostLog->getPointId();
        }
        echo json_encode($response);
        exit;
    }

    public function delete($laborCostLogId)
    {
        /** Server Side Validations **/
        $this->form_validation->set_rules('detail', 'Detalle', 'trim');

        if ($this->form_validation->run() === FALSE) 
        {
            $validationErrors = validation_errors();
            $validationErrors = str_replace("<p>", "", $validationErrors);
            $validationErrors = str_replace("</p>", "<br>", $validationErrors);
            $response = array("success" => 0, "message" => $validationErrors);
            $success = $validationErrors != "" ? 0 : 1;
            $logMasterDetail = Model_labor_cost_log::prepareArrayLogMasterDetal($laborCostLogId);
            $response["success"] = $success;
            $response["message"] = $validationErrors;
            $response["data"]["logMasterDetail"] = $logMasterDetail;
        } 
        else
        {
            $formData = $this->input->post();
            $laborCostLog = Model_labor_cost_log::getById($laborCostLogId);
            $laborCostLog->delete();
            $response["success"] = 1;
            $response["message"] = "Registro eliminado.";
            $response['data']['pointId'] = $laborCostLog->getPointId();
        }
        echo json_encode($response);
        exit;
    }    
}
