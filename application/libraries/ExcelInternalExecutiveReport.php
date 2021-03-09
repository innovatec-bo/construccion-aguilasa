<?php
require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelInternalExecutiveReport
{
    private object $_sessionUser;
    private array $_workflowDetail;
    private array $_generalExecutiveReportToPrint;
    private Spreadsheet $_phpSpreadsheet;
    private array $_dependency;
    private array $_externalObservations;
    private string $_fileName;

    public function __construct(object $sessionUser = NULL)
    {
    	if(is_null($sessionUser))
		{
			$sessionUser = new \stdClass();
			$sessionUser->fullName = "Generado Automaticamente";
		}
        $this->_sessionUser = $sessionUser;
        $this->_workflowDetail = array();
        $this->_generalExecutiveReportToPrint = array();
        $this->_phpSpreadsheet = new Spreadsheet();
        $this->_dependency = array(
			'juancgh@cre.com.bo' => 'Rudy Peredo',
			'joseeba@cre.com.bo' => 'Rudy Peredo',
			'miltonro@cre.com.bo' => 'Rudy Peredo',
			'rclaure@cruztel.com' => 'Rudy Peredo',
			'pablopdvm@gmail.com' => 'Rudy Peredo',
			'layonelrlm@cre.com.bo' => 'Rudy Peredo',
			'carlosagad@cre.com.bo' => 'Rudy Peredo',
			'diegoasr@cre.com.bo' => 'Rudy Peredo',
			'dariojfm@cre.com.bo' => 'Rudy Peredo',
			'paulrs@cre.com.bo' => 'Rudy Peredo',
			'robertomm@cre.com.bo' => 'Rudy Peredo',
			'christianvr@cre.com.bo' => 'Rudy Peredo',
			'luisdf@cre.com.bo' => 'Alberto Lobera',
			'salviocm@cre.com.bo' => 'Alberto Lobera',
			'rolandodc@cre.com.bo' => 'Alberto Lobera',
			'juancmg@cre.com.bo' => 'Alberto Lobera',
			'erlinac@cre.com.bo' => 'Alberto Lobera',
			'mariodgr@cre.com.bo' => 'Alberto Lobera',
			'josers@cre.com.bo' => 'Alberto Lobera',
			'javiervm@cre.com.bo' => 'Alberto Lobera',
			'miltonmr@cre.com.bo' => 'Alberto Lobera',
			'jhonyvv@cre.com.bo' => 'Alberto Lobera',
			'reneoom@cre.com.bo' => 'Alberto Lobera'
		);
		$this->_fileName = 'Informe Ejecutivo Interno - '.date("d.m.y h.i A").'.xlsx';
    }

    function getReport($save = FALSE) : void
    {
		$additionalParameters = array('status-keyword' => "already_sent,approved,assign_to,in_progress,paused,completed,project_energized,cre_return_order,project_return_materials,conciliation_reception");
//		$additionalParameters = array('status-keyword' => "project_return_materials");
		$this->_fileName = 'Informe Ejecutivo Interno - '.date("d.m.y h.i A").'.xlsx';

        $this->_workflowDetail = Model_project::getWorkflowDetail($additionalParameters);
		usort($this->_workflowDetail, function($a, $b) {
			return $a['cre_fiscal_pro'] <=> $b['cre_fiscal_pro'];
		});
//		$this->_externalObservations = Model_external_fiscal_observations::getMasterDetail();
//		$this->_removeObservedProjects();
		$this->_phpSpreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Informe Ejecutivo")
            ->setSubject("Informe acerca de los proyectos manejados por fiscales de CRE")
            ->setDescription("Contiene varias pestanias que informan del estado de los proyectos manejados por los fiscales de CRE")
            ->setKeywords("reporte ejecutivo cre")
            ->setCategory("Reporte");
        Cell::setValueBinder( new AdvancedValueBinder());
		$this->_phpSpreadsheet->removeSheetByIndex(0);
        $this->_generalDetail();
		$this->_generalExecutiveReport();
		$this->_generalDetail('Detalle-AREA GIS','gis');
		$this->_generalExecutiveReport('Informe Ejecutivo-AREA GIS','gis');
		$this->_generalDetail('Detalle-AREA GIR','gir');
		$this->_generalExecutiveReport('Informe Ejecutivo-AREA GIR','gir');
		$this->_phpSpreadsheet->setActiveSheetIndex(0);

		if($save)
		{
			try
			{
				$writer = IOFactory::createWriter($this->_phpSpreadsheet, 'Xlsx');
				$writer->save(FCPATH.'assets/'.$this->_fileName);
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
			header('Content-Disposition: attachment;filename="'.$this->_fileName.'"');
			header('Cache-Control: max-age=0');

			try
			{
				$writer = IOFactory::createWriter($this->_phpSpreadsheet, 'Xlsx');
				$writer->save('php://output');
			}
			catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e)
			{
				exit($e->getMessage());
			}
		}
    }

    private function _generalDetail($sheetTitle = 'Detalle General', $filterBy = "") : void
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

        $sheet1 = $this->_phpSpreadsheet->createSheet();
		$sheet1->setTitle($sheetTitle);

		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('A1', 'DETALLE GENERAL');
		$this->_phpSpreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A1:J1')->applyFromArray($titleStyleArray);
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('A1:J1');

		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)
            ->setCellValue('A2', "#")
            ->setCellValue('B2', "CODIGO")
            ->setCellValue('C2', "ESTADO")
            ->setCellValue('D2', "FECHA")
            ->setCellValue('E2', "DIAS ESTATICO")
            ->setCellValue('F2', "FISCAL CRE")
            ->setCellValue('G2', "FISCAL SEREBO")
            ->setCellValue('H2', "DIRECCION")
            ->setCellValue('I2', "IMPORTE")
            ->setCellValue('J2', "DEPENDENCIA");
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A2:J2')->applyFromArray($headerStyleArray);
        $counter = 1;
        $i = 2;
        $totalTotalBudget = 0;
        foreach ($this->_workflowDetail as $row)
        {
			$workArea = $row['work_area_pro'];
			if($filterBy != "")
			{
				if($filterBy != $workArea)
				{
					continue;
				}
			}
			$statusKeyword = $row['keyword_pst'];
        	$creFiscal = $row['cre_fiscal_pro'];
			$totalBudget = PublicController::getPaymentByStatusFromWorkflow($row);
//			if($statusKeyword == 'already_sent')
//			{
//				if($row['schedulee_tentative_total_budget'] != null && $row['schedulee_tentative_total_budget'] > 0)
//				{
//					$totalBudget = $row['schedulee_tentative_total_budget'];
//				}
//			}
			$totalTotalBudget += $totalBudget;
			$sereboFiscal = $row['fiscal_responsible'];
			if(is_null($sereboFiscal) || $statusKeyword == "project_return_materials")
			{
				$workArea = $row['work_area_pro'];
				$sereboFiscal = 'Eddyson Copa';
				if($workArea == 'gir')
					$sereboFiscal = 'Mario Aguilera';
			}
			$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)
                ->setCellValue('A'.($i+1), $counter)
                ->setCellValue('B'.($i+1), $row["code_pro"])
                ->setCellValue('C'.($i+1), $row["status_name_pst"])
                ->setCellValue('D'.($i+1), $row['status_log_manual_entry_date'])
                ->setCellValue('E'.($i+1), $row['static_days'])
                ->setCellValue('F'.($i+1), $creFiscal)
                ->setCellValue('G'.($i+1), $sereboFiscal)
                ->setCellValue('H'.($i+1), $row['address_pro'])
                ->setCellValue('I'.($i+1), $totalBudget)
                ->setCellValue('J'.($i+1), "");
			$this->_phpSpreadsheet->getActiveSheet()->getStyle('D'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
			$this->_phpSpreadsheet->getActiveSheet()->getStyle('I'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
            $i++;
            $counter++;
        }
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("A".($i+1), 'Totales');
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A'.($i+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("I".($i+1), '=SUM(I3:I'.$i.')');
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('I'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);

		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('A'.($i+1).':H'.($i+1));
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A1:J'.($i+1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }

	private function _generalExecutiveReport($sheetTitle = "Informe Ejecutivo General", $filterBy = "") : void
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

		$generalExecutiveReportToPrint = $this->_prepareGeneralExecutiveReport($filterBy);

		$sheet2 = $this->_phpSpreadsheet->createSheet();
		$sheet2->setTitle($sheetTitle);

		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('A1', 'INFORME EJECUTIVO GENERAL');
		$this->_phpSpreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A1:AI1')->applyFromArray($titleStyleArray);
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('A1:AI1');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('C2', "ENVIADO");
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('F2', "APROBADO");
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('I2', "ASIGNACION");
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('L2', "EN CONSTRUCCION");
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('O2', "PAUSADO");
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('R2', "COMPLETADO");
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('U2', "ENERGIZADO");
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('X2', "RECEP. DE CONCIL.");
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('AA2', "RECEP. ORDEN DEV.");
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('AD2', "MATE. DEV A CRE");
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('AG2', "TOTALES");
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A2:AI2')->applyFromArray($titleStyleArray);
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('C2:E2');
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('F2:H2');
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('I2:K2');
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('L2:N2');
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('O2:Q2');
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('R2:T2');
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('U2:W2');
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('X2:Z2');
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('AA2:AC2');
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('AD2:AF2');
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('AG2:AI2');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)
			->setCellValue('A3', "#")
			->setCellValue('B3', "FISCAL DE\nSEREBO")
			->setCellValue('C3', "Cant.\nProyectos")
			->setCellValue('D3', "Tiempo Prome.\nDias")
			->setCellValue('E3', "Importe")
			->setCellValue('F3', "Cant.\nProyectos")
			->setCellValue('G3', "Tiempo Prome.\nDias")
			->setCellValue('H3', "Importe")
			->setCellValue('I3', "Cant.\nProyectos")
			->setCellValue('J3', "Tiempo Prome.\nDias")
			->setCellValue('K3', "Importe")
			->setCellValue('L3', "Cant.\nProyectos")
			->setCellValue('M3', "Tiempo Prome.\nDias")
			->setCellValue('N3', "Importe")
			->setCellValue('O3', "Cant.\nProyectos")
			->setCellValue('P3', "Tiempo Prome.\nDias")
			->setCellValue('Q3', "Importe")
			->setCellValue('R3', "Cant.\nProyectos")
			->setCellValue('S3', "Tiempo Prome.\nDias")
			->setCellValue('T3', "Importe")
			->setCellValue('U3', "Cant.\nProyectos")
			->setCellValue('V3', "Tiempo Prome.\nDias")
			->setCellValue('W3', "Importe")
			->setCellValue('X3', "Cant.\nProyectos")
			->setCellValue('Y3', "Tiempo Prome.\nDias")
			->setCellValue('Z3', "Importe")
			->setCellValue('AA3', "Cant.\nProyectos")
			->setCellValue('AB3', "Tiempo Prome.\nDias")
			->setCellValue('AC3', "Importe")
			->setCellValue('AD3', "Cant.\nProyectos")
			->setCellValue('AE3', "Tiempo Prome.\nDias")
			->setCellValue('AF3', "Importe")
			->setCellValue('AG3', "Cant.\nProyectos")
			->setCellValue('AH3', "Tiempo Prome.\nDias")
			->setCellValue('AI3', "Importe");
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A3:AI3')->applyFromArray($headerStyleArray);
		$counter = 1;
		$i = 3;
