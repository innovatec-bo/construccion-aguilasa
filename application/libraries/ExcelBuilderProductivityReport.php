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
        $logDateRange = array('from' => $this->_startDate, 'to' => $this->_endDate);
		$individualProductivityLog = Model_project::getProductivityBaseReport($logDateRange, $this->_builderId);
        $date = date_create_from_format('Y-m-d H:i:s', $this->_startDate);
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
//        $worksheet1 = $spreadsheet->createSheet(0);
//        $worksheet1->setTitle('Resumen');
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());

        $dataToPrint = $this->prepareDataToPrint($projectProductivity);
        $index = 0;
        foreach($dataToPrint['fiscals'] as $fiscal)
        {
            $spreadsheet = $this->builder($spreadsheet, $fiscal, $index);
            $index++;
        }

        $spreadsheet = $this->builderLog($spreadsheet, $individualProductivityLog, $index);
		$spreadsheet->setActiveSheetIndex(0);
        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$this->_userBuilder->getFullName().' - '.$month.' del '.$year.'.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
	}

	public function builder($spreadsheet, $fiscal, $index)
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

		$manPowerWorkSheet = $spreadsheet->createSheet($index);
		$manPowerWorkSheet->setTitle($fiscal['fiscalFullName']);
        //HEADER
        $date = date_create_from_format('Y-m-d H:i:s', $this->_startDate);
        $month = date_format($date, 'F');
        $year = date_format($date, 'Y');
        $spreadsheet->setActiveSheetIndex($index)->setCellValue('D5', "INFORME DE PRODUCCION MENSUAL");
        $spreadsheet->getActiveSheet()->mergeCells('D5:H5');
        $spreadsheet->getActiveSheet()->getStyle('D5')->applyFromArray($titleStyleArray);
        $spreadsheet->setActiveSheetIndex($index)->setCellValue('E7', "MES");
        $spreadsheet->getActiveSheet()->getStyle('E7')->getFont()->setBold(true);
        $spreadsheet->setActiveSheetIndex($index)->setCellValue('F7', $this->_months[strtolower($month)]);
        $spreadsheet->setActiveSheetIndex($index)->setCellValue('G7', $year);
        $spreadsheet->setActiveSheetIndex($index)->setCellValue('E8', "GRUPO");
        $spreadsheet->getActiveSheet()->getStyle('E8')->getFont()->setBold(true);
        $spreadsheet->setActiveSheetIndex($index)->setCellValue('F8', $this->_userBuilder->getFullName());
        
        $spreadsheet->setActiveSheetIndex($index)->setCellValue('E9', "FISCAL");
        $spreadsheet->getActiveSheet()->getStyle('E9')->getFont()->setBold(true);
        $spreadsheet->setActiveSheetIndex($index)->setCellValue('F9', $fiscal['fiscalFullName']);
        
        //********AS ASSIGNED
        $spreadsheet->setActiveSheetIndex($index)->setCellValue('D10', "PRODUCCION CON PROYECTOS ASIGNADOS");
        $spreadsheet->getActiveSheet()->getStyle('D10')->applyFromArray($tableTitle);
        $spreadsheet->setActiveSheetIndex($index)
            ->setCellValue('D11', "No")
            ->setCellValue('E11', "PROYECTO")
            ->setCellValue('F11', "UBICACION")
            ->setCellValue('G11', "DIAS EN OBRA")
            ->setCellValue('H11', "MONTO\nEJECUTADO BS");
        $spreadsheet->getActiveSheet()->getStyle('D11:H11')->applyFromArray($tableHeader);
        $totalExecutedAmount = 0;
        $i = 12;
        $rowCounter = 1;
        foreach ($fiscal['asAssigned'] as $row)
        {
            $spreadsheet->setActiveSheetIndex($index)
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
        $spreadsheet->setActiveSheetIndex($index)
            ->setCellValue('G'.$i, 'A) TOTAL')
            // ->setCellValue('H'.$i, '=SUM(H12:H'.($i-1).')');
            ->setCellValue('H'.$i, '=SUM(H'.(($i-1)-(count($fiscal['asAssigned']))).':H'.($i-1).')');
        $spreadsheet->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('G'.$i.':H'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Currency format
        $spreadsheet->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);

        //******ADDITIONAL ITEMS
        $j = $i +3;
        $spreadsheet->setActiveSheetIndex($index)->setCellValue('D'.$j, "ITEMS ADICIONALES, NO CONTEMPLADOS EN PROYECTO ORIGINAL");
        $spreadsheet->getActiveSheet()->getStyle('D'.$j)->applyFromArray($tableTitle);
        $j++;
        $spreadsheet->setActiveSheetIndex($index)
            ->setCellValue('D'.$j, "No")
            ->setCellValue('E'.$j, "PROYECTO")
            ->setCellValue('F'.$j, "ESTRUCTURA")
            ->setCellValue('G'.$j, "CANTIDAD")
            ->setCellValue('H'.$j, "MONTO BS");
        $spreadsheet->getActiveSheet()->getStyle('D'.$j.':H'.$j)->applyFromArray($tableHeader);
        $spreadsheet->getActiveSheet()->getStyle('D'.$j.':H'.($j+2))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $totalAdditional = "H".($j+3);
        $spreadsheet->setActiveSheetIndex($index)
            ->setCellValue('G'.($j+3), 'B) TOTAL')
            ->setCellValue('H'.($j+3), '=SUM(H'.($j+1).':H'.($j+2).')');
        $spreadsheet->getActiveSheet()->getStyle('G'.($j+3))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('G'.($j+3).':H'.($j+3))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Currency format
        $spreadsheet->getActiveSheet()->getStyle('H'.($j+3))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        //**** AS SUPPORT 
        $k = $j+6;       
        $spreadsheet->setActiveSheetIndex($index)->setCellValue('D'.$k, "PROYECTOS COMO APOYO");
        $spreadsheet->getActiveSheet()->getStyle('D'.$k)->applyFromArray($tableTitle);
        $k++;
        $spreadsheet->setActiveSheetIndex($index)
            ->setCellValue('D'.$k, "No")
            ->setCellValue('E'.$k, "PROYECTO")
            ->setCellValue('F'.$k, "UBICACION")
            ->setCellValue('G'.$k, "DIAS EN OBRA")
            ->setCellValue('H'.$k, "MONTO\nEJECUTADO BS");
        $spreadsheet->getActiveSheet()->getStyle('D'.$k.':H'.$k)->applyFromArray($tableHeader);
        $totalExecutedAmount = 0;
        $k++;
        $rowCounter = 1;
        foreach ($fiscal['asSupport'] as $row)
        {
            $spreadsheet->setActiveSheetIndex($index)
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
        
        $spreadsheet->getActiveSheet()->getStyle('D'.(($k-1)-(count($fiscal['asSupport']))).':H'.($k-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $totalAsSupport = "H".($k);
        $spreadsheet->setActiveSheetIndex($index)
            ->setCellValue('G'.$k, 'B) TOTAL')
            ->setCellValue('H'.$k, '=SUM(H'.(($k-1)-(count($fiscal['asSupport']))).':H'.($k-1).')');
        $spreadsheet->getActiveSheet()->getStyle('G'.$k)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('G'.$k.':H'.$k)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Currency format
        $spreadsheet->getActiveSheet()->getStyle('H'.($k))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);


        $spreadsheet->setActiveSheetIndex($index)
            ->setCellValue('D'.($k+2), '(A + B) TOTAL EJECUTADO EN PERIODO BS.:')
            ->setCellValue('H'.($k+2), '=SUM('.$totalAssigned.','.$totalAdditional.','.$totalAsSupport.')');
            $spreadsheet->getActiveSheet()->getStyle('H'.($k+2))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
            // ->setCellValue('H'.($k+2), '=SUM(H13,H20,H25)');
        $spreadsheet->getActiveSheet()->mergeCells('D'.($k+2).':G'.($k+2));
        $spreadsheet->getActiveSheet()->getStyle('D'.($k+2).':H'.($k+2))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('D'.($k+2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('D'.($k+2).':H'.($k+2))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        //Boder
        $fillGradientLinear = [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Reader\Xls\Style\FillPattern::lookup(0x07),
                    'rotation' => 90,
                    'startColor' => [
                        'rgb' => 'c0c0c0',
                    ],
                    'endColor' => [
                        'argb' => '00000000',
                    ],
                ],
            ];
        $spreadsheet->getActiveSheet()->getStyle('B2:J2')->applyFromArray($fillGradientLinear);
        $spreadsheet->getActiveSheet()->getStyle('B3:B'.($k+4))->applyFromArray($fillGradientLinear);
        $spreadsheet->getActiveSheet()->getStyle('J3:J'.($k+4))->applyFromArray($fillGradientLinear);
        $spreadsheet->getActiveSheet()->getStyle('B'.($k+4).':J'.($k+4))->applyFromArray($fillGradientLinear);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(1.8);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(3.93);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(4);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(1.8);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(3.93);

        $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(12);
        $spreadsheet->getActiveSheet()->getRowDimension('6')->setRowHeight(25);
        $spreadsheet->getActiveSheet()->getRowDimension(($k+4))->setRowHeight(12);

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(FCPATH.'assets/images/sereboFullLogo.png');
        $drawing->setHeight(60);
        $drawing->setCoordinates('D4');

        $spreadsheet->getActiveSheet()->getPageSetup()
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LETTER);

        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToPage(1);

        $drawing->setWorksheet($spreadsheet->getActiveSheet());
        return $spreadsheet;
    }

    public function builderLog($spreadsheet, $individualProductivityLog, $index)
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

		$headerStyleArray = [
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
		$manPowerWorkSheet = $spreadsheet->createSheet($index);
		$manPowerWorkSheet->setTitle('Log de trabajo');
		$date = date_create_from_format('Y-m-d H:i:s', $this->_startDate);
		$month = date_format($date, 'F');
		$month = $this->_months[strtolower($month)];
		$year = date_format($date, 'Y');
		$spreadsheet->setActiveSheetIndex($index)->setCellValue('A1', "HISTORIAL DE TRABAJO DE ".strtoupper($this->_userBuilder->getFullName())." - ".strtoupper($month)." DEL ".$year);
		$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$spreadsheet->getActiveSheet()->getStyle('A1:N1')->applyFromArray($titleStyleArray);
		$spreadsheet->getActiveSheet()->mergeCells('A1:N1');

		$spreadsheet->setActiveSheetIndex($index)
			->setCellValue('A2', "#")
			->setCellValue('B2', "PROYECTO")
			->setCellValue('C2', "FECHA")
			->setCellValue('D2', "EJECUCION")
			->setCellValue('E2', "ACTIVIDAD")
			->setCellValue('F2', "ESTRUCTURA")
			->setCellValue('G2', "DESCRIPCION")
			->setCellValue('H2', "PUNTO")
			->setCellValue('I2', "CANTIDAD\nTRABAJADA")
			->setCellValue('J2', "UNIDAD")
			->setCellValue('K2', "PRECIO\nUNITARIO")
			->setCellValue('L2', "MONTO\nTRABAJADO")
			->setCellValue('M2', "MONTO\nCONSIGNADO")
            ->setCellValue('N2', "FISCAL");
		$spreadsheet->getActiveSheet()->getStyle('A2:N2')->applyFromArray($headerStyleArray);
		$counter = 1;
		$i = 2;
		// $workflowDetail = array();
		foreach ($individualProductivityLog as $row)
		{
//			$row = $row->toArray();
			// echo"<pre>";var_dump($row);exit;
			$spreadsheet->setActiveSheetIndex($index)
				->setCellValue('A'.($i+1), $counter)
				->setCellValue('B'.($i+1), $row["code_pro"])
				->setCellValue('C'.($i+1), $row["manual_entry_date_lal"])
				->setCellValue('D'.($i+1), $row["labor_cost_execution"])
				->setCellValue('E'.($i+1), $row["labor_cost_activity"])
				->setCellValue('F'.($i+1), $row["structure_code"])
				->setCellValue('G'.($i+1), $row["structure_description"])
				->setCellValue('H'.($i+1), $row["point_label"])
				->setCellValue('I'.($i+1), $row["worked_up_wus"])
				->setCellValue('J'.($i+1), $row["structure_unit_of_measurement"])
				->setCellValue('K'.($i+1), $row["price_wus"])
				->setCellValue('L'.($i+1), $row["total_amount_worked_to_split"])
				->setCellValue('M'.($i+1), $row["total_amount_worked_by_builder"])
                ->setCellValue('N'.($i+1), $row['fiscal_responsible']);
			$i++;
			$counter++;

		}
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getStyle('A1:N'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
		$spreadsheet->getActiveSheet()->getStyle('C3:C'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
		$spreadsheet->getActiveSheet()->getStyle('I3:I'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$spreadsheet->getActiveSheet()->getStyle('K3:K'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$spreadsheet->getActiveSheet()->getStyle('L3:L'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$spreadsheet->getActiveSheet()->getStyle('M3:M'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		return $spreadsheet;
	}

    public function prepareDataToPrint($projectProductivity)
    {
        $arrayPerformanceList = [];
        $fiscals = [];
        $asAssigned = [];
        $asSupport  = [];
        foreach ($projectProductivity as $row) 
        {
            $fiscalId = $row['fiscalIdAssigned'];
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
                    if(!isset($fiscals[$fiscalId]))
                    {
                        $fiscals[$fiscalId] = ['fiscalFullName' => $row['fiscalFullName']];
                        $fiscals[$fiscalId]['asAssigned'] = [];
                    }

                    $fiscals[$fiscalId]['asAssigned'][] = array(
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
                    if(!isset($fiscals[$fiscalId]))
                    {
                        $fiscals[$fiscalId] = ['fiscalFullName' => $row['fiscalFullName']];
                        $fiscals[$fiscalId]['asSupport'] = [];
                    }
                    $fiscals[$fiscalId]['asSupport'][] = array(
                        "id"=> $row['id'],
                        "code" => $row['code'],
                        "address" => $row['address'],
                        "datesOnProject" => count($builder['totalDatesInProject']),
                        "executedAmount" => $builder['totalWorkedAsSupport']
                    );
                }
                
            }
        }
        $productivity['fiscals'] = $fiscals;
        $productivity['asAssigned'] = $asAssigned;
        $productivity['asSupport'] = $asSupport;
        return $productivity;
    }
}
