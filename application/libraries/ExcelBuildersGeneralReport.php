<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
class ExcelBuildersGeneralReport
{
    private $_sessionUser;
    private $_startDate;
    private $_endDate;
    private $_months;
    private $_fiscalList;
    private $_builderList;
	public function __construct($sessionUser, $startDate, $endDate)
	{
        $this->_sessionUser = $sessionUser;
        $this->_startDate = $startDate;
        $this->_endDate = $endDate;
        $this->_months = array(
                            "january" => "Enero",
                            "february" => "Febrero",
                            "march" => "Marzo",
                            "april" => "Abril",
                            "may" => "Mayo",
                            "june" => "Junio",
                            "july" => "Julio",
                            "august" => "Agosto",
                            "september" => "Septiembre",
                            "october" => "Octubre",
                            "november" => "Noviembre",
                            "december" => "Diciembre"
                        );
        $this->_fiscalList = Model_user::getByRoleKeyword('fiscal');
        $this->_builderList = Model_user::getByRoleKeyword('builder');
	}

	function getReport()
	{
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';

        $projectProductivity = Model_project::getBuilderIndividualReport($this->_startDate, $this->_endDate);
        $date = date_create_from_format('Y-m-d', $this->_startDate);
        $month = date_format($date, 'F');
        $month = $this->_months[strtolower($month)];
        $year = date_format($date, 'Y');
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Reporte general de constructores")
            ->setSubject("Reporte general de constructores")
            ->setDescription("Reporte detallado acerca de cada constructor segun el mes seleccionado")
            ->setKeywords("reporte general constructor constructores")
            ->setCategory("Reporte");
        $worksheet1 = $spreadsheet->createSheet(0);
        $worksheet1->setTitle('Resumen');
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());

