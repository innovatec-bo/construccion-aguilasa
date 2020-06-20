<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelProjectMasterDetail
{
    private $_sessionUser;
    private $_projectId;
    private $_logDateRange;
    private $_months;

    CONST FORM_QUANTITY = 25;

    public function __construct($sessionUser, $logDateRange = array())
    {
        $this->_sessionUser = $sessionUser;
        $this->_logDateRange = $logDateRange;
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
        $list = Model_project::productionGeneralSummary($this->_logDateRange);

        $date = date_create_from_format('Y-m-d H:i:s', $this->_logDateRange['from']);
        $month = date_format($date, 'F');
        $month = $this->_months[strtolower($month)];
        $year = date_format($date, 'Y');

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Reporte de importes")
            ->setSubject("Importes y excedentes")
            ->setDescription("Contiene una lista de proyectos con su detalle de produccion y presupuesto destinado")
            ->setKeywords("reporte produccion proyectos")
            ->setCategory("Reporte");
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());
        
        // echo"<pre>";var_dump($laborCostMasterDetail);exit;
        $spreadsheet = $this->_projects($spreadsheet, $list);

        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Costo y produccion actual - '.$month.' del '.$year.'.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    private function _projects($spreadsheet, $list)
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

        $date = date_create_from_format('Y-m-d H:i:s', $this->_logDateRange['from']);
        $month = date_format($date, 'F');
        $month = $this->_months[strtolower($month)];
        $year = date_format($date, 'Y');

        $manPowerWorkSheet = $spreadsheet->createSheet(0);
        $manPowerWorkSheet->setTitle('PROYECTOS');

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'DETALLE MAESTRO DE IMPORTES - '.strtoupper($month).' DEL '.$year);
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $spreadsheet->getActiveSheet()->getStyle('A1:I1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('A1:I1');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', "#")
            ->setCellValue('B2', "CODIGO")
            ->setCellValue('C2', "ESTADO")
            ->setCellValue('D2', "FISCAL\nRESPONSABLE")
            ->setCellValue('E2', "CONSTRUCTOR\nRESPONSABLE")
            ->setCellValue('F2', "PRODUCTION\nACTUAL")
            ->setCellValue('G2', "PRODUCCION\nACTUAL + ".html_entity_decode("DISE&Ntilde;O"))
            ->setCellValue('H2', "PROYECTO")
            ->setCellValue('I2', "DIFERENCIA\nH2 - G2");

        $spreadsheet->getActiveSheet()->getStyle('A2:I2')->applyFromArray($headerStyleArray);
        $counter = 1;
        $i = 2;
        // $workflowDetail = array();
        foreach ($list as $row)
        {
			$row = (array) $row;
            // echo"<pre>";var_dump($row);exit;
			$projectBudget = $row['importe_aprobado'];
            $projectDesign = $row['design_prb'];
			if(!is_null($row['importe_real']) && $row['importe_real'] > 0)
            {
				$projectBudget = $row['importe_real'];
                $projectDesign = $row['design_reb'];
            }

            $currentProduction = $row['produccion_actual'] + $projectDesign;
            $diff = $projectBudget - $currentProduction;
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+1), $counter)
                ->setCellValue('B'.($i+1), $row["codigo"])
                ->setCellValue('C'.($i+1), $row["estado"])
                ->setCellValue('D'.($i+1), $row["fiscal_responsible"])
                ->setCellValue('E'.($i+1), $row["builder_responsible"])
                ->setCellValue('F'.($i+1), $row['produccion_actual'])
                ->setCellValue('G'.($i+1), $currentProduction)
                ->setCellValue('H'.($i+1), $projectBudget)
                ->setCellValue('I'.($i+1), $diff);
                //Currency format
           $spreadsheet->getActiveSheet()->getStyle('F'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
           $spreadsheet->getActiveSheet()->getStyle('G'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
           $spreadsheet->getActiveSheet()->getStyle('H'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
           $spreadsheet->getActiveSheet()->getStyle('I'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
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

        $spreadsheet->getActiveSheet()->getStyle('A1:I'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        return $spreadsheet;
    }
}
