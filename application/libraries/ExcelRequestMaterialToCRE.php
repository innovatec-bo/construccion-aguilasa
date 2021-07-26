<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelRequestMaterialToCRE
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
        $topLeftText = ['font' => ['bold' => true]];
        $topCenterText = [
            'font' => ['bold' => true,'underline'=> true],
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
            'font' => ['bold' => true],
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

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'SEREBO S-40/2019');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', 'REF: MATERIAL ADICIONAL');
        $spreadsheet->getActiveSheet()->getStyle('A1:A2')->applyFromArray($topLeftText);
        $spreadsheet->getActiveSheet()->mergeCells('A1:B1');
        $spreadsheet->getActiveSheet()->mergeCells('A2:B2');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A8', 'LISTA DE MATERIALES');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A9', 'GRAFO '.$this->_projectWorkflow->approved_graph_number);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A10', strtoupper($this->_projectWorkflow->code_pro));
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A11', strtoupper($this->_projectWorkflow->cre_fiscal_pro));
        $spreadsheet->getActiveSheet()->mergeCells('A8:I8');
        $spreadsheet->getActiveSheet()->mergeCells('A9:I9');
        $spreadsheet->getActiveSheet()->mergeCells('A10:I10');
        $spreadsheet->getActiveSheet()->mergeCells('A11:I11');
        $spreadsheet->getActiveSheet()->getStyle('A8:I11')->applyFromArray($topCenterText);

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(FCPATH.'assets/images/sereboFullLogo.png');
        $drawing->setHeight(100);
        $drawing->setCoordinates('G1');
        $drawing->setWorksheet($spreadsheet->getActiveSheet());


        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A13', "ITEM")
            ->setCellValue('B13', "DESCRIPCION")
            ->setCellValue('C13', "UNIDAD")
            ->setCellValue('D13', "CODIGO")
            ->setCellValue('E13', "CANTIDAD")
            ->setCellValue('F13', "TENSION")
            ->setCellValue('G13', "RESERVA")
            ->setCellValue('H13', "PUNTO")
            ->setCellValue('I13', "OBSERV./MOTIVO DEL AD.");
        $spreadsheet->getActiveSheet()->getStyle('A13:I13')->applyFromArray($headerStyleArray);
        $counter = 1;
        $i = 14;
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
                ->setCellValue('B'.$i, $row["material_description"])
                ->setCellValue('C'.$i, $row["material_unit_of_measurement"])
                ->setCellValue('D'.$i, $row['material_code'])
                ->setCellValue('E'.$i, $row['material_quantity'])
                ->setCellValue('F'.$i, $row['material_tension'])
                ->setCellValue('G'.$i, $this->_projectWorkflow->approved_reservation_number)
                ->setCellValue('H'.$i, $row['material_request_cre_pto'])
                ->setCellValue('I'.$i, $row['material_request_cre_detail']);
                if(isset($this->_materialList[$counter]) && $this->_materialList[$counter]['material_request_cre_pto'] != $currentPoints)
                {
                    $spreadsheet->getActiveSheet()->mergeCells('H'.$currentPointsIndex.':H'.$i);
                    $spreadsheet->getActiveSheet()->getStyle('H'.$currentPointsIndex.':H'.$i)->applyFromArray($reservationText);
                    $currentPointsIndex = $i+1;
                }
                if(isset($this->_materialList[$counter]) && $this->_materialList[$counter]['material_request_cre_detail'] != $currentCreDetail)
                {
                    $spreadsheet->getActiveSheet()->mergeCells('I'.$currentDetailIndex.':I'.$i);
                    $spreadsheet->getActiveSheet()->getStyle('I'.$currentDetailIndex.':I'.$i)->applyFromArray($reservationText);
                    $currentDetailIndex = $i+1;
                }
            $i++;
            $counter++;
        }
        $spreadsheet->getActiveSheet()->mergeCells('G14:G'.($i-1));
        $spreadsheet->getActiveSheet()->getStyle('G14:G'.($i-1))->applyFromArray($reservationText);
        
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:I'.$i)->applyFromArray($rowsStyleArray);
        $spreadsheet->getActiveSheet()->getStyle('A13:I'.($i-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.($i+4), ucwords($this->_sessionUser->fullName));
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.($i+5), 'DEPARTAMENTO REDES');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.($i+6), date('m/d/Y'));
        $spreadsheet->getActiveSheet()->mergeCells('A'.($i+4).':I'.($i+4));
        $spreadsheet->getActiveSheet()->mergeCells('A'.($i+5).':I'.($i+5));
        $spreadsheet->getActiveSheet()->mergeCells('A'.($i+6).':I'.($i+6));
        $spreadsheet->getActiveSheet()->getStyle('A'.($i+4).':I'.($i+6))->applyFromArray($bottomCenterText);

        for($i = 1; $i < 300; $i++)
        {
            $spreadsheet->getActiveSheet()->getRowDimension($i)->setRowHeight(20);
        }
        $spreadsheet->getActiveSheet()->getSheetView()->setZoomScale(70);
        return $spreadsheet;
    }
}
