<?php
require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

class MaterialsFileReader
{
    private int $_projectId;
    private Model_file $_file;
    private array $_excelArrayData;
    private string $_graphNumber;
    private string $_levelOfTension;
    private string $_destiny;
    private array $_materialListFromExcelFile;
    private array $_materialsQuantityLog;
    private int $_isAdditional = 0;

    public function __construct(int $projectId, Model_file $file)
	{
	    $this->_projectId = $projectId;
        $this->_file = $file;
        $this->_setExcelArrayData();
        $this->_setMaterialListFromExcelFile();
        $this->_setDataFromExcelFile();
	}

	public function isAdditional() : void
	{
		$this->_isAdditional = 1;
	}

	private function _setExcelArrayData() : void
    {
        switch (strtolower($this->_file->getExtension()))
        {
            case 'xlsx':
                $reader = new Xlsx();
                break;
            case 'xls':
                $reader = new Xls();
                break;
            default:
                $reader = new Csv();
                $reader->setDelimiter(';');
                $reader->setInputEncoding('ISO-8859-1');
                break;
        }
		
        $fileLocation = FCPATH.$this->_file->getUrl();
        $spreadsheet = $reader->load($fileLocation);
        $sheetList = $spreadsheet->getAllSheets();
        $sheetData = $sheetList[0];
        $this->_excelArrayData = $sheetData->toArray();
    }

	private function _setMaterialListFromExcelFile() : void
    {
        $startReadingData = FALSE;
        //Prepare data to save from excel file
        foreach($this->_excelArrayData as $index => $data)
        {
            //Setting approved budgets
            if($data[0] == 'ITEM')
            {
                $startReadingData = TRUE;
                continue;
            }
            if($startReadingData)
            {
                $materialCode = trim($data[1]);
                $description = trim($data[2]);
                $unit = trim($data[3]);
                $quantity = trim($data[4]);
                $currentUser = PrivateController::getSessionUser();
                $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
                if($materialCode != "")
                {
                    $this->_materialListFromExcelFile[$materialCode] = array(
                        'code_mat' => $materialCode,
                        'description_mat' => $description,
                        'unit_of_measurement_mat' => $unit,
                        'createdon_mat' => date('Y-m-d H:i:s'),
                        'createdby_mat' => $currentUserId
                    );

                    $this->_materialsQuantityLog[$materialCode] = array(
						'quantity_pmq' => $quantity,
						'createdon_pmq' => date('Y-m-d H:i:s'),
						'createdby_pmq' => $currentUserId
					);
                }
            }
        }
    }

	public function saveMaterialsInDataBase() : void
    {
        $materialListFromExcelFile = $this->_materialListFromExcelFile;
        $materialsToUpdate = array();
        $materialCodeList = array_keys($materialListFromExcelFile);
        $existingMaterials = Model_material::getByCodeList($materialCodeList);
        foreach($existingMaterials as $material)
        {
            $material = $material->toArray();
            $existingMaterialCode = $material['code_mat'];
            if(isset($materialListFromExcelFile[$existingMaterialCode]))
            {
				$materialsToUpdate[] = $materialListFromExcelFile[$existingMaterialCode];
                unset($materialListFromExcelFile[$existingMaterialCode]);
            }
        }
        $materialListFromExcelFile = array_values($materialListFromExcelFile);
        if(count($materialListFromExcelFile) > 0)
            Model_material::insertBatch($materialListFromExcelFile);
        if(count($materialsToUpdate) > 0)
			Model_material::updateBatch($materialsToUpdate, 'code_mat');
    }

    private function _setDataFromExcelFile() : void
    {
        foreach($this->_excelArrayData as $index => $data)
        {
            //Setting Graph number and level of tension
            if(strpos(strtolower($data[0]),'grafo') !== FALSE)
            {
                $haystack = array_values(array_filter(explode(" ",$data[0])));
                foreach ($haystack as $index => $value)
                {
                    if (preg_match('/.*grafo.*/i', strtolower($value)))
                    {
                        $this->_graphNumber = trim($haystack[$index+1]);
                    }

                    if (preg_match('/.*tension.*/i', strtolower($value)))
                    {
                        $this->_levelOfTension = trim($haystack[$index+1]);
                    }
                }
            }
            //Setting destiny
            if(strpos(strtolower($data[0]),'destino') !== FALSE)
            {
                $haystack = array_values(array_filter(explode(":",$data[0])));
                foreach ($haystack as $index => $value)
                {
                    if(preg_match('/.*destino.*/i', strtolower($value)))
                    {
                        $this->_destiny = trim($haystack[$index+1]);
                        break;
                    }
                }
            }
        }
    }

	/**
	 * This method allow register initial materials and additional materials to project.
	 * @param int $projectStatusLogId All materials are associated to project status log ID
	 * @param string $entryDate Specify the materials entry date
	 * @param int $userResponsibleId User responsible by materials summary
	 * @param int $summaryTypeId This variable specify the warehouse material activity
	 * @param string $detail
	 * @param int|null $parentSummaryId
	 * @param string $reservationNumber
	 */
    public function registerMaterialsInSystem(int $projectStatusLogId, string $entryDate, ?int $userResponsibleId = NULL, int $summaryTypeId, string $detail = "", ?int $parentSummaryId = NULL, ?string $reservationNumber = "") : void
    {
        $materialSummaries = Model_material_summary::getByProjectId($this->_projectId);
        //If the material summary does not exist for the project then let's create it and add its project's material list
        if(count($materialSummaries) <= 0)
        {
            $materialSummary = new Model_material_summary($projectStatusLogId, $this->_levelOfTension, $this->_projectId, $this->_projectId, $this->_graphNumber,  $this->_destiny, $entryDate, $detail, $userResponsibleId, $summaryTypeId, $reservationNumber, $this->_file->getId(), $parentSummaryId);
            $materialSummary->save();
            $materialsCodeList = array_keys($this->_materialListFromExcelFile);
            $existingMaterials = Model_material::getMasterDetailByMaterialCodeList($materialsCodeList);
            $startReadingData = FALSE;
            /** @var Model_material_status $status */
			$status = Model_material_status::getByCode('NVO');
            foreach($this->_excelArrayData as $index => $data)
            {
                //Material
				$materialCode = trim($data[1]);
				$quantity = trim($data[4]);
				//let's find the key from existing material list
                $key = array_search($materialCode, array_column($existingMaterials, 'code_mat'));
                //Once found the key let's get the material internal ID
                $materialId = $existingMaterials[$key];
                $materialId = $materialId['id_mat'];

                if($data[0] == 'ITEM')
                {
                    $startReadingData = TRUE;
                    continue;
                }

                if($startReadingData && $materialCode != '')
                {
                	//Save the projects material
                    $projectMaterial = new Model_project_material($materialSummary->getId(), $materialId, $quantity, $status->getId());
					$projectMaterial->save();
                }
            }
        }
    }
}
