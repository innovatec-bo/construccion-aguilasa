<?php
/**
 * @author Jair Cussy
 */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ExcelProjectWorkflow
{
    private $_sessionUser;
    private $_additionalParameters;
    private $_columnDefinition;
	public function __construct($sessionUser)
	{
        $this->_sessionUser = $sessionUser;
        $this->_additionalParameters = array();
        $this->_setColumnDefinition();
	}

	function getReport()
	{
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';

        $projectWorkflow = Model_project::getWorkflowDetail($this->_additionalParameters);
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

        $i = 2;
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder() );
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

        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="projects_workflow.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
	}

	private function _headerColumnGroup($spreadsheet)
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

        $statusName = $this->_getExcelColumnByDataKey("status_name_pst");
        $buildingCompletionDate = $this->_getExcelColumnByDataKey("cre_building_completion_date_pro");
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue($statusName.'1', "INGRESO DE PROYECTOS");
        $spreadsheet->getActiveSheet()->getStyle($statusName.'1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells($statusName.'1:'.$buildingCompletionDate.'1');

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
        $paymentOrderHasBeenSettledDate = $this->_getExcelColumnByDataKey("payment_order_has_been_settled_date");
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue($paymentOrderRegisteredDate.'1', "GESTION DE PAGO");
        $spreadsheet->getActiveSheet()->getStyle($paymentOrderRegisteredDate.'1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells($paymentOrderRegisteredDate.'1:'.$paymentOrderHasBeenSettledDate.'1');

        $spreadsheet->getActiveSheet()->getStyle($projectCode.'1:'.$paymentOrderHasBeenSettledDate.'1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);

    }

    private function _headerColumn($spreadsheet)
    {
        $this->_drawRow($spreadsheet,  2);
        $projectCode = $this->_getExcelColumnByDataKey("code_pro");
        $paymentOrderHasBeenSettledDate = $this->_getExcelColumnByDataKey("payment_order_has_been_settled_date");
        $spreadsheet->getActiveSheet()->getStyle($projectCode.'2:'.$paymentOrderHasBeenSettledDate.'2')->getAlignment()->setWrapText(true);
    }

    private function _dateFormat($spreadsheet, $totalRows)
    {
        $columnList = array("entry_date_pro", "folder_date_pro", "cre_design_completion_date_pro", "cre_building_completion_date_pro", "stake_date", "returned_date", "digitization_date", "drawing_date", "schedule_date", "schedule_start", "schedule_end", "already_sent_date", "approved_date", "canceled_date", "rectify_design_date", "rectify_illustration_date", "record_building_materials_date","get_materials_date",
                            "deliver_materials_date", "materials_reception_date", "assign_to_date", "start_date_assigned", "end_date_assigned", "in_progress_date", "completed_date", "paused_date", "stopped_date", "as_built_date", "conciliation_reception_date", "conciliation_shipment_date", "cre_return_order_date", "project_return_materials_date", "payment_order_registered_date", "payment_order_invoice_sent_date", "payment_order_has_been_settled_date");
        $columnList = $this->_getExcelColumnListByArrayDataKey($columnList);
        foreach($columnList as $key => $column)
        {
            $spreadsheet->getActiveSheet()->getStyle($column.'3:'.$column.$totalRows)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
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

    private function _setColumnDefinition()
    {
        $this->_columnDefinition = array(
            "code_pro" => "CODIGO",
            "status_name_pst" => "ESTADO",
            "static_days" => "DIAS ESTATICO",
            "entry_date_pro" => "FECHA INGRESO",
            "folder_date_pro" => "FECHA CARPETA",
            "cre_fiscal_pro" => "FISCAL DE CRE",
            "system_pro" => "SISTEMA",
            "management_by_pro" => "ADMINISTRADO POR",
            "address_pro" => "DIRECCION",
            "points_pro" => "PUNTOS",
            "distance_pro" => "DISTANCIA",
            "quality_level_pro" => "NIVEL DE CALIDAD",
            "budgetary_position_pro" => "POSICION PRESUPUESTARIA",
            "cre_design_completion_date_pro" => "FECHA COMPLETADO DE DISEÑO",
            "cre_building_completion_date_pro" => "FECHA COMPLETADO DE CONSTRUCCION",
            "stake_date" => "FECHA DE ESTAQUEADO",
            "stake_responsible" => "RESPONSABLES DE ESTAQUEADO",
            "digitization_points_quantity" => "PUNTOS DIGITALIZADOS",
            "digitization_distance" => "DISTANCIA DIGITALIZADA",
            "rd_digitization_points_quantity" => "PUNTOS RECTIFICADOS EN DIGITALIZACION",
            "rd_digitization_distance" => "DISTANCIA RECTIFICADA EN DIGITALIZACION",
            "returned_date" => "NO FACTIBLE - DEVUELTO A CRE",
            "digitization_date" => "FECHA DIGITALIZACION",
            "drawing_date" => "FECHA DIBUJO",
            "schedule_date" => "FECHA DEFINICION DE CRONOGRAMA",
            "schedule_start" => "FECHA CRONOGRAMA INICIO",
            "schedule_end" => "FECHA CRONOGRAMA FIN",
            "already_sent_date" => "FECHA PROYECTO ENVIADO A CRE",
            "approved_date" => "FECHA APROBACION",
            "canceled_date" => "FECHA CANCELADO",
            "rectify_design_date" => "FECHA RECTIFICACION DISEÑO",
            "rectify_illustration_date" => "FECHA RECTIFICACION ILUSTRACION",
            "design_budget" => "IMPORTE DISEÑO",
            "building_budget" => "IMPORTE CONSTRUCCION",
            "transportation_budget" => "IMPORTE TRANSPORTE",
            "live_line_budget" => "LINEA VIVA",
            "right_of_way_budget" => "DERECHO DE VIA",
            "total_approved" => "TOTAL IMPORTE APROBADO",
            "record_building_materials_date" => "FECHA GRABADO DE MATERIALES",
            "get_materials_date" => "FECHA RETIRO DE MATERIALES",
            "deliver_materials_date" => "FECHA MATERIALES A CONSTRUCCION",
            "materials_reception_date" => "FECHA RECEPCION DE MATERIALES DE CONSTR.",
            "assign_to_date" => "FECHA ASIGNACION DE RESPONSABLES CONSTR.",
            "live_line_assigned" => "LINEA VIVA",
            "power_down_assigned" => "CORTE",
            "maneuver_assigned" => "MANIOBRA",
            "builder_responsible" => "RESPONSABLE CONSTRUC.",
            "fiscal_responsible" => "RESPONSABLE FISCAL",
            "start_date_assigned" => "INICIO DE OBRA EN ASIGNACION",
            "end_date_assigned" => "FIN DE OBRA EN ASIGNACION",
            "estimated_time_assigned" => "DIAS ESTIMADOS EN ASIGNACION",
            "in_progress_date" => "FECHA INICIO DE CONSTRUC.",
            "completed_date" => "CONSTRUCCION COMPLETADA",
            "paused_date" => "FECHA DE PAUSA DE CONSTRUC",
            "percentage_paused" => "% DE PAUSA",
            "stopped_date" => "FECHA DE CONSTRUCCION DETENIDA",
            "percentage_stopped" => "% DE CONTRUC. DETENIDA",
            "as_built_date" => "FECHA DE ENVIO DE AS BUILT",
            "as_built_points_quantity" => "AS BUILT - PUNTOS",
            "as_built_distance" => "AS BUILT - DISTANCE",
            "conciliation_reception_date" => "FECHA RECEPCION DE CONCILIACION",
            "conciliation_shipment_date" => "FECHA ENVIO DE CONCILIACION",
            "cre_return_order_date" => "ORDEN DE DEVOLUCION DE MATERIALES",
            "project_return_materials_date" => "CONFIRMACION DE DEVOLUCION DE MATERIALES",
            "payment_order_registered_date" => "FECHA DE REGSITRO DE ORDEN DE PAGO",
            "payment_order_registered_order_number" => "NRO ORDEN DE PAGO",
            "payment_order_registered_design_budget" => "IMPORTE REAL - DISEÑO",
            "payment_order_registered_transportation_budget" => "IMPORTE REAL - TRANSPORTE",
            "payment_order_registered_live_line_budget" => "IMPORTE REAL - LINEA VIVA",
            "payment_order_registered_building_budget" => "IMPORTE REAL - CONSTRUCCION",
            "payment_order_registered_right_of_way_budget" => "IMPORTE REAL - DERECHO DE VIA",
            "payment_order_registered_total_real_budget" => "IMPORTE REAL - TOTAL",
            "payment_order_registered_invoice_number" => "NRO FACTURA",
            "payment_order_invoice_sent_date" => "FECHA DE ENVIO DE FACTURA",
            "payment_order_has_been_settled_date" => "FECHA DE LIQUIDACION"
        );
    }

    private function _drawRow($spreadsheet, $rowNumber, $rowData = FALSE)
    {
        $arrayRounds = array("","A","B");
        $arrayAlphabet = range("A","Z");
        $maxColumn = count($this->_columnDefinition);
        $arrayTitles = array_values($this->_columnDefinition);
        $arrayKeys = array_keys($this->_columnDefinition);
        $i = 0;
        foreach ($arrayRounds as $round)
        {
            foreach ($arrayAlphabet as $char)
            {
                if($rowData === FALSE)
                {
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue($round.$char.$rowNumber, $arrayTitles[$i]);
                }
                else
                {
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue($round.$char.$rowNumber, $rowData[$arrayKeys[$i]]);
                }

                $i++;
                if($i == $maxColumn)
                {
                    break;
                }
            }
        }
    }

    private function _getExcelColumnListByArrayDataKey($arrayDataKey = array())
    {
        $arrayRounds = array("","A","B");
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
                if($maxColumn == $i)
                {
                    break;
                }
            }
        }
        return $response;
    }

    private function _getExcelColumnByDataKey($dataKey = "")
    {
        $arrayRounds = array("","A","B");
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
                if($maxColumn == $i)
                {
                    break;
                }
            }
            if($response != "")
                break;
        }
        return $response;
    }
}