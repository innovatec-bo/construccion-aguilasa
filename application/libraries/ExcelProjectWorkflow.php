<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ExcelProjectWorkflow
{
    private $_sessionUser;
	public function __construct($sessionUser)
	{
        $this->_sessionUser = $sessionUser;
	}

	function getReport()
	{
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';

        $projectWorkflow = Model_project::getWorkflowDetail();
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
        foreach ($projectWorkflow as $row)
        {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+1), $row["code_pro"])
                ->setCellValue('B'.($i+1), $row["status_name_pst"])
                ->setCellValue('C'.($i+1), $this->_dateFormat($row["entry_date_pro"]))
                ->setCellValue('D'.($i+1), $this->_dateFormat($row["folder_date_pro"]))
                ->setCellValue('E'.($i+1), $row["cre_fiscal_pro"])
                ->setCellValue('F'.($i+1), $row["system_pro"])
                ->setCellValue('G'.($i+1), $row["management_by_pro"])
                ->setCellValue('H'.($i+1), $row["address_pro"])
                ->setCellValue('I'.($i+1), $row["points_pro"])
                ->setCellValue('J'.($i+1), $row["distance_pro"])
                ->setCellValue('K'.($i+1), $row["quality_level_pro"])
                ->setCellValue('L'.($i+1), $row["budgetary_position_pro"])
                ->setCellValue('M'.($i+1), $this->_dateFormat($row["cre_design_completion_date_pro"]))
                ->setCellValue('N'.($i+1), $this->_dateFormat($row["cre_building_completion_date_pro"]))
                ->setCellValue('O'.($i+1), $this->_dateFormat($row["stake_date"]))
                ->setCellValue('P'.($i+1), $row["stake_responsible"])
                ->setCellValue('Q'.($i+1), $row["digitization_points_quantity"])
                ->setCellValue('R'.($i+1), $row["digitization_distance"])
                ->setCellValue('S'.($i+1), $row["rd_digitization_points_quantity"])
                ->setCellValue('T'.($i+1), $row["rd_digitization_distance"])
                ->setCellValue('U'.($i+1), $this->_dateFormat($row["returned_date"]))
                ->setCellValue('V'.($i+1), $this->_dateFormat($row["digitization_date"]))
                ->setCellValue('W'.($i+1), $this->_dateFormat($row["drawing_date"]))
                ->setCellValue('X'.($i+1), $this->_dateFormat($row["schedule_date"]))
                ->setCellValue('Y'.($i+1), $this->_dateFormat($row["schedule_start"]))
                ->setCellValue('Z'.($i+1), $this->_dateFormat($row["schedule_end"]))
                ->setCellValue('AA'.($i+1), $this->_dateFormat($row["already_sent_date"]))
                ->setCellValue('AB'.($i+1), $this->_dateFormat($row["approved_date"]))
                ->setCellValue('AC'.($i+1), $this->_dateFormat($row["canceled_date"]))
                ->setCellValue('AD'.($i+1), $this->_dateFormat($row["rectify_design_date"]))
                ->setCellValue('AE'.($i+1), $this->_dateFormat($row["rectify_illustration_date"]))
                ->setCellValue('AF'.($i+1), $row["design_budget"])
                ->setCellValue('AG'.($i+1), $row["building_budget"])
                ->setCellValue('AH'.($i+1), $row["transportation_budget"])
                ->setCellValue('AI'.($i+1), $row["live_line_budget"])
                ->setCellValue('AJ'.($i+1), $row["right_of_way_budget"])
                ->setCellValue('AK'.($i+1), $row["total_approved"])
                ->setCellValue('AL'.($i+1), $this->_dateFormat($row["record_building_materials_date"]))
                ->setCellValue('AM'.($i+1), $this->_dateFormat($row["get_materials_date"]))
                ->setCellValue('AN'.($i+1), $this->_dateFormat($row["deliver_materials_date"]))
                ->setCellValue('AO'.($i+1), $this->_dateFormat($row["materials_reception_date"]))
                ->setCellValue('AP'.($i+1), $this->_dateFormat($row["assign_to_date"]))
                ->setCellValue('AQ'.($i+1), $row["builder_responsible"])
                ->setCellValue('AR'.($i+1), $row["fiscal_responsible"])
                ->setCellValue('AS'.($i+1), $this->_dateFormat($row["start_date_assigned"]))
                ->setCellValue('AT'.($i+1), $this->_dateFormat($row["end_date_assigned"]))
                ->setCellValue('AU'.($i+1), $row["estimated_time_assigned"])
                ->setCellValue('AV'.($i+1), $this->_dateFormat($row["in_progress_date"]))
                ->setCellValue('AW'.($i+1), $this->_dateFormat($row["completed_date"]))
                ->setCellValue('AX'.($i+1), $this->_dateFormat($row["paused_date"]))
                ->setCellValue('AY'.($i+1), $row["percentage_paused"])
                ->setCellValue('AZ'.($i+1), $this->_dateFormat($row["stopped_date"]))
                ->setCellValue('BA'.($i+1), $row["percentage_stopped"])
                ->setCellValue('BB'.($i+1), $this->_dateFormat($row["as_built_date"]))
                ->setCellValue('BC'.($i+1), $this->_dateFormat($row["conciliation_reception_date"]))
                ->setCellValue('BD'.($i+1), $this->_dateFormat($row["conciliation_shipment_date"]))
                ->setCellValue('BE'.($i+1), $this->_dateFormat($row["cre_return_order_date"]))
                ->setCellValue('BF'.($i+1), $this->_dateFormat($row["project_return_materials_date"]))
                ->setCellValue('BG'.($i+1), $this->_dateFormat($row["payment_order_registered_date"]))
                ->setCellValue('BH'.($i+1), $row["payment_order_registered_order_number"])
                ->setCellValue('BI'.($i+1), $row["payment_order_registered_design_budget"])
                ->setCellValue('BJ'.($i+1), $row["payment_order_registered_transportation_budget"])
                ->setCellValue('BK'.($i+1), $row["payment_order_registered_live_line_budget"])
                ->setCellValue('BL'.($i+1), $row["payment_order_registered_building_budget"])
                ->setCellValue('BM'.($i+1), $row["payment_order_registered_right_of_way_budget"])
                ->setCellValue('BN'.($i+1), $row["payment_order_registered_total_real_budget"])
                ->setCellValue('BO'.($i+1), $row["payment_order_registered_invoice_number"])
                ->setCellValue('BP'.($i+1), $this->_dateFormat($row["payment_order_invoice_sent_date"]))
                ->setCellValue('BQ'.($i+1), $this->_dateFormat($row["payment_order_has_been_settled_date"]));

            $i++;
        }
        $this->_currencyFormatNumber($spreadsheet, $i);
        $spreadsheet->getActiveSheet()->getColumnDimension("O")->setAutoSize(true);
        $this->_adjustColumnToText($spreadsheet);
        $columnList = array("C","AA","AB","BB","BD","BF","BG","BQ");
        $this->_highlightColumns($spreadsheet,$i,$columnList,'FFE699');
        $columnList = array("O","P","Q","R","X","AF","AG","AH","AI","AJ","AK","AP","AQ","AR","AV","AW","BI","BJ","BK","BL","BM","BN","BP");
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
        $spreadsheet->getActiveSheet()->mergeCells('AV1:BB1');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('BC1', "ADMINISTRACION");
        $spreadsheet->getActiveSheet()->getStyle('BC1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('BC1:BF1');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('BG1', "GESTION DE PAGO");
        $spreadsheet->getActiveSheet()->getStyle('BG1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('BG1:BQ1');

        $spreadsheet->getActiveSheet()->getStyle('A1:BQ1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);

    }

    private function _headerColumn($spreadsheet)
    {
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', "CODIGO")
            ->setCellValue('B2', "ESTADO")
            ->setCellValue('C2', "FECHA INGRESO")
            ->setCellValue('D2', "FECHA CARPETA")
            ->setCellValue('E2', "FISCAL DE CRE")
            ->setCellValue('F2', "SISTEMA")
            ->setCellValue('G2', "ADMINISTRADO POR")
            ->setCellValue('H2', "DIRECCION")
            ->setCellValue('I2', "PUNTOS")
            ->setCellValue('J2', "DISTANCIA")
            ->setCellValue('K2', "NIVEL DE CALIDAD")
            ->setCellValue('L2', "POSICION PRESUPUESTARIA")
            ->setCellValue('M2', "FECHA COMPLETADO DE DISEÑO")
            ->setCellValue('N2', "FECHA COMPLETADO DE CONSTRUCCION")
            ->setCellValue('O2', "FECHA DE ESTAQUEADO")
            ->setCellValue('P2', "RESPONSABLES DE ESTAQUEADO")
            ->setCellValue('Q2', "PUNTOS DIGITALIZADOS")
            ->setCellValue('R2', "DISTANCIA DIGITALIZADA")
            ->setCellValue('S2', "PUNTOS RECTIFICADOS EN DIGITALIZACION")
            ->setCellValue('T2', "DISTANCIA RECTIFICADA EN DIGITALIZACION")
            ->setCellValue('U2', "NO FACTIBLE - DEVUELTO A CRE")
            ->setCellValue('V2', "FECHA DIGITALIZACION")
            ->setCellValue('W2', "FECHA DIBUJO")
            ->setCellValue('X2', "FECHA DEFINICION DE CRONOGRAMA")
            ->setCellValue('Y2', "FECHA CRONOGRAMA INICIO")
            ->setCellValue('Z2', "FECHA CRONOGRAMA FIN")
            ->setCellValue('AA2', "FECHA PROYECTO ENVIADO A CRE")
            ->setCellValue('AB2', "FECHA APROBACION")
            ->setCellValue('AC2', "FECHA CANCELADO")
            ->setCellValue('AD2', "FECHA RECTIFICACION DISEÑO")
            ->setCellValue('AE2', "FECHA RECTIFICACION ILUSTRACION")
            ->setCellValue('AF2', "IMPORTE DISEÑO")
            ->setCellValue('AG2', "IMPORTE CONSTRUCCION")
            ->setCellValue('AH2', "IMPORTE TRANSPORTE")
            ->setCellValue('AI2', "LINEA VIVA")
            ->setCellValue('AJ2', "DERECHO DE VIA")
            ->setCellValue('AK2', "TOTAL IMPORTE APROBADO")
            ->setCellValue('AL2', "FECHA GRABADO DE MATERIALES")
            ->setCellValue('AM2', "FECHA RETIRO DE MATERIALES")
            ->setCellValue('AN2', "FECHA MATERIALES A CONSTRUCCION")
            ->setCellValue('AO2', "FECHA RECEPCION DE MATERIALES DE CONSTR.")
            ->setCellValue('AP2', "FECHA ASIGNACION DE RESPONSABLES CONSTR.")
            ->setCellValue('AQ2', "RESPONSABLE CONSTRUC.")
            ->setCellValue('AR2', "RESPONSABLE FISCAL")
            ->setCellValue('AS2', "INICIO DE OBRA EN ASIGNACION")
            ->setCellValue('AT2', "FIN DE OBRA EN ASIGNACION")
            ->setCellValue('AU2', "DIAS ESTIMADOS EN ASIGNACION")
            ->setCellValue('AV2', "FECHA INICIO DE CONSTRUC.")
            ->setCellValue('AW2', "CONSTRUCCION COMPLETADA")
            ->setCellValue('AX2', "FECHA DE PAUSA DE CONSTRUC")
            ->setCellValue('AY2', "% DE PAUSA")
            ->setCellValue('AZ2', "FECHA DE CONSTRUCCION DETENIDA")
            ->setCellValue('BA2', "% DE CONTRUC. DETENIDA")
            ->setCellValue('BB2', "FECHA DE ENVIO DE AS BUILT")
            ->setCellValue('BC2', "FECHA RECEPCION DE CONCILIACION")
            ->setCellValue('BD2', "FECHA ENVIO DE CONCILIACION")
            ->setCellValue('BE2', "ORDEN DE DEVOLUCION DE MATERIALES")
            ->setCellValue('BF2', "CONFIRMACION DE DEVOLUCION DE MATERIALES")
            ->setCellValue('BG2', "FECHA DE REGSITRO DE ORDEN DE PAGO")
            ->setCellValue('BH2', "NRO ORDEN DE PAGO")
            ->setCellValue('BI2', "IMPORTE REAL - DISEÑO")
            ->setCellValue('BJ2', "IMPORTE REAL - TRANSPORTE")
            ->setCellValue('BK2', "IMPORTE REAL - LINEA VIVA")
            ->setCellValue('BL2', "IMPORTE REAL - CONSTRUCCION")
            ->setCellValue('BM2', "IMPORTE REAL - DERECHO DE VIA")
            ->setCellValue('BN2', "IMPORTE REAL - TOTAL")
            ->setCellValue('BO2', "NRO FACTURA")
            ->setCellValue('BP2', "FECHA DE ENVIO DE FACTURA")
            ->setCellValue('BQ2', "FECHA DE LIQUIDACION");
        $spreadsheet->getActiveSheet()->getStyle('A2:BQ2')->getAlignment()->setWrapText(true);
    }

    private function _dateFormat($date)
    {
        $response = "";
        if(isset($date) && $date != "" && $date != "0000-00-00 00:00:00")
        {
            $response = $date;
            $response = DateTime::createFromFormat('Y-m-d H:i:s', $response);
            $response = date_format($response, 'd/m/Y');
        }
        return $response;
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
            $spreadsheet->getActiveSheet()->getStyle($column.'3:'.$column.$totalRows)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        }

    }
}