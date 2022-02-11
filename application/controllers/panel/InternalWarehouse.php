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

	public function entryLog()
	{
		$allInternals = Model_internals::basicEntryLog();

		$this->_loadPanelView("internal-warehouse/entry-log", compact('allInternals'));
	}

	public function entry()
	{
		$this->complementHandler->addViewComplement('jquery.inputmask.bundle');
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
			$entryDate = date('d-m-Y');
			$entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
			$entryDate = date_format($entryDate, 'Y-m-d');
			$entryDate = $entryDate." ".date("H:i:s");
			$materials = array_values($formData['summary']);
			$currentUser = PrivateController::getSessionUser();
			$currentUserId = isset($currentUser) ? $currentUser->id:NULL;
			
			foreach ($materials as $material)
			{
				$quantity = str_replace(',','',$material['quantity']);
				$quantity = floatval($quantity);
				if($quantity > 0)
				{
					$iternalMaterials = new Model_internals($material['id'],$quantity,$material['status'],$material['tension']);
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
			
			redirect(base_url("panel/Warehouse/internal"));				
		}
		
	}
}
