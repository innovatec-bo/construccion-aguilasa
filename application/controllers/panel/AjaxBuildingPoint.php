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

	public function add($projectId)
	{
		// $this->_validateFeature('role_edit');

		/** Server Side Validations **/
		$this->form_validation->set_rules('label', 'Label', 'trim|required');
		$this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
		$this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
		$this->form_validation->set_rules('previous-point', 'Punto anterior', 'trim|required');

		if($this->form_validation->run() === FALSE)
		{
			$validationErrors = validation_errors();
			$validationErrors = str_replace("<p>","",$validationErrors);
			$validationErrors = str_replace("</p>","<br>",$validationErrors);
			$response = array("success" => 0, "message" => $validationErrors);
			$success = $validationErrors != ""?0:1;
			$response["success"] = $success;
			$response["message"] = $validationErrors;
			$response["data"]["buildingPoint"] = array();
			$response['data']["template"] = $this->loadView("panel/content/building-point/BuildingPointHandler", array(),true);
			$response['data']["templateName"] = '#building-point-add-form';
		}
		else
		{
			$formData = $this->input->post();
			$label = $formData["label"];
			$latitude = $formData["latitude"];
			$longitude = $formData["longitude"];
			$previousPoint = $formData["previous-point"];
			$buildingPoint = new Model_building_point($projectId, $label,$latitude, $longitude,$previousPoint);
			$buildingPoint->save();
			$response["success"] = 1;
			$response["message"] = "Punto agregado correctamente.";

		}
		echo json_encode($response);exit;
	}

	public function addStructureToPoint($buildingPointId)
	{
		// $this->_validateFeature('role_edit');

		/** Server Side Validations **/
		$this->form_validation->set_rules('quantity-to-use', 'Cantidad a usar', 'trim');
		$this->form_validation->set_rules('labor-cost-id', 'Labor cost ID', 'trim');

		if($this->form_validation->run() === FALSE)
		{
			$validationErrors = validation_errors();
			$validationErrors = str_replace("<p>","",$validationErrors);
			$validationErrors = str_replace("</p>","<br>",$validationErrors);
			$response = array("success" => 0, "message" => $validationErrors);
			$success = $validationErrors != ""?0:1;
			/** @var Model_building_point $buildingPoint */
			$buildingPoint = Model_building_point::getById($buildingPointId);
			$structuresInPoint = Model_structure_by_point::getByPointId($buildingPointId);
			$arrayStructuresInPoint = array();
			/** @var Model_structure_by_point $structureByPoint */
			foreach ($structuresInPoint as $structureByPoint)
			{
				$arrayStructuresInPoint[] = array(
					"id" => $structureByPoint->getId(),
					"laborCostId" => $structureByPoint->getLaborCostId(),
					"label" => $structureByPoint->getLabel()
				);
			}
			$response["success"] = $success;
			$response["message"] = $validationErrors;
			$response["data"]["buildingPoint"]['id'] = $buildingPoint->getId();
			$response["data"]["buildingPoint"]['label'] = $buildingPoint->getLabel();
			$response["data"]["buildingPoint"]['project']['id'] = $buildingPoint->getProjectId();
			$response["data"]["buildingPoint"]['structureList'] = $arrayStructuresInPoint;
			$response['data']["template"] = $this->loadView("panel/content/building-point/BuildingPointHandler", array(),true);
			$response['data']["templateName"] = '#building-point-structure-add-form';
		}
		else
		{
			$formData = $this->input->post();
//			echo"<pre>";var_dump($formData);exit;
			/** @var Model_building_point $buildingPoint */
			$buildingPoint = Model_building_point::getById($buildingPointId);
			$buildingPoint->addStructuresToUse($formData['additional-structures']);
			$listSize = count($formData['additional-structures']);
			$message = "Se agreg&oacute; ".$listSize." estructrua al punto ".$buildingPoint->getLabel();
			if($listSize > 1)
				$message = "Se agregaron ".$listSize." estructuras al punto ".$buildingPoint->getLabel();
			$response["success"] = 1;
			$response["message"] = $message;

		}
		echo json_encode($response);exit;
	}
}
