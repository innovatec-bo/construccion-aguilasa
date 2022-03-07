<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 09/08/2018
 * Time: 10:34 AM
 */

require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use Carbon\Carbon;

class InternalWarehouse extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

	public function printView($summaryId = NULL, $getAsVariable = NULL)
	{
		$materialSummary = NULL;
		if(!is_null($summaryId))
		{
			$materialsRequestId = $summaryId;
			$method = debug_backtrace()[1]['function'];
			$redirectTo = "panel/Warehouse/".$method;
			/** @var Model_material_summary $materialSummary */
			$materialSummary = $this->_validateObjectToEdit($materialsRequestId,Model_material_summary::class, $redirectTo, "No se encuentra la lista de solicitud.");
		}

		$this->complementHandler->addProjectCss('warehouse.print-view', TRUE);
		$this->complementHandler->addProjectJs('warehouse.print-view', TRUE);

		/*** data from request list - begin*/
		$materialList = NULL;
		$summaryTypeId = NULL;
		if($materialSummary instanceof Model_material_summary)
		{
			$materialSummary = Model_material_summary::getMasterDetailByListId($materialSummary->getId());
			$materialList = Model_project_material::getBySummaryId($materialSummary['summary_id']);
			$summaryType = Model_material_summary_type::getById($materialSummary['summary_type']);
			$summaryTypeId = $summaryType->getId();
		}
		/*** data from request list - end*/
		$viewTitle = "Movimiento de materiales";
		if($summaryTypeId == 15 || $summaryTypeId == 14)
			$viewTitle = "Solicitud de materiales";


		if($getAsVariable == 1)
		{
			$visiblePrintBlock = "visible-print-block";
			return $this->load->view("default-template/panel/content/warehouse/print-view",compact('viewTitle','materialSummary','materialList','summaryTypeId','summaryType','visiblePrintBlock'), TRUE);
		}

		else
		{
			$visiblePrintBlock = "";
			$this->_loadPanelView("warehouse/print-view",compact('viewTitle','materialSummary','materialList','summaryTypeId','summaryType','visiblePrintBlock'));
		}
	}

	public function showAll()
	{
		$allInternals = Model_internals::basicEntryLog();

		$this->_loadPanelView("internal-warehouse/show-all", compact('allInternals'));
	}

	public function index()
	{
		$operationTypes = Model_internal_warehouse_operation_type::getAll(100,0);
		$arrayOperationTypes = [];
		foreach ($operationTypes as $operationType) 
		{
			$arrayOperationTypes[$operationType->id_oty] = (array)$operationType;
		}
		$allOperations = Model_internal_warehouse_operation::getAll(10000,0);
		$this->_loadPanelView("internal-warehouse/index", compact('allOperations','arrayOperationTypes'));
	}

	public function show($operationId)
	{
		$operationTypes = Model_internal_warehouse_operation_type::getAll(100,0);
		$arrayOperationTypes = [];
		foreach ($operationTypes as $operationType) 
		{
			$arrayOperationTypes[$operationType->id_oty] = (array)$operationType;
		}
		$operation = Model_internal_warehouse_operation::getById($operationId);
		$materials = Model_internals::getByOperationId($operationId);
		$this->_loadPanelView("internal-warehouse/show", compact('operation','materials','arrayOperationTypes'));
	}

	public function loan()
	{
		$this->complementHandler->addViewComplement('jquery.inputmask.bundle');
		$this->complementHandler->addViewComplement("date-time-picker");
		$this->complementHandler->addProjectJs('warehouse.loan');
		
		$this->form_validation->set_rules('summary[]', 'Materiales','trim|required');

		$materials = Model_material::getAll(10000,0);
		$projects = Model_project::getByStatusKeywordList(['approved','assign_to','in_progress','stopped','paused','completed','as_built','conciliation_reception','conciliation_shipment','cre_return_order','project_return_materials','project_energized']);
		$fiscals = Model_user::getByRoleKeyword('fiscal');
		$builders = Model_user::getByRoleKeyword('builder');
		if($this->form_validation->run() === FALSE)
		{
			$this->_loadPanelView('warehouse/loan', compact('materials','projects','fiscals','builders'));
		}
		else
		{
			$formData = $this->input->post();
			$detail = $formData['detail'];
			$fiscalId = $formData['fiscal'];
			$builderId = $formData['builder'];
			$projectId = $formData['project'];
			$entryDate = $formData['entry-date'];
			$entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
			$entryDate = date_format($entryDate, 'Y-m-d');
			$entryDate = $entryDate." ".date("H:i:s");
			$materials = array_values($formData['summary']);
			$currentUser = PrivateController::getSessionUser();
			$currentUserId = isset($currentUser) ? $currentUser->id:NULL;
			$operationType = Model_internal_warehouse_operation_type::getByKeywords(['loan']);
			$operationType = array_values($operationType); 
			/** @var $operationType Model_internal_warehouse_operation_type */
			$operationType = $operationType[0];
			$operation = new Model_internal_warehouse_operation($entryDate, $detail, $operationType->getId());
			if(is_numeric($fiscalId))
			{
				$operation->setFiscalId($fiscalId);
			}
			if(is_numeric($builderId))
			{
				$operation->setBuilderId($builderId);
			}
			if(is_numeric($projectId))
			{
				$operation->setProjectId($projectId);
			}
			$operation = $operation->save();
			foreach ($materials as $material)
			{
				$quantity = str_replace(',','',$material['quantity']);
				$quantity = floatval($quantity);
				if($quantity > 0)
				{
					$iternalMaterials = new Model_internals($material['id'],$quantity,$material['status'],$material['tension'], $operation->getId());
					$iternalMaterials->setCreatedOn($entryDate);
					$iternalMaterials->setCreatedBy($currentUserId);
					$dataToSave[] = $iternalMaterials->toArray();
				}
			}

			if(count($dataToSave) > 0)
			{
				Model_internals::insertBatch($dataToSave);
				$this->session->set_flashdata("successMessage", 'Se agregaron nuevos materiales a la reserva interna.');
			}
			else
			{
				$this->session->set_flashdata("errorMessage", 'No se agrego ningun material');
			}			
			
			redirect(base_url("panel/InternalWarehouse/loan"));
		}	
	}

	public function entry()
	{
		$this->complementHandler->addViewComplement('jquery.inputmask.bundle');
		$this->complementHandler->addViewComplement("date-time-picker");
		$this->complementHandler->addProjectJs('warehouse.internal');
		
		$this->form_validation->set_rules('summary[]', 'Materiales','trim|required');

		$materials = Model_material::getAll(10000,0);
		if($this->form_validation->run() === FALSE)
		{
			$this->_loadPanelView('warehouse/internal', compact('materials'));
		}
		else
		{
			$formData = $this->input->post();
			$detail = $formData['detail'];
			$entryDate = $formData['entry-date'];
			$entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
			$entryDate = date_format($entryDate, 'Y-m-d');
			$entryDate = $entryDate." ".date("H:i:s");
			$materials = array_values($formData['summary']);
			$currentUser = PrivateController::getSessionUser();
			$currentUserId = isset($currentUser) ? $currentUser->id:NULL;
			$operationType = Model_internal_warehouse_operation_type::getByKeywords(['entry']);
			$operationType = array_values($operationType); 
			/** @var $operationType Model_internal_warehouse_operation_type */
			$operationType = $operationType[0];
			$operation = new Model_internal_warehouse_operation($entryDate, $detail, $operationType->getId());
			$operation = $operation->save();
			foreach ($materials as $material)
			{
				$quantity = str_replace(',','',$material['quantity']);
				$quantity = floatval($quantity);
				if($quantity > 0)
				{
					$iternalMaterials = new Model_internals($material['id'],$quantity,$material['status'],$material['tension'], $operation->getId());
					$iternalMaterials->setCreatedOn($entryDate);
					$iternalMaterials->setCreatedBy($currentUserId);
					$dataToSave[] = $iternalMaterials->toArray();
				}
			}

			if(count($dataToSave) > 0)
			{
				Model_internals::insertBatch($dataToSave);
				$this->session->set_flashdata("successMessage", 'Se agregaron nuevos materiales a la reserva interna.');
			}
			else
			{
				$this->session->set_flashdata("errorMessage", 'No se agrego ningun material');
			}			
			
			redirect(base_url("panel/InternalWarehouse/entry"));
		}
		
	}

	public function generalList()
	{
		$allInternals = Model_internals::basicEntryLog();
		
		$grouped = [];
		foreach ($allInternals as $row)
		{
			
			if(!isset($grouped[$row['code_mat']]))
			{
				$grouped[$row['code_mat']] = $row;
				$grouped[$row['code_mat']]['total'] = 0;
			}
			
			$grouped[$row['code_mat']]['total'] += floatval($row['quantity_int']);
		}
		$this->_loadPanelView("internal-warehouse/general-list", compact('grouped'));
	}

	//Used to update old data in mat_internals table
	// public function createOperations()
	// {
	// 	$allInternals = Model_internals::basicEntryLog();
	// 	$dataToUpdate = [];

	// 	foreach ($allInternals as $row) 
	// 	{
	// 		if(is_null($row['operation_id_int']))
	// 		{
	// 			$dataToUpdate[$row['createdon_int']][] = $row;
	// 		}
	// 	}

	// 	foreach ($dataToUpdate as $date => $items) 
	// 	{
	// 		$operation = new Model_internal_warehouse_operation($date, "");
	// 		$operation = $operation->save();

	// 		$toAssignOperationId = [];
	// 		foreach ($items as $item) 
	// 		{
	// 			$toAssignOperationId[] = [
	// 				'id_int' => $item['id_int'],
	// 				'operation_id_int' => $operation->getId()
	// 			];
	// 		}
	// 		if(count($toAssignOperationId) > 0)
	// 			Model_internals::updateBatch($toAssignOperationId,'id_int');
	// 	}
	// }
}