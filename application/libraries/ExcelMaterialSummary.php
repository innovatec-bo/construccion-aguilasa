<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelMaterialSummary
{
    private $_sessionUser;
    private $_additionalParameters;

    public function __construct($sessionUser)
    {
        $this->_sessionUser = $sessionUser;
        $this->_additionalParameters = [];
    }

    function getReport()
    {
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Resumen de materiales")
            ->setSubject("Detalle de materiales y sus existencias en SEREBO y CRE")
            ->setDescription("Contiene un listado de todos los materiales con sus respectivos detalles acerca de uso en los proyectos.")
            ->setKeywords("materiales resumen")
            ->setCategory("Reporte");
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());

		$paginationHandler = new MaterialSummaryPaginationHandler(50000, 0);
		$paginationHandler->setAdditionalParameters($this->_additionalParameters);
		$list = $paginationHandler->getAll();
        $spreadsheet = $this->_summary($spreadsheet, $list);
    
        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Resumen de materiales - '.date("d.m.y h.i A").'.xls"');
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
        $spreadsheet->getActiveSheet()->getStyle('A1:H1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('A1:H1');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', "#")
            ->setCellValue('B2', "CODIGO")
            ->setCellValue('C2', "DESCRIPCION")
            ->setCellValue('D2', "PROYECTO")
            ->setCellValue('E2', "FISCAL")
            ->setCellValue('F2', "CANTIDAD\nCOMPROMETIDA")
            ->setCellValue('G2', "RETIRADO\nDE CRE")
            ->setCellValue('H2', "PENDIENTE POR\nRETIRAR DE CRE");
        $spreadsheet->getActiveSheet()->getStyle('A2:H2')->applyFromArray($headerStyleArray);
        $counter = 1;
        $i = 2;
        foreach ($data as $row)
        {
            $row = (array)$row;
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+1), $counter)
                ->setCellValue('B'.($i+1), $row["material_code"])
                ->setCellValue('C'.($i+1), $row["material_description"])
                ->setCellValue('D'.($i+1), $row['project_code'])
                ->setCellValue('E'.($i+1), $row['fiscal_responsible'])
                ->setCellValue('F'.($i+1), $row['quantity_assigned_materials'])
                ->setCellValue('G'.($i+1), $row['quantity_picked_up_from_cre'])
                ->setCellValue('H'.($i+1), $row['pending_material_in_cre']);
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
        $spreadsheet->getActiveSheet()->getStyle('A1:H'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        return $spreadsheet;
    }

    public function setAdditionalParameters(array $additionalParameters = [])
    {
        $this->_additionalParameters = $additionalParameters;
    }
}
