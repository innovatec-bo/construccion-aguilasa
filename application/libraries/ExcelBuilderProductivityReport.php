<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
class ExcelBuilderProductivityReport
{
    private $_sessionUser;
    private $_builderId;
    private $_startDate;
    private $_endDate;
    private $_months;
	public function __construct($sessionUser, $builderId, $startDate, $endDate)
	{
        $this->_sessionUser = $sessionUser;
        $this->_builderId = $builderId;
        $this->_userBuilder = Model_user::getById($builderId);
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
	}

	function getReport()
	{
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';

        // $workflowDetail = Model_project::getWorkflowDetail();
        $projectProductivity = Model_project::getBuilderIndividualReport($this->_startDate, $this->_endDate);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Reporte de produccion de Constructores")
            ->setSubject("Reporte de constructores")
            ->setDescription("Reporte de production de constructores")
            ->setKeywords("reporte Constructor constructores")
            ->setCategory("Reporte");
        $worksheet1 = $spreadsheet->createSheet(0);
        $worksheet1->setTitle('Por Constructor');
        $worksheet2 = $spreadsheet->createSheet(1);
        $worksheet2->setTitle('En progreso');
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());

        $spreadsheet = $this->builder($spreadsheet, $projectProductivity);
        // $spreadsheet = $this->approves($spreadsheet, $workflowDetail);

        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="reporte_fiscales.xls"');
        header('Cache-Control: max-age=0');

