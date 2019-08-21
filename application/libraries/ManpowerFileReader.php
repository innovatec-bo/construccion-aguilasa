<?php
require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ManpowerFileReader
{
    private $_file;
    private $_excelArrayData;
    private $_designBudgetIdentifiers;
    private $_buildingBudgetIdentifiers;
    private $_transportationBudgetIdentifiers;
    private $_liveLineBudgetIdentifiers;
    private $_rightOfWayBudgetIdentifiers;
    private $_designBudget;
    private $_buildingBudget;
    private $_transportationBudget;
    private $_liveLineBudget;
    private $_rightOfWayBudget;
    private $_graphNumber;
    private $_levelOfTension;
    private $_destiny;
    private $_structureListFromExcelFile;

    public function __construct(Model_file $file)
	{
        $this->_file = $file;
        $this->_setExcelArrayData();
        $this->_designBudgetIdentifiers = array('ERU', 'ERU_B', 'ERR');
        $this->_buildingBudgetIdentifiers = array();
        $this->_transportationBudgetIdentifiers = array('CTPH-M');
        $this->_liveLineBudgetIdentifiers = array('lv');
        $this->_rightOfWayBudgetIdentifiers = array('R1');
        $this->_designBudget = 0;
        $this->_buildingBudget = 0;
        $this->_transportationBudget = 0;
        $this->_liveLineBudget = 0;
        $this->_rightOfWayBudget = 0;
        $this->_graphNumber = '';
        $this->_levelOfTension = '';
        $this->_destiny = '';

        $this->_setStructureListFromExcelFile();
        $this->_setDataFromExcelFile();
	}

	private function _setExcelArrayData()
    {
        $reader = new Xlsx();
        if(strtolower($this->_file->getExtension()) == "xls")
        {
            $reader = new Xls();
        }

        $fileLocation = FCPATH.$this->_file->getUrl();
        $spreadsheet = $reader->load($fileLocation);
        $sheetList = $spreadsheet->getAllSheets();
        $sheetData = $sheetList[0];
        $this->_excelArrayData = $sheetData->toArray();
    }

	private function _setStructureListFromExcelFile()
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
                $structureCode = trim($data[2]);
                $description = trim($data[4]);
                $unit = trim($data[5]);
                $currentUser = PrivateController::getSessionUser();
                $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
                if($structureCode != "")
                {
                    $this->_structureListFromExcelFile[$structureCode] = array(
                        'structure_code_bus' => $structureCode,
                        'description_bus' => $description,
                        'unit_of_measurement_bus' => $unit,
                        'createdon_bus' => date('Y-m-d H:i:s'),
                        'createdby_bus' => $currentUserId
                    );
                }
            }
        }
    }

	public function saveStructuresInDataBase()
    {
        $structureListFromExcelFile = $this->_structureListFromExcelFile;
        $structureCodeList = array_keys($structureListFromExcelFile);
        $existingStructures = Model_building_structure::getByStructureList($structureCodeList);
        foreach($existingStructures as $structure)
        {
            $structure = $structure->toArray();
            $existingStructureCode = $structure['structure_code_bus'];
            if(isset($structureListFromExcelFile[$existingStructureCode]))
            {
                unset($structureListFromExcelFile[$existingStructureCode]);
            }
        }
        $structureListFromExcelFile = array_values($structureListFromExcelFile);
        if(count($structureListFromExcelFile) > 0)
            Model_building_structure::insertBatch($structureListFromExcelFile);
    }

    private function _setDataFromExcelFile()
    {
        $startReadingData = FALSE;
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
            //Setting approved budgets
            if($data[0] == 'ITEM')
            {
                $startReadingData = TRUE;
                continue;
            }
            if($startReadingData)
            {
                $structure = trim($data[2]);
                $execution = trim($data[3]);
                $quantity = floatval(trim($data[6]));
                $unitPrice = floatval(trim($data[7]));
                $amount = round($quantity*$unitPrice, 2);

                if(in_array($structure, $this->_designBudgetIdentifiers))
                {
                    $this->_designBudget += $amount;
                }
                if(in_array($structure, $this->_buildingBudgetIdentifiers))
                {
                    $this->_buildingBudget += $amount;
                }
                if(in_array($structure, $this->_transportationBudgetIdentifiers))
                {
                    $this->_transportationBudget += $amount;
                }
                if(in_array(strtolower($execution), $this->_liveLineBudgetIdentifiers))
                {
                    $this->_liveLineBudget += $amount;
                }
                if(in_array($structure, $this->_rightOfWayBudgetIdentifiers))
                {
                    $this->_rightOfWayBudget += $amount;
                }
            }
        }
    }

    public function getDesignBudget()
    {
        return $this->_designBudget;
    }

    public function getBuildingBudget()
    {
        return $this->_buildingBudget;
    }

    public function getTransportationBudget()
    {
        return $this->_transportationBudget;
    }

    public function getLiveLineBudget()
    {
        return $this->_liveLineBudget;
    }

    public function getRightOfWayBudget()
    {
        return $this->_rightOfWayBudget;
    }

    public function getGraphNumber()
    {
        return $this->_graphNumber;
    }

    public function getLevelOfTension()
    {
        return $this->_levelOfTension;
    }

    public function getDestiny()
    {
        return $this->_destiny;
    }

    public function registerManpowerInSystem($projectId)
    {
        $laborCostToSave = array();
        $laborDetail = Model_labor_detail::getByProjectId($projectId);

        //If the labor detail does not exist for the project then let's create it and add its labor cost list
        if(!$laborDetail instanceof Model_labor_detail)
        {
            $laborDetail = new Model_labor_detail($projectId, $this->_graphNumber, $this->_levelOfTension, $this->_destiny);
            $laborDetail->save();
            $structureCodeList = array_keys($this->_structureListFromExcelFile);
            $existingStructures = Model_building_structure::getMasterDetailByStructureCodeList($structureCodeList);
            $startReadingData = FALSE;
            foreach($this->_excelArrayData as $index => $data)
            {
                //Structure
                $structure = trim($data[2]);
                $key = array_search($structure, array_column($existingStructures, 'structure_code_bus'));
                $structureId = $existingStructures[$key];
                $structureId = $structureId['id_bus'];
                //Activity
                $activity = trim($data[1]);
                //Execution
                $execution = trim($data[3]);
                //Quantity
                $quantity = floatval(trim($data[6]));
                //Unite price
                $unitPrice = floatval(trim($data[7]));
                //Current user Id
                $currentUser = PrivateController::getSessionUser();
                $currentUserId = isset($currentUser) ? $currentUser->id:NULL;

                if($data[0] == 'ITEM')
                {
                    $startReadingData = TRUE;
                    continue;
                }

                if($startReadingData && $structure != '')
                {
                    $laborCostToSave[] = array(
                        "labor_detail_id_lac" => $laborDetail->getId(),
                        "building_structure_id_lac" => $structureId,
                        "activity_lac" => $activity,
                        "execution_lac" => $execution,
                        "quantity_lac" => $quantity,
                        "unit_price_lac" => $unitPrice,
                        "deleted_lac" => 0,
                        "createdon_lac" => date('Y-m-d H:i:s'),
                        "createdby_lac" => $currentUserId
                    );
                }
            }
            if(count($laborCostToSave))
                Model_labor_cost::insertBatch($laborCostToSave);
        }
    }

    public function registerDesignBudgetOnLog($projectId)
    {
        $userId = NULL;
        $detail = "Ingresado automaticamente por el sistema";
        $manualEntryDate = date("Y-m-d H:i:s");        
        $laborCostList = Model_labor_cost::getByProjectIdAndStructureCodeList($projectId, $this->_designBudgetIdentifiers);
        foreach($laborCostList as $laborCost)
        {
            $workedUp[] = array('labor-cost-id' => $laborCost['id_lac'], 'quantity' => $laborCost['quantity_lac']);
        }
        $builders = array();
        // echo"<pre>";var_dump($userId, $detail, $manualEntryDate, $workedUp, $builders);exit;
        Model_labor_cost_log::addLog($userId, $detail, $manualEntryDate, $workedUp, $builders);
    }
}