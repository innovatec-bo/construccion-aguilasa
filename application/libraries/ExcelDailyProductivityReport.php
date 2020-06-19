<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
class ExcelDailyProductivityReport
{
    private $_sessionUser;
    private $_logDateRange;
    private $_months;
    private $_builders;
	public function __construct($sessionUser, $logDateRange)
	{
        $this->_sessionUser = $sessionUser;
        $this->_logDateRange = $logDateRange;
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
        $this->_builders = Model_user::getByRoleKeyword('builder');
	}

	function getReport()
	{
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';

		$individualProductivityLog = Model_project::getProductivityBaseReport($this->_logDateRange);
        $date = date_create_from_format('Y-m-d H:i:s', $this->_logDateRange['from']);
        $month = date_format($date, 'F');
        $month = $this->_months[strtolower($month)];
        $year = date_format($date, 'Y');
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Reporte diario de produccion - ".$month." del ".$year)
            ->setSubject("Reporte de constructores")
            ->setDescription("Reporte de production de constructores")
            ->setKeywords("reporte Constructor constructores")
            ->setCategory("Reporte");

        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());
        
        $spreadsheet = $this->_dailyLog($spreadsheet, $individualProductivityLog);
		$spreadsheet->setActiveSheetIndex(0);
        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Reporte diario de production - '.$month.' del '.$year.'.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
	}

    private function _dailyLog($spreadsheet, $individualProductivityLog)
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
		$workSheet = $spreadsheet->createSheet(0);
		$workSheet->setTitle('Reporte diario');
		$date = date_create_from_format('Y-m-d H:i:s', $this->_logDateRange['from']);
		$month = date_format($date, 'F');
		$month = $this->_months[strtolower($month)];
		$year = date_format($date, 'Y');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "HISTORIAL DIARIO DE TRABAJO - ".strtoupper($month)." DEL ".$year);
		$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$spreadsheet->getActiveSheet()->getStyle('A1:M1')->applyFromArray($titleStyleArray);
		$spreadsheet->getActiveSheet()->mergeCells('A1:M1');

		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A2', "#")
			->setCellValue('B2', "PROYECTO")
			->setCellValue('C2', "FECHA")
			->setCellValue('D2', "EJECUCION")
			->setCellValue('E2', "ACTIVIDAD")
			->setCellValue('F2', "ESTRUCTURA")
			->setCellValue('G2', "DESCRIPCION")
			->setCellValue('H2', "PUNTO")
			->setCellValue('I2', "CANTIDAD\nTRABAJADA")
			->setCellValue('J2', "UNIDAD")
			->setCellValue('K2', "PRECIO\nUNITARIO")
			->setCellValue('L2', "MONTO\nTRABAJADO")
			->setCellValue('M2', "MONTO\nCONSIGNADO");
		$spreadsheet->getActiveSheet()->getStyle('A2:M2')->applyFromArray($headerStyleArray);
		$counter = 1;
		$i = 2;
		// $workflowDetail = array();
        $individualProductivityLog = $this->_parepareDataToPrint($individualProductivityLog);
		foreach ($individualProductivityLog as $row)
		{
//			$row = $row->toArray();
			echo"<pre>";var_dump($individualProductivityLog);exit;
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.($i+1), $counter)
				->setCellValue('B'.($i+1), $row["code_pro"])
				->setCellValue('C'.($i+1), $row["manual_entry_date_lal"])
				->setCellValue('D'.($i+1), $row["labor_cost_execution"])
				->setCellValue('E'.($i+1), $row["labor_cost_activity"])
				->setCellValue('F'.($i+1), $row["structure_code"])
				->setCellValue('G'.($i+1), $row["structure_description"])
				->setCellValue('H'.($i+1), $row["point_label"])
				->setCellValue('I'.($i+1), $row["worked_up_wus"])
				->setCellValue('J'.($i+1), $row["structure_unit_of_measurement"])
				->setCellValue('K'.($i+1), $row["price_wus"])
				->setCellValue('L'.($i+1), $row["total_amount_worked_to_split"])
				->setCellValue('M'.($i+1), $row["total_amount_worked_by_builder"]);
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
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getStyle('A1:M'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
		$spreadsheet->getActiveSheet()->getStyle('C3:C'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
		$spreadsheet->getActiveSheet()->getStyle('I3:I'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$spreadsheet->getActiveSheet()->getStyle('K3:K'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$spreadsheet->getActiveSheet()->getStyle('L3:L'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$spreadsheet->getActiveSheet()->getStyle('M3:M'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		return $spreadsheet;
	}

    private function _parepareDataToPrint($individualProductivityLog)
    {
        $period = new DatePeriod(
             new DateTime($this->_logDateRange['from']),
             new DateInterval('P1D'),
             new DateTime($this->_logDateRange['to'])
        );

        $fullDatesFromLog  = array_column($individualProductivityLog, 'manual_entry_date_lal');

        $datesFromLog = array();
        foreach ($fullDatesFromLog as $value)
        {
            $date = new DateTime($value);
            $datesFromLog[] = $date->format('Y-m-d');
        }
        $buildersProductivity  = $this->_buildersProductivity($individualProductivityLog);
        // echo"<pre>";var_dump($buildersProductivity);exit;
        $defaultRow = $this->_defaultRow($individualProductivityLog);
        foreach ($period as $key => $value) 
        {
            $date = $value->format("Y-m-d");
            $dateNumber = $value->format("d");
            $dateNumberAsKey = $value->format("j");
            $dayOfWeek = $value->format("l");
            if(!isset($buildersProductivity[$dateNumberAsKey]))
            {
                $buildersProductivity[$dateNumberAsKey] = $defaultRow;
                $buildersProductivity[$dateNumberAsKey]['dateNumber'] = $dateNumber;
                $buildersProductivity[$dateNumberAsKey]['dayOfWeek'] = $dayOfWeek;
                $buildersProductivity[$dateNumberAsKey]['totalInDay'] = 0;
            }
            
        }
        ksort($buildersProductivity);
        echo"<pre>";var_dump($buildersProductivity);exit;
        exit;
    }

    private function _buildersProductivity($arrayLog)
    {
        
        $buildersProductivity = array();
        $index = 1;
        $defaultRow = $this->_defaultRow($arrayLog);
        foreach ($arrayLog as $value) 
        {
            $date = new DateTime($value['manual_entry_date_lal']);
            $dateNumber = $date->format("d");
            $dateNumberAsKey = $date->format("j");
            $dayOfWeek = $date->format("l");

            if(!isset($buildersProductivity[$dateNumberAsKey]))
            {
                $buildersProductivity[$dateNumberAsKey] = $defaultRow;
            }
            $buildersProductivity[$dateNumberAsKey]['dateNumber'] = $dateNumber;
            $buildersProductivity[$dateNumberAsKey]['dayOfWeek'] = $dayOfWeek;
            $buildersProductivity[$dateNumberAsKey]['totalInDay'] += $value['total_amount_worked_to_split'];
            $arrayIds = explode(",", $value['builders']);
            foreach ($arrayIds as $builderId) 
            {
                if(!isset($buildersProductivity[$dateNumberAsKey][$builderId]))
                    $buildersProductivity[$dateNumberAsKey][$builderId] = 0;

                $buildersProductivity[$dateNumberAsKey][$builderId] += $value['total_amount_worked_by_builder'];
            }
            $index++;
        }
        return $buildersProductivity;
    }

    private function _defaultRow($arrayLog)
    {
        //get the builders Id
        $concatenatedIdList = array_column($arrayLog, 'builders');
        $idList = array();
        foreach ($concatenatedIdList as $value) 
        {
            $arrayId = explode(",", $value);
            $idList = array_merge($idList, $arrayId);
        }
        $idList = array_unique($idList);
        $defaultValues = array_fill(0, count($idList), 0);
        $idsAndDefaultValue = array_combine($idList, $defaultValues);

        $default = array('dateNumber' => '', 'dayOfWeek' => '', 'totalInDay' => 0);
        $default = array_replace($default, $idsAndDefaultValue);
        return $default;
    }
}
