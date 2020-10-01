<?php
require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelExecutiveReport
{
    private object $_sessionUser;
    private array $_workflowDetail;
    private array $_generalDetailToPrint;
    private Spreadsheet $_phpSpreadsheet;
    private array $_supervisingGroup;

    public function __construct(object $sessionUser)
    {
        $this->_sessionUser = $sessionUser;
        $this->_workflowDetail = array();
        $this->_generalDetailToPrint = array();
        $this->_phpSpreadsheet = new Spreadsheet();
        $this->_supervisingGroup = array(
        	'rudypb@cre.com.bo' => array(
        							'juancgh@cre.com.bo',
									'joseeba@cre.com.bo',
									'miltonro@cre.com.bo',
									'rclaure@cruztel.com'
							)
		);
    }

    function getReport() : void
    {
        $this->_workflowDetail = Model_project::getWorkflowDetail();
		$this->_prepareGeneralDetail();
		echo"<pre>";var_dump($this->_generalDetailToPrint);exit;
		$this->_phpSpreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Informe Ejecutivo")
            ->setSubject("Informe acerca de los proyectos manejados por fiscales de CRE")
            ->setDescription("Contiene varias pestanias que informan del estado de los proyectos manejados por los fiscales de CRE")
            ->setKeywords("reporte ejecutivo cre")
            ->setCategory("Reporte");
        Cell::setValueBinder( new AdvancedValueBinder());

		$this->_generalDetail();
		$this->_generalExecutiveReport();

        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Log de proyectos - '.date("d.m.y h.i A").'.xls"');
        header('Cache-Control: max-age=0');

		try
		{
			$writer = IOFactory::createWriter($this->_phpSpreadsheet, 'Xls');
			$writer->save('php://output');
		}
		catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e)
		{
			exit($e->getMessage());
		}
    }

    private function _generalDetail() : void
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

        $manPowerWorkSheet = $this->_phpSpreadsheet->createSheet(0);
        $manPowerWorkSheet->setTitle('LOG DE PROYECTOS');

		$this->_phpSpreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'Log de Proyectos');
		$this->_phpSpreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A1:F1')->applyFromArray($titleStyleArray);
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('A1:F1');

		$this->_phpSpreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', "#")
            ->setCellValue('B2', "CODIGO")
            ->setCellValue('C2', "FECHA")
            ->setCellValue('D2', "ESTADO")
            ->setCellValue('E2', "RESPONSABLE")
            ->setCellValue('F2', "DETALLE");
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A2:F2')->applyFromArray($headerStyleArray);
        $counter = 1;
        $i = 2;
        foreach ($workflowDetail as $row)
        {
			$this->_phpSpreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+1), $counter)
                ->setCellValue('B'.($i+1), $row["project_code"])
                ->setCellValue('C'.($i+1), $row["log_entry_date"])
                ->setCellValue('D'.($i+1), $row['status_name'])
                ->setCellValue('E'.($i+1), $row['responsible_full_name'])
                ->setCellValue('F'.($i+1), $row['log_detail']);

			$this->_phpSpreadsheet->getActiveSheet()->getStyle('C'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
            $i++;
            $counter++;
            
        }

		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A1:F'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }

	private function _generalExecutiveReport() : void
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

		$manPowerWorkSheet = $this->_phpSpreadsheet->createSheet(0);
		$manPowerWorkSheet->setTitle('LOG DE PROYECTOS');

		$this->_phpSpreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'Log de Proyectos');
		$this->_phpSpreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A1:F1')->applyFromArray($titleStyleArray);
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('A1:F1');

		$this->_phpSpreadsheet->setActiveSheetIndex(0)
			->setCellValue('A2', "#")
			->setCellValue('B2', "CODIGO")
			->setCellValue('C2', "FECHA")
			->setCellValue('D2', "ESTADO")
			->setCellValue('E2', "RESPONSABLE")
			->setCellValue('F2', "DETALLE");
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A2:F2')->applyFromArray($headerStyleArray);
		$counter = 1;
		$i = 2;
		foreach ($workflowDetail as $row)
		{
			$this->_phpSpreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.($i+1), $counter)
				->setCellValue('B'.($i+1), $row["project_code"])
				->setCellValue('C'.($i+1), $row["log_entry_date"])
				->setCellValue('D'.($i+1), $row['status_name'])
				->setCellValue('E'.($i+1), $row['responsible_full_name'])
				->setCellValue('F'.($i+1), $row['log_detail']);

			$this->_phpSpreadsheet->getActiveSheet()->getStyle('C'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
			$i++;
			$counter++;

		}

		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A1:F'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
	}

	private function _prepareGeneralDetail() : void
	{
		foreach ($this->_workflowDetail as $row)
		{
			$this->_generalDetailToPrint[] = $row;
			break;
		}
	}
}
