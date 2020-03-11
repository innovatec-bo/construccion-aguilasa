<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ExcelWorkPlanReport
{
    private $_sessionUser;
    private $_startDate;
    private $_endDate;
	public function __construct($sessionUser, $startDate, $endDate)
	{
        $this->_sessionUser = $sessionUser;
        $this->_startDate = $startDate;
        $this->_endDate = $endDate;
	}

	function getReport()
	{
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';

        $workPlanSummary = Model_work_plan::getMonthlySummary($this->_startDate, $this->_endDate);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Reporte de plan de trabajo")
            ->setSubject("Reporte de plan de trabajo")
            ->setDescription("Reporte de plan de trabajo")
            ->setKeywords("reporte plan trabajo")
            ->setCategory("Reporte");
        $worksheet1 = $spreadsheet->createSheet(0);
        $worksheet1->setTitle('Por Estaqueadores');
        $worksheet2 = $spreadsheet->createSheet(1);
        $worksheet2->setTitle('Aprobados');
//        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());
        $spreadsheet = $this->workPlan($spreadsheet, $workPlanSummary);
//        $this->prepareDataToPrint($workflowDetail);

        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="reporte_plan_de_trabajo.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
	}

	public function workPlan($spreadsheet, $workPlanSummary)
    {

        $titleStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];

        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '95B3D7']
            ]
        ];

        $fiscalRowStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '95B3D7']
            ]
        ];
        $builderRowStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'cecece']
            ]
        ];

        $period = new DatePeriod(
            new DateTime($this->_startDate),
            new DateInterval('P1D'),
            new DateTime($this->_endDate)
        );
        $arrayRounds = array("","A","B", "C");
        $arrayAlphabet = range("A","Z");
        $cols = array();
        foreach ($arrayRounds as $round)
        {
            foreach ($arrayAlphabet as $char)
            {
                $cols[] =  $round.$char;
            }
        }
        $i = 3;
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', "CRONOGRAMA SEMANAL  DE PROYECTOS CONSTRUCCION DE REDES - SEREBO SRL.");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', "N");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B4', "PROYECTO");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C4', "LUGAR");
        foreach ($period as $key => $value)
        {
//            echo"<pre>";var_dump($cols, $cols[$i], $value->format('Y-m-d'));exit;
            $spreadsheet->setActiveSheetIndex(0)->setCellValue($cols[$i].'4', $value->format('D'));
            $spreadsheet->setActiveSheetIndex(0)->setCellValue($cols[$i].'5', $value->format('d'));
            $spreadsheet->getActiveSheet()->getColumnDimension($cols[$i])->setWidth(5);
            $i++;
        }
        $spreadsheet->getActiveSheet()->mergeCells('A4:A5');
        $spreadsheet->getActiveSheet()->mergeCells('B4:B5');
        $spreadsheet->getActiveSheet()->mergeCells('C4:C5');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue($cols[$i].'4', "DETALLE");
        $spreadsheet->getActiveSheet()->mergeCells($cols[$i].'4:'.$cols[$i].'5');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue($cols[$i+1].'4', "OBSERVACION");
        $spreadsheet->getActiveSheet()->mergeCells($cols[$i+1].'4:'.$cols[$i+1].'5');//var_dump('A3:'.$cols[$i+1]."3");exit;
        $spreadsheet->getActiveSheet()->mergeCells('A2:'.$cols[$i+1]."2");
        $spreadsheet->getActiveSheet()->getStyle('A2:'.$cols[$i+1]."2")->applyFromArray($titleStyle);
        $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
        $spreadsheet->getActiveSheet()->getStyle("A4:".$cols[$i+1]."5")->applyFromArray($headerStyle);

        $i = 6;
        foreach ($workPlanSummary as $fiscal)
        {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("A".$i, $fiscal['fullName']);
            $j = $i+1;
            foreach ($fiscal['builderList'] as $builder)
            {
                $spreadsheet->setActiveSheetIndex(0)->setCellValue("A".$j, $builder['fullName']);
                $k = $j+1;
                $projectCounter = 1;
//                echo"<pre>";var_dump($fiscal);exit;
                foreach ($builder['projectList'] as $project)
                {
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue("A".$k, $projectCounter);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue("B".$k, $project['code']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue("C".$k, $project['address']);
                    $periodIndex = 3;
                    foreach ($period as $key => $value)
                    {
                        foreach ($project['dateList'] as $date)
                        {
                            if($value->format('Y-m-d') == $date)
                            {
                                $spreadsheet->setActiveSheetIndex(0)->setCellValue($cols[$periodIndex].$k, "X");
                            }
                        }
                        $periodIndex ++;
                    }
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue($cols[$periodIndex].$k, $project['dateDetail']);
                    $spreadsheet->getActiveSheet()->getColumnDimension($cols[$periodIndex])->setWidth(20);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue($cols[$periodIndex+1].$k, $project['dateObservation']);
                    $spreadsheet->getActiveSheet()->getColumnDimension($cols[$periodIndex+1])->setWidth(20);
                    $k++;
                    $projectCounter++;
                }
                $spreadsheet->getActiveSheet()->getStyle("A".$j.":".$cols[$periodIndex+1].$j)->applyFromArray($builderRowStyle);
                $spreadsheet->getActiveSheet()->mergeCells("A".$j.":".$cols[$periodIndex+1].$j);
                $j = $k+1;
            }
            $spreadsheet->getActiveSheet()->getStyle("A".$i.":".$cols[$periodIndex+1].$i)->applyFromArray($fiscalRowStyle);
            $spreadsheet->getActiveSheet()->mergeCells("A".$i.":".$cols[$periodIndex+1].$i);
            $i = $k+1;
        }
        $spreadsheet->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A4:'.$cols[$periodIndex+1].($k-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        return $spreadsheet;
    }

	public function stakes($spreadsheet, $workflowDetail)
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

        $dataToPrint = $this->prepareDataToPrint_deprecated($workflowDetail);
        foreach ($dataToPrint as $data)
        {
            $i = 3;
            $borderCoordinate1 = $borderCoordinate2 = '';
            $totalAmount = 0;
            $totalApprovedAmount = 0;
            foreach ($data['workflow'] as $row)
            {
                $borderCoordinate1 = $data['cols'][0].'2';
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue($data['cols'][0].'2', 'PRODUCCION '.strtoupper($data['stakerFullName']));
                $spreadsheet->getActiveSheet()->mergeCells($data['cols'][0].'2:'.$data['cols'][6].'2');

                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue($data['cols'][0].'3', "Nro. de Proyecto")
                    ->setCellValue($data['cols'][1].'3', "Recepcion")
                    ->setCellValue($data['cols'][2].'3', "Por enviar")
                    ->setCellValue($data['cols'][3].'3', "Envio")
                    ->setCellValue($data['cols'][4].'3', "Aprobado")
                    ->setCellValue($data['cols'][5].'3', "Cooperador(es)")
                    ->setCellValue($data['cols'][6].'3', "Costo")
                    ->setCellValue($data['cols'][7].'3', "Costo de Aprobacion");
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][0].'2:'.$data['cols'][7].'3')->applyFromArray($titleStyleArray);

                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue($data['cols'][0].($i+1), $row["code_pro"])
                    ->setCellValue($data['cols'][1].($i+1), $row["entry_date_pro"])
                    ->setCellValue($data['cols'][2].($i+1), $row["already_sent_date"])
                    ->setCellValue($data['cols'][3].($i+1), $row["already_sent_date"])
                    ->setCellValue($data['cols'][4].($i+1), $row["approved_date"])
                    ->setCellValue($data['cols'][5].($i+1), $this->findPartners($data['stakerFullName'],$row["stake_responsible"]))