        $spreadsheet = $this->_buildersGeneralReport($spreadsheet, $projectProductivity);

        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Reporte general de constructores - '.$month.' del '.$year.'.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
	}

	private function _buildersGeneralReport($spreadsheet, $projectProductivity)
    {
        $titleStyleArray = [
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $tableTitle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $tableHeader = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        
        
        //HEADER
        $date = date_create_from_format('Y-m-d', $this->_startDate);
        $month = date_format($date, 'F');
        $year = date_format($date, 'Y');
        
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D2', "RESUMEN DE PRODUCCION MES DE ".$this->_months[strtolower($month)]." ".$year."  - CONSTRUCCION DE REDES");
        $spreadsheet->getActiveSheet()->mergeCells('D2:M2');
        $spreadsheet->getActiveSheet()->getStyle('D2')->applyFromArray($titleStyleArray);
        
        $dataToPrint = $this->_prepareDataToPrint($projectProductivity);
        
        //******** MONTH PRODUCTION
        // $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', "INFORME DE PRODUCCION MENSUAL");
        // $spreadsheet->getActiveSheet()->getStyle('D10')->applyFromArray($tableTitle);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B4', "No")
            ->setCellValue('D4', "GRUPO")
            ->setCellValue('I4', "PRODUCCION MES");
        $spreadsheet->getActiveSheet()->mergeCells('D4:F4');
        $spreadsheet->getActiveSheet()->mergeCells('I4:M4');
        $spreadsheet->getActiveSheet()->getStyle('D4:I4')->applyFromArray($tableHeader);
        // echo"<pre>";var_dump($dataToPrint);exit;
        $totalExecutedAmount = 0;
        $i = 6;
        $rowCounter = 1;
        foreach ($dataToPrint['buildersAndProductivity'] as $row)
        {
            $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('B'.$i, $rowCounter)
                    ->setCellValue('D'.$i, $row["builderFullName"])
                    ->setCellValue('I'.$i, $row["production"]);
            $spreadsheet->getActiveSheet()->mergeCells('D'.$i.':F'.$i);
            $spreadsheet->getActiveSheet()->mergeCells('I'.$i.':M'.$i);
            $spreadsheet->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
            $i++;
            $i++; 
            $rowCounter++;
        }
        // $spreadsheet->getActiveSheet()->getStyle('D11:H'.($i-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('K'.$i, 'TOTAL Bs.')
            ->setCellValue('M'.$i, '=SUM(I'.(($i-1)-(count($dataToPrint['buildersAndProductivity'])*2)).':I'.($i-1).')');
        // $spreadsheet->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);
        // $spreadsheet->getActiveSheet()->getStyle('G'.$i.':H'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Currency format
        // $spreadsheet->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);

        //**** AS SUPPORT 
        $j = $i+2;       
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$j, "REPORTE GENERAL - CONSTRUCCION");
        // $spreadsheet->getActiveSheet()->getStyle('D'.$j)->applyFromArray($tableTitle);
        $j++;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('D'.$j, "FISCAL")
            ->setCellValue('I'.$j, "ENCARGADO")
            ->setCellValue('K'.$j, "CONCILIADO CON SEREBO");
        // $spreadsheet->getActiveSheet()->getStyle('D'.$k.':H'.$k)->applyFromArray($tableHeader);
        // $totalExecutedAmount = 0;
        $j++;
        foreach ($dataToPrint['fiscalsAndBuildersProductivity'] as $row)
        {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('D'.$j, $row["fiscalFullName"]);
            // $spreadsheet->getActiveSheet()->getStyle('H'.$k)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
            $k=$j;
            foreach ($row['builders'] as $data) 
            {
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('I'.$k, $data["builderFullName"])
                ->setCellValue('K'.$k, $data["production"]);
                $k++;
                $j++;
            }
            // $j=$j+$k; 
        }
        
        // $spreadsheet->getActiveSheet()->getStyle('D'.(($k-1)-(count($dataToPrint['asSupport']))).':H'.($k-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        // $totalAsSupport = "H".($k);
        // $spreadsheet->setActiveSheetIndex(0)
        //     ->setCellValue('G'.$k, 'B) TOTAL')
        //     ->setCellValue('H'.$k, '=SUM(H'.(($k-1)-(count($dataToPrint['asSupport']))).':H'.($k-1).')');
        // $spreadsheet->getActiveSheet()->getStyle('G'.$k)->getFont()->setBold(true);
        // $spreadsheet->getActiveSheet()->getStyle('G'.$k.':H'.$k)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Currency format
        // $spreadsheet->getActiveSheet()->getStyle('H'.($k))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);


        // $spreadsheet->setActiveSheetIndex(0)
        //     ->setCellValue('D'.($k+2), '(A + B) TOTAL EJECUTADO EN PERIODO BS.:')
        //     ->setCellValue('H'.($k+2), '=SUM('.$totalAssigned.','.$totalAdditional.','.$totalAsSupport.')');
        //     $spreadsheet->getActiveSheet()->getStyle('H'.($k+2))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
            // ->setCellValue('H'.($k+2), '=SUM(H13,H20,H25)');
        // $spreadsheet->getActiveSheet()->mergeCells('D'.($k+2).':G'.($k+2));
        // $spreadsheet->getActiveSheet()->getStyle('D'.($k+2).':H'.($k+2))->getFont()->setBold(true);
        // $spreadsheet->getActiveSheet()->getStyle('D'.($k+2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        // $spreadsheet->getActiveSheet()->getStyle('D'.($k+2).':H'.($k+2))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(1.8);
        // $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(4);
        // $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(1.8);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(2);
        // $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(1.8);
        // $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(3.93);

        // $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(12);
        // $spreadsheet->getActiveSheet()->getRowDimension('6')->setRowHeight(25);
        // $spreadsheet->getActiveSheet()->getRowDimension(($k+4))->setRowHeight(12);

        return $spreadsheet;
    }

    public function _prepareDataToPrint($projectProductivity)
    {
        $arrayPerformanceList = array();
        $buildersAndProductivity = array();
        $fiscalsAndBuildersProductivity = array();
        // echo"<pre>";var_dump($projectProductivity);exit;
        foreach ($projectProductivity as $row) 
        {
            $fiscalAssignedId = $row['fiscalIdAssigned'];
            foreach ($row['allBuilders'] as $key => $builder) 
            {
                //Group by builder
                $builderObject = $this->_builderList[$key];
                $generalProduction = floatval($builder['totalWorkedAsSupport']) + floatval($builder['totalWorked']);
                if(!isset($buildersAndProductivity[$key]))
                {
                    $buildersAndProductivity[$key] = array(
                                    "builderId"=> $builderObject->getId(),
                                    "builderFullName" => $builderObject->getFullName(),
                                    "production" => 0
                                );
                }
                $buildersAndProductivity[$key]["production"] += $generalProduction;

                //Group by fiscal and builder
                $fiscalObject = $this->_fiscalList[$fiscalAssignedId];
                if(!isset($fiscalsAndBuildersProductivity[$fiscalAssignedId]['builders'][$key]))
                {
                    $fiscalsAndBuildersProductivity[$fiscalAssignedId]['fiscalId'] = $fiscalObject->getId();
                    $fiscalsAndBuildersProductivity[$fiscalAssignedId]['fiscalFullName'] = $fiscalObject->getFullName();
                    $fiscalsAndBuildersProductivity[$fiscalAssignedId]['builders'][$key]['builderId'] = $builderObject->getId();
                    $fiscalsAndBuildersProductivity[$fiscalAssignedId]['builders'][$key]['builderFullName'] = $builderObject->getFullName();
                    $fiscalsAndBuildersProductivity[$fiscalAssignedId]['builders'][$key]['production'] = 0;
                }
                $fiscalsAndBuildersProductivity[$fiscalAssignedId]['builders'][$key]['production'] += $generalProduction;
            }
            

        }
        // echo"<pre>";var_dump($buildersAndProductivity);exit;
        $arrayPerformanceList['buildersAndProductivity'] = $buildersAndProductivity;
        $arrayPerformanceList['fiscalsAndBuildersProductivity'] = $fiscalsAndBuildersProductivity;
        return $arrayPerformanceList;
    }
}