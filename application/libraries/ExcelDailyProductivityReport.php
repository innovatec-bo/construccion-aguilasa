<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
class ExcelDailyProductivityReport
{
    private $_sessionUser;
    private $_logDateRange;
    private $_months;
    private $_builders;
    private $_daysOfWeek;
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
        $this->_daysOfWeek = array(
        			"monday" => "Lunes",
					"tuesday" => "Martes",
					"wednesday" => "Miercoles",
					"thursday" => "Jueves",
					"friday" => "Viernes",
					"saturday" => "Sabado",
					"sunday" => "Domingo"
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

    private function _dailyLog($spreadsheet, $data)
	{
		$titleStyleArray = [
			'font' => ['bold' => true, 'size' => 17, 'underline' => true],
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
		$workSheet = $spreadsheet->createSheet(0);
		$workSheet->setTitle('Reporte diario');
		$date = date_create_from_format('Y-m-d H:i:s', $this->_logDateRange['from']);
		$month = date_format($date, 'F');
		$month = $this->_months[strtolower($month)];
		$year = date_format($date, 'Y');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "REPORTE DIARIO DE PRODUCCION\nCORRESPONDIENTE AL MES DE ".strtoupper($month)." DEL ".$year);
		
		$counter = 1;
		$i = 2;
        $arrayAlphabet = range("A","Z");
        $headers = $this->_columnHeaders($data);
		$optimumUMBO = $this->_builderUMBO($data);
        $data = $this->_prepareDataToPrint($data);
        array_unshift($data, $headers);
//        echo"<pre>";var_dump($data);exit;
		foreach ($data as $rows)
		{
            $j = 0;
            foreach ($rows as $key => $value) 
            {
				$spreadsheet->setActiveSheetIndex(0)->setCellValue($arrayAlphabet[$j].$i, $value);

                if($i>2 && $j>=2)
                {
                    $spreadsheet->getActiveSheet()->getStyle($arrayAlphabet[$j].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                    
                }
                if($j==0)
                {
                    $spreadsheet->getActiveSheet()->getColumnDimension($arrayAlphabet[$j])->setAutoSize(true);
                }
                if($j>=1)
                {
                    $spreadsheet->getActiveSheet()->getColumnDimension($arrayAlphabet[$j])->setWidth(12);
                }
                if($j>=2)
                {
                    $spreadsheet->getActiveSheet()->getStyle($arrayAlphabet[$j].$i)->getAlignment()->setWrapText(true);
                }
                //If this is the last iteration then add the footer data
                if(($counter) == count($data) && $j > 1)
                {
                    //totales
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue(
                        $arrayAlphabet[$j].($i+1), '=SUM('.$arrayAlphabet[$j].'3:'.$arrayAlphabet[$j].$i.')');
                    $spreadsheet->getActiveSheet()->getStyle(
                        $arrayAlphabet[$j].($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                    $spreadsheet->getActiveSheet()->getStyle($arrayAlphabet[$j].($i+1))->getFont()->setBold(true);
                    //dias trabajados
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue(
                        $arrayAlphabet[$j].($i+2), '=COUNTIF('.$arrayAlphabet[$j].'3:'.$arrayAlphabet[$j].$i.',">0.00")');//=COUNTIF(C2:C8,">=5")
                    //ubmo
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue(
                        $arrayAlphabet[$j].($i+3), '='.$arrayAlphabet[$j].($i+1).'/187.38');
                    $spreadsheet->getActiveSheet()->getStyle(
                        $arrayAlphabet[$j].($i+3))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
					//umbo optimo
					$spreadsheet->setActiveSheetIndex(0)->setCellValue(
						$arrayAlphabet[$j].($i+4), $optimumUMBO[($j-2)]);
					$spreadsheet->getActiveSheet()->getStyle(
						$arrayAlphabet[$j].($i+4))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
					//% logrado
					$spreadsheet->setActiveSheetIndex(0)->setCellValue(
						$arrayAlphabet[$j].($i+5), '='.$arrayAlphabet[$j].($i+3).'/'.$arrayAlphabet[$j].($i+4));
					$spreadsheet->getActiveSheet()->getStyle(
						$arrayAlphabet[$j].($i+5))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_00);
                }
                $j++;
            }

			$i++;
			$counter++;
		}
		if($i > 2)
		{
//			echo"<pre>";var_dump($arrayAlphabet[2].($i), '=SUM('.$arrayAlphabet[3].$i.':'.$arrayAlphabet[count($rows)-1].$i.')');exit;
			$spreadsheet->setActiveSheetIndex(0)->setCellValue(
				$arrayAlphabet[2].($i), '=SUM('.$arrayAlphabet[3].$i.':'.$arrayAlphabet[count($rows)-1].$i.')');
		}

        //footer - begin
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$i, 'TOTALES');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->mergeCells('A'.$i.':B'.$i); 
        $i++;
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$i, 'DIAS PROD.');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->mergeCells('A'.$i.':B'.$i); 
        $i++;
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$i, 'UBMO');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->mergeCells('A'.$i.':B'.$i); 
        $i++;
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$i, 'UBMO OPTIMO');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->mergeCells('A'.$i.':B'.$i); 
        $i++;
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$i, '% LOGRADO');
        $spreadsheet->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->mergeCells('A'.$i.':B'.$i); 
        $i++;
        
        //footer - end

        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(80);
        $spreadsheet->getActiveSheet()->getStyle('A1:'.$arrayAlphabet[($j-1)].'1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('A1:'.$arrayAlphabet[($j-1)].'1');
        $spreadsheet->getActiveSheet()->getStyle('A2:'.$arrayAlphabet[($j-1)].'2')->applyFromArray($headerStyleArray);
        $spreadsheet->getActiveSheet()->getStyle('A1:'.$arrayAlphabet[($j-1)].($i-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


		return $spreadsheet;
	}

    private function _prepareDataToPrint($individualProductivityLog)
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
        $defaultRow = $this->_defaultRow($individualProductivityLog);
        foreach ($period as $key => $value) 
        {
            $date = $value->format("Y-m-d");
            $dateNumber = $value->format("d");
            $dateNumberAsKey = $value->format("j");
            $dayOfWeek = $this->_daysOfWeek[strtolower($value->format("l"))];
            if(!isset($buildersProductivity[$dateNumberAsKey]))
            {
                $buildersProductivity[$dateNumberAsKey] = $defaultRow;
                $buildersProductivity[$dateNumberAsKey]['dateNumber'] = $dateNumber;
                $buildersProductivity[$dateNumberAsKey]['dayOfWeek'] = $dayOfWeek;
                $buildersProductivity[$dateNumberAsKey]['totalInDay'] = 0;
            }
            
        }
        ksort($buildersProductivity);
        return $buildersProductivity;
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
			$dayOfWeek = $this->_daysOfWeek[strtolower($date->format("l"))];

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

    private function _columnHeaders($arrayLog)
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

        $default = array('dateNumber' => 'DIA', 'dayOfWeek' => 'LITERAL', 'totalInDay' => 'TOTAL');
        $default = array_replace($default, $idsAndDefaultValue);
        foreach ($default as $key => $value) 
        {
            if(isset($this->_builders[$key]))
            {
                $builder = $this->_builders[$key];

                $default[$key] = strtoupper($builder->getFullName());
            }
        }
        return $default;
    }

	private function _builderUMBO($arrayLog)
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

//		$default = array('dateNumber' => '', 'dayOfWeek' => 'LITERAL', 'totalInDay' => 'TOTAL');
		$default = array();
		$default = array_replace($default, $idsAndDefaultValue);
		foreach ($default as $key => $value)
		{
			if(isset($this->_builders[$key]))
			{
				/** @var Model_user $builder */
				$builder = $this->_builders[$key];

				$default[$key] = floatval($builder->getUMBO());
			}
		}
		$default = array_values($default);
		$total = array_sum($default);
		array_unshift($default, $total);
		return $default;
	}
}
