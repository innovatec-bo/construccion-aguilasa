<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ExcelBuilderReport
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

        $workflowDetail = Model_project::getWorkflowDetail();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Reporte de constructores")
            ->setSubject("Reporte de constructores")
            ->setDescription("Reporte de production de constructores")
            ->setKeywords("reporte constructores construccion")
            ->setCategory("Reporte");
        $worksheet1 = $spreadsheet->createSheet(0);
        $worksheet1->setTitle('Por Fiscal');
        $worksheet2 = $spreadsheet->createSheet(1);
        $worksheet2->setTitle('Por Constructor');
        $worksheet2 = $spreadsheet->createSheet(2);
        $worksheet2->setTitle('En progreso');
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());

        $spreadsheet = $this->fiscals($spreadsheet, $workflowDetail);
        $spreadsheet = $this->builders($spreadsheet, $workflowDetail);
        $spreadsheet = $this->inProgress($spreadsheet, $workflowDetail);

        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="reporte_constructores.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
	}

    public function fiscals($spreadsheet, $workflowDetail)
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

        $dataToPrint = $this->prepareFiscalDataToPrint($workflowDetail);
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
                    ->setCellValue($data['cols'][0].'2', 'PRODUCCION '.strtoupper($data['fiscalFullName']));
                $spreadsheet->getActiveSheet()->mergeCells($data['cols'][0].'2:'.$data['cols'][7].'2');

                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue($data['cols'][0].'3', "Nro. de Proyecto")
                    ->setCellValue($data['cols'][1].'3', "Recepcion")
                    ->setCellValue($data['cols'][2].'3', "Aprobado")
                    ->setCellValue($data['cols'][3].'3', "Asignacion")
                    ->setCellValue($data['cols'][4].'3', "En construccion")
                    ->setCellValue($data['cols'][5].'3', "Constructores")
                    ->setCellValue($data['cols'][6].'3', "% / Fecha")
                    ->setCellValue($data['cols'][7].'3', "Costo de Aprobacion");
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][0].'2:'.$data['cols'][7].'3')->applyFromArray($titleStyleArray);

                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue($data['cols'][0].($i+1), $row["code_pro"])
                    ->setCellValue($data['cols'][1].($i+1), $row["entry_date_pro"])
                    ->setCellValue($data['cols'][2].($i+1), $row["approved_date"])
                    ->setCellValue($data['cols'][3].($i+1), $row["assign_to_date"])
                    ->setCellValue($data['cols'][4].($i+1), $row["in_progress_date"])
                    ->setCellValue($data['cols'][5].($i+1), $row["builder_responsible"])
                    ->setCellValue($data['cols'][6].($i+1), $row["last_three_incidents"])
                    ->setCellValue($data['cols'][7].($i+1), $row["building_budget"]);
                $totalAmount += 0;
                $totalApprovedAmount += $row["building_budget"];
                $i++;
                //Date format
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][1].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][2].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][3].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][4].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                //Currency format
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][7].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                //align right
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][6].$i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue($data['cols'][0].($i+1), 'TOTAL')
                ->setCellValue($data['cols'][7].($i+1), $totalApprovedAmount);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][0].($i+1).':'.$data['cols'][7].($i+1))->applyFromArray($titleStyleArray);
            // $spreadsheet->getActiveSheet()->getStyle($data['cols'][4].($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][7].($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);

            $borderCoordinate2 = $data['cols'][7].($i+1);
            $spreadsheet->getActiveSheet()->getColumnDimension($data['cols'][0])->setWidth(11);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][0].'3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][1].'3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][2].'3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][3].'3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][4].'3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getColumnDimension($data['cols'][5])->setAutoSize(true);

            $spreadsheet->getActiveSheet()->getColumnDimension($data['cols'][6])->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension($data['cols'][7])->setWidth(13);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][7].'3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle($borderCoordinate1.':'.$borderCoordinate2)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }
        return $spreadsheet;
    }

	public function builders($spreadsheet, $workflowDetail)
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

        $dataToPrint = $this->prepareDataToPrint($workflowDetail);
        foreach ($dataToPrint as $data)
        {
            $i = 3;
            $borderCoordinate1 = $borderCoordinate2 = '';
            $totalAmount = 0;
            $totalApprovedAmount = 0;
            foreach ($data['workflow'] as $row)
            {
                $borderCoordinate1 = $data['cols'][0].'2';
                $spreadsheet->setActiveSheetIndex(1)
                    ->setCellValue($data['cols'][0].'2', 'PRODUCCION '.strtoupper($data['builderFullName']));
                $spreadsheet->getActiveSheet()->mergeCells($data['cols'][0].'2:'.$data['cols'][7].'2');

                $spreadsheet->setActiveSheetIndex(1)
                    ->setCellValue($data['cols'][0].'3', "Nro. de Proyecto")
                    ->setCellValue($data['cols'][1].'3', "Recepcion")
                    ->setCellValue($data['cols'][2].'3', "Aprobado")
                    ->setCellValue($data['cols'][3].'3', "En construccion")
                    ->setCellValue($data['cols'][4].'3', "Fiscal")
                    ->setCellValue($data['cols'][5].'3', "Cooperador(es)")
                    ->setCellValue($data['cols'][6].'3', "% / Fecha")
                    ->setCellValue($data['cols'][7].'3', "Costo de Aprobacion");
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][0].'2:'.$data['cols'][7].'3')->applyFromArray($titleStyleArray);

                $spreadsheet->setActiveSheetIndex(1)
                    ->setCellValue($data['cols'][0].($i+1), $row["code_pro"])
                    ->setCellValue($data['cols'][1].($i+1), $row["entry_date_pro"])
                    ->setCellValue($data['cols'][2].($i+1), $row["approved_date"])
                    ->setCellValue($data['cols'][3].($i+1), $row["in_progress_date"])
                    ->setCellValue($data['cols'][4].($i+1), $row["fiscal_responsible"])
                    ->setCellValue($data['cols'][5].($i+1), $this->findPartners($data['builderFullName'],$row["builder_responsible"]))
                    ->setCellValue($data['cols'][6].($i+1), $row["last_three_incidents"])
                    ->setCellValue($data['cols'][7].($i+1), $row["building_budget"]);
                $totalAmount += 0;
                $totalApprovedAmount += $row["building_budget"];
                $i++;
                //Date format
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][1].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][2].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][3].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                //Currency format
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][7].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                //align right
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][6].$i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            }
            $spreadsheet->setActiveSheetIndex(1)
                ->setCellValue($data['cols'][0].($i+1), 'TOTAL')
                ->setCellValue($data['cols'][7].($i+1), $totalApprovedAmount);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][0].($i+1).':'.$data['cols'][7].($i+1))->applyFromArray($titleStyleArray);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][7].($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);

            $borderCoordinate2 = $data['cols'][7].($i+1);
            $spreadsheet->getActiveSheet()->getColumnDimension($data['cols'][0])->setWidth(11);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][0].'3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][1].'3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][2].'3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][3].'3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getColumnDimension($data['cols'][4])->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension($data['cols'][5])->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension($data['cols'][6])->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension($data['cols'][7])->setWidth(13);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][7].'3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle($borderCoordinate1.':'.$borderCoordinate2)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }
        return $spreadsheet;
    }

    public function inProgress($spreadsheet, $workflowDetail)
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

        $i = 3;
        $borderCoordinate1 = 'B2';
        $borderCoordinate2 = '';
        $totalAmount = 0;
        $totalApprovedAmount = 0;
        foreach ($workflowDetail as $row)
        {
            $isBetweenDates = $this->isInGivenRange($row["in_progress_date"]);
            if($isBetweenDates && $row["in_progress_date"] != "")
            {
                // $borderCoordinate1 = 'B2';
                $spreadsheet->setActiveSheetIndex(2)
                    ->setCellValue('B2', 'PROYECTOS EN PROGRESO');
                $spreadsheet->getActiveSheet()->mergeCells('B2:I2');

                $spreadsheet->setActiveSheetIndex(2)
                    ->setCellValue('B3', "Nro. de Proyecto")
                    ->setCellValue('C3', "Recepcion")
                    ->setCellValue('D3', "Aprobacion")
                    ->setCellValue('E3', "En Construccion")
                    ->setCellValue('F3', "Fiscal")
                    ->setCellValue('G3', "Constructor(es)")
                    ->setCellValue('H3', "% / Fecha")
                    ->setCellValue('I3', "Costo de Aprobacion");
                $spreadsheet->getActiveSheet()->getStyle('B2:I3')->applyFromArray($titleStyleArray);

                $spreadsheet->setActiveSheetIndex(2)
                    ->setCellValue('B'.($i+1), $row["code_pro"])
                    ->setCellValue('C'.($i+1), $row["entry_date_pro"])
                    ->setCellValue('D'.($i+1), $row["approved_date"])
                    ->setCellValue('E'.($i+1), $row["in_progress_date"])
                    ->setCellValue('F'.($i+1), $row["fiscal_responsible"])
                    ->setCellValue('G'.($i+1), $row["builder_responsible"])
                    ->setCellValue('H'.($i+1), $row["last_three_incidents"])
                    ->setCellValue('I'.($i+1), $row["building_budget"]);
                $totalAmount += 0;
                $totalApprovedAmount += $row["building_budget"];
                $i++;
                //Date format
                $spreadsheet->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $spreadsheet->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $spreadsheet->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                //Currency format
                $spreadsheet->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                //align right
                $spreadsheet->getActiveSheet()->getStyle('H'.$i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            }
        }
        $spreadsheet->setActiveSheetIndex(2)
            ->setCellValue('B'.($i+1), 'TOTAL')
            ->setCellValue('I'.($i+1), $totalApprovedAmount);
        $spreadsheet->getActiveSheet()->getStyle('B'.($i+1).':'.'I'.($i+1))->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->getStyle('I'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);

        $borderCoordinate2 = 'I'.($i+1);
        $spreadsheet->getActiveSheet()->getStyle('B3:I3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(11);
        $spreadsheet->getActiveSheet()->getStyle('B3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('E3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(13);
        $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);//var_dump($borderCoordinate1.':'.$borderCoordinate2);exit;
        $spreadsheet->getActiveSheet()->getStyle($borderCoordinate1.':'.$borderCoordinate2)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->setActiveSheetIndex(0);
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

    public function prepareDataToPrint($workFlowDetail)
    {
        $builderUsers = Model_user::getByRoleKeyword('builder');

        $arrayPerformanceList = array();
        $userCounter = 0;
        foreach ($workFlowDetail as $row)
        {
            $isBetweenDates = $this->isInGivenRange($row["in_progress_date"]);
            if($isBetweenDates)
            {
                foreach ($builderUsers as $user)
                {
                    /** @var  $user Model_user */
                    $responsibleListIds = explode(",", $row["builder_responsible_user_id"]);
                    
                    if(array_search($user->getId(), $responsibleListIds) !== FALSE)
                    {
                        $alphabeth = "";
                        for ($i = 'A'; $i !== 'ZZ'; $i++)
                        {
                            $alphabeth .= $i.',';
                        }
                        $allCols = explode(",", $alphabeth);
                        $columnsToUseByBuilder = 9;
                        $cols = array_chunk($allCols, $columnsToUseByBuilder);
                        $arrayPerformanceList[$user->getId()]['workflow'][] = $row;
                        if(!isset($arrayPerformanceList[$user->getId()]['cols']))
                        {
                            $arrayPerformanceList[$user->getId()]['cols'] = $cols[$userCounter];
                            $arrayPerformanceList[$user->getId()]['counter'] = $userCounter;
                            $userCounter++;
                        }                            
                        $arrayPerformanceList[$user->getId()]['builderFullName'] = $user->getFullName();
                    }
                }
            }
        }
        // echo"<pre>";var_dump($cols, $arrayPerformanceList);exit;
        return $arrayPerformanceList;
    }

    public function prepareFiscalDataToPrint($workFlowDetail)
    {
        $fiscalUsers = Model_user::getByRoleKeyword('fiscal');

        $arrayPerformanceList = array();
        $userCounter = 0;
        foreach ($workFlowDetail as $row)
        {
            $isBetweenDates = $this->isInGivenRange($row["in_progress_date"]);
            if($isBetweenDates && $row["in_progress_date"] != "")
            {
                foreach ($fiscalUsers as $user)
                {
                    /** @var  $user Model_user */
                    $responsibleListIds = explode(",", $row["fiscal_responsible_id"]);
                    
                    if(array_search($user->getId(), $responsibleListIds) !== FALSE)
                    {
                        $alphabeth = "";
                        for ($i = 'A'; $i !== 'ZZ'; $i++)
                        {
                            $alphabeth .= $i.',';
                        }
                        $allCols = explode(",", $alphabeth);
                        $columnsToUseByBuilder = 9;
                        $cols = array_chunk($allCols, $columnsToUseByBuilder);
                        $arrayPerformanceList[$user->getId()]['workflow'][] = $row;
                        if(!isset($arrayPerformanceList[$user->getId()]['cols']))
                        {
                            $arrayPerformanceList[$user->getId()]['cols'] = $cols[$userCounter];
                            $arrayPerformanceList[$user->getId()]['counter'] = $userCounter;
                            $userCounter++;
                        }                            
                        $arrayPerformanceList[$user->getId()]['fiscalFullName'] = $user->getFullName();
                    }
                }
            }
        }
        // echo"<pre>";var_dump($cols, $arrayPerformanceList);exit;
        return $arrayPerformanceList;
    }
}