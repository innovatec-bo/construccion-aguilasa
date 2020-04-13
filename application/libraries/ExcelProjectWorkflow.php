<?php
/**
 * @author Jair Cussy
 */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
class ExcelProjectWorkflow
{
    private $_sessionUser;
    private $_additionalParameters;
    private $_columnDefinition;
    private $_arrayColumnDataCounter;
    private $_hideHeaderColumnGroup;
	public function __construct($sessionUser)
	{
        $this->_sessionUser = $sessionUser;
        $this->_additionalParameters = array();
        $this->_arrayColumnDataCounter = array();
        $this->_hideHeaderColumnGroup = FALSE;
        $this->setColumnDefinition();
	}

	function getReport()
	{
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';

        $projectWorkflow = Model_project::getWorkflowDetail($this->_additionalParameters);
        // echo"<pre>";var_dump($projectWorkflow);exit;
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Workflow report")
            ->setSubject("Project report")
            ->setDescription("This report allow see all workflow form all projects on system. Report generated on ".date("Y-m-d H:i:s"))
            ->setKeywords("report workflow projects")
            ->setCategory("Report");

        $this->_headerColumnGroup($spreadsheet);
        $this->_headerColumn($spreadsheet);

        $i = $this->startDataRow();
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());

        foreach ($projectWorkflow as $row)
        {
            $this->_drawRow($spreadsheet, ($i+1), $row);
            $i++;
        }

        $this->_currencyFormatNumber($spreadsheet, $i);
        $this->_dateFormat($spreadsheet, $i);
        $this->_adjustColumnToText($spreadsheet);
        $columnList = array("entry_date_pro","already_sent_date","approved_date","as_built_date","as_built_points_quantity","as_built_distance","conciliation_shipment_date","project_return_materials_date","payment_order_has_been_settled_date");
        $columnList = $this->_getExcelColumnListByArrayDataKey($columnList);
        $this->_highlightColumns($spreadsheet, $i, $columnList,'FFE699');
        $columnList = array("stake_date","stake_responsible","digitization_points_quantity","digitization_distance","schedule_date","design_budget","building_budget","transportation_budget","live_line_budget","right_of_way_budget","total_approved","assign_to_date","builder_responsible","fiscal_responsible","in_progress_date","completed_date","payment_order_registered_date","payment_order_registered_order_number","payment_order_registered_design_budget","payment_order_registered_transportation_budget","payment_order_registered_live_line_budget","payment_order_registered_building_budget","payment_order_registered_right_of_way_budget","payment_order_registered_total_real_budget","payment_order_invoice_sent_date");
        $columnList = $this->_getExcelColumnListByArrayDataKey($columnList);
        $this->_highlightColumns($spreadsheet,$i,$columnList,'DDEBF7');
        ;
        $this->_hideColumns($spreadsheet, $this->_getNotEmptyColumns());
        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="projects_workflow.xls"');
        header('Cache-Control: max-age=0');

        // $writer = new Xlsx($spreadsheet);
        // $writer->save('php://output');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
	}

	private function _headerColumnGroup($spreadsheet)
    {
        if($this->_hideHeaderColumnGroup === FALSE)
        {
            $titleStyleArray = [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'DDEBF7']
                ]
            ];
            $projectCode = $this->_getExcelColumnByDataKey("code_pro");
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue($projectCode.'1', "ETAPAS");
            $spreadsheet->getActiveSheet()->getStyle($projectCode.'1')->applyFromArray($titleStyleArray);

            $contractNumber = $this->_getExcelColumnByDataKey("contract_number_con");
            $projectDetail = $this->_getExcelColumnByDataKey("detail_pro");
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue($contractNumber.'1', "INGRESO DE PROYECTOS");
            $spreadsheet->getActiveSheet()->getStyle($contractNumber.'1')->applyFromArray($titleStyleArray);
            $spreadsheet->getActiveSheet()->mergeCells($contractNumber.'1:'.$projectDetail.'1');

            $stakeDate = $this->_getExcelColumnByDataKey("stake_date");
            $alreadySentDate = $this->_getExcelColumnByDataKey("already_sent_date");
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue($stakeDate.'1', "DISEÑO");
            $spreadsheet->getActiveSheet()->getStyle($stakeDate.'1')->applyFromArray($titleStyleArray);
            $spreadsheet->getActiveSheet()->mergeCells($stakeDate.'1:'.$alreadySentDate.'1');

            $approvedDate = $this->_getExcelColumnByDataKey("approved_date");
            $totalApproved = $this->_getExcelColumnByDataKey("total_approved");
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue($approvedDate.'1', "APROBACION/CANCELACION");
            $spreadsheet->getActiveSheet()->getStyle($approvedDate.'1')->applyFromArray($titleStyleArray);
            $spreadsheet->getActiveSheet()->mergeCells($approvedDate.'1:'.$totalApproved.'1');

            $recordBuildingMaterialsDate = $this->_getExcelColumnByDataKey("record_building_materials_date");
            $materialsReceptionDate = $this->_getExcelColumnByDataKey("materials_reception_date");
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue($recordBuildingMaterialsDate.'1', "ALMACEN");
            $spreadsheet->getActiveSheet()->getStyle($recordBuildingMaterialsDate.'1')->applyFromArray($titleStyleArray);
            $spreadsheet->getActiveSheet()->mergeCells($recordBuildingMaterialsDate.'1:'.$materialsReceptionDate.'1');

            $assignToDate = $this->_getExcelColumnByDataKey("assign_to_date");
            $estimatedTimeAssigned = $this->_getExcelColumnByDataKey("estimated_time_assigned");
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue($assignToDate.'1', "ASIGNACION");
            $spreadsheet->getActiveSheet()->getStyle($assignToDate.'1')->applyFromArray($titleStyleArray);
            $spreadsheet->getActiveSheet()->mergeCells($assignToDate.'1:'.$estimatedTimeAssigned.'1');

            $inProgressDate = $this->_getExcelColumnByDataKey("in_progress_date");
            $asBuiltDistance = $this->_getExcelColumnByDataKey("as_built_distance");
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue($inProgressDate.'1', "CONSTRUCCION");
            $spreadsheet->getActiveSheet()->getStyle($inProgressDate.'1')->applyFromArray($titleStyleArray);
            $spreadsheet->getActiveSheet()->mergeCells($inProgressDate.'1:'.$asBuiltDistance.'1');

            $conciliationReceptionDate = $this->_getExcelColumnByDataKey("conciliation_reception_date");
            $projectReturnMaterialsDate = $this->_getExcelColumnByDataKey("project_return_materials_date");
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue($conciliationReceptionDate.'1', "ADMINISTRACION");
            $spreadsheet->getActiveSheet()->getStyle($conciliationReceptionDate.'1')->applyFromArray($titleStyleArray);
            $spreadsheet->getActiveSheet()->mergeCells($conciliationReceptionDate.'1:'.$projectReturnMaterialsDate.'1');

            $paymentOrderRegisteredDate = $this->_getExcelColumnByDataKey("payment_order_registered_date");
            $paymentOrderHasBeenSettledDate = $this->_getExcelColumnByDataKey("payment_order_has_been_settled_date");//echo"<pre>";var_dump($paymentOrderRegisteredDate,$paymentOrderHasBeenSettledDate);exit;
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue($paymentOrderRegisteredDate.'1', "GESTION DE PAGO");
            $spreadsheet->getActiveSheet()->getStyle($paymentOrderRegisteredDate.'1')->applyFromArray($titleStyleArray);
            $spreadsheet->getActiveSheet()->mergeCells($paymentOrderRegisteredDate.'1:'.$paymentOrderHasBeenSettledDate.'1');

            $spreadsheet->getActiveSheet()->getStyle($projectCode.'1:'.$paymentOrderHasBeenSettledDate.'1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        }
    }

    private function _headerColumn($spreadsheet)
    {
        $startDataRow = $this->startDataRow();
        $this->_drawRow($spreadsheet,  $startDataRow);
        $projectCode = $this->_getExcelColumnByDataKey("code_pro");
        $paymentOrderHasBeenSettledDate = $this->_getLastExcelColumn();
        $spreadsheet->getActiveSheet()->getStyle($projectCode.$startDataRow.':'.$paymentOrderHasBeenSettledDate.$startDataRow)->getAlignment()->setWrapText(true);
    }

    private function _dateFormat($spreadsheet, $totalRows)
    {
        $columnList = array("entry_date_pro", "status_log_manual_entry_date", "folder_date_pro", "cre_design_completion_date_pro", "cre_building_completion_date_pro", "stake_date", "returned_date", "digitization_date", "drawing_date", "schedule_date", "schedule_start", "schedule_end", "already_sent_date", "approved_date", "canceled_date", "rectify_design_date", "rectify_illustration_date", "record_building_materials_date","get_materials_date",
                            "deliver_materials_date", "materials_reception_date", "assign_to_date", "start_date_assigned", "end_date_assigned", "in_progress_date", "completed_date", "paused_date", "stopped_date", "as_built_date", "conciliation_reception_date", "conciliation_shipment_date", "cre_return_order_date", "project_return_materials_date", "payment_order_registered_date", "payment_order_invoice_sent_date", "payment_order_has_been_settled_date","project_energized_entry_date");
        $columnList = $this->_getExcelColumnListByArrayDataKey($columnList);
        $startData = $this->startDataRow() + 1;
        foreach($columnList as $key => $column)
        {

            $spreadsheet->getActiveSheet()->getStyle($column.$startData.':'.$column.$totalRows)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
        }
    }

    private function _adjustColumnToText($spreadsheet)
    {
        $columnsToAdjust = array("status_name_pst","cre_fiscal_pro","system_pro","management_by_pro");
        $columnsToAdjust = $this->_getExcelColumnListByArrayDataKey($columnsToAdjust);
        foreach ($columnsToAdjust as $key => $column)
        {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }
    }

    private function _highlightColumns($spreadsheet, $lastRow, $columnList, $color)
    {
        $titleStyleArray = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => $color]
            ]
        ];
        foreach ($columnList as $key => $column)
        {
            $spreadsheet->getActiveSheet()->getStyle($column.'2:'.$column.$lastRow)->applyFromArray($titleStyleArray);
        }
    }

    private function _currencyFormatNumber($spreadsheet, $totalRows)
    {
        $columnList = array("design_budget","building_budget","transportation_budget","live_line_budget","right_of_way_budget","total_approved");
        $columnList = $this->_getExcelColumnListByArrayDataKey($columnList);
        foreach($columnList as $key => $column)
        {
            $spreadsheet->getActiveSheet()->getStyle($column.'3:'.$column.$totalRows)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        }

    }

    public function setAdditionalParameters($additionalParameters = array())
    {
        $this->_additionalParameters = $additionalParameters;
    }

    public function setColumnDefinition($columnsToExport = array())
    {
        $this->_columnDefinition = PrivateController::getWorkflowColumns();

        //If there is a columnArray to export then execute this code.
        if(count($columnsToExport) > 1 && count($columnsToExport) != count($this->_columnDefinition))
        {
            //If there is special columns to export then let's hide the column grouping.
            $this->_hideHeaderColumnGroup = TRUE;

            $this->_columnDefinition = array_filter(
                                            $this->_columnDefinition,
                                            function ($key) use ($columnsToExport)
                                            {
                                                return in_array($key, $columnsToExport);
                                            },
                                            ARRAY_FILTER_USE_KEY
                                        );
        }

    }

    private function _drawRow($spreadsheet, $rowNumber, $rowData = FALSE)
    {
        $arrayRounds = array("","A","B","C");
        $arrayAlphabet = range("A","Z");
        $maxColumn = count($this->_columnDefinition);
        $arrayTitles = array_values($this->_columnDefinition);
        $arrayKeys = array_keys($this->_columnDefinition);
        $i = 0;

        foreach ($arrayRounds as $round)
        {
            foreach ($arrayAlphabet as $char)
            {
                if ($rowData === FALSE)
                {
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue($round . $char . $rowNumber, $arrayTitles[$i]);
                }
                else
                {
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue($round . $char . $rowNumber, $rowData[$arrayKeys[$i]]);

                    if ($rowNumber == ($this->startDataRow() + 1))
                    {
                        //Let's start our counter
                        $this->_arrayColumnDataCounter[$arrayKeys[$i]] = 0;
                    }
                    if (!empty($rowData[$arrayKeys[$i]]) && $rowData[$arrayKeys[$i]] != "0000-00-00 00:00:00")
                    {
                        //If there is any data then the counter will increase its value to these column

                        $this->_arrayColumnDataCounter[$arrayKeys[$i]]++;
                    }
                }
                $i++;
                if ($i == $maxColumn || !isset($arrayTitles[$i]))
                {
                    break;
                }
            }
            if ($i == $maxColumn || !isset($arrayTitles[$i]))
            {
                break;
            }
        }
    }

    private function _getExcelColumnListByArrayDataKey($arrayDataKey = array())
    {
        $arrayRounds = array("","A","B","C");
        $arrayAlphabet = range("A","Z");
        $maxColumn = count($this->_columnDefinition);
        $arrayKeys = array_keys($this->_columnDefinition);
        $response = array();
        $i = 0;
        foreach ($arrayRounds as $round)
        {
            foreach ($arrayAlphabet as $char)
            {
                if(array_search($arrayKeys[$i], $arrayDataKey) !== FALSE)
                {
                    $excelColumn = $round.$char;
                    $response[] = $excelColumn;
                }
                $i++;
                if ($i == $maxColumn || !isset($arrayKeys[$i]))
                {
                    break;
                }
            }
            if ($i == $maxColumn || !isset($arrayKeys[$i]))
            {
                break;
            }
        }

        return $response;
    }

    private function _getExcelColumnByDataKey($dataKey = "")
    {
        $arrayRounds = array("","A","B","C");
        $arrayAlphabet = range("A","Z");
        $maxColumn = count($this->_columnDefinition);
        $arrayKeys = array_keys($this->_columnDefinition);
        $response = "";
        $i = 0;
        foreach ($arrayRounds as $round)
        {
            foreach ($arrayAlphabet as $char)
            {
                if($arrayKeys[$i] == $dataKey)
                {
                    $excelColumn = $round.$char;
                    $response = $excelColumn;
                    break;
                }
                $i++;
                if ($i == $maxColumn || !isset($arrayKeys[$i]))
                {
                    break;
                }
            }
            if ($i == $maxColumn || !isset($arrayKeys[$i]))
            {
                break;
            }
            if($response != "")
                break;
        }
        return $response;
    }

    private function _hideColumns($spreadsheet, $columnList = array())
    {
        $columnList = $this->_getExcelColumnListByArrayDataKey($columnList);
        foreach ($columnList as $column)
        {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setVisible(FALSE);
        }

    }

    private function _getNotEmptyColumns()
    {
        $response = array();
        foreach($this->_arrayColumnDataCounter as $key => $value)
        {
            if($value <= 0)
            {
                $response[] = $key;
            }
        }
        return $response;
    }

    public function _hideHeaderColumnGroup()
    {
        $this->_hideHeaderColumnGroup = TRUE;
    }

    private function startDataRow()
    {
        $response = 2;
        if($this->_hideHeaderColumnGroup)
        {
            $response = 1;
        }
        return $response;
    }

    private function _getLastExcelColumn()
    {
        $arrayRounds = array("","A","B", "C");
        $arrayAlphabet = range("A","Z");
        $maxColumn = count($this->_columnDefinition);
        $arrayKeys = array_keys($this->_columnDefinition);
        $response = "";
        $i = 0;
        foreach ($arrayRounds as $round)
        {
            foreach ($arrayAlphabet as $char)
            {
                $excelColumn = $round.$char;
                $response = $excelColumn;
                $i++;
                if ($i == $maxColumn || !isset($arrayKeys[$i]))
                {
                    break;
                }
            }
            if ($i == $maxColumn || !isset($arrayKeys[$i]))
            {
                break;
            }
            if($response != "")
                break;
        }
        return $response;
    }
}