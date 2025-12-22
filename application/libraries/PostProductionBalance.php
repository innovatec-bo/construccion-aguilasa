<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PostProductionBalance
{
    private $_sessionUser;
    private $_months;

    public function __construct($sessionUser)
    {
        $this->_sessionUser = $sessionUser;
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
        // $list = Model_project::productionGeneralSummary();
        // $list = Model_project::getProductivityBaseReport(['from' => '2025-01-01 00:00:00', 'to' => '2025-01-31 23:59:59']);
        $postProductionStatus = Model_project_status::postProductionStatus();
        $keywords = "";
        foreach ($postProductionStatus as $status) 
        {
            $keywords .= $status->getKeyword().",";
        }
        $keywords = substr($keywords,0,-1);
        
        $list = Model_project::getProductivityBaseReport();
        $paginationHandler = new WorkflowPaginationHandler(4000,0);
		$paginationHandler->setColumnsToShow(['status_name_pst','keyword_pst','project_current_budget','production_total_bs','project_current_design_budget']);
        $paginationHandler->setAdditionalParameters(['status-keyword'=>$keywords]);
		$response = $paginationHandler->getAll();
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Saldos Post-Producción")
            ->setSubject("Proyectos y saldos de producción")
            ->setDescription("Detalle sobre proyectos que pasaron la etapa de producción y tienen saldos en sus manos de obra")
            ->setKeywords("proyectos, saldos")
            ->setCategory("Reporte");
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());
        
        $spreadsheet = $this->_projects($spreadsheet, $response);

        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Saldos Post-Produccion - '.date('Y.m.d.H.i.s').'.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    private function _projects($spreadsheet, $list)
    {
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

        $spreadsheet->getActiveSheet()->getRowDimension('0')->setRowHeight(18);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', "COD")
            ->setCellValue('B1', "ESTADO")
            ->setCellValue('C1', "MANO DE OBRA")
            ->setCellValue('D1', "PRODUCIDO")
            ->setCellValue('E1', "SALDO");

        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->applyFromArray($headerStyleArray);
        $counter = 1;
        $i = 1;

        foreach ($list as $workflow)
        {
            $workflow = (array)$workflow;
            $code = $workflow['code_pro'];
            $status = $workflow['status_name_pst'];
            $currentBudget = floatval($workflow['project_current_budget']);
            $production = floatval($workflow['production_total_bs']) + floatval($workflow['project_current_design_budget']);
            $balance = round($currentBudget - $production,2);
            if ($balance > 0) 
            {
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+1), $code)
                ->setCellValue('B'.($i+1), $status)
                ->setCellValue('C'.($i+1), $currentBudget)
                ->setCellValue('D'.($i+1), $production)
                ->setCellValue('E'.($i+1), $balance);
                //Currency format
                $spreadsheet->getActiveSheet()->getStyle('C'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                $spreadsheet->getActiveSheet()->getStyle('D'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                $spreadsheet->getActiveSheet()->getStyle('E'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                $i++;
                $counter++;
            }
        }
        
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1:E'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        return $spreadsheet;
    }
}