//		if($filterBy != "")
//		{
//			echo"<pre>";var_dump($filterBy, $this->_generalExecutiveReportToPrint);exit;
//		}
		foreach ($generalExecutiveReportToPrint as $row)
		{
			$staticDays1 = "";
			if(isset($row["already_sent"]))
				$staticDays1 = round($row["already_sent"]['staticDays']/$row["already_sent"]['quantity'],2);

			$staticDays2 = "";
			if(isset($row["approved"]))
				$staticDays2 = round($row["approved"]['staticDays']/$row["approved"]['quantity'],2);

			$staticDays3 = "";
			if(isset($row["assign_to"]))
				$staticDays3 = round($row["assign_to"]['staticDays']/$row["assign_to"]['quantity'],2);

			$staticDays4 = "";
			if(isset($row["in_progress"]))
				$staticDays4 = round($row["in_progress"]['staticDays']/$row["in_progress"]['quantity'],2);

			$staticDays5 = "";
			if(isset($row["paused"]))
				$staticDays5 = round($row["paused"]['staticDays']/$row["paused"]['quantity'],2);

			$staticDays6 = "";
			if(isset($row["completed"]))
				$staticDays6 = round($row["completed"]['staticDays']/$row["completed"]['quantity'],2);

			$staticDays7 = "";
			if(isset($row["project_energized"]))
				$staticDays7 = round($row["project_energized"]['staticDays']/$row["project_energized"]['quantity'],2);

			$staticDays8 = "";
			if(isset($row["cre_return_order"]))
				$staticDays8 = round($row["cre_return_order"]['staticDays']/$row["cre_return_order"]['quantity'],2);

			$staticDays9 = "";
			if(isset($row["project_return_materials"]))
				$staticDays9 = round($row["project_return_materials"]['staticDays']/$row["project_return_materials"]['quantity'],2);

			$staticDays10 = "";
			if(isset($row["conciliation_reception"]))
				$staticDays10 = round($row["conciliation_reception"]['staticDays']/$row["conciliation_reception"]['quantity'],2);

			$staticDays11 = "";
			if(isset($row["total"]))
				$staticDays11 = round($row["total"]['staticDays']/$row["total"]['quantity'],2);

			$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)
				->setCellValue('A'.($i+1), $counter)
				->setCellValue('B'.($i+1), $row["fullName"])
				->setCellValue('C'.($i+1), $row["already_sent"]['quantity']??"")
				->setCellValue('D'.($i+1), $staticDays1)
				->setCellValue('E'.($i+1), $row["already_sent"]['totalBudget']??"")
				->setCellValue('F'.($i+1), $row["approved"]['quantity']??"")
				->setCellValue('G'.($i+1), $staticDays2)
				->setCellValue('H'.($i+1), $row["approved"]['totalBudget']??"")
				->setCellValue('I'.($i+1), $row["assign_to"]['quantity']??"")
				->setCellValue('J'.($i+1), $staticDays3)
				->setCellValue('K'.($i+1), $row["assign_to"]['totalBudget']??"")
				->setCellValue('L'.($i+1), $row["in_progress"]['quantity']??"")
				->setCellValue('M'.($i+1), $staticDays4)
				->setCellValue('N'.($i+1), $row["in_progress"]['totalBudget']??"")
				->setCellValue('O'.($i+1), $row["paused"]['quantity']??"")
				->setCellValue('P'.($i+1), $staticDays5)
				->setCellValue('Q'.($i+1), $row["paused"]['totalBudget']??"")
				->setCellValue('R'.($i+1), $row["completed"]['quantity']??"")
				->setCellValue('S'.($i+1), $staticDays6)
				->setCellValue('T'.($i+1), $row["completed"]['totalBudget']??"")
				->setCellValue('U'.($i+1), $row["project_energized"]['quantity']??"")
				->setCellValue('V'.($i+1), $staticDays7)
				->setCellValue('W'.($i+1), $row["project_energized"]['totalBudget']??"")
				->setCellValue('x'.($i+1), $row["conciliation_reception"]['quantity']??"")
				->setCellValue('y'.($i+1), $staticDays10)
				->setCellValue('z'.($i+1), $row["conciliation_reception"]['totalBudget']??"")
				->setCellValue('AA'.($i+1), $row["cre_return_order"]['quantity']??"")
				->setCellValue('AB'.($i+1), $staticDays8)
				->setCellValue('AC'.($i+1), $row["cre_return_order"]['totalBudget']??"")
				->setCellValue('AD'.($i+1), $row["project_return_materials"]['quantity']??"")
				->setCellValue('AE'.($i+1), $staticDays9)
				->setCellValue('AF'.($i+1), $row["project_return_materials"]['totalBudget']??"")
				->setCellValue('AG'.($i+1), $row["total"]['quantity']??"")
				->setCellValue('AH'.($i+1), $staticDays11)
				->setCellValue('AI'.($i+1), "=SUM(E".($i+1).",H".($i+1).",K".($i+1).",N".($i+1).",Q".($i+1).",T".($i+1).",W".($i+1).",Z".($i+1).",AC".($i+1).",AF".($i+1).")");

			$this->_phpSpreadsheet->getActiveSheet()->getStyle('E'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$this->_phpSpreadsheet->getActiveSheet()->getStyle('H'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$this->_phpSpreadsheet->getActiveSheet()->getStyle('K'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$this->_phpSpreadsheet->getActiveSheet()->getStyle('N'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$this->_phpSpreadsheet->getActiveSheet()->getStyle('Q'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$this->_phpSpreadsheet->getActiveSheet()->getStyle('T'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$this->_phpSpreadsheet->getActiveSheet()->getStyle('W'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$this->_phpSpreadsheet->getActiveSheet()->getStyle('Z'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$this->_phpSpreadsheet->getActiveSheet()->getStyle('AC'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$this->_phpSpreadsheet->getActiveSheet()->getStyle('AF'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$this->_phpSpreadsheet->getActiveSheet()->getStyle('AI'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$i++;
			$counter++;
		}
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("B".($i+1), 'Totales');
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('B'.($i+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("C".($i+1), '=SUM(C4:C'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("E".($i+1), '=SUM(E4:E'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("F".($i+1), '=SUM(F4:F'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("H".($i+1), '=SUM(H4:H'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("I".($i+1), '=SUM(I4:I'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("K".($i+1), '=SUM(K4:K'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("L".($i+1), '=SUM(L4:L'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("N".($i+1), '=SUM(N4:N'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("O".($i+1), '=SUM(O4:O'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("Q".($i+1), '=SUM(Q4:Q'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("R".($i+1), '=SUM(R4:R'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("T".($i+1), '=SUM(T4:T'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("U".($i+1), '=SUM(U4:U'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("W".($i+1), '=SUM(W4:W'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("X".($i+1), '=SUM(X4:X'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("Z".($i+1), '=SUM(Z4:Z'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("AA".($i+1), '=SUM(AA4:AA'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("AC".($i+1), '=SUM(AC4:AC'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("AD".($i+1), '=SUM(AD4:AD'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("AF".($i+1), '=SUM(AF4:AF'.$i.')');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue("AI".($i+1), '=SUM(AI4:AI'.$i.')');
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('C'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('E'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('F'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('H'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('I'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('K'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('L'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('N'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('O'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('Q'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('R'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('T'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('U'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('W'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('X'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('Z'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('AA'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('AC'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('AD'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('AF'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('AI'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);

		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A1:AI'.($i+1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
	}

	private function _prepareGeneralExecutiveReport($filterBy = "") : array
	{
		$generalExecutiveReportToPrint = array();
		foreach ($this->_workflowDetail as $row)
		{
			$workArea = $row['work_area_pro'];
			if($filterBy != "")
			{
				if($filterBy != $workArea)
				{
					continue;
				}
			}
			$statusKeyword = $row['keyword_pst'];
			$sereboFiscalId = $row['fiscal_responsible_id'];
			$sereboFiscalName = $row['fiscal_responsible'];
			if(is_null($sereboFiscalName) || $statusKeyword == "project_return_materials")
			{
				$workArea = $row['work_area_pro'];
				$sereboFiscalId = 1000;
				$sereboFiscalName = 'Eddyson Copa';
				if($workArea == 'gir')
				{
					$sereboFiscalId = 1001;
					$sereboFiscalName = 'Mario Aguilera';
				}
			}

			$totalBudget = PublicController::getPaymentByStatusFromWorkflow($row);
//			if($statusKeyword == 'already_sent')
//			{
//				if($row['schedulee_tentative_total_budget'] != null && $row['schedulee_tentative_total_budget'] > 0)
//				{
//					$totalBudget = $row['schedulee_tentative_total_budget'];
//				}
//			}
			if(!isset($generalExecutiveReportToPrint[$sereboFiscalId]))
			{
				$generalExecutiveReportToPrint[$sereboFiscalId]['fullName'] = $sereboFiscalName;
			}
			if(!isset($generalExecutiveReportToPrint[$sereboFiscalId][$statusKeyword]))
			{
				$generalExecutiveReportToPrint[$sereboFiscalId][$statusKeyword]['quantity'] = 0;
				$generalExecutiveReportToPrint[$sereboFiscalId][$statusKeyword]['staticDays'] = 0;
				$generalExecutiveReportToPrint[$sereboFiscalId][$statusKeyword]['totalBudget'] = 0;
			}

			$generalExecutiveReportToPrint[$sereboFiscalId][$statusKeyword]['quantity'] ++;
			$generalExecutiveReportToPrint[$sereboFiscalId][$statusKeyword]['staticDays'] += $row['static_days'];
			$generalExecutiveReportToPrint[$sereboFiscalId][$statusKeyword]['totalBudget'] += $totalBudget;

			if(!isset($generalExecutiveReportToPrint[$sereboFiscalId]['total']))
			{
				$generalExecutiveReportToPrint[$sereboFiscalId]['total']['quantity'] = 0;
				$generalExecutiveReportToPrint[$sereboFiscalId]['total']['staticDays'] = 0;
				$generalExecutiveReportToPrint[$sereboFiscalId]['total']['totalBudget'] = 0;
			}

			$generalExecutiveReportToPrint[$sereboFiscalId]['total']['quantity'] ++;
			$generalExecutiveReportToPrint[$sereboFiscalId]['total']['staticDays'] += $row['static_days'];
			$generalExecutiveReportToPrint[$sereboFiscalId]['total']['totalBudget'] += $totalBudget;
		}
		return $generalExecutiveReportToPrint;
	}

	private function _removeObservedProjects()
	{
		$observedProjectIds = array_column($this->_externalObservations,'project_id_efo');
		$observedProjectIds = array_unique($observedProjectIds);
		$i = 0;
		foreach ($this->_workflowDetail as $row)
		{
			$workflowProjectId = $row['id_pro'];
			if(array_search($workflowProjectId,$observedProjectIds) !== FALSE)
			{
				unset($this->_workflowDetail[$i]);
			}
			$i++;
		}
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
		return FCPATH.'assets/'.$this->_fileName;
	}


}
