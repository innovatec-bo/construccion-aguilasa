<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 10/1/2018
 * Time: 2:01 PM
 */


class AjaxBuildingPoint extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

	public function paginationJs()
	{
		$formData = $this->input->post();
		$pageSize = $formData['pageSize'];
		$pageNumber = $formData['pageNumber'] == 1?($formData['pageNumber'] - 1):(($formData['pageNumber']-1)*20)+1;
		$textToSearch = isset($formData['textToSearch'])?$formData['textToSearch']:"";
		$additionalParameters = isset($formData["additionalParameters"])?$formData["additionalParameters"]:array();
		$additionalParameters['project-id'] = $formData['projectId'];
		$recordsTotal = Model_building_point::countAll($additionalParameters);
		$recordsFiltered = $recordsTotal;
		if ($textToSearch == "")
		{
			$resultArray = Model_building_point::getAll($pageSize, $pageNumber, NULL, "asc", $additionalParameters);
		}
		else
		{
			$resultArray = Model_building_point::search($textToSearch, $pageSize, $pageNumber, NULL, "asc", array("label_bpo"), $additionalParameters);
			$recordsFiltered = Model_building_point::searchTotalCount($textToSearch, array("label_bpo"), $additionalParameters);

		}
		$response = array();
		$response['recordsTotal'] = $recordsTotal;
		$response['recordsFiltered'] = $recordsFiltered;
		$response['resultArray'] = $resultArray;
		echo json_encode($response);exit;
	}
}
