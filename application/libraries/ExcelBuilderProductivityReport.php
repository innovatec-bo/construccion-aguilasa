<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
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

        $projectProductivity = Model_project::getBuilderIndividualReport($this->_startDate, $this->_endDate);
        $date = date_create_from_format('Y-m-d', $this->_startDate);
        $month = date_format($date, 'F');
        $month = $this->_months[strtolower($month)];
        $year = date_format($date, 'Y');
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Reporte de produccion de ".$this->_userBuilder->getFullName()." - ".$month." del ".$year)
            ->setSubject("Reporte de constructores")
            ->setDescription("Reporte de production de constructores")
            ->setKeywords("reporte Constructor constructores")
            ->setCategory("Reporte");
        $worksheet1 = $spreadsheet->createSheet(0);
        $worksheet1->setTitle('Resumen');
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());

        $spreadsheet = $this->builder($spreadsheet, $projectProductivity);

        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$this->_userBuilder->getFullName().' - '.$month.' del '.$year.'.xls"');
        header('Cache-Control: max-age=0');

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
            ->setCellValue('H11', "MONTO\nEJECUTADO BS");
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
        $totalAssigned = "H".$i;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('G'.$i, 'A) TOTAL')
            ->setCellValue('H'.$i, '=SUM(H12:H'.($i-1).')');
        $spreadsheet->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);
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
        $totalAdditional = "H".($j+3);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('G'.($j+3), 'B) TOTAL')
            // ->setCellValue('H'.($j+3), 0.00);
            ->setCellValue('H'.($j+3), '=SUM(H'.($j+1).':H'.($j+2).')');
        $spreadsheet->getActiveSheet()->getStyle('G'.($j+3))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('G'.($j+3).':H'.($j+3))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Currency format
        $spreadsheet->getActiveSheet()->getStyle('H'.($j+3))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
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
            ->setCellValue('H'.$k, "MONTO\nEJECUTADO BS");
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
        $totalAsSupport = "H".($k);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('G'.$k, 'B) TOTAL')
            // ->setCellValue('H'.$k, $totalExecutedAmount);
            ->setCellValue('H'.$k, '=SUM(H'.(($k-1)-(count($dataToPrint['asSupport']))).':H'.($k-1).')');
        $spreadsheet->getActiveSheet()->getStyle('G'.$k)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('G'.$k.':H'.$k)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Currency format
        $spreadsheet->getActiveSheet()->getStyle('H'.($k))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);


        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('D'.($k+2), '(A + B) TOTAL EJECUTADO EN PERIODO BS.:')
            ->setCellValue('H'.($k+2), '=SUM('.$totalAssigned.','.$totalAdditional.','.$totalAsSupport.')');
            $spreadsheet->getActiveSheet()->getStyle('H'.($k+2))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
            // ->setCellValue('H'.($k+2), '=SUM(H13,H20,H25)');
        $spreadsheet->getActiveSheet()->mergeCells('D'.($k+2).':G'.($k+2));
        $spreadsheet->getActiveSheet()->getStyle('D'.($k+2).':H'.($k+2))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('D'.($k+2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('D'.($k+2).':H'.($k+2))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(3.83);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(2);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(3.83);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(4);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);

        return $spreadsheet;
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
                        "address" => $row['address'],
                        "datesOnProject" => count($builder['totalDatesInProject']),
                        "executedAmount" => $builder['totalWorked']
                    );
                }
                else
                {
                    $asSupport[] = array(
                        "id"=> $row['id'],
                        "code" => $row['code'],
                        "address" => $row['address'],
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