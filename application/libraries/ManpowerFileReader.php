<?php
require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ManpowerFileReader
{
    private $_file;
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

    public function __construct(Model_file $file)
	{
	    $this->_file = $file;
        $this->_designBudgetIdentifiers = array('ERU', 'ERU_B');
        $this->_buildingBudgetIdentifiers = array();
        $this->_transportationBudgetIdentifiers = array('CTPH-M');
        $this->_liveLineBudgetIdentifiers = array('lv');
        $this->_rightOfWayBudgetIdentifiers = array();
        $this->_designBudget = 0;
        $this->_buildingBudget = 0;
        $this->_transportationBudget = 0;
        $this->_liveLineBudget = 0;
        $this->_rightOfWayBudget = 0;
        $this->_graphNumber = '';
	}

	public function saveStaticData()
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
        $arrayData = $sheetData->toArray();
        $startReadingData = FALSE;
        $structureList = array();

        $i = 0;
        foreach($arrayData as $index => $data)
        {
            //Setting approved budgets
            if($data[0] == 'ITEM')
            {
                $startReadingData = TRUE;
                continue;
            }
            $structureList[trim($data[2])]['count'] = 0;
            if($startReadingData)
            {
                $structureList[trim($data[2])]['count'] ++;
                $structureList[trim($data[2])]['list'][] = array(trim($data[2]), trim($data[1]));
            }
            $i++;
        }
        echo"<pre>";var_dump($structureList);exit;
    }

    public function setBudgetsFromExcelFile()
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
        $arrayData = $sheetData->toArray();
        $startReadingData = FALSE;

        foreach($arrayData as $index => $data)
        {
            //Setting Graph number
            if(strpos(strtolower($data[0]),'grafo') !== FALSE)
            {
                $haystack = array_values(array_filter(explode(" ",$data[0])));
                foreach ($haystack as $index => $value)
                {
                    if (preg_match('/.*grafo.*/i', strtolower($value)))
                    {
                        $this->_graphNumber = trim($haystack[$index+1]);
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
}