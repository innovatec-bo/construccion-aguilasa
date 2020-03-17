<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls as XlsReader;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

class ExcelManPowerEntryActivity
{
    private $_sessionUser;
    private $_projectId;

    CONST FORM_QUANTITY = 25;

    public function __construct($sessionUser, $projectId)
    {
        $this->_sessionUser = $sessionUser;
        $this->_projectId = $projectId;
    }

    function getReport()
    {
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
        $project = Model_project::getById($this->_projectId);
        $project = $project->toArray();
        $laborCostMasterDetail = Model_labor_cost::getMasterDetailByProjectId($this->_projectId);
        $builders = Model_user::getByRoleKeyword('builder');

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Formulario de registro de actividad")
            ->setSubject("Registro de actividad en mano de obra")
            ->setDescription("Ingrese las actividades en cada una de las hojas de este documento")
            ->setKeywords("formulario registro actividad mano de obra")
            ->setCategory("Reporte");
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());
        
        
        // echo"<pre>";var_dump($laborCostMasterDetail);exit;
        $spreadsheet = $this->_manPower($spreadsheet, $laborCostMasterDetail, $project);
        $spreadsheet = $this->_builders($spreadsheet, $builders);
        $spreadsheet = $this->_activityForms($spreadsheet, $laborCostMasterDetail);

        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Formulario de actividad - '.$project['code_pro'].'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    private function _manPower($spreadsheet, $workflowDetail, $project)
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
        $manPowerWorkSheet->setTitle('Mano_de_obra');

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'MANO DE OBRA - PROYECTO '.$project['code_pro']);
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $spreadsheet->getActiveSheet()->getStyle('A1:L1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('A1:L1');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', "#")
            ->setCellValue('B2', "ACT.")
            ->setCellValue('C2', "ESTRUCTURA")
            ->setCellValue('D2', "EJEC.")
            ->setCellValue('E2', "DESCRIPCION")
            ->setCellValue('F2', "UNIDAD")
            ->setCellValue('G2', "CANTIDAD")
            ->setCellValue('H2', "P/UNITARIO")
            ->setCellValue('I2', "P/TOTAL")
            ->setCellValue('J2', "TRABAJADO")
            ->setCellValue('K2', "DIF.")
            ->setCellValue('L2', "SELECTOR");
        $spreadsheet->getActiveSheet()->getStyle('A2:L2')->applyFromArray($headerStyleArray);
        $counter = 1;
        $i = 2;
        // $workflowDetail = array();
        foreach ($workflowDetail as $row)
        {
            // echo"<pre>";var_dump($row);exit;
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+1), $counter)
                ->setCellValue('B'.($i+1), $row["activity"])
                ->setCellValue('C'.($i+1), $row["structure_code"])
                ->setCellValue('D'.($i+1), $row["execution"])
                ->setCellValue('E'.($i+1), $row["description"])
                ->setCellValue('F'.($i+1), $row["unit_of_measurement"])
                ->setCellValue('G'.($i+1), $row["quantity"])
                ->setCellValue('H'.($i+1), $row["unit_price"])
                ->setCellValue('I'.($i+1), $row["total_price_by_structure"])
                ->setCellValue('J'.($i+1), $row["worked_up"])
                ->setCellValue('K'.($i+1), $row["diff"])
                ->setCellValue('L'.($i+1), $row["labor_cost_id"]." ".$row["structure_code"]."_".$row["unit_of_measurement"]."_".$row["activity"]."_".$row["execution"]);
            $i++;
            $counter++;
            
        }
        //Currency format
        $spreadsheet->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        $spreadsheet->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('E2:E'.$i)->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('B2:B'.$i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('D2:D'.$i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F2:F'.$i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getColumnDimension("E")->setWidth(30);
        $spreadsheet->getActiveSheet()->getStyle('A1:L'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
        return $spreadsheet;
    }

    private function _builders($spreadsheet, $builders)
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
        $manPowerWorkSheet = $spreadsheet->createSheet(1);
        $manPowerWorkSheet->setTitle('Constructores');

        $spreadsheet->setActiveSheetIndex(1)->setCellValue('A1', 'CONSTRUCTORES');
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $spreadsheet->getActiveSheet()->getStyle('A1:D1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('A1:D1');

        $spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('A2', "#")
            ->setCellValue('B2', "NOMBRE")
            ->setCellValue('C2', "APELLIDO")
            ->setCellValue('D2', "SELECTOR");
        $spreadsheet->getActiveSheet()->getStyle('A2:D2')->applyFromArray($headerStyleArray);
        $counter = 1;
        $i = 2;
        // $workflowDetail = array();
        foreach ($builders as $row)
        {
            $row = $row->toArray();
            // echo"<pre>";var_dump($row);exit;
            $spreadsheet->setActiveSheetIndex(1)
                ->setCellValue('A'.($i+1), $counter)
                ->setCellValue('B'.($i+1), $row["firstname_usr"])
                ->setCellValue('C'.($i+1), $row["lastname_usr"])
                ->setCellValue('D'.($i+1), $row["id_usr"]." ".$row["firstname_usr"]." ".$row["lastname_usr"]);
            $i++;
            $counter++;
            
        }
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:D'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
        return $spreadsheet;
    }

    public function _activityForms($spreadsheet, $workflowDetail)
    {
        $titleStyleArray = [
            'font' => ['bold' => true, 'size' => 16],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $counter = 1;
        for ($i=2; $i <= static::FORM_QUANTITY; $i++) 
        { 
            $worksheetForm = $spreadsheet->createSheet($i);
            $worksheetForm->setTitle('Form '.$counter);
            //Title
            $spreadsheet->setActiveSheetIndex($i)->setCellValue('A2', "FORMULARIO DE REGISTRO DE ACTIVIDAD");
            $spreadsheet->getActiveSheet()->getStyle('A2:E2')->applyFromArray($titleStyleArray);
            $spreadsheet->getActiveSheet()->mergeCells('A2:E2');

            //Header data
            $spreadsheet->setActiveSheetIndex($i)->setCellValue('A4', "FECHA");
            $spreadsheet->getActiveSheet()->getStyle('A4:B4')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $spreadsheet->setActiveSheetIndex($i)->setCellValue('A5', "CONSTRUCTOR");
            $spreadsheet->setActiveSheetIndex($i)->setCellValue('A6', "DETALLE");
            $spreadsheet->getActiveSheet()->mergeCells('B6:E6');
            $spreadsheet->getActiveSheet()->getStyle('A5:E6')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()->getStyle('A4:A6')->getFont()->setBold(true);

            //Table
            $spreadsheet->setActiveSheetIndex($i)->setCellValue('A8', "ESTRUCTURA");
            $spreadsheet->setActiveSheetIndex($i)->setCellValue('B8', "CANTIDAD");
            $spreadsheet->getActiveSheet()->getStyle('A8:B20')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()->getStyle('A8:B8')->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getColumnDimension("A")->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension("B")->setWidth(27);
            $spreadsheet->getActiveSheet()->getColumnDimension("C")->setWidth(27);
            $spreadsheet->getActiveSheet()->getColumnDimension("D")->setWidth(27);
            $spreadsheet->getActiveSheet()->getColumnDimension("E")->setWidth(27);
            $this->createStructureList($spreadsheet, "A");
            $this->createValidationQuantity($spreadsheet, "B");
            $this->createBuilderList($spreadsheet, "B");
            $this->createBuilderList($spreadsheet, "C");
            $this->createBuilderList($spreadsheet, "D");
            $this->createBuilderList($spreadsheet, "E");
            $this->createDateValidation($spreadsheet, "B");

            //Nota
            $noteList = array(
                "Debe especificar al menos un constructor",
                "Debe especificar al menos una estructura",
                "No ingrese ningun valor que fuera de los que aparecen en la lista.",
                "No deje en blanco el campo de fecha. Los formularios con fecha en blanco no seran tomados en cuenta.",
                "Si especifica una fecha que ya existe, esta sera sobre escrita con la nueva informacion.",
                "No altere la informacion que esta en la hoja de Mano de obra y Constructores.",
                "La lista de estructura esta compuesta por \"codigoInterno codigoDeEstructura_unidadDeMedida_actividad_ejecucion\"",
                "La lista de constructores esta compuesta por \"codigoInterno nombreCompletoDelConstructor\"",
                "No edite el nombre de las hojas de este archivo.",
                "Revise que no este especificando mas de una vez la misma estructura en la lista de avance, ya que solo se guardara la ulima ocurrencia de la lista.",
                "Si elige una estructura no olvide ingresar su cantidad de avance y viceversa."
            );
            $spreadsheet->setActiveSheetIndex($i)->setCellValue('D8', "NOTA");
            $j = 1;
            foreach ($noteList as $row) 
            {
                $spreadsheet->setActiveSheetIndex($i)->setCellValue('D'.($j+8), $j.") ".$row);    
                $j++;
            }
            $spreadsheet->setActiveSheetIndex($i)->setCellValue('D'.($j+9), "APLIQUE LAS NOTAS ESPECIFICADAS PARA CARGAR EL FORMULARIO DE FORMA CORRECTA");
            $counter++;
        }
        $spreadsheet->setActiveSheetIndex(2);
        return $spreadsheet;
    }

    public function createStructureList($spreadsheet, $column)
    {
        $xl = $spreadsheet;
        $sht = $xl->getActiveSheet();
        $oVal = new \PhpOffice\PhpSpreadsheet\Cell\DataValidation();
        $oVal->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
        $oVal->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
        $oVal->setAllowBlank(false);
        $oVal->setShowInputMessage(true);
        $oVal->setShowErrorMessage(true);
        $oVal->setShowDropDown(true);
        $oVal->setErrorTitle('Estimado '.$this->_sessionUser->fullName);
        $oVal->setError('El valor que intentas colocar no forma parte de la lista predeterminada');
        $oVal->setPromptTitle('Lista de estructuras');
        $oVal->setPrompt('Por favor escoger una estructura de la lista predeterminada.');
        $oVal->setFormula1('Mano_de_obra!$L$3:$L$1000');

        for ($i=9; $i <= 20 ; $i++) 
        { 
            // echo"<pre>";var_dump($column.$i);exit;
            $sht->setDataValidation($column.$i, $oVal);    
        }
    }

    public function createValidationQuantity($spreadsheet, $column)
    {
        $xl = $spreadsheet;
        $sht = $xl->getActiveSheet();
        $oVal = new \PhpOffice\PhpSpreadsheet\Cell\DataValidation();
        $oVal->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_DECIMAL );
        $oVal->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
        $oVal->setAllowBlank(true);
        $oVal->setShowInputMessage(true);
        $oVal->setShowErrorMessage(true);
        $oVal->setErrorTitle('Estimado '.$this->_sessionUser->fullName);
        $oVal->setError('Por favor ingresar un numero valido entero o decimal. Los valores fuera de este criterio no seran tomados en cuenta.');
        $oVal->setPromptTitle('Cantidad de avance');
        $oVal->setPrompt("Ingrese un numero mayor que 0\n(puede ser un numero decimal)");

        for ($i=9; $i <= 20 ; $i++) 
        { 
            $sht->setDataValidation($column.$i, $oVal);    
        }
    }

    public function createBuilderList($spreadsheet, $column)
    {
        $xl = $spreadsheet;
        $sht = $xl->getActiveSheet();
        $oVal = new \PhpOffice\PhpSpreadsheet\Cell\DataValidation();
        $oVal->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
        $oVal->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
        $oVal->setAllowBlank(false);
        $oVal->setShowInputMessage(true);
        $oVal->setShowErrorMessage(true);
        $oVal->setShowDropDown(true);
        $oVal->setErrorTitle('Estimado '.$this->_sessionUser->fullName);
        $oVal->setError('El valor que intentas colocar no forma parte de la lista de constructores');
        $oVal->setPromptTitle('Lista de constructores');
        $oVal->setPrompt('Por favor escoger un constructor de la lista predeterminada.');
        $oVal->setFormula1('Constructores!$D$3:$D$500');

        $sht->setDataValidation($column."5", $oVal);
    }

    public function createDateValidation($spreadsheet, $column)
    {
        $xl = $spreadsheet;
        $sht = $xl->getActiveSheet();
        $oVal = new \PhpOffice\PhpSpreadsheet\Cell\DataValidation();
        $oVal->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_DATE );
        $oVal->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
        $oVal->setAllowBlank(false);
        $oVal->setShowInputMessage(true);
        $oVal->setShowErrorMessage(true);
        $oVal->setShowDropDown(false);
        $oVal->setErrorTitle('Estimado '.$this->_sessionUser->fullName);
        $oVal->setError('El valor que intentas colocar no cuenta con el formato especifico de fecha permitida. Este dato es determinante para el guardado de la informacion.');
        $oVal->setPromptTitle('Formatos permitidos');
        $oVal->setPrompt("DD/MM/YYYY\nDD-MM-YYYY\nYYYY/MM/DD\nYYYY-MM-DD");
        // $oVal->setPrompt('Por favor escoger una estructura de la lista predeterminada.');
        $sht->setDataValidation($column."4", $oVal);
    }

    public function uploadActivity(Model_file $document)
    {
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
        set_time_limit(240);
        ini_set('memory_limit','256M');
        $xlsxLog = array();
        $fileLocation = FCPATH.$document->getUrl();
        $dataToSave = array();
        $datesToDelete = array();

        if(strtolower($document->getExtension()) == "xls")
        {
           $reader = new XlsReader();
        }

        elseif(strtolower($document->getExtension()) == "xlsx")
        {
           $reader = new XlsxReader();
        }

        $spreadsheet = $reader->load($fileLocation);
        $sheetList = $spreadsheet->getAllSheets();

        $i = 0;
        foreach ($sheetList as $sheetData)
        {
            if($i > 1)
            {
                $formName = trim($sheetData->getTitle());
                $xlsxLog[$formName] = array();
                $arrayData = $sheetData->toArray();
                // if($i == 3)
                // {
                //     echo"<pre>";var_dump($arrayData);exit;    
                // }
                
                //Date
                $manualEntryDate = "";
                if(isset($arrayData[3][1]))
                {
                    try 
                    {
                        $manualEntryDate = new DateTime($manualEntryDate);
                        $manualEntryDate = $manualEntryDate->format("Y-m-d");
                    } 
                    catch (Exception $e) 
                    {
                        $xlsxLog[$formName][] = "<strong>".$formName.":</strong> El formato de la fecha <strong>".$manualEntryDate."</strong> es incorrecto.";
                    }    
                }
                
                //Builders
                $builders = array();
                for ($j=1; $j < 5; $j++) 
                { 
                    if(isset($arrayData[4][$j]))
                    {
                        $builder = trim($arrayData[4][$j]);
                        $builder = explode(" ", $builder);
                        $builderId = intval($builder[0]);
                        $builders[] = $builderId;    
                    }
                }
                $builders = array_unique($builders);
                $builders = array_filter($builders);
                $builders = array_values($builders);
                // var_dump($manualEntryDate, $manualEntryDate != "");exit;
                if(count($builders) <=0 && $manualEntryDate != "")
                {
                    $xlsxLog[$formName][] = "<strong>".$formName.":</strong> No se especifico ningun constructor.";
                }
                //detail
                $detail = isset($arrayData[5][1])?trim($arrayData[5][1]):"";
                //$worked up
                $workedUp = array();
                for ($j=8; $j < 20; $j++) 
                { 
                    $laborCostId = isset($arrayData[$j][0])?trim($arrayData[$j][0]):"";
                    $laborCostId = explode(" ", $laborCostId);
                    $laborCostId = intval($laborCostId[0]);
                    $quantityWorkedUp = isset($arrayData[$j][1])?floatval(trim($arrayData[$j][1])):"";
                    if($laborCostId != "" && $quantityWorkedUp > 0)
                    {
                        $workedUp[$laborCostId] = array(
                                        "labor-cost-id" => $laborCostId,
                                        "quantity" => $quantityWorkedUp
                                    );    
                    }
                }
                $workedUp = array_values($workedUp);
                if(count($workedUp) <=0 && $manualEntryDate != "")
                {
                    $xlsxLog[$formName][] = "<strong>".$formName.":</strong> No se especifico ninguna estructura.";
                }
                
                //define if save or not
                if(count($xlsxLog[$formName]) <= 0 && $manualEntryDate != "")
                {
                    $dataToSave[$formName][] = array(
                        "detail" => $detail,
                        "manualEntryDate" => $manualEntryDate,
                        "workedUp" => $workedUp,
                        "builders" => $builders
                    );
                    $datesToDelete[] = $manualEntryDate;
                    // echo "<pre>";var_dump($userId, $detail, $manualEntryDate->format("Y-m-d"), $workedUp, $builders);exit;
                }
            }
            $i++;
        }
        $this->_deleteDates($datesToDelete, $dataToSave, $xlsxLog);
    }

    private function _deleteDates($datesToDelete,$dataToSave, $xlsxLog)
    {
        $arrayLog = Model_labor_cost_log::prepareArrayLog($this->_projectId);
        $logIds = array();
        foreach ($arrayLog as $row) 
        {
            $logDate = new DateTime($row['manualEntryDate']);
            $logDate = $logDate->format("Y-m-d");
            if(array_search($logDate, $datesToDelete))
            {
                $logIds[] = $logId;
            }
        }
        echo"<pre>";var_dump($logIds, $arrayLog, $datesToDelete, $dataToSave, $xlsxLog);exit;
    }

    private function insertData($dataToSave)
    {
        $userId = $this->_sessionUser->id;
        foreach ($dataToSave as $row)
        {
            Model_labor_cost_log::addLog($userId, $row['detail'], $row['manualEntryDate'], $row['workedUp'], $row['builders']);
        }
    }
}