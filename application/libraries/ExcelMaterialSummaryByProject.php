<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelMaterialSummaryByProject
{
    private $_sessionUser;
    private $_additionalParameters;

    public function __construct($sessionUser)
    {
        $this->_sessionUser = $sessionUser;
        $this->_additionalParameters = [
            ''
        ];
    }

    function getReport()
    {
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Resumen de materiales por proyecto")
            ->setSubject("Detalle de materiales por proyecto")
            ->setDescription("Contiene un listado de todos los materiales por proyecto.")
            ->setKeywords("materiales resumen por proyecto")
            ->setCategory("Reporte");
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());

		$paginationHandler = new MaterialSummaryPaginationHandler(50000, 0);
		$paginationHandler->setAdditionalParameters($this->_additionalParameters);
        $list = $paginationHandler->getAll();
        $list = $this->_groupData($list);
        // dd($list);
        $spreadsheet = $this->_summary($spreadsheet, $list);
    
        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Resumen de materiales por proyecto - '.date("d.m.y h.i A").'.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    private function _summary($spreadsheet, $data)
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
        $manPowerWorkSheet->setTitle('Resumen de materiales');

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'Resumen de materiales');
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('A1:E1');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', "#")
            ->setCellValue('B2', "PROYECTO")
            ->setCellValue('C2', "FISCAL")
            ->setCellValue('D2', "NRO. RESERVA")
            ->setCellValue('E2', "CANTIDAD\nDE ITEMS");
        $spreadsheet->getActiveSheet()->getStyle('A2:E2')->applyFromArray($headerStyleArray);
        $counter = 1;
        $i = 2;
        foreach ($data as $row)
        {
            $row = (array)$row;
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+1), $counter)
                ->setCellValue('B'.($i+1), $row["project_code"])
                ->setCellValue('C'.($i+1), $row["fiscal_responsible"])
                ->setCellValue('D'.($i+1), $row['summary_reservation_number'])
                ->setCellValue('E'.($i+1), $row['global_quantity']);
            $i++;
            $counter++;
        }
        
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:E'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        return $spreadsheet;
    }

    public function setAdditionalParameters(array $additionalParameters = [])
    {
        $this->_additionalParameters = $additionalParameters;
    }

    private function _groupData($data)
    {
        $dataGrouped = [];
        foreach ($data as $row) 
        {
            $row = (array)$row;
            if(!isset($dataGrouped[$row['project_code']]))
            {
                $dataGrouped[$row['project_code']] = $row;
                $dataGrouped[$row['project_code']]['global_quantity'] = 0;
            }
            $dataGrouped[$row['project_code']]['global_quantity'] += $row['pending_material_in_cre'];
        }
        return $dataGrouped;
    }
}
