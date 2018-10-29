<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ExcelNetworksBuilding
{
    private $_sessionUser;
    private $_reportSections;
    private $_mainList;
    private $_year;

	public function __construct($sessionUser, $mainList, $year)
	{
        $this->_sessionUser = $sessionUser;
        $this->_mainList = $mainList;
        $this->_year = $year;
        $this->_setReportSections();
	}

	function getReport()
	{
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Networks building report")
            ->setSubject("Networks building report")
            ->setDescription("This report allow see the networks building detailed by year and month. Report generated on ".date("Y-m-d H:i:s"))
            ->setKeywords("report networks building projects month year")
            ->setCategory("Report");

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', "2018");
        $spreadsheet->getActiveSheet()->mergeCells('A1:B1');
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('C1', "ENERO")
            ->setCellValue('D1', "FEBRERO")
            ->setCellValue('E1', "MARZO")
            ->setCellValue('F1', "ABRIL")
            ->setCellValue('G1', "MAYO")
            ->setCellValue('H1', "JUNIO")
            ->setCellValue('I1', "JULIO")
            ->setCellValue('J1', "AGOSTO")
            ->setCellValue('K1', "SEPTIEMBRE")
            ->setCellValue('L1', "OCTUBRE")
            ->setCellValue('M1', "NOVIEMBRE")
            ->setCellValue('N1', "DICIEMBRE")
            ->setCellValue('O1', "TOTAL");

//        $projectTotalsList = array();
        $i = 1;
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());
        foreach($this->_reportSections as $keyword => $columnTypeList)
        {
            foreach ($columnTypeList as $rowKey => $criteria)
            {
                $data = Model_project::getStatusQuantityDetailByYear($keyword, $year, $rowKey, $mainList);
                if(count($data) >= 1)
                {
                    $data = $this->_array_unshift_assoc($data[0], 'criteria', $criteria);
                    $data = $this->_array_unshift_assoc($data, 'rowKey', $rowKey);
                }
                else
                {
                    $data[0] = array('january' => 0, 'february' => 0, 'march' => 0, 'april' => 0, 'may' => 0, 'june' => 0, 'july' => 0, 'august' => 0, 'september' => 0, 'october' => 0, 'november' => 0, 'december' => 0);
                    $data = $this->_array_unshift_assoc($data[0], 'criteria', $criteria);
                }
                $data['total'] = $data['january'] + $data['february'] + $data['march'] + $data['april'] + $data['may'] + $data['june'] + $data['july'] + $data['august'] + $data['september'] + $data['october'] + $data['november'] + $data['december'];
//                $projectTotalsList[] = $data;
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('B'.($i+1), $data["criteria"])
                    ->setCellValue('C'.($i+1), $data["january"])
                    ->setCellValue('D'.($i+1), $data["february"])
                    ->setCellValue('E'.($i+1), $data["march"])
                    ->setCellValue('F'.($i+1), $data["april"])
                    ->setCellValue('G'.($i+1), $data["may"])
                    ->setCellValue('H'.($i+1), $data["june"])
                    ->setCellValue('I'.($i+1), $data["july"])
                    ->setCellValue('J'.($i+1), $data["august"])
                    ->setCellValue('K'.($i+1), $data["september"])
                    ->setCellValue('L'.($i+1), $data["october"])
                    ->setCellValue('M'.($i+1), $data["november"])
                    ->setCellValue('N'.($i+1), $data["december"])
                    ->setCellValue('O'.($i+1), $data["total"]);
                $i++;
            }
        }

        $this->_currencyFormatNumber($spreadsheet, $i);
//        foreach ($asBuiltProjectsByYearAndMonth as $row)
//        {
//            $spreadsheet->setActiveSheetIndex(0)
//                ->setCellValue('B'.($i+1), $row["year"])
//                ->setCellValue('C'.($i+1), $row["january"])
//                ->setCellValue('D'.($i+1), $row["february"])
//                ->setCellValue('E'.($i+1), $row["march"])
//                ->setCellValue('F'.($i+1), $row["april"])
//                ->setCellValue('G'.($i+1), $row["may"])
//                ->setCellValue('H'.($i+1), $row["june"])
//                ->setCellValue('I'.($i+1), $row["july"])
//                ->setCellValue('J'.($i+1), $row["august"])
//                ->setCellValue('K'.($i+1), $row["september"])
//                ->setCellValue('L'.($i+1), $row["october"])
//                ->setCellValue('M'.($i+1), $row["november"])
//                ->setCellValue('N'.($i+1), $row["december"])
//                ->setCellValue('O'.($i+1), $row["total"]);
//            $i++;
//        }
        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="networks_building_report.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
	}

	private function _setReportSections()
    {
        $this->_reportSections = array(
            'project_has_been_created' => array(
                'entryPoints' => 'INGRESO - PUNTOS',
                'entryDistance' => 'INGRESO - DISTANCIA'
            ),
            'already_sent' => array(
                'digitizationPoints' => 'ESTACADO - PUNTOS',
                'digitizationDistance' => 'ESTACADO - DISTANCIA'
            ),
            'as_built' => array(
                'digitizationPoints' => 'CONSTRUIDO - PUNTOS',
                'digitizationDistance' => 'CONSTRUIDO - DISTANCIA'
            ),
            'approved' => array(
                'sumDesignBudget' => 'IMPORTE DISEÑO',
                'sumBuildingBudget' => 'IMPORTE CONSTRUCCION',
                'sumTransportationBudget' => 'IMPORTE TRANSPORTE',
                'sumLiveLineBudget' => 'IMPORTE LINEA VIVA',
                'sumRightOfWayBudget' => 'IMPORTE DERECHO DE VIA',
                'sumBudget' => 'TOTAL IMPORTE'
            ),
            'conciliation_shipment' => array(
                'sumDesignRealBudget' => 'IMPORTE REAL - DISEÑO',
                'sumBuildingRealBudget' => 'IMPORTE REAL - CONSTRUCCION',
                'sumTransportationRealBudget' => 'IMPORTE REAL - TRANSPORTE',
                'sumLiveLineRealBudget' => 'IMPORTE REAL - LINEA VIVA',
                'sumRightOfWayRealBudget' => 'IMPORTE REAL - DERECHO DE VIA',
                'sumRealBudget' => 'TOTAL IMPORTE REAL'
            )
        );
    }

    private function _array_unshift_assoc(&$arr, $key, $val)
    {
        $arr = array_reverse($arr, true);
        $arr[$key] = $val;
        $arr = array_reverse($arr, true);
        return $arr;
    }

    private function _currencyFormatNumber($spreadsheet, $totalRows)
    {
        $columnList = array("C","D","E","F","G","H","I","J","K","L","M","N","O");

        foreach($columnList as $key => $column)
        {
            $spreadsheet->getActiveSheet()->getStyle($column.'2:'.$column.$totalRows)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        }

    }
}