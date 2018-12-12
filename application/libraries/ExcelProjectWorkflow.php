<?php
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
//            $arrayCellContent = array(
//                $row["code_pro"],
//                $row["status_name_pst"],
//                $row["entry_date_pro"],
//                $row["folder_date_pro"],
//                $row["cre_fiscal_pro"],
//                $row["system_pro"],
//                $row["management_by_pro"],
//                $row["address_pro"],
//                $row["points_pro"],
//                $row["distance_pro"],
//                $row["quality_level_pro"],
//                $row["budgetary_position_pro"],
//                $row["cre_design_completion_date_pro"],
//                $row["cre_building_completion_date_pro"],
//                $row["stake_date"],
//                $row["stake_responsible"],
//                $row["digitization_points_quantity"],
//                $row["digitization_distance"],
//                $row["rd_digitization_points_quantity"],
//                $row["rd_digitization_distance"],
//                $row["returned_date"],
//                $row["digitization_date"],
//                $row["drawing_date"],
//                $row["schedule_date"],
//                $row["schedule_start"],
//                $row["schedule_end"],
//                $row["already_sent_date"],
//                $row["approved_date"],
//                $row["canceled_date"],
//                $row["rectify_design_date"],
//                $row["rectify_illustration_date"],
//                $row["design_budget"],
//                $row["building_budget"],
//                $row["transportation_budget"],
//                $row["live_line_budget"],
//                $row["right_of_way_budget"],
//                $row["total_approved"],
//                $row["record_building_materials_date"],
//                $row["get_materials_date"],
//                $row["deliver_materials_date"],
//                $row["materials_reception_date"],
//                $row["assign_to_date"],
//                $row["builder_responsible"],
//                $row["fiscal_responsible"],
//                $row["start_date_assigned"],
//                $row["end_date_assigned"],
//                $row["estimated_time_assigned"],
//                $row["in_progress_date"],
//                $row["completed_date"],
//                $row["paused_date"],
//                $row["percentage_paused"],
//                $row["stopped_date"],
//                $row["percentage_stopped"],
//                $row["as_built_date"],
//                $row["as_built_points_quantity"],
//                $row["as_built_distance"],
//                $row["conciliation_reception_date"],
//                $row["conciliation_shipment_date"],
//                $row["cre_return_order_date"],
//                $row["project_return_materials_date"],
//                $row["payment_order_registered_date"],
//                $row["payment_order_registered_order_number"],
//                $row["payment_order_registered_design_budget"],
//                $row["payment_order_registered_transportation_budget"],
//                $row["payment_order_registered_live_line_budget"],
//                $row["payment_order_registered_building_budget"],
//                $row["payment_order_registered_right_of_way_budget"],
//                $row["payment_order_registered_total_real_budget"],
//                $row["payment_order_registered_invoice_number"],
//                $row["payment_order_invoice_sent_date"],
//                $row["payment_order_has_been_settled_date"]
//            );
            $this->_drawRow($spreadsheet, ($i+1), $row);
            $i++;
        }
        $this->_currencyFormatNumber($spreadsheet, $i);
        $this->_dateFormat($spreadsheet, $i);
        $this->_adjustColumnToText($spreadsheet);
        $columnList = array("C","AA","AB","BB","BC","BD","BF","BH","BI","BS");
        $this->_highlightColumns($spreadsheet,$i,$columnList,'FFE699');
        $columnList = array("O","P","Q","R","X","AF","AG","AH","AI","AJ","AK","AP","AQ","AR","AV","AW","BI","BJ","BK","BL","BM","BN","BO","BP","BR");
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
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', "ETAPAS");
        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($titleStyleArray);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B1', "INGRESO DE PROYECTOS");
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('B1:N1');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('O1', "DISEÑO");
        $spreadsheet->getActiveSheet()->getStyle('O1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('O1:AA1');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('AB1', "APROBACION/CANCELACION");
        $spreadsheet->getActiveSheet()->getStyle('AB1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('AB1:AK1');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('AL1', "ALMACEN");
        $spreadsheet->getActiveSheet()->getStyle('AL1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('AL1:AO1');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('AP1', "ASIGNACION");
        $spreadsheet->getActiveSheet()->getStyle('AP1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('AP1:AU1');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('AV1', "CONSTRUCCION");
        $spreadsheet->getActiveSheet()->getStyle('AV1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('AV1:BD1');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('BE1', "ADMINISTRACION");
        $spreadsheet->getActiveSheet()->getStyle('BE1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('BE1:BH1');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('BI1', "GESTION DE PAGO");
        $spreadsheet->getActiveSheet()->getStyle('BI1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('BI1:BS1');

        $spreadsheet->getActiveSheet()->getStyle('A1:BS1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);

    }

    private function _headerColumn($spreadsheet)
    {
//        $arrayCellContent = array(
//        "CODIGO",
//        "ESTADO",
//        "FECHA INGRESO",
//        "FECHA CARPETA",
//        "FISCAL DE CRE",
//        "SISTEMA",
//        "ADMINISTRADO POR",
//        "DIRECCION",
//        "PUNTOS",
//        "DISTANCIA",
//        "NIVEL DE CALIDAD",
//        "POSICION PRESUPUESTARIA",
//        "FECHA COMPLETADO DE DISEÑO",
//        "FECHA COMPLETADO DE CONSTRUCCION",
//        "FECHA DE ESTAQUEADO",
//        "RESPONSABLES DE ESTAQUEADO",
//        "PUNTOS DIGITALIZADOS",
//        "DISTANCIA DIGITALIZADA",
//        "PUNTOS RECTIFICADOS EN DIGITALIZACION",
//        "DISTANCIA RECTIFICADA EN DIGITALIZACION",
//        "NO FACTIBLE - DEVUELTO A CRE",
//        "FECHA DIGITALIZACION",
//        "FECHA DIBUJO",
//        "FECHA DEFINICION DE CRONOGRAMA",
//        "FECHA CRONOGRAMA INICIO",
//        "FECHA CRONOGRAMA FIN",
//        "FECHA PROYECTO ENVIADO A CRE",
//        "FECHA APROBACION",
//        "FECHA CANCELADO",
//        "FECHA RECTIFICACION DISEÑO",
//        "FECHA RECTIFICACION ILUSTRACION",
//        "IMPORTE DISEÑO",
//        "IMPORTE CONSTRUCCION",
//        "IMPORTE TRANSPORTE",
//        "LINEA VIVA",
//        "DERECHO DE VIA",
//        "TOTAL IMPORTE APROBADO",
//        "FECHA GRABADO DE MATERIALES",
//        "FECHA RETIRO DE MATERIALES",
//        "FECHA MATERIALES A CONSTRUCCION",
//        "FECHA RECEPCION DE MATERIALES DE CONSTR.",
//        "FECHA ASIGNACION DE RESPONSABLES CONSTR.",
//        "RESPONSABLE CONSTRUC.",
//        "RESPONSABLE FISCAL",
//        "INICIO DE OBRA EN ASIGNACION",
//        "FIN DE OBRA EN ASIGNACION",
//        "DIAS ESTIMADOS EN ASIGNACION",
//        "FECHA INICIO DE CONSTRUC.",
//        "CONSTRUCCION COMPLETADA",
//        "FECHA DE PAUSA DE CONSTRUC",
//        "% DE PAUSA",
//        "FECHA DE CONSTRUCCION DETENIDA",
//        "% DE CONTRUC. DETENIDA",
//        "FECHA DE ENVIO DE AS BUILT",
//        "AS BUILT - PUNTOS",
//        "AS BUILT - DISTANCE",
//        "FECHA RECEPCION DE CONCILIACION",
//        "FECHA ENVIO DE CONCILIACION",
//        "ORDEN DE DEVOLUCION DE MATERIALES",
//        "CONFIRMACION DE DEVOLUCION DE MATERIALES",
//        "FECHA DE REGSITRO DE ORDEN DE PAGO",
//        "NRO ORDEN DE PAGO",
//        "IMPORTE REAL - DISEÑO",
//        "IMPORTE REAL - TRANSPORTE",
//        "IMPORTE REAL - LINEA VIVA",
//        "IMPORTE REAL - CONSTRUCCION",
//        "IMPORTE REAL - DERECHO DE VIA",
//        "IMPORTE REAL - TOTAL",
//        "NRO FACTURA",
//        "FECHA DE ENVIO DE FACTURA",
//        "FECHA DE LIQUIDACION"
//        );
        $this->_drawRow($spreadsheet,  2);
        $spreadsheet->getActiveSheet()->getStyle('A2:BQ2')->getAlignment()->setWrapText(true);
    }

    private function _dateFormat($spreadsheet, $totalRows)
    {
        $columnList = array("C", "D", "M", "N", "O", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AL","AM",
                            "AN", "AO", "AP", "AS", "AT", "AV", "AW", "AX", "AZ", "BB", "BE", "BF", "BG", "BH", "BI", "BR", "BS");
        foreach($columnList as $key => $column)
        {
            $spreadsheet->getActiveSheet()->getStyle($column.'3:'.$column.$totalRows)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
        }
    }

    private function _adjustColumnToText($spreadsheet)
    {
        $columnsToAdjust = array("B","E","F","G");
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
        $columnList = array("AF","AG","AH","AI","AJ","AK");

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

}