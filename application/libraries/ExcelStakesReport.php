<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ExcelStakesReport
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
            ->setTitle("Reporte de estaqueadores")
            ->setSubject("Reporte de estaqueadores")
            ->setDescription("Reporte de production de estaqueadores")
            ->setKeywords("reporte estaqueadores estaquedo")
            ->setCategory("Reporte");
        $worksheet1 = $spreadsheet->createSheet(0);
        $worksheet1->setTitle('Por Estaqueadores');
        $worksheet2 = $spreadsheet->createSheet(1);
        $worksheet2->setTitle('Aprobados');
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());

        $spreadsheet = $this->stakes($spreadsheet, $workflowDetail);
        $spreadsheet = $this->approves($spreadsheet, $workflowDetail);

        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="reporte_estaquedores.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
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

        $dataToPrint = $this->prepareDataToPrint($workflowDetail);
        foreach ($dataToPrint as $data)
        {
            $i = 3;
            $borderCoordinate1 = $borderCoordinate2 = '';
            $totalAmount = 0;
            foreach ($data['workflow'] as $row)
            {
                $borderCoordinate1 = $data['cols'][0].'2';
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue($data['cols'][0].'2', 'PRODUCCION '.strtoupper($row["stake_responsible"]));
                $spreadsheet->getActiveSheet()->mergeCells($data['cols'][0].'2:'.$data['cols'][5].'2');

                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue($data['cols'][0].'3', "Nro. de Proyecto")
                    ->setCellValue($data['cols'][1].'3', "Recepcion")
                    ->setCellValue($data['cols'][2].'3', "Envio")
                    ->setCellValue($data['cols'][3].'3', "Aprobado")
                    ->setCellValue($data['cols'][4].'3', "Cooperador(es)")
                    ->setCellValue($data['cols'][5].'3', "Costo");
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][0].'2:'.$data['cols'][5].'3')->applyFromArray($titleStyleArray);


                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue($data['cols'][0].($i+1), $row["code_pro"])
                    ->setCellValue($data['cols'][1].($i+1), $row["entry_date_pro"])
                    ->setCellValue($data['cols'][2].($i+1), $row["already_sent_date"])
                    ->setCellValue($data['cols'][3].($i+1), $row["approved_date"])
                    ->setCellValue($data['cols'][4].($i+1), "")
                    ->setCellValue($data['cols'][5].($i+1), $row["schedule_design_budget"]);
                $totalAmount += $row["schedule_design_budget"];
                $i++;
                //Date format
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][1].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][2].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][3].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                //Currency format
                $spreadsheet->getActiveSheet()->getStyle($data['cols'][5].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);

            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue($data['cols'][0].($i+1), 'TOTAL')
                ->setCellValue($data['cols'][5].($i+1), $totalAmount);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][0].($i+1).':'.$data['cols'][5].($i+1))->applyFromArray($titleStyleArray);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][5].($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);

            $borderCoordinate2 = $data['cols'][5].($i+1);
            $spreadsheet->getActiveSheet()->getStyle($data['cols'][0].'3:'.$data['cols'][5].'3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle($borderCoordinate1.':'.$borderCoordinate2)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        }
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

        $i = 3;
        $borderCoordinate1 = $borderCoordinate2 = '';
        $totalAmount = 0;
        foreach ($workflowDetail as $row)
        {
            $isBetweenDates = $this->isInGivenRange($row["stake_date"]);
            if($isBetweenDates)
            {
                $borderCoordinate1 = 'B2';
                $spreadsheet->setActiveSheetIndex(1)
                    ->setCellValue('B2', 'PROYECTOS APROBADOS');
                $spreadsheet->getActiveSheet()->mergeCells('B2:G2');

                $spreadsheet->setActiveSheetIndex(1)
                    ->setCellValue('B3', "Nro. de Proyecto")
                    ->setCellValue('C3', "Recepcion")
                    ->setCellValue('D3', "Envio")
                    ->setCellValue('E3', "Aprobado")
                    ->setCellValue('F3', "Cooperador(es)")
                    ->setCellValue('G3', "Costo");
                $spreadsheet->getActiveSheet()->getStyle('B2:G3')->applyFromArray($titleStyleArray);


                $spreadsheet->setActiveSheetIndex(1)
                    ->setCellValue('B'.($i+1), $row["code_pro"])
                    ->setCellValue('C'.($i+1), $row["entry_date_pro"])
                    ->setCellValue('D'.($i+1), $row["already_sent_date"])
                    ->setCellValue('E'.($i+1), $row["approved_date"])
                    ->setCellValue('F'.($i+1), "")
                    ->setCellValue('G'.($i+1), $row["schedule_design_budget"]);
                $totalAmount += $row["schedule_design_budget"];
                $i++;
                //Date format
                $spreadsheet->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $spreadsheet->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                $spreadsheet->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
                //Currency format
                $spreadsheet->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
            }
        }
        $spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('B'.($i+1), 'TOTAL')
            ->setCellValue('G'.($i+1), $totalAmount);
        $spreadsheet->getActiveSheet()->getStyle('B'.($i+1).':'.'G'.($i+1))->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->getStyle('G'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);

        $borderCoordinate2 = 'G'.($i+1);
        $spreadsheet->getActiveSheet()->getStyle('B3:G3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle($borderCoordinate1.':'.$borderCoordinate2)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
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

    public function prepareDataToPrint($workFlowDetail)
    {
        $stakeUsers = Model_user::getByRoleKeyword('stacker');
        $arrayPerformanceList = array();
        foreach ($workFlowDetail as $row)
        {
            $isBetweenDates = $this->isInGivenRange($row["stake_date"]);
            if($isBetweenDates)
            {
                $userCounter = 0;
                foreach ($stakeUsers as $user)
                {
                    /** @var  $user Model_user */
                    $responsibleListIds = explode(",", $row["stake_responsible_user_id"]);
                    if(array_search($user->getId(), $responsibleListIds) !== FALSE)
                    {
                        $cols = array_chunk(range("A", "Z"),7);
                        $arrayPerformanceList[$user->getId()]['workflow'][] = $row;
                        $arrayPerformanceList[$user->getId()]['cols'] = $cols[$userCounter];
                    }
                    $userCounter++;
                }
            }
        }
        return $arrayPerformanceList;
    }
}