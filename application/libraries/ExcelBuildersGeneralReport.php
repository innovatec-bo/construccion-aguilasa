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
    private $_fiscalAssignments;
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
		$this->_fiscalAssignments = Model_user_supervisor_by_period::getAssignmentByDateRange(array('from' =>$this->_startDate, 'to'=>$this->_endDate));
        $projectProductivity = Model_project::getBuilderIndividualReport($this->_startDate, $this->_endDate);
        $date = date_create_from_format('Y-m-d H:i:s', $this->_startDate);
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
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '8DB4E2'
                ]
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                ]
            ]
        ];
        $tableHeader = [
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                ]
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '8DB4E2'
                ]
            ]
        ];

        $indexColumn = [
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];

        $fiscalNameStyle1 = [
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                ]
            ]
        ];

		$fiscalTotalWorkedStyle = [
			'font' => ['bold' => true, 'size' => 12],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
			],
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
				]
			],
			'numberFormat' => ['formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2]
		];

        $builderNameStyle1 = [
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                ]
            ]
        ];

        $amountByBuilderStyle1 = [
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                ]
            ],
            'numberFormat' => ['formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2]
        ];

        $totalAmountStyle1 = [
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                ]
            ],
            'numberFormat' => ['formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'F4F402'
                ]
            ]
        ];
        $textTotalAmountStyle1 = [
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                ]
            ],
            'numberFormat' => ['formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'F4F402'
                ]
            ]
        ];

        //HEADER
        $date = date_create_from_format('Y-m-d H:i:s', $this->_startDate);
        $month = date_format($date, 'F');
        $year = date_format($date, 'Y');
        
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D2', "RESUMEN DE PRODUCCION MES DE ".strtoupper($this->_months[strtolower($month)])." ".$year."  - CONSTRUCCION DE REDES");
        $spreadsheet->getActiveSheet()->mergeCells('D2:M2');
        $spreadsheet->getActiveSheet()->getStyle('D2:M2')->applyFromArray($titleStyleArray);
        
        $dataToPrint = $this->_prepareDataToPrint($projectProductivity);
        
        //************************************** MONTH PRODUCTION
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B4', "No")
            ->setCellValue('D4', "GRUPO")
            ->setCellValue('I4', "PRODUCCION MES");
        $spreadsheet->getActiveSheet()->mergeCells('D4:F4');
        $spreadsheet->getActiveSheet()->mergeCells('I4:M4');
        $spreadsheet->getActiveSheet()->getStyle('B4')->applyFromArray($indexColumn);
        $spreadsheet->getActiveSheet()->getStyle('D4:F4')->applyFromArray($tableHeader);
        $spreadsheet->getActiveSheet()->getStyle('I4:M4')->applyFromArray($tableHeader);
        $i = 6;
        $rowCounter = 1;
        foreach ($dataToPrint['buildersAndProductivity'] as $row)
        {
            $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('B'.$i, $rowCounter)
                    ->setCellValue('D'.$i, strtoupper($row["builderFullName"]))
                    ->setCellValue('I'.$i, $row["production"]);
            $spreadsheet->getActiveSheet()->mergeCells('D'.$i.':F'.$i);
            $spreadsheet->getActiveSheet()->mergeCells('I'.$i.':M'.$i);
            $spreadsheet->getActiveSheet()->getStyle('B'.$i)->applyFromArray($indexColumn);
            $spreadsheet->getActiveSheet()->getStyle('D'.$i.':F'.$i)->applyFromArray($builderNameStyle1);
            $spreadsheet->getActiveSheet()->getStyle('I'.$i.':M'.$i)->applyFromArray($amountByBuilderStyle1);
            $i++;
            $i++; 
            $rowCounter++;
        }
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('K'.$i, 'TOTAL Bs.')
            ->setCellValue('M'.$i, '=SUM(I'.(($i-1)-(count($dataToPrint['buildersAndProductivity'])*2)).':I'.($i-1).')');
        $spreadsheet->getActiveSheet()->getStyle('K'.$i)->applyFromArray($textTotalAmountStyle1);
        $spreadsheet->getActiveSheet()->getStyle('M'.$i)->applyFromArray($totalAmountStyle1);

        //*********************************** fiscal and builder
        $j = $i+2;
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$j, "REPORTE GENERAL - CONSTRUCCION POR FISCAL");
        $spreadsheet->getActiveSheet()->mergeCells('D'.$j.':M'.$j);
        $spreadsheet->getActiveSheet()->getStyle('D'.$j.':M'.$j)->applyFromArray($titleStyleArray);
        $secondTitleHeight = $j;
        $j++;
        $j++;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('D'.$j, "FISCAL")
            ->setCellValue('I'.$j, "ENCARGADO")
            ->setCellValue('K'.$j, "CONCILIADO CON\nSEREBO")
			->setCellValue('M'.$j, "TOTAL POR\nFISCAL");
        $spreadsheet->getActiveSheet()->mergeCells('D'.$j.':F'.$j);
        $spreadsheet->getActiveSheet()->getStyle('D'.$j.':F'.$j)->applyFromArray($tableHeader);
        $spreadsheet->getActiveSheet()->getStyle('I'.$j)->applyFromArray($tableHeader);
        $spreadsheet->getActiveSheet()->getStyle('K'.$j)->applyFromArray($tableHeader);
        $spreadsheet->getActiveSheet()->getStyle('M'.$j)->applyFromArray($tableHeader);
        $j++;
        $j++;
        $cellsToSum = "";
        foreach ($dataToPrint['fiscalsAndBuildersProductivity'] as $row)
        {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$j, strtoupper($row["fiscalFullName"]));
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('M'.$j, strtoupper($row["production"]));
            $k=$j;
            $mergeStart = $k;
            foreach ($row['builders'] as $data) 
            {
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('I'.$k, strtoupper($data["builderFullName"]))
                ->setCellValue('K'.$k, $data["production"]);
                $spreadsheet->getActiveSheet()->getStyle('I'.$k)->applyFromArray($builderNameStyle1);   
                $spreadsheet->getActiveSheet()->getStyle('K'.$k)->applyFromArray($amountByBuilderStyle1);
                $cellsToSum .= "K".$k.", ";
                $k = $k + 2;
                $j = $j + 2;
            }
            $mergeEnd = $j-2;
            $spreadsheet->getActiveSheet()->mergeCells('D'.$mergeStart.':F'.$mergeEnd);
            $spreadsheet->getActiveSheet()->getStyle('D'.$mergeStart.':F'.$mergeEnd)->applyFromArray($fiscalNameStyle1);
			$spreadsheet->getActiveSheet()->mergeCells('M'.$mergeStart.':M'.$mergeEnd);
			$spreadsheet->getActiveSheet()->getStyle('M'.$mergeStart.':M'.$mergeEnd)->applyFromArray($fiscalTotalWorkedStyle);
        }
        $cellsToSum = substr($cellsToSum, 0, -2);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('K'.$j, '=SUM('.$cellsToSum.')');
        $spreadsheet->getActiveSheet()->getStyle('K'.$j)->applyFromArray($totalAmountStyle1);

		//*********************************** Builders and supervising
		$k = $j+2;
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$k, "REPORTE GENERAL - CONSTRUCCION POR SUPERVISOR");
		$spreadsheet->getActiveSheet()->mergeCells('D'.$k.':M'.$k);
		$spreadsheet->getActiveSheet()->getStyle('D'.$k.':M'.$k)->applyFromArray($titleStyleArray);
		$secondTitleHeight = $k;
		$k++;
		$k++;
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('D'.$k, "FISCAL")
			->setCellValue('I'.$k, "ENCARGADO")
			->setCellValue('K'.$k, "CONCILIADO CON\nSEREBO")
			->setCellValue('M'.$k, "TOTAL POR\nFISCAL");
		$spreadsheet->getActiveSheet()->mergeCells('D'.$k.':F'.$k);
		$spreadsheet->getActiveSheet()->getStyle('D'.$k.':F'.$k)->applyFromArray($tableHeader);
		$spreadsheet->getActiveSheet()->getStyle('I'.$k)->applyFromArray($tableHeader);
		$spreadsheet->getActiveSheet()->getStyle('K'.$k)->applyFromArray($tableHeader);
		$spreadsheet->getActiveSheet()->getStyle('M'.$k)->applyFromArray($tableHeader);
		$k++;
		$k++;
		$cellsToSum = "";
		foreach ($dataToPrint['buildersAndSupervising'] as $row)
		{
			$spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$k, strtoupper($row["fiscalFullName"]));
			$spreadsheet->setActiveSheetIndex(0)->setCellValue('M'.$k, strtoupper($row["production"]));
			$l=$k;
			$mergeStart = $l;
			foreach ($row['builders'] as $data)
			{
				$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('I'.$l, strtoupper($data["builderFullName"]))
					->setCellValue('K'.$l, $data["production"]);
				$spreadsheet->getActiveSheet()->getStyle('I'.$l)->applyFromArray($builderNameStyle1);
				$spreadsheet->getActiveSheet()->getStyle('K'.$l)->applyFromArray($amountByBuilderStyle1);
				$cellsToSum .= "K".$l.", ";
				$l = $l + 2;
				$k = $k + 2;
			}
			$mergeEnd = $k-2;
			$spreadsheet->getActiveSheet()->mergeCells('D'.$mergeStart.':F'.$mergeEnd);
			$spreadsheet->getActiveSheet()->getStyle('D'.$mergeStart.':F'.$mergeEnd)->applyFromArray($fiscalNameStyle1);
			$spreadsheet->getActiveSheet()->mergeCells('M'.$mergeStart.':M'.$mergeEnd);
			$spreadsheet->getActiveSheet()->getStyle('M'.$mergeStart.':M'.$mergeEnd)->applyFromArray($fiscalTotalWorkedStyle);
		}
		$cellsToSum = substr($cellsToSum, 0, -2);
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('K'.$k, '=SUM('.$cellsToSum.')');
		$spreadsheet->getActiveSheet()->getStyle('K'.$k)->applyFromArray($totalAmountStyle1);

        //columns and rows dimensions
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(1.8);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(1.8);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(2);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(TRUE);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(2);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(17);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(2);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(TRUE);
        $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(25);
        $spreadsheet->getActiveSheet()->getRowDimension($secondTitleHeight)->setRowHeight(25);

        return $spreadsheet;
    }

    public function _prepareDataToPrint($projectProductivity)
    {
        $arrayPerformanceList = array();
        $buildersAndProductivity = array();
        $fiscalsAndBuildersProductivity = array();
        $buildersAndSupervising = array();

        foreach ($projectProductivity as $row)
        {
            $fiscalAssignedId = $row['fiscalIdAssigned'];
            foreach ($row['allBuilders'] as $key => $builder) 
            {
                //**************** Group by builder
				/** @var Model_user $builderObject */
                $builderObject = $this->_builderList[$key];
                $generalProduction = floatval($builder['totalWorkedAsSupport']) + floatval($builder['totalWorked']);
                if(!isset($buildersAndProductivity[$key]))
                {
                	$supervisorId = $this->_getSupervisorId($builderObject->getId());
                    $buildersAndProductivity[$key] = array(
                                    "builderId"=> $builderObject->getId(),
                                    "builderFullName" => $builderObject->getFullName(),
                                    "supervisingId" => $supervisorId,//$builderObject->getSupervisingId(),
                                    "production" => 0
                                );
                }
                $buildersAndProductivity[$key]["production"] += $generalProduction;

                //**************** Group by fiscal and builder
                $fiscalObject = $this->_fiscalList[$fiscalAssignedId];
                if(!$fiscalObject instanceof Model_user)
				{
					echo "El proyecto ".$row['code']." no tiene regitros de haber estado en construccion.";exit;
//					echo '<pre>';var_dump($row);exit;
				}
                if(!isset($fiscalsAndBuildersProductivity[$fiscalAssignedId]))
				{
					$fiscalsAndBuildersProductivity[$fiscalAssignedId]['fiscalId'] = $fiscalObject->getId();
					$fiscalsAndBuildersProductivity[$fiscalAssignedId]['fiscalFullName'] = $fiscalObject->getFullName();
					$fiscalsAndBuildersProductivity[$fiscalAssignedId]['production'] = 0;
				}
				if(!isset($fiscalsAndBuildersProductivity[$fiscalAssignedId]['builders'][$key]))
				{
					$fiscalsAndBuildersProductivity[$fiscalAssignedId]['builders'][$key]['builderId'] = $builderObject->getId();
					$fiscalsAndBuildersProductivity[$fiscalAssignedId]['builders'][$key]['builderFullName'] = $builderObject->getFullName();
					$fiscalsAndBuildersProductivity[$fiscalAssignedId]['builders'][$key]['production'] = 0;

				}
                $fiscalsAndBuildersProductivity[$fiscalAssignedId]['builders'][$key]['production'] += $generalProduction;
				$fiscalsAndBuildersProductivity[$fiscalAssignedId]['production'] += $generalProduction;
            }
		}

		//Group by builder and supervising
		foreach ($buildersAndProductivity as $builder)
		{
			$supervisingId = $builder['supervisingId'];
			$fiscalId = 1000;
			$fiscalFullName = "Sin supervisor";
			if(!is_null($supervisingId))
			{
				/** @var Model_user $fiscal */
				$fiscal = $this->_fiscalList[$supervisingId];
				$fiscalId = $fiscal->getId();
				$fiscalFullName = $fiscal->getFullName();
			}
			if(!isset($buildersAndSupervising[$fiscalId]))
				$buildersAndSupervising[$fiscalId]['production'] = 0;
			$buildersAndSupervising[$fiscalId]['fiscalId'] = $fiscalId;
			$buildersAndSupervising[$fiscalId]['fiscalFullName'] = $fiscalFullName;
			$buildersAndSupervising[$fiscalId]['production'] += $builder['production'];
			$buildersAndSupervising[$fiscalId]['builders'][$builder['builderId']]['builderId'] = $builder['builderId'];
			$buildersAndSupervising[$fiscalId]['builders'][$builder['builderId']]['builderFullName'] = $builder['builderFullName'];
			$buildersAndSupervising[$fiscalId]['builders'][$builder['builderId']]['production'] = $builder['production'];
		}
		sort($buildersAndSupervising);

        $arrayPerformanceList['buildersAndProductivity'] = $buildersAndProductivity;
        $arrayPerformanceList['fiscalsAndBuildersProductivity'] = $fiscalsAndBuildersProductivity;
		$arrayPerformanceList['buildersAndSupervising'] = $buildersAndSupervising;
        return $arrayPerformanceList;
    }

    private function _getSupervisorId($builderIdToFind)
	{
		$supervisorId = NULL;
		foreach ($this->_fiscalAssignments as $fiscal)
		{
			$fiscalId = $fiscal['id'];
			$builders = $fiscal['builders'];
			foreach ($builders as $builder)
			{
				if($builder['id'] == $builderIdToFind)
				{
					$supervisorId = $fiscalId;
					break;
				}
				if(!is_null($supervisorId))
				{
					break;
				}
			}
		}
		return $supervisorId;
	}
}
