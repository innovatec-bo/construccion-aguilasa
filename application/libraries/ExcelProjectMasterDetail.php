<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Reader\Xls as XlsReader;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelProjectMasterDetail
{
    private $_sessionUser;
    private $_projectId;

    CONST FORM_QUANTITY = 25;

    public function __construct($sessionUser)
    {
        $this->_sessionUser = $sessionUser;
    }

    function getReport()
    {
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
        $list = Model_project::productionGeneralSummary();

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
        header('Content-Disposition: attachment;filename="Costo y produccion actual.xls"');
        header('Cache-Control: max-age=0');

        // $writer = new Xlsx($spreadsheet);
        // $writer->save('php://output');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    private function _projects($spreadsheet, $workflowDetail)
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

        $manPowerWorkSheet = $spreadsheet->createSheet(0);
        $manPowerWorkSheet->setTitle('PROYECTOS');

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'DETALLE MAESTRO DE IMPORTES');
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('A1:F1');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', "#")
            ->setCellValue('B2', "CODIGO")
            ->setCellValue('C2', "ESTADO")
            ->setCellValue('D2', "PRODUCCION\nACTUAL + ".html_entity_decode("DISE&Ntilde;O"))
            ->setCellValue('E2', "PROYECTO")
            ->setCellValue('F2', "DIFERENCIA")
		;
        $spreadsheet->getActiveSheet()->getStyle('A2:F2')->applyFromArray($headerStyleArray);
        $counter = 1;
        $i = 2;
        // $workflowDetail = array();
        foreach ($workflowDetail as $row)
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
                ->setCellValue('D'.($i+1), $currentProduction)
                ->setCellValue('E'.($i+1), $projectBudget)
                ->setCellValue('F'.($i+1), $diff);
                //Currency format
           $spreadsheet->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
           $spreadsheet->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
           $spreadsheet->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
            $i++;
            $counter++;
            
        }
        
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
//        $spreadsheet->getActiveSheet()->getStyle('E2:E'.$i)->getAlignment()->setWrapText(true);
//        $spreadsheet->getActiveSheet()->getStyle('B2:B'.$i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
//        $spreadsheet->getActiveSheet()->getStyle('D2:D'.$i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
//        $spreadsheet->getActiveSheet()->getStyle('F2:F'.$i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
//        $spreadsheet->getActiveSheet()->getColumnDimension("E")->setWidth(30);
        $spreadsheet->getActiveSheet()->getStyle('A1:F'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
        return $spreadsheet;
    }
}
