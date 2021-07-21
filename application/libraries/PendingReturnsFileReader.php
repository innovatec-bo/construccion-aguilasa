<?php
require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

class PendingReturnsFileReader
{
    private Model_file $_file;
    private array $_excelArrayData;

    public function __construct(Model_file $file)
	{
        $this->_file = $file;
        $this->_setExcelArrayData();
        //$this->_setDataFromExcelFile();
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
                break;
        }
		//$reader->setInputEncoding('ISO-8859-1');
        $fileLocation = FCPATH.$this->_file->getUrl();
        $spreadsheet = $reader->load($fileLocation);
        $sheetList = $spreadsheet->getAllSheets();
        $sheetData = $sheetList[0];
        $this->_excelArrayData = $sheetData->toArray();
    }

	public function previewPendingSummary()
    {
        $i = 0;
        $list = [];
        foreach($this->_excelArrayData as $index => $data)
        {
            $project = explode('.',trim($data[10]));
            array_pop($project);
            $project = implode('.',$project);
            $code = trim($data[3]);
            $detail = trim($data[4]);
            $nec = trim($data[5]);
            $dif = trim($data[6]);
            $lote = trim($data[7]);
            $umb = trim($data[8]);
            $tension = explode('.',trim($data[10]));
            $tension = end($tension);
            if($i > 0 && $project != "")
            {
                $list[$project]['project'] = $project;
                if(!isset($list[$project]['materials']))
                    $list[$project]['materials'] = [];
                
                $list[$project]['materials'][$code.'-'.$lote.'-'.$tension] = [
                                                                                'code' => $code, 
                                                                                'detail' => $detail,
                                                                                'nec' => $nec,
                                                                                'dif' => $dif,
                                                                                'lote' => $lote,
                                                                                'umb' => $umb,
                                                                                'tension' => $tension
                                                                            ];
            }
            $i++;
        }
        foreach($list as &$row)
        {
            $row['materials'] = array_values($row['materials']);
        }
        return $list;
    }

    public function createPendingSummary()
    {
        $i = 0;
        $list = [];
        
        $materialCodes = $this->_getArrayMaterialCodes();
        $materials = Model_material::getByCodeList($materialCodes);
        dd($materials, $materialCodes);
        foreach($this->_excelArrayData as $index => $data)
        {
            $project = explode('.',trim($data[10]));
            array_pop($project);
            $project = implode('.',$project);
            $code = trim($data[3]);
            $detail = trim($data[4]);
            $nec = trim($data[5]);
            $dif = trim($data[6]);
            $lote = trim($data[7]);
            $umb = trim($data[8]);
            $tension = explode('.',trim($data[10]));
            $tension = end($tension);
            if($i > 0 && $project != "")
            {
                $list[$project]['project'] = $project;
                if(!isset($list[$project]['materials']))
                    $list[$project]['materials'] = [];
                
                $list[$project]['materials'][$code.'-'.$lote.'-'.$tension] = [
                                                                                'code' => $code, 
                                                                                'detail' => $detail,
                                                                                'nec' => $nec,
                                                                                'dif' => $dif,
                                                                                'lote' => $lote,
                                                                                'umb' => $umb,
                                                                                'tension' => $tension
                                                                            ];
            }
            $i++;
        }
        foreach($list as &$row)
        {
            $row['materials'] = array_values($row['materials']);
        }
        return $list;
    }
    
    private function _getArrayMaterialCodes()
    {
        $materialCodes = array_column($this->_excelArrayData, 3);// 3 => material column
        $materialCodes = array_unique($materialCodes);
        //Removing nulls and column title
        if (($key = array_search('Material', $materialCodes)) !== false) {
            unset($materialCodes[$key]);
        }
        if (($key = array_search(null, $materialCodes)) !== false) {
            unset($materialCodes[$key]);
        }
        $materialCodes = array_values($materialCodes);
        $materialCodes = array_map(function($value) {
            return intval($value);
        }, $materialCodes);

        return $materialCodes;   
    }
}
