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
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());

        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Networks building report")
            ->setSubject("Networks building report")
            ->setDescription("This report allow see the networks building detailed by year and month. Report generated on ".date("Y-m-d H:i:s"))
            ->setKeywords("report networks building projects month year")
            ->setCategory("Report");


        $this->_headerColumn($spreadsheet);

        //begin - Adding total column
        $data = Model_project::getStatusQuantityDetailByYear($this->_mainList, $this->_year, "countId", $this->_mainList);
        if(count($data) >= 1)
        {
            $data = $this->_array_unshift_assoc($data[0], 'criteria', "TOTALES");
        }
        else
        {
            $data[0] = array('january' => 0, 'february' => 0, 'march' => 0, 'april' => 0, 'may' => 0, 'june' => 0, 'july' => 0, 'august' => 0, 'september' => 0, 'october' => 0, 'november' => 0, 'december' => 0);
            $data = $this->_array_unshift_assoc($data[0], 'criteria', "TOTALES");
        }
        $data = $this->_array_unshift_assoc($data, 'rowKey', "countId");
        $data['total'] = $data['january'] + $data['february'] + $data['march'] + $data['april'] + $data['may'] + $data['june'] + $data['july'] + $data['august'] + $data['september'] + $data['october'] + $data['november'] + $data['december'];
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B2', $data["criteria"])
            ->setCellValue('C2', $data["january"])
            ->setCellValue('D2', $data["february"])
            ->setCellValue('E2', $data["march"])
            ->setCellValue('F2', $data["april"])
            ->setCellValue('G2', $data["may"])
            ->setCellValue('H2', $data["june"])
            ->setCellValue('I2', $data["july"])
            ->setCellValue('J2', $data["august"])
            ->setCellValue('K2', $data["september"])
            ->setCellValue('L2', $data["october"])
            ->setCellValue('M2', $data["november"])
            ->setCellValue('N2', $data["december"])
            ->setCellValue('O2', $data["total"]);
        $this->_highlightRow($spreadsheet,2, $data["rowKey"]);
        //end - adding total column
        $i = 2;
        $totalRow = $data;
        $subArray = array();
        foreach($this->_reportSections as $keyword => $columnTypeList)
        {
            $totalColumnsType = count($columnTypeList);
            foreach ($columnTypeList as $rowKey => $criteria)
            {
                if($rowKey == "countWithoutBudgets" || $rowKey == "countWithoutRealBudgets" || $rowKey == "countWithoutDigitizationPoints" || $rowKey == "countWithoutAsBuiltPoints")
                {
                    $dataDiff = $this->_getDiff($totalRow, $subArray, $criteria, $rowKey);
//                    $dataDiff = $this->_formatNumbers($dataDiff);
                    $data = $dataDiff;
                }
                else
                {
                    $data = Model_project::getStatusQuantityDetailByYear($keyword, $this->_year, $rowKey, $this->_mainList);
                    if(count($data) >= 1)
                    {
                        $data = $this->_array_unshift_assoc($data[0], 'criteria', $criteria);
                        $data = $this->_array_unshift_assoc($data, 'rowKey', $rowKey);
                    }
                    else
                    {
                        $data[0] = array('january' => 0, 'february' => 0, 'march' => 0, 'april' => 0, 'may' => 0, 'june' => 0, 'july' => 0, 'august' => 0, 'september' => 0, 'october' => 0, 'november' => 0, 'december' => 0);
                        $data = $this->_array_unshift_assoc($data[0], 'criteria', $criteria);
                        $data = $this->_array_unshift_assoc($data, 'rowKey', $rowKey);
                    }
                }

                $data['total'] = $data['january'] + $data['february'] + $data['march'] + $data['april'] + $data['may'] + $data['june'] + $data['july'] + $data['august'] + $data['september'] + $data['october'] + $data['november'] + $data['december'];
                $subArray = $data;
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
                $this->_highlightRow($spreadsheet,$i+1, $data["rowKey"]);
                $i++;
            }
            $groupRow = $this->_groupRows($keyword);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.($i+1-$totalColumnsType), $groupRow);
            if($keyword == "approved" || $keyword == "conciliation_shipment")
                $spreadsheet->getActiveSheet()->getStyle('A'.($i+1-$totalColumnsType))->getAlignment()->setTextRotation(45);
            $spreadsheet->getActiveSheet()->mergeCells('A'.($i+1-$totalColumnsType).':A'.($i));
        }
        $this->_adjustColumnToText($spreadsheet);
        $this->_leftColumn($spreadsheet, $i);
        $this->_currencyFormatNumber($spreadsheet, $i);

        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="networks_building_report.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
	}

    private function _headerColumn($spreadsheet)
    {
        $titleStyleArray = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', $this->_year)
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
        $spreadsheet->getActiveSheet()->getStyle('A1:O1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->mergeCells('A1:B1');
        $spreadsheet->getActiveSheet()->mergeCells('A1:B1');
    }

    private function _leftColumn($spreadsheet, $totalRows)
    {
        $titleStyleArray = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $spreadsheet->getActiveSheet()->getStyle('A3:A'.$totalRows)->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->getStyle('A3:B'.$totalRows)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }
    private function _groupRows($key)
    {
        $groupRowsArray = array(
                                "project_has_been_created" => "INGRESO",
                                "digitization" => "ESTACADO",
                                "as_built" => "CONSTRUIDO",
                                "approved" => "IMPORTE ORIGINAL",
                                "conciliation_shipment" => "IMPORTE REAL"
                                );
        return $groupRowsArray[$key];
    }

	private function _setReportSections()
    {
        $this->_reportSections = array(
            'project_has_been_created' => array(
                'entryPoints' => 'PUNTOS',
                'entryDistance' => 'DISTANCIA'
            ),
            'digitization' => array(
                'countDigitizationPoints' => 'PROYECTOS CON ESTACADO',
                'countWithoutDigitizationPoints' => 'PROYECTOS SIN ESTACADO',
                'digitizationPoints' => 'PUNTOS',
                'digitizationDistance' => 'DISTANCIA'
            ),
            'as_built' => array(
                'countAsBuiltPoints' => 'PROYECTOS CON AREA CONSTRUIDA',
                'countWithoutAsBuiltPoints' => 'PROYECTOS SIN AREA CONSTRUIDA',
                'asBuiltPoints' => 'PUNTOS',
                'asBuiltDistance' => 'DISTANCIA'
            ),
            'approved' => array(
                'countBudgets' => 'PROYECTOS CON IMPORTE',
                'countWithoutBudgets' => 'PROYECTOS SIN IMPORTE',
                'sumDesignBudget' => 'IMPORTE DISEÑO',
                'sumBuildingBudget' => 'IMPORTE CONSTRUCCION',
                'sumTransportationBudget' => 'IMPORTE TRANSPORTE',
                'sumLiveLineBudget' => 'IMPORTE LINEA VIVA',
                'sumRightOfWayBudget' => 'IMPORTE DERECHO DE VIA',
                'sumBudget' => 'TOTAL IMPORTE'
            ),
            'conciliation_shipment' => array(
                'countRealBudgets' => 'PROYECTOS CON IMPORTE REAL',
                'countWithoutRealBudgets' => 'PROYECTOS SIN IMPORTE REAL',
                'sumDesignRealBudget' => 'IMPORTE REAL - DISEÑO',
                'sumBuildingRealBudget' => 'IMPORTE REAL - CONSTRUCCION',
                'sumTransportationRealBudget' => 'IMPORTE REAL - TRANSPORTE',
                'sumLiveLineRealBudget' => 'IMPORTE REAL - LINEA VIVA',
                'sumRightOfWayRealBudget' => 'IMPORTE REAL - DERECHO DE VIA',
                'sumRealBudget' => 'TOTAL IMPORTE REAL'
            )
        );
    }

    private function _adjustColumnToText($spreadsheet)
    {
        $columnsToAdjust = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O");
        foreach ($columnsToAdjust as $key => $column)
        {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }
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

    private function _getDiff($rowTotal, $subArray, $criteria, $rowKey)
    {
        $monthList = array("january","february","march","april","may","june","july","august","september","october","november","december","total");
        $diffArray = array();
        foreach ($monthList as $month)
        {

            $diffArray[$month] = $rowTotal[$month] - $subArray[$month];
        }
        $diffArray = $this->_array_unshift_assoc($diffArray, 'criteria', $criteria);
        $diffArray = $this->_array_unshift_assoc($diffArray, 'rowKey', $rowKey);
        return $diffArray;
    }

    private function _highlightRow($spreadsheet, $currentRow, $keyword)
    {
//        var_dump($currentRow, $keyword);exit;
        $colors = array(
            "88B2E4" => array("countId"),
            "F9FF00" => array("entryPoints", "entryDistance", "digitizationPoints", "digitizationDistance", "asBuiltPoints", "asBuiltDistance"),
            "DBE6F2" => array("countWithoutDigitizationPoints", "countWithoutAsBuiltPoints", "countWithoutBudgets", "countWithoutRealBudgets"),
            "E9F3DE" => array("sumDesignBudget", "sumBuildingBudget", "sumTransportationBudget", "sumLiveLineBudget", "sumRightOfWayBudget", "sumDesignRealBudget", "sumBuildingRealBudget", "sumTransportationRealBudget", "sumLiveLineRealBudget", "sumRightOfWayRealBudget"),
            "79DA4C" => array("sumBudget", "sumRealBudget")
        );

        foreach ($colors as $color => $statusList)
        {
            if(array_search($keyword, $statusList) !== FALSE)
            {
                $spreadsheet->getActiveSheet()->getStyle('B'.$currentRow.':O'.$currentRow)
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $spreadsheet->getActiveSheet()->getStyle('B'.$currentRow.':O'.$currentRow)
                    ->getFill()->getStartColor()->setARGB($color);
            }
        }
    }
}