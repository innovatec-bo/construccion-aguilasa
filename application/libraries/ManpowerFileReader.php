<?php
require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

class ManpowerFileReader
{
    private $_projectId;
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
    private $_pointList;
    private $_pointToPointToSave;

    public function __construct($projectId, Model_file $file, Model_file $pointToPointFile = NULL)
	{
	    $this->_projectId = $projectId;
        $this->_file = $file;
        $this->_setExcelArrayData();
        $this->_designBudgetIdentifiers = array('ERU', 'ERU_B', 'ERR');
        $this->_pointList = array();
        $this->_setBuildingBudgetIdentifiers($pointToPointFile);
        $this->_transportationBudgetIdentifiers = array('CTPH-M', 'CTPH-B');
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
        // $reader = new Xlsx();
        // if(strtolower($this->_file->getExtension()) == "xls")
        // {
        //     $reader = new Xls();
        // }
        // if(strtolower($pointToPointFile->getExtension()) == "csv")
        //     {
        //         $reader = new Csv();
        //         $reader->setDelimiter(';');
        // }
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
                break;
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
            $addToBuildingBudget = TRUE;
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
                    $addToBuildingBudget = FALSE;
                }

                if(in_array($structure, $this->_transportationBudgetIdentifiers))
                {
                    $this->_transportationBudget += $amount;
                    $addToBuildingBudget = FALSE;
                }
                if(in_array(strtolower($execution), $this->_liveLineBudgetIdentifiers))
                {
                    $this->_liveLineBudget += $amount;
                    $addToBuildingBudget = FALSE;
                }
                if(in_array($structure, $this->_rightOfWayBudgetIdentifiers))
                {
                    $this->_rightOfWayBudget += $amount;
                    $addToBuildingBudget = FALSE;
                }
                //If the point to point file is playing then out building budget identifier array is filled
                if(count($this->_buildingBudgetIdentifiers) > 0)
                {

                    if(in_array($structure, $this->_buildingBudgetIdentifiers))
                    {
//                        echo "<pre>";var_dump($this->_buildingBudgetIdentifiers, $structure, $amount, $this->_buildingBudget);exit;
                        $this->_buildingBudget += $amount;
                    }
                }
                else
                {
//                    echo"<pre>";var_dump('there is not data in building budget identifiers');exit;
                    //If the line isn't in the others budgets then add to building budget
                    if($addToBuildingBudget)
                    {
                        $this->_buildingBudget += $amount;
                    }
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

    public function registerManpowerInSystem()
    {
        $laborCostToSave = array();
        $laborDetail = Model_labor_detail::getByProjectId($this->_projectId);

        //If the labor detail does not exist for the project then let's create it and add its labor cost list
        if(!$laborDetail instanceof Model_labor_detail)
        {
            $laborDetail = new Model_labor_detail($this->_projectId, $this->_graphNumber, $this->_levelOfTension, $this->_destiny);
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

    /**
     * After upload the manpower file let's create a log about the design advance
     */
    public function registerDesignBudgetOnLog()
    {
        $laborDetail = Model_labor_detail::getByProjectId($this->_projectId);
        if(!$laborDetail instanceof Model_labor_detail)
        {
            $userId = NULL;
            $detail = "Ingresado automaticamente por el sistema";
            $manualEntryDate = date("Y-m-d H:i:s");        
            $laborCostList = Model_labor_cost::getByProjectIdAndStructureCodeList($this->_projectId, $this->_designBudgetIdentifiers);
            $workedUp = array();
            foreach($laborCostList as $laborCost)
            {
                $workedUp[] = array('labor-cost-id' => $laborCost['id_lac'], 'quantity' => $laborCost['quantity_lac']);
            }
            $builders = array();
            // echo"<pre>";var_dump($userId, $detail, $manualEntryDate, $workedUp, $builders);exit;
            if(count($workedUp) > 0)
                Model_labor_cost_log::addLog($userId, $detail, $manualEntryDate, $workedUp, $builders);    
        }
    }

    /**
    * This method allow set the building budgets
    **/
    private function _setBuildingBudgetIdentifiers(Model_file $pointToPointFile = NULL)
    {
        $this->_buildingBudgetIdentifiers = array();
        if($pointToPointFile instanceof Model_file)
        {
            $reader = new Xlsx();
            if(strtolower($pointToPointFile->getExtension()) == "csv")
            {
                $reader = new Csv();
                $reader->setDelimiter(';');
            }

            $fileLocation = FCPATH.$pointToPointFile->getUrl();
            $spreadsheet = $reader->load($fileLocation);
            $sheetList = $spreadsheet->getAllSheets();
            $sheetData = $sheetList[0];
            $data = $sheetData->toArray();
            unset($data[0]);
            unset($data[1]);
            $data = array_values($data);

            foreach ($data as $key => $value)
            {
                $projectCode = $value[0];
                $structureCode = $value[14];
                $quantityToUse = $value[13];
                $pointLabel = $value[1];
                $latitude = $value[3];
                $longitude = $value[2];
                $previousPoint = $value[5];
                $reg = $value[4];
                $distanceAT = $value[6];
                $angleAT = $value[7];
                $distanceMT = $value[8];
                $angleMT = $value[9];
                $distanceBT = $value[10];
                $angleBT = $value[11];
                $activity = $value[12];
                $execution = $value[15];
                $unitOfMeasurement = $value[16];
                $structureDetail = $value[17];
                $this->_buildingBudgetIdentifiers[] = $structureCode;
                $pointData = array(
                    "label" => $pointLabel,
                    "latitude" => $latitude,
                    "longitude" => $longitude,
                    "previous_point" => $previousPoint
                );
                $this->_pointList[$pointLabel]["pointData"] = $pointData;
                $structureToUse =  array(
                    "structure_code" => $structureCode,
                    "quantity_to_use" => $quantityToUse
                );
                $this->_pointList[$pointLabel]["structureList"][] = $structureToUse;

                $pointToPointRow = array(
                    "project_code_ptp" => $projectCode,
                    "point_ptp" => $pointLabel,
                    "latitude_ptp" => $latitude,
                    "longitude_ptp" => $longitude,
                    "reg_ptp" => $reg,
                    "previous_point_ptp" => $previousPoint,
                    "distance_at_ptp" => $distanceAT,
                    "angle_at_ptp" => $angleAT,
                    "distance_mt_ptp" => $distanceMT,
                    "angle_mt_ptp" => $angleMT,
                    "distance_bt_ptp" => $distanceBT,
                    "angle_bt_ptp" => $angleBT,
                    "activity_ptp" => $activity,
                    "quantity_ptp" => $quantityToUse,
                    "building_structure_code_ptp" => $structureCode,
                    "execution_ptp" => $execution,
                    "unit_of_measurement_ptp" => $unitOfMeasurement,
                    "building_structure_detail_ptp" => $structureDetail
                );
                $this->_pointToPointToSave[] = $pointToPointRow;
            }
            //Let's remove the duplicated values
            $this->_buildingBudgetIdentifiers = array_unique($this->_buildingBudgetIdentifiers);
//            echo"<pre>";var_dump(array_unique($this->_buildingBudgetIdentifiers, $this->_buildingBudget));
//            exit;
        }
    }


    public function registerPointToPointInSystem()
    {
        $this->_insertPointToPointFileInTable();
        $this->_insertBuildingPoints();
        $this->_insertStructuresToUse();
        $this->_linkStructuresToPoints();
    }

    private function _insertPointToPointFileInTable()
    {
        Model_point_to_point_master::insertBatch($this->_pointToPointToSave);
    }

    private function _insertBuildingPoints()
    {
        Model_point_to_point_master::exportBuildingPoints($this->_projectId);
    }

    private function _insertStructuresToUse()
    {
        Model_point_to_point_master::exportStructuresToUse($this->_projectId);
    }

    private function _linkStructuresToPoints()
    {
        Model_point_to_point_master::linkStructuresToPoints($this->_projectId);   
    }
    /**
     * Use this method before registerManpowerInSystem method has been executed
     * @return mixed
     */
    public function registerPointToPointInSystem_deprecated_2()
    {
        $laborCostList = Model_labor_cost::getByProjectIdAndStructureCodeList($this->_projectId, $this->_buildingBudgetIdentifiers);
        $i = 0;
        foreach ($this->_pointList as $value)
        {
            $i++;
            $pointData = $value["pointData"];
            $structureList = $value["structureList"];
            $point = new Model_building_point($pointData["label"], $pointData["latitude"], $pointData["longitude"], $pointData["previous_point"]);
            $point->save();
            foreach ($structureList as &$structure)
            {
                $structureCode = $structure["structure_code"];
                $key = array_search($structureCode,array_column($laborCostList, "structure_code_bus"));
                $structure["labor_cost_id"] = $laborCostList[$key]["id_lac"];

            }
            $point->addStructuresToUse($structureList);
        }
        $response = "Se establecio ".$i." punto de construccion.";
        if($i>1)
        {
            $response = "Se establecieron ".$i." puntos de construccion.";
        }
        return $response;
    }

    /**
     * Use this method before registerManpowerInSystem method has been executed
     * @return mixed
     */
    public function registerPointToPointInSystem_deprecated()
    {
        $laborCostList = Model_labor_cost::getByProjectIdAndStructureCodeList($this->_projectId, $this->_buildingBudgetIdentifiers);
        $i = 0;
        foreach ($this->_pointList as $value)
        {
            $i++;
            $pointData = $value["pointData"];
            $structureList = $value["structureList"];
            $point = new Model_building_point($pointData["label"], $pointData["latitude"], $pointData["longitude"], $pointData["previous_point"]);
            $point->save();
            foreach ($structureList as &$structure)
            {
                $structureCode = $structure["structure_code"];
                $key = array_search($structureCode,array_column($laborCostList, "structure_code_bus"));
                $structure["labor_cost_id"] = $laborCostList[$key]["id_lac"];

            }
            $point->addStructuresToUse($structureList);
        }
        $response = "Se establecio ".$i." punto de construccion.";
        if($i>1)
        {
            $response = "Se establecieron ".$i." puntos de construccion.";
        }
        return $response;
    }
}
