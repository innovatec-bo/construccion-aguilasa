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

        $titleStyleArray = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];

        $headerStyleArray = [
            'font' => ['bold' => true],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];

        $projectWorkflow = Model_project::getWorkflowDetail();
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Workflow report")
            ->setSubject("Project report")
            ->setDescription("This report allow see all workflow form all projects on system. Report generated on ".date("Y-m-d H:i:s"))
            ->setKeywords("report workflow projects")
            ->setCategory("Report");

        $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('B1', "INGRESO DE PROYECTOS");
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('B1:M1');

        $spreadsheet->setActiveSheetIndex(0)

            ->setCellValue('A2', "ESTADO")
            ->setCellValue('B2', "CODIGO")
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
            ->setCellValue('Z2', "FECHA PROYECTO ENVIADO A CRE")
            ->setCellValue('AA2', "FECHA APROBACION")
            ->setCellValue('AB2', "FECHA CANCELADO")
            ->setCellValue('AC2', "FECHA RECTIFICACION DISEÑO")
            ->setCellValue('AD2', "FECHA RECTIFICACION ILUSTRACION")
            ->setCellValue('AE2', "IMPORTE DISEÑO")
            ->setCellValue('AF2', "IMPORTE CONSTRUCCION")
            ->setCellValue('AG2', "IMPORTE TRANSPORTE")
            ->setCellValue('AH2', "LINEA VIVA")
            ->setCellValue('AI2', "DERECHO DE VIA")
            ->setCellValue('AJ2', "TOTAL IMPORTE APROBADO")
            ->setCellValue('AK2', "FECHA GRABADO DE MATERIALES")
            ->setCellValue('AL2', "FECHA RETIRO DE MATERIALES")
            ->setCellValue('AM2', "FECHA MATERIALES A CONSTRUCCION")
            ->setCellValue('AN2', "FECHA RECEPCION DE MATERIALES DE CONSTR.")
            ->setCellValue('AO2', "FECHA ASIGNACION DE RESPONSABLES CONSTR.")
            ->setCellValue('AP2', "RESPONSABLE CONSTRUC.")
            ->setCellValue('AQ2', "RESPONSABLE FISCAL")
            ->setCellValue('AR2', "INICIO DE OBRA EN ASIGNACION")
            ->setCellValue('AS2', "FIN DE OBRA EN ASIGNACION")
            ->setCellValue('AT2', "DIAS ESTIMADOS EN ASIGNACION")
            ->setCellValue('AU2', "FECHA INICIO DE CONSTRUC.")
            ->setCellValue('AV2', "CONSTRUCCION COMPLETADA")
            ->setCellValue('AW2', "FECHA DE PAUSA DE CONSTRUC")
            ->setCellValue('AX2', "% DE PAUSA")
            ->setCellValue('AY2', "FECHA DE CONSTRUCCION DETENIDA")
            ->setCellValue('AZ2', "% DE CONTRUC. DETENIDA")
            ->setCellValue('BA2', "FECHA DE ENVIO DE AS BUILT")
            ->setCellValue('BB2', "FECHA RECEPCION DE CONCILIACION")
            ->setCellValue('BC2', "FECHA ENVIO DE CONCILIACION")
            ->setCellValue('BD2', "ORDEN DE DEVOLUCION DE MATERIALES")
            ->setCellValue('BE2', "CONFIRMACION DE DEVOLUCION DE MATERIALES")
            ->setCellValue('BF2', "FECHA DE REGSITRO DE ORDEN DE PAGO")
            ->setCellValue('BG2', "NRO ORDEN DE PAGO")
            ->setCellValue('BH2', "IMPORTE REAL - DISEÑO")
            ->setCellValue('BI2', "IMPORTE REAL - TRANSPORTE")
            ->setCellValue('BJ2', "IMPORTE REAL - LINEA VIVA")
            ->setCellValue('BK2', "IMPORTE REAL - CONSTRUCCION")
            ->setCellValue('BL2', "IMPORTE REAL - DERECHO DE VIA")
            ->setCellValue('BM2', "IMPORTE REAL - TOTAL")
            ->setCellValue('BN2', "NRO FACTURA")
            ->setCellValue('BO2', "FECHA DE ENVIO DE FACTURA")
            ->setCellValue('BP2', "FECHA DE LIQUIDACION");
        $spreadsheet->getActiveSheet()->getStyle('A2:N2')->applyFromArray($headerStyleArray);

        $i = 2;
        foreach ($projectWorkflow as $row)
        {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+1), $row["status_pro"])
                ->setCellValue('B'.($i+1), $row["code_pro"])
                ->setCellValue('C'.($i+1), $row["entry_date_pro"])
                ->setCellValue('D'.($i+1), $row["folder_date_pro"])
                ->setCellValue('E'.($i+1), $row["cre_fiscal_pro"])
                ->setCellValue('F'.($i+1), $row["system_pro"])
                ->setCellValue('G'.($i+1), $row["management_by_pro"])
                ->setCellValue('H'.($i+1), $row["address_pro"])
                ->setCellValue('I'.($i+1), $row["points_pro"])
                ->setCellValue('J'.($i+1), $row["distance_pro"])
                ->setCellValue('K'.($i+1), $row["quality_level_pro"])
                ->setCellValue('L'.($i+1), $row["budgetary_position_pro"])
                ->setCellValue('M'.($i+1), $row["cre_design_completion_date_pro"])
                ->setCellValue('N'.($i+1), $row["cre_building_completion_date_pro"]);
            $i++;
        }
        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="projects_workflow.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
	}
}