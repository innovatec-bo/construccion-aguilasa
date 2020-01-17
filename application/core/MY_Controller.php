<?php
class PublicController extends CI_Controller
{
    protected $_ci;
    /**
     * @var ComplementHandler
     */
    protected $complementHandler;

    /**
     * @var string
     */
    protected $_panelTmpl;
    protected $_tabTitle;

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/La_Paz');
        $this->load->helper("ssl_helper");
        $this->_evalSslUsage();
        $this->_ci = &get_instance();
        $this->load->driver('session');
        $this->load->library('form_validation');
        $this->_panelTmpl = "default-template";
        $this->_tabTitle = "Login";
        $this->complementHandler = new ComplementHandler();
        $this->complementHandler->addViewComplement("jquery");
        $this->complementHandler->addViewComplement("bootstrap");
        $this->complementHandler->addViewComplement("metisMenu");
        $this->complementHandler->addViewComplement("font-awesome");
        $this->complementHandler->addViewComplement("sb-admin-2");
        $this->complementHandler->addViewComplement("jquery.blockui");
        $this->complementHandler->addProjectCss('public-custom-style', TRUE);
    }

    protected function _loadPublicView($contentView, $contentData = array())
    {
        $contentData["complementHandler"] = $this->complementHandler;
        $contentData["tabTitle"] = $this->_tabTitle;
        $contentData["contentView"] = $contentView;
        $this->load->view($this->_panelTmpl."/public/master/master", array("contentData" => $contentData));
    }

    protected function _encryptPassword($password)
    {
        $options = [
            'cost' => 10,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, $options);
        return $passwordHash;
    }

    public function loadView($viewFile, $contentData = array(), $returnAsData = FALSE)
    {
        if($returnAsData)
        {
            return $this->load->view($this->_panelTmpl."/".$viewFile, $contentData,$returnAsData);
        }
        else
        {
            $this->load->view($this->_panelTmpl."/".$viewFile, $contentData);
        }
    }

    protected function _validateObjectToEdit($parameter, $class, $onFailRedirectTo)
    {
        if(!is_numeric($parameter))
        {
            $this->session->set_flashdata("errorMessage", "Parametro incorrecto.");
            redirect(base_url($onFailRedirectTo));
        }
        $object = $class::getById($parameter);

        if(!$object instanceof $class)
        {
            $this->session->set_flashdata("errorMessage", "El objeto no existe.");
            redirect(base_url($onFailRedirectTo));
        }

        return $object;
    }

    protected function _evalSslUsage()
    {
        if(ENVIRONMENT == "production" || ENVIRONMENT == "testing" )
        {
            force_ssl();
        }
    }

    protected function _validateStatusSet($statusSet, $project)
    {
        switch ($statusSet)
        {
            case 'design':
                $keywordList = array("project_has_been_created","stakes","returned","digitization","drawing","schedule");
                break;
            case 'approvement':
                $keywordList = array("ready_to_send","already_sent","approved","canceled","rectify_design","rectify_illustration");
                break;
            case 'rectify_design':
                $keywordList = array("rectify_design", "rd_stakes", "rd_digitization", "rd_drawing");
                break;
            case 'rectify_illustration':
                $keywordList = array("rectify_illustration", "ri_digitization", "ri_drawing");
                break;
//            case 'warehouse':
//                $keywordList = array("warehouse","record_building_materials", "get_materials", "deliver_materials", "assign_to", "return_materials","materials_reception");
//                break;
            case 'building':
                $keywordList = array("assign_to","in_progress", "paused", "stopped", "completed","project_energized","as_built", "conciliation_reception", "conciliation_shipment","cre_return_order","project_return_materials", "project_real_budget_confirmation");
                break;
            default:
                $keywordList = array();
                $this->session->set_flashdata("errorMessage","El conjunto de estados es incorrecto!");
                redirect("panel/Project");
        }

        return $keywordList;
    }

    public static function array_unshift_assoc(&$arr, $key, $val)
    {
        $arr = array_reverse($arr, true);
        $arr[$key] = $val;
        $arr = array_reverse($arr, true);
        return $arr;
    }

    public static function creFiscalSupervisingList($creFiscalEmail)
    {
        $list = array(
//            SISTEMA INTEGRADO
            'luisdf@cre.com.bo' => array('albertol@cre.com.bo','nicolaps@cre.com.bo'),
            'salviocm@cre.com.bo' => array('albertol@cre.com.bo','nicolaps@cre.com.bo'),
            'rolandodc@cre.com.bo' => array('albertol@cre.com.bo','nicolaps@cre.com.bo'),
            'juancmg@cre.com.bo' => array('albertol@cre.com.bo','nicolaps@cre.com.bo'),
            'erlinac@cre.com.bo' => array('albertol@cre.com.bo','nicolaps@cre.com.bo'),
            'mariodgr@cre.com.bo' => array('albertol@cre.com.bo','nicolaps@cre.com.bo'),
            'josers@cre.com.bo' => array('albertol@cre.com.bo','nicolaps@cre.com.bo'),
            'javiervm@cre.com.bo' => array('albertol@cre.com.bo','nicolaps@cre.com.bo'),
            'miltonmr@cre.com.bo' => array('albertol@cre.com.bo','nicolaps@cre.com.bo'),
            'jhonyvv@cre.com.bo' => array('albertol@cre.com.bo','nicolaps@cre.com.bo'),//Not in excel list
//            SISTEMA INTEGRADO
            //dariojfm@cre.com.bo also manage the same people that sergiommp@cre.com.bo but just on as built and conciliation
            'juancgh@cre.com.bo' => array('rudypb@cre.com.bo','sergiommp@cre.com.bo','percygg@cre.com.bo'),
            'joseeba@cre.com.bo' => array('rudypb@cre.com.bo','sergiommp@cre.com.bo','percygg@cre.com.bo'),
            'miltonro@cre.com.bo' => array('rudypb@cre.com.bo','sergiommp@cre.com.bo','percygg@cre.com.bo'),
            'rclaure@cruztel.com' => array('rudypb@cre.com.bo','sergiommp@cre.com.bo','percygg@cre.com.bo'),
            'pablopdvm@gmail.com' => array('rudypb@cre.com.bo','sergiommp@cre.com.bo','percygg@cre.com.bo'),
            'layonelrlm@cre.com.bo' => array('rudypb@cre.com.bo','sergiommp@cre.com.bo','percygg@cre.com.bo'),//Not in excel list
//            SISTEMA INTEGRADO
            'carlosagad@cre.com.bo' => array('rudypb@cre.com.bo','carlosmc@cre.com.bo','percygg@cre.com.bo'),
            'diegoasr@cre.com.bo' => array('rudypb@cre.com.bo','carlosmc@cre.com.bo','percygg@cre.com.bo'),
            'dariojfm@cre.com.bo' => array('rudypb@cre.com.bo','carlosmc@cre.com.bo','percygg@cre.com.bo'),
//            SISTEMA MISIONES
            'santosbcg@cre.com.bo' => array('oscarbr@cre.com.bo','anibalga@cre.com.bo', 'jhonnyrc@cre.com.bo'),
            'walterag@cre.com.bo' => array('oscarbr@cre.com.bo','anibalga@cre.com.bo', 'jhonnyrc@cre.com.bo'),
            'hermanvf@cre.com.bo' => array('oscarbr@cre.com.bo','anibalga@cre.com.bo', 'jhonnyrc@cre.com.bo'),
            'santiagojse@cre.com.bo' => array('oscarbr@cre.com.bo','anibalga@cre.com.bo', 'jhonnyrc@cre.com.bo'),
//            SISTEMA GERMAN BUSH
            'joselrs@cre.com.bo' => array('rolandsh@cre.com.bo','juanjal@cre.com.bo'),
//            SISTEMA  ROBORE
            'darwindm@cre.com.bo' => array('rolandsh@cre.com.bo','wilsongg@cre.com.bo'),
//            SISTEMA  VALLES
            'oresterb@cre.com.bo' => array('rolandoecp@cre.com.bo','rogerwrc@cre.com.bo'),
            //News(Not in excel list//Not in excel list)
            'sergiommp@cre.com.bo' => array('rudypb@cre.com.bo'),
            'paulrs@cre.com.bo' => array('dariojfm@cre.com.bo','sergiommp@cre.com.bo','rudypb@cre.com.bo','percygg@cre.com.bo')
            //'sergiommp@cre.com.bo' => array('dariojfm@cre.com.bo')//solo proyectos por conciliar
        );
        return isset($list[$creFiscalEmail])?$list[$creFiscalEmail]:array();
    }

    public static function internalNoticeByStatus($status)
    {
        $statusList = array(
            "approved" => array("to" => array("maguilera@serebo.com","eddysonca@serebo.com"), "cc" => array()),
            "assign_to" => array("to" => array("fiscal","maguilera@serebo.com","eddysonca@serebo.com"), "cc" => array()),
            "in_progress" => array("to" => array("fiscal","maguilera@serebo.com","eddysonca@serebo.com"), "cc" => array()),
            "paused" => array("to" => array("fiscal","maguilera@serebo.com","eddysonca@serebo.com"), "cc" => array()),
            "completed" => array("to" => array("fiscal","maguilera@serebo.com","eddysonca@serebo.com"), "cc" => array()),
            "project_energized" => array("to" => array("fiscal","maguilera@serebo.com","eddysonca@serebo.com"), "cc" => ""),
            "cre_return_order" => array("to" => array("fiscal","maguilera@serebo.com","eddysonca@serebo.com"), "cc" => ""),
            "project_return_materials" => array("to" => array("maguilera@serebo.com"), "cc" => ""),
            "conciliation_reception" => array("to" => array("fiscal","maguilera@serebo.com","eddysonca@serebo.com"), "cc" => "")
        );
        return $statusList[$status];
    }
}

class PrivateController extends PublicController
{
    /**
     * @var Model_User
     */
    protected $sessionUser;
    protected $_projectSystems;

    public function __construct()
    {
        parent::__construct();
        //Add General Components
        $this->complementHandler = new ComplementHandler();
        $this->complementHandler->addViewComplement("jquery");
        $this->complementHandler->addViewComplement("bootstrap");
        $this->complementHandler->addViewComplement("metisMenu");
        $this->complementHandler->addViewComplement("font-awesome");
        $this->complementHandler->addViewComplement("sb-admin-2");
        $this->complementHandler->addViewComplement('bootbox');
        $this->complementHandler->addViewComplement('sweet-alert2');
        $this->complementHandler->addViewComplement("handlebars");
        $this->complementHandler->addViewComplement("handlebars.custom.helpers");
        $this->complementHandler->addViewComplement("font-awesome");
        $this->complementHandler->addViewComplement('select2');
        $this->complementHandler->addProjectCss('general-custom-style');
        $this->complementHandler->addViewComplement("jquery.blockui");
        $this->complementHandler->addProjectJs('IncidentHandler');
        $this->complementHandler->addProjectJs('general-scripts', TRUE);
        $this->_projectSystems = array(
            1 => "Sistema Santa Cruz",
            2 => "Sistema Velasco",
            3 => "Sistema Misiones",
            4 => "Sistema Camiri",
            5 => "Sistema German bush",
            6 => "Sistema Robore",
            7 => "Sistema Valles"
        );
        $this->_validateSession();
    }

    protected function _loadPanelView($contentView, $contentData = array())
    {
        $contentData["complementHandler"] = $this->complementHandler;
        $contentData["contentView"] = $contentView;
        $contentData["sessionUser"] = $this->sessionUser;
        $contentData["isSuperAdmin"] = $this->_is("super_admin");
        $contentData["showProjectQuickSearch"] = $this->_validateFeature('project_quick_search', TRUE);
        $featureList = unserialize($this->sessionUser->featureList);
        $treeFeatureHtml = Model_feature::drawTreeHtml(NULL,$featureList,array());
        $contentData["treeFeatureHtml"] = $treeFeatureHtml;

        $this->load->view($this->_panelTmpl."/panel/master/master", array("contentData" => $contentData));
    }

    private function _validateSession()
    {
        if ($this->session->has_userdata("authenticated") && $this->session->userdata("authenticated") === 1)
        {
            $this->sessionUser = $this->session->userdata("sessionUser");
        }
        else
        {
            $this->session->set_flashdata("errorMessage","Your session has expired!");
            redirect(base_url("Login"));
        }
    }

    protected function _validateFeature_deprecated($securityString)
    {
        $featureList = unserialize($this->sessionUser->featureList);
        $key = array_search($securityString, array_column($featureList, 'securitystring_fes'));

        if($key === FALSE)
        {
            if($this->input->is_ajax_request())
            {
                $response["success"] = 0;
                $response["message"] = "Permission denied!";
                echo json_encode($response);exit;
            }
            else{
                $this->session->set_flashdata("errorMessage", "Permission denied!");
                redirect(base_url("panel/Home"));
            }
        }
    }

    protected function _validateFeature($securityString, $binaryResponse = FALSE)
    {
        $featureList = unserialize($this->sessionUser->featureList);
        $key = array_search($securityString, array_column($featureList, 'securitystring_fes'));

        if(!$binaryResponse)
        {
            if($key === FALSE)
            {
                if($this->input->is_ajax_request())
                {
                    $response["success"] = 0;
                    $response["message"] = "Access denied!!!!";
                    echo json_encode($response);exit;
                }
                else{
                    $this->session->set_flashdata("errorMessage", "Access denied!");
                    redirect(base_url("panel/Home"));
                }
            }
        }
        else
        {
            $response = $key === FALSE?$key:TRUE;
            return +$response;
        }
    }

    protected function _is($roleKeyWord)
    {
        $roleList = unserialize($this->sessionUser->roleList);
        $response = array_search($roleKeyWord, $roleList);
        if($response !== FALSE)
        {
            $response = TRUE;
        }
        return +$response;
    }

    public static function getSessionUser()
    {
        $ci = &get_instance();
        $currentUser = NULL;
        if ($ci->session->has_userdata("authenticated") && $ci->session->userdata("authenticated") === 1)
        {
            $currentUser = $ci->session->userdata("sessionUser");
        }
        return $currentUser;
    }

    public static function getWorkflowColumns()
    {
        $columnList = array(
            "code_pro" => "CODIGO",
            "contract_number_con" => "CONTRATO",
            "detail_pro" => "DETALLE DEL PROYECTO",
            "percentage_inc" => "CONSTRUCCION - % FISICO",
            "detail_inc" => "DETALLE - INCIDENCIA",
            "status_name_pst" => "ESTADO",
            "project_percentage_pro" => "PROGRESO GENERAL",
            "status_log_manual_entry_date" => "INGRESO EN STATUS",
            "static_days" => "DIAS ESTATICO",
            "entry_date_pro" => "FECHA INGRESO",
            "folder_date_pro" => "FECHA CARPETA",
            "cre_fiscal_pro" => "FISCAL DE CRE",
            "system_pro" => "SISTEMA",
            "management_by_pro" => "ADMINISTRADO POR",
            "address_pro" => "DIRECCION",
            "points_pro" => "PUNTOS",
            "distance_pro" => "DISTANCIA",
            "quality_level_pro" => "NIVEL DE CALIDAD",
            "budgetary_position_pro" => "POSICION PRESUPUESTARIA",
            "cre_design_completion_date_pro" => "FECHA COMPLETADO DE DISEÑO",
            "cre_building_completion_date_pro" => "FECHA COMPLETADO DE CONSTRUCCION",            
            "stake_date" => "FECHA DE ESTAQUEADO",
            "stake_responsible" => "RESPONSABLES DE ESTAQUEADO",
            "digitization_points_quantity" => "PUNTOS DIGITALIZADOS",
            "digitization_distance" => "DISTANCIA DIGITALIZADA",
            "rd_digitization_points_quantity" => "PUNTOS RECTIFICADOS EN DIGITALIZACION",
            "rd_digitization_distance" => "DISTANCIA RECTIFICADA EN DIGITALIZACION",
            "returned_date" => "NO FACTIBLE - DEVUELTO A CRE",
            "digitization_date" => "FECHA DIGITALIZACION",
            "drawing_date" => "FECHA DIBUJO",
            "schedule_date" => "FECHA DEFINICION DE CRONOGRAMA",
            "schedule_start" => "FECHA CRONOGRAMA INICIO",
            "schedule_end" => "FECHA CRONOGRAMA FIN",
            "schedule_design_budget" => "CRONOGRAMA - IMPORTE DISEÑO",
            "already_sent_date" => "FECHA PROYECTO ENVIADO A CRE",
            "approved_date" => "FECHA APROBACION",
            "canceled_date" => "FECHA CANCELADO",
            "rectify_design_date" => "FECHA RECTIFICACION DISEÑO",
            "rectify_illustration_date" => "FECHA RECTIFICACION ILUSTRACION",
            "design_budget" => "IMPORTE - DISEÑO",
            "building_budget" => "IMPORTE - CONSTRUCCION",
            "transportation_budget" => "IMPORTE - TRANSPORTE",
            "live_line_budget" => "IMPORTE - LINEA VIVA",
            "right_of_way_budget" => "IMPORTE - DERECHO DE VIA",
            "total_approved" => "TOTAL IMPORTE APROBADO",
            "record_building_materials_date" => "FECHA GRABADO DE MATERIALES",
            "get_materials_date" => "FECHA RETIRO DE MATERIALES",
            "deliver_materials_date" => "FECHA MATERIALES A CONSTRUCCION",
            "materials_reception_date" => "FECHA RECEPCION DE MATERIALES DE CONSTR.",
            "assign_to_date" => "FECHA ASIGNACION DE RESPONSABLES CONSTR.",
            "live_line_assigned" => "LINEA VIVA",
            "power_down_assigned" => "CORTE",
            "maneuver_assigned" => "MANIOBRA",
            "builder_responsible" => "RESPONSABLE CONSTRUC.",
            "fiscal_responsible" => "RESPONSABLE FISCAL",
            "start_date_assigned" => "INICIO DE OBRA EN ASIGNACION",
            "end_date_assigned" => "FIN DE OBRA EN ASIGNACION",
            "estimated_time_assigned" => "DIAS ESTIMADOS EN ASIGNACION",
            "in_progress_date" => "FECHA INICIO DE CONSTRUC.",
            "completed_date" => "CONSTRUCCION COMPLETADA",
            "energized_pro" => "ENERGIZADO",
            "project_energized_entry_date" => "FECHA DE ENERGIZADO",
            "paused_date" => "FECHA DE PAUSA DE CONSTRUC",
            "percentage_paused" => "% DE PAUSA",
            "stopped_date" => "FECHA DE CONSTRUCCION DETENIDA",
            "percentage_stopped" => "% DE CONTRUC. DETENIDA",
            "as_built_date" => "FECHA DE ENVIO DE AS BUILT",
            "as_built_points_quantity" => "AS BUILT - PUNTOS",
            "as_built_distance" => "AS BUILT - DISTANCE",
            "conciliation_reception_date" => "FECHA RECEPCION DE CONCILIACION",
            "conciliation_shipment_date" => "FECHA ENVIO DE CONCILIACION",
            "cre_return_order_date" => "ORDEN DE DEVOLUCION DE MATERIALES",
            "project_return_materials_date" => "CONFIRMACION DE DEVOLUCION DE MATERIALES",
            "payment_order_registered_date" => "FECHA DE REGSITRO DE ORDEN DE PAGO",
            "payment_order_registered_order_number" => "NRO ORDEN DE PAGO",
            "payment_order_registered_design_budget" => "IMPORTE REAL - DISEÑO",
            "payment_order_registered_transportation_budget" => "IMPORTE REAL - TRANSPORTE",
            "payment_order_registered_live_line_budget" => "IMPORTE REAL - LINEA VIVA",
            "payment_order_registered_building_budget" => "IMPORTE REAL - CONSTRUCCION",
            "payment_order_registered_right_of_way_budget" => "IMPORTE REAL - DERECHO DE VIA",
            "payment_order_registered_total_real_budget" => "IMPORTE REAL - TOTAL",
            "payment_order_registered_invoice_number" => "NRO FACTURA",
            "payment_order_invoice_sent_date" => "FECHA DE ENVIO DE FACTURA",
            "payment_order_has_been_settled_date" => "FECHA DE LIQUIDACION"
        );
        return $columnList;
    }
}

