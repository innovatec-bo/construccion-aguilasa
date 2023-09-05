<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelRequestMaterialToCREV2
{
    private object $_sessionUser;
    private int $_summaryId;
    private array $_materialSummary;
    private array $_materialList;
    private object $_projectWorkflow;

    public function __construct(object $sessionUser, int $summaryId)
    {
        $this->_sessionUser = $sessionUser;
        $this->_summaryId = $summaryId;
    }

    function getReport()
    {
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(16);
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Solicitud de materiales a CRE")
            ->setSubject("Solicitud de materiales a CRE")
            ->setDescription("Contiene un de la Solicitud de materiales a CRE.")
            ->setKeywords("solicitud materiales cre")
            ->setCategory("Reporte");
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());

		$this->_materialSummary = Model_material_summary::getMasterDetailByListId($this->_summaryId);
		$this->_materialList = Model_project_material::getBySummaryId($this->_summaryId);	

        $wokflowPaginationHandler = new WorkflowPaginationHandler(1);
        $wokflowPaginationHandler->setAdditionalParameters(['id-list'=>$this->_materialSummary['project_id']]);
        $wokflowPaginationHandler->setColumnsToShow(['approved_reservation_number','approved_graph_number','cre_fiscal_pro']);
        $this->_projectWorkflow = $wokflowPaginationHandler->getAll()[0];
        // dd($this->_projectWorkflow, $this->_materialSummary, $this->_materialList);
        $spreadsheet = $this->_summary($spreadsheet);
    
        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$this->_projectWorkflow->code_pro.' ADICIONAL - ('.strtoupper($this->_projectWorkflow->cre_fiscal_pro).') '.date("d.m.y h.i A").'.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');  
    }

    private function _summary($spreadsheet)
    {
        $topCenterText = [
            'font' => ['bold' => true,'underline'=> true, 'size' => '22'],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $bottomCenterText = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $reservationText = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $titleStyleArray = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];

        $headerStyleArray = [
            'font' => ['bold' => true, 'size' => '22'],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $rowsStyleArray = [
            'font' => ['size' => '14']
        ];

        $manPowerWorkSheet = $spreadsheet->createSheet(0);
        $manPowerWorkSheet->setTitle(strtoupper($this->_projectWorkflow->code_pro));

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'REF: MATERIAL ADICIONAL');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A6', 'Proyecto '.strtoupper($this->_projectWorkflow->code_pro));
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A7', 'Grafo '.$this->_projectWorkflow->approved_graph_number);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A8', 'Reserva '.$this->_projectWorkflow->approved_reservation_number);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A9', 'Fiscal '.strtoupper($this->_projectWorkflow->cre_fiscal_pro));
        $spreadsheet->getActiveSheet()->mergeCells('A5:H5');
        $spreadsheet->getActiveSheet()->mergeCells('A6:H6');
        $spreadsheet->getActiveSheet()->mergeCells('A7:H7');
        $spreadsheet->getActiveSheet()->mergeCells('A8:H8');
        $spreadsheet->getActiveSheet()->mergeCells('A9:H9');
        $spreadsheet->getActiveSheet()->getStyle('A5:H9')->applyFromArray($topCenterText);

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Serebo-Logo');
        $drawing->setDescription('Serebo-Logo');
        $drawing->setPath(FCPATH.'assets/images/sereboFullLogo.png');
        $drawing->setHeight(150);
        $drawing->setOffsetX(0);
        $drawing->setOffsetY(80);
        $drawing->setCoordinates('C2');
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('CRE-Logo');
        $drawing->setDescription('CRE-Logo');
        $drawing->setPath(FCPATH.'assets/images/logo-cre.png');
        $drawing->setHeight(250);
        $drawing->setCoordinates('H2');
        $drawing->setOffsetX(120);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());


        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A10', "ITEM")
            ->setCellValue('B10', "Material")
            ->setCellValue('C10', "TEXTO BREVE DEL MATERIAL")
            ->setCellValue('D10', "CTD. NEC.")
            ->setCellValue('E10', "UNIDAD")
            ->setCellValue('F10', "TENSION")
            ->setCellValue('G10', "PUNTO")
            ->setCellValue('H10', "MOTIVO DEL ADICIONAL");
        $spreadsheet->getActiveSheet()->getStyle('A10:H10')->applyFromArray($headerStyleArray);
        $counter = 1;
        $i = 11;
        $currentPoints = "";
        $currentCreDetail = "";
        $currentPointsIndex = $i;
        $currentDetailIndex = $i;
        foreach ($this->_materialList as $row)
        {
            $currentPoints = $row['material_request_cre_pto'];
            $currentCreDetail = $row['material_request_cre_detail'];
            
            $row = (array)$row;
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $counter)
                ->setCellValue('B'.$i, $row['material_code'])
                ->setCellValue('C'.$i, $row["material_description"])
                ->setCellValue('D'.$i, $row['material_quantity'])
                ->setCellValue('E'.$i, $row["material_unit_of_measurement"])
                ->setCellValue('F'.$i, $row['material_tension'])
                ->setCellValue('G'.$i, $row['material_request_cre_pto'])
                ->setCellValue('H'.$i, $row['material_request_cre_detail']);
            $i++;
            $counter++;
        }
        
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(7);//10=1.24 in
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(36);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(11);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(9);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(49);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(1);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(2);
        // $spreadsheet->getActiveSheet()->getStyle('A1:H'.$i)->applyFromArray($rowsStyleArray);
        $spreadsheet->getActiveSheet()->getStyle('A10:H'.($i-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.($i+4), ucwords($this->_sessionUser->fullName));
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.($i+5), 'DEPARTAMENTO REDES');

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.($i+4), ucwords($this->_projectWorkflow->cre_fiscal_pro));
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.($i+5), 'FISCAL DE CRE');
        $spreadsheet->getActiveSheet()->mergeCells('E'.($i+4).':G'.($i+4));
        $spreadsheet->getActiveSheet()->mergeCells('E'.($i+5).':G'.($i+5));
        $spreadsheet->getActiveSheet()->getRowDimension(($i+4))->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension(($i+5))->setRowHeight(20);

        $spreadsheet->getActiveSheet()->getStyle('C'.($i+4).':G'.($i+5))->applyFromArray($bottomCenterText);
        for($j = 1; $j <= ($i+4); $j++)
        {
            $spreadsheet->getActiveSheet()->getRowDimension($j)->setRowHeight(30);
        }
        
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(105);
        $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(105);
        $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(105);
        $spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(105);
        $spreadsheet->getActiveSheet()->getRowDimension('5')->setRowHeight(55);
        $spreadsheet->getActiveSheet()->getRowDimension('6')->setRowHeight(35);
        $spreadsheet->getActiveSheet()->getRowDimension('7')->setRowHeight(35);
        $spreadsheet->getActiveSheet()->getRowDimension('8')->setRowHeight(35);
        $spreadsheet->getActiveSheet()->getRowDimension('9')->setRowHeight(35);
        $spreadsheet->getActiveSheet()->getSheetView()->setZoomScale(70);
        return $spreadsheet;
    }
}
