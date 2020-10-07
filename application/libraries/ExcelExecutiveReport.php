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
    private array $_generalExecutiveReportToPrint;
    private Spreadsheet $_phpSpreadsheet;
    private array $_dependency;
    private array $_externalObservations;

    public function __construct(object $sessionUser)
    {
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
			'luisdf@cre.com.bo' => 'Alberto Lobera',
			'salviocm@cre.com.bo' => 'Alberto Lobera',
			'rolandodc@cre.com.bo' => 'Alberto Lobera',
			'juancmg@cre.com.bo' => 'Alberto Lobera',
			'erlinac@cre.com.bo' => 'Alberto Lobera',
			'mariodgr@cre.com.bo' => 'Alberto Lobera',
			'josers@cre.com.bo' => 'Alberto Lobera',
			'javiervm@cre.com.bo' => 'Alberto Lobera',
			'miltonmr@cre.com.bo' => 'Alberto Lobera',
			'jhonyvv@cre.com.bo' => 'Alberto Lobera'
		);
    }

    function getReport() : void
    {
    	$additionalParameters = array('status-keyword' => 'already_sent,as_built,conciliation_shipment');
        $this->_workflowDetail = Model_project::getWorkflowDetail($additionalParameters);
		usort($this->_workflowDetail, function($a, $b) {
			return $a['cre_fiscal_pro'] <=> $b['cre_fiscal_pro'];
		});
		$this->_externalObservations = Model_external_fiscal_observations::getMasterDetail();
		$this->_removeObservedProjects();
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
		$this->_generalDetail('Detalle-AREA GIS','Rudy Peredo');
		$this->_generalExecutiveReport('Informe Ejecutivo-AREA GIS','Rudy Peredo');
		$this->_generalDetail('Detalle-AREA GIR','Alberto Lobera');
		$this->_generalExecutiveReport('Informe Ejecutivo-AREA GIR','Alberto Lobera');
		$this->_phpSpreadsheet->setActiveSheetIndex(0);

		// redirect output to client browser
//        header('Content-Type: application/vnd.ms-excel');
//        header('Content-Disposition: attachment;filename="Informe Ejecutivo - '.date("d.m.y h.i A").'.xlsx"');
//        header('Cache-Control: max-age=0');

		try
		{
			$writer = IOFactory::createWriter($this->_phpSpreadsheet, 'Xlsx');
//			$writer->save('php://output');
			$writer->save(FCPATH.'assets/Informe-Ejecutivo-'.date("d.m.y").'.xlsx');
		}
		catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e)
		{
			exit($e->getMessage());
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
			$dependency = $this->_dependency[$row['cre_fiscal_email']]??"Sin especificar";
        	if($filterBy != "")
			{
				if($filterBy != $dependency)
					continue;
			}
        	switch ($row['keyword_pst'])
			{
				case "already_sent":
					$totalBudget = floatval($row['schedule_design_budget']);
					break;
				case "as_built":
					$totalBudget = floatval($row['total_approved']);
					break;
				default://case "conciliation_shipment":
					$totalBudget = floatval($row['payment_order_registered_total_real_budget']);
					break;
			}
			$totalTotalBudget += $totalBudget;

			$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)
                ->setCellValue('A'.($i+1), $counter)
                ->setCellValue('B'.($i+1), $row["code_pro"])
                ->setCellValue('C'.($i+1), $row["status_name_pst"])
                ->setCellValue('D'.($i+1), $row['status_log_manual_entry_date'])
                ->setCellValue('E'.($i+1), $row['static_days'])
                ->setCellValue('F'.($i+1), $row['cre_fiscal_pro'])
                ->setCellValue('G'.($i+1), $row['fiscal_responsible']??"Sin Asignar")
                ->setCellValue('H'.($i+1), $row['address_pro'])
                ->setCellValue('I'.($i+1), $totalBudget)
                ->setCellValue('J'.($i+1), $dependency);
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
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A1:N1')->applyFromArray($titleStyleArray);
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('A1:N1');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('C2', "ENVIADO");
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('F2', "AS BUILT");
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('I2', "ENVIO DE CONCIL.");
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)->setCellValue('L2', "TOTALES");
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A2:N2')->applyFromArray($titleStyleArray);
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('C2:E2');
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('F2:H2');
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('I2:K2');
		$this->_phpSpreadsheet->getActiveSheet()->mergeCells('L2:N2');
		$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)
			->setCellValue('A3', "#")
			->setCellValue('B3', "FISCAL CRE")
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
			->setCellValue('N3', "Importe");
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A3:N3')->applyFromArray($headerStyleArray);
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
			if(isset($row["as_built"]))
				$staticDays2 = round($row["as_built"]['staticDays']/$row["as_built"]['quantity'],2);

			$staticDays3 = "";
			if(isset($row["conciliation_shipment"]))
				$staticDays3 = round($row["conciliation_shipment"]['staticDays']/$row["conciliation_shipment"]['quantity'],2);

			$staticDays4 = "";
			if(isset($row["total"]))
				$staticDays4 = round($row["total"]['staticDays']/$row["total"]['quantity'],2);
			$this->_phpSpreadsheet->setActiveSheetIndexByName($sheetTitle)
				->setCellValue('A'.($i+1), $counter)
				->setCellValue('B'.($i+1), $row["fullName"])
				->setCellValue('C'.($i+1), $row["already_sent"]['quantity']??"")
				->setCellValue('D'.($i+1), $staticDays1)
				->setCellValue('E'.($i+1), $row["already_sent"]['totalBudget']??"")
				->setCellValue('F'.($i+1), $row["as_built"]['quantity']??"")
				->setCellValue('G'.($i+1), $staticDays2)
				->setCellValue('H'.($i+1), $row["as_built"]['totalBudget']??"")
				->setCellValue('I'.($i+1), $row["conciliation_shipment"]['quantity']??"")
				->setCellValue('J'.($i+1), $staticDays3)
				->setCellValue('K'.($i+1), $row["conciliation_shipment"]['totalBudget']??"")
				->setCellValue('L'.($i+1), $row["total"]['quantity']??"")
				->setCellValue('M'.($i+1), $staticDays4)
				->setCellValue('N'.($i+1), $row["total"]['totalBudget']??"");

			$this->_phpSpreadsheet->getActiveSheet()->getStyle('E'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$this->_phpSpreadsheet->getActiveSheet()->getStyle('H'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$this->_phpSpreadsheet->getActiveSheet()->getStyle('K'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$this->_phpSpreadsheet->getActiveSheet()->getStyle('N'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
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
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('C'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('E'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('F'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('H'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('I'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('K'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('L'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('N'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);

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
		$this->_phpSpreadsheet->getActiveSheet()->getStyle('A1:N'.($i+1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
	}

	private function _prepareGeneralExecutiveReport($filterBy = "") : array
	{
		$generalExecutiveReportToPrint = array();
		foreach ($this->_workflowDetail as $row)
		{
			$dependency = $this->_dependency[$row['cre_fiscal_email']]??"Sin especificar";
			if($filterBy != "")
			{
				if($filterBy != $dependency)
				{

					continue;
				}

			}
			$creFiscalId = $row['cre_fiscal_id'];
			$statusKeyword = $row['keyword_pst'];
			switch ($statusKeyword)
			{
				case "already_sent":
					$totalBudget = floatval($row['schedule_design_budget']);
					break;
				case "as_built":
					$totalBudget = floatval($row['total_approved']);
					break;
				default://case "conciliation_shipment":
					$totalBudget = floatval($row['payment_order_registered_total_real_budget']);
					break;
			}
			if(!isset($generalExecutiveReportToPrint[$creFiscalId]))
			{
				$generalExecutiveReportToPrint[$creFiscalId]['fullName'] = $row['cre_fiscal_pro'];
			}
			if(!isset($generalExecutiveReportToPrint[$creFiscalId][$statusKeyword]))
			{
				$generalExecutiveReportToPrint[$creFiscalId][$statusKeyword]['quantity'] = 0;
				$generalExecutiveReportToPrint[$creFiscalId][$statusKeyword]['staticDays'] = 0;
				$generalExecutiveReportToPrint[$creFiscalId][$statusKeyword]['totalBudget'] = 0;
			}

			$generalExecutiveReportToPrint[$creFiscalId][$statusKeyword]['quantity'] ++;
			$generalExecutiveReportToPrint[$creFiscalId][$statusKeyword]['staticDays'] += $row['static_days'];
			$generalExecutiveReportToPrint[$creFiscalId][$statusKeyword]['totalBudget'] += $totalBudget;

			if(!isset($generalExecutiveReportToPrint[$creFiscalId]['total']))
			{
				$generalExecutiveReportToPrint[$creFiscalId]['total']['quantity'] = 0;
				$generalExecutiveReportToPrint[$creFiscalId]['total']['staticDays'] = 0;
				$generalExecutiveReportToPrint[$creFiscalId]['total']['totalBudget'] = 0;
			}

			$generalExecutiveReportToPrint[$creFiscalId]['total']['quantity'] ++;
			$generalExecutiveReportToPrint[$creFiscalId]['total']['staticDays'] += $row['static_days'];
			$generalExecutiveReportToPrint[$creFiscalId]['total']['totalBudget'] += $totalBudget;
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
}