        // $writer = new Xlsx($spreadsheet);
        // $writer->save('php://output');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
	}

	public function builder($spreadsheet, $projectProductivity)
    {
        $titleStyleArray = [
            'font' => ['bold' => true],
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
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', "INFORME DE PRODUCCION MENSUAL");
        $spreadsheet->getActiveSheet()->mergeCells('D5:H5');
        $spreadsheet->getActiveSheet()->getStyle('D5')->applyFromArray($titleStyleArray);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E7', "MES");
        $spreadsheet->getActiveSheet()->getStyle('E7')->getFont()->setBold(true);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F7', $this->_months[strtolower($month)]);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G7', $year);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E8', "GRUPO");
        $spreadsheet->getActiveSheet()->getStyle('E8')->getFont()->setBold(true);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F8', $this->_userBuilder->getFullName());
        $dataToPrint = $this->prepareDataToPrint($projectProductivity);
        
        //********AS ASSIGNED
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D10', "PRODUCCION CON PROYECTOS ASIGNADOS");
        $spreadsheet->getActiveSheet()->getStyle('D10')->applyFromArray($tableTitle);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('D11', "No")
            ->setCellValue('E11', "PROYECTO")
            ->setCellValue('F11', "UBICACION")
            ->setCellValue('G11', "DIAS EN OBRA")
            ->setCellValue('H11', "MONTO EJECUTADO BS");
        $spreadsheet->getActiveSheet()->getStyle('D11:H11')->applyFromArray($tableHeader);
        // echo"<pre>";var_dump($dataToPrint);exit;
        $totalExecutedAmount = 0;
        $i = 12;
        $rowCounter = 1;
        foreach ($dataToPrint['asAssigned'] as $row)
        {
            $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('D'.$i, $rowCounter)
                    ->setCellValue('E'.$i, $row["code"])
                    ->setCellValue('F'.$i, $row["address"])
                    ->setCellValue('G'.$i, $row["datesOnProject"])
                    ->setCellValue('H'.$i, $row["executedAmount"]);
                $totalExecutedAmount += $row["executedAmount"];
                $spreadsheet->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                $i++; 
                $rowCounter++;
        }
        $spreadsheet->getActiveSheet()->getStyle('D11:H'.($i-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('G'.$i, 'A) TOTAL')
            ->setCellValue('H'.$i, $totalExecutedAmount);
        $spreadsheet->getActiveSheet()->getStyle('G'.$i.':H'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Currency format
        $spreadsheet->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);

        //******ADDITIONAL ITEMS
        $j = $i +3;
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$j, "ITEMS ADICIONALES, NO CONTEMPLADOS EN PROYECTO ORIGINAL");
        $spreadsheet->getActiveSheet()->getStyle('D'.$j)->applyFromArray($tableTitle);
        $j++;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('D'.$j, "No")
            ->setCellValue('E'.$j, "PROYECTO")
            ->setCellValue('F'.$j, "ESTRUCTURA")
            ->setCellValue('G'.$j, "CANTIDAD")
            ->setCellValue('H'.$j, "MONTO BS");
        $spreadsheet->getActiveSheet()->getStyle('D'.$j.':H'.$j)->applyFromArray($tableHeader);
        $spreadsheet->getActiveSheet()->getStyle('D'.$j.':H'.($j+2))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('G'.($j+3), 'B) TOTAL')
            ->setCellValue('H'.($j+3), "");
        $spreadsheet->getActiveSheet()->getStyle('G'.($j+3).':H'.($j+3))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //**** AS SUPPORT 
        $k = $j+6;       
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$k, "PROYECTOS COMO APOYO");
        $spreadsheet->getActiveSheet()->getStyle('D'.$k)->applyFromArray($tableTitle);
        $k++;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('D'.$k, "No")
            ->setCellValue('E'.$k, "PROYECTO")
            ->setCellValue('F'.$k, "UBICACION")
            ->setCellValue('G'.$k, "DIAS EN OBRA")
            ->setCellValue('H'.$k, "MONTO EJECUTADO BS");
        $spreadsheet->getActiveSheet()->getStyle('D'.$k.':H'.$k)->applyFromArray($tableHeader);
        // echo"<pre>";var_dump($dataToPrint);exit;
        $totalExecutedAmount = 0;
        $k++;
        $rowCounter = 1;
        foreach ($dataToPrint['asSupport'] as $row)
        {
            $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('D'.$k, $rowCounter)
                    ->setCellValue('E'.$k, $row["code"])
                    ->setCellValue('F'.$k, $row["address"])
                    ->setCellValue('G'.$k, $row["datesOnProject"])
                    ->setCellValue('H'.$k, $row["executedAmount"]);
                $totalExecutedAmount += $row["executedAmount"];
                $spreadsheet->getActiveSheet()->getStyle('H'.$k)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                $k++; 
                $rowCounter++;
        }
        
        $spreadsheet->getActiveSheet()->getStyle('D'.(($k-1)-(count($dataToPrint['asSupport']))).':H'.($k-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('G'.$k, 'A) TOTAL')
            ->setCellValue('H'.$k, $totalExecutedAmount);
        $spreadsheet->getActiveSheet()->getStyle('G'.$k.':H'.$k)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Currency format
        $spreadsheet->getActiveSheet()->getStyle('H'.($k))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(4);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);

        return $spreadsheet;
    }

    public function approves($spreadsheet, $workflowDetail)
    {
        $titleStyleArray = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'BFBFBF']
            ]
        ];

        $i = 12;
        $borderCoordinate1 = $borderCoordinate2 = '';
        
        foreach ($workflowDetail as $row)
        {
            
            // $isBetweenDates = $this->isInGivenRange($row["in_progress_date"]);
            // if($isBetweenDates && $row["in_progress_date"] != "")
            // {

                
            // }
        }
        

        
        // $spreadsheet->getActiveSheet()->getStyle('B3:G3')->getAlignment()->setWrapText(true);
        // $spreadsheet->getActiveSheet()->getStyle($borderCoordinate1.':'.$borderCoordinate2)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        // $spreadsheet->setActiveSheetIndex(0);
        return $spreadsheet;
    }

    // Function to get all the dates in given range
    public function isInGivenRange($date)
    {
        $date = new DateTime($date);
        $startDate = new DateTime($this->_startDate);
        $endDate = new DateTime($this->_endDate);
        return $date > $startDate && $date < $endDate;
    }

    public function findPartners($currentStaker, $stakerList)
    {
        $stakerArray = explode(",",$stakerList);
        $currentStakerPosition = array_search($currentStaker, $stakerArray);
        $partnerList = "";
        if($currentStakerPosition !== FALSE)
        {
            unset($stakerArray[$currentStakerPosition]);
            $partnerList = implode(",",$stakerArray);
        }

        return $partnerList;
    }

    public function prepareDataToPrint($projectProductivity)
    {
        $arrayPerformanceList = array();
        $asAssigned = array();
        $asSupport  = array();
        foreach ($projectProductivity as $row) 
        {
            $allBulders = $row['allBuilders'];
            //let see if the builder has worked in this project
            if(isset($allBulders[$this->_builderId]))
            {
                $builder = $allBulders[$this->_builderId];
                //if the builder is present then let's verify is this is the assigned builder
                if($row["builderIdAssigned"] == $this->_builderId)
                {
                    $asAssigned[] = array(
                        "id"=> $row['id'],
                        "code" => $row['code'],
                        "address" => "",
                        "datesOnProject" => count($builder['totalDatesInProject']),
                        "executedAmount" => $builder['totalWorked']
                    );
                }
                else
                {
                    $asSupport[] = array(
                        "id"=> $row['id'],
                        "code" => $row['code'],
                        "address" => "",
                        "datesOnProject" => count($builder['totalDatesInProject']),
                        "executedAmount" => $builder['totalWorkedAsSupport']
                    );
                }
                
            }
        }
        $productivity['asAssigned'] = $asAssigned;
        $productivity['asSupport'] = $asSupport;
        return $productivity;
    }
}