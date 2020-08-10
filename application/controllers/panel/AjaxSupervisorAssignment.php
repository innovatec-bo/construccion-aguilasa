<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 07/02/2019
 * Time: 9:36 AM
 */

class AjaxSupervisorAssignment extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function saveDistribution()
    {
        /** Server Side Validations **/
        $this->form_validation->set_rules('distributionList', 'Lista de distribucion', 'trim');
        $this->form_validation->set_rules('year', "A&ntilde;o", 'trim');
        $this->form_validation->set_rules('month', 'Mes', 'trim');

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

            $month = $formData["month"];
            $year = $formData["year"];
			$startDate = $year."-".$month."-01 00:00:00";
			$endDate = date("Y-m-t 23:59:59", strtotime($startDate));
			$dateRange = array("from" => $startDate, "to" => $endDate);
            $distributionList = $formData["distributionList"];
            Model_user_supervisor_by_period::saveDistributionList($dateRange, $distributionList);

            $response = array("success" => 1, "message" => "Distribucion guardada correctamente.");
        }
        echo json_encode($response);exit;
    }

    public function loadDistribution($month, $year)
	{
		$startDate = $year."-".$month."-01 00:00:00";
		$endDate = date("Y-m-t 23:59:59", strtotime($startDate));
		$dateRange = array("from" => $startDate, "to" => $endDate);
		$list = Model_user_supervisor_by_period::getAssignmentByDateRange($dateRange);
		$availableBuilders = Model_user_supervisor_by_period::getAvailableBuildersByDateRange($dateRange);
		$result['success'] = 1;
		$result['message'] = '';
		$result['data']['template'] = $this->load->view('default-template/panel/content/supervisor-assignment/SupervisorAssignmentHandler', array(), TRUE);
		$result['data']['distributionList'] = array_values($list);
		$result['data']['availableBuilders'] = $availableBuilders;
		echo json_encode($result);exit;
	}
}