//                    ->setCellValue($data['cols'][4].($i+1), "")
                    ->setCellValue($data['cols'][6].($i+1), $row["schedule_design_budget"])
                    ->setCellValue($data['cols'][7].($i+1), $row["design_budget"]);
                $totalAmount += $row["schedule_design_budget"];
                $totalApprovedAmount += $row["design_budget"];
                $i++;
                //Date format
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][1].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][2].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][3].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][4].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                //Currency format
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][6].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][7].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue($data['cols'][0].($i+1), 'TOTAL')
                ->setCellValue($data['cols'][6].($i+1), $totalAmount)
                ->setCellValue($data['cols'][7].($i+1), $totalApprovedAmount);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][0].($i+1).':'.$data['cols'][7].($i+1))->applyFromArray($titleStyleArray);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][6].($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][7].($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);

            $borderCoordinate2 = $data['cols'][7].($i+1);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][0].'3:'.$data['cols'][7].'3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle($borderCoordinate1.':'.$borderCoordinate2)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }
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

    public function prepareDataToPrint_deprecated($workFlowDetail)
    {
        $stakeUsers = Model_user::getByRoleKeyword('stacker');
        $arrayPerformanceList = array();
        foreach ($workFlowDetail as $row)
        {
            $isBetweenDates = $this->isInGivenRange($row["schedule_date"]);
            if($isBetweenDates)
            {
                $userCounter = 0;
                foreach ($stakeUsers as $user)
                {
                    /** @var  $user Model_user */
                    $responsibleListIds = explode(",", $row["stake_responsible_user_id"]);
                    if(array_search($user->getId(), $responsibleListIds) !== FALSE)
                    {
                        $cols = array_chunk(range("A", "Z"),9);
                        $arrayPerformanceList[$user->getId()]['workflow'][] = $row;
                        $arrayPerformanceList[$user->getId()]['cols'] = $cols[$userCounter];
                        $arrayPerformanceList[$user->getId()]['stakerFullName'] = $user->getFullName();
                    }
                    $userCounter++;
                }
            }
        }
        return $arrayPerformanceList;
    }

    public function prepareDataToPrint($workflowDetail)
    {
        $workPlanSummary = Model_work_plan::getMonthlySummary();
        echo"<pre>";var_dump($workPlanSummary);exit;

    }
}