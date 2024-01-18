<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelAllProjectsLog
{
    private $_sessionUser;
    private string $_fileName;

    public function __construct($sessionUser)
    {
        $this->_sessionUser = $sessionUser;
    }

    function getReport($save = FALSE) : void
    {
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
        $list = Model_project::allProjectsLog();

        $this->_fileName = 'Log de proyectos - '.date("d.m.y h.i A");
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Log de proyectos")
            ->setSubject("Historial de estados")
            ->setDescription("Contiene un listado de todos los estados por los que ha pasado un proyecto")
            ->setKeywords("reporte log proyectos historial")
            ->setCategory("Reporte");
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());
        $spreadsheet = $this->_projects($spreadsheet, $list);

        if($save)
		{
			try
			{
				$writer = IOFactory::createWriter($spreadsheet, 'Xls');
				$writer->save(FCPATH.'assets/'.$this->_fileName.'.xls');
			}
			catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e)
			{
				exit($e->getMessage());
			}
		}
        else
        {
            // redirect output to client browser
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$this->_fileName.'.xls"');
            header('Cache-Control: max-age=0');

            $writer = IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
        }
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
        $manPowerWorkSheet->setTitle('LOG DE PROYECTOS');

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'Log de Proyectos');
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $spreadsheet->getActiveSheet()->getStyle('A1:G1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('A1:G1');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', "#")
            ->setCellValue('B2', "CODIGO")
            ->setCellValue('C2', "FECHA")
            ->setCellValue('D2', "ESTADO")
            ->setCellValue('E2', "FECHA DEL SISTEMA")
            ->setCellValue('F2', "USUARIO")
            ->setCellValue('G2', "DETALLE");
        $spreadsheet->getActiveSheet()->getStyle('A2:G2')->applyFromArray($headerStyleArray);
        $counter = 1;
        $i = 2;
        foreach ($workflowDetail as $row)
        {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+1), $counter)
                ->setCellValue('B'.($i+1), $row["project_code"])
                ->setCellValue('C'.($i+1), $row["log_entry_date"])
                ->setCellValue('D'.($i+1), $row['status_name'])
                ->setCellValue('E'.($i+1), $row['log_system_date'])
                ->setCellValue('F'.($i+1), $row['created_by_fullname'])
                ->setCellValue('G'.($i+1), $row['log_detail']);

            $spreadsheet->getActiveSheet()->getStyle('C'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
            $spreadsheet->getActiveSheet()->getStyle('E'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DATETIME);
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
        $spreadsheet->getActiveSheet()->getStyle('A1:G'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        return $spreadsheet;
    }

    public function removeFile()
	{
		if(file_exists($this->getFilePath()))
		{
			unlink($this->getFilePath());
		}
	}

	public function getFilePath()
	{
		return FCPATH.'assets/'.$this->_fileName.'.xls';
	}
}
