<?php
class PrivateController extends CI_Controller
{
    /**
     * @var GN_ComplementHandler
     */
    protected $complementHandler;
    /**
     * @var Model_User
     */
    protected $sessUser;

    public function __construct()
    {
        parent::__construct();
        $this->load->driver('session');
        $this->_panelTmpl = "base-template";
        $this->complementHandler = new ComplementHandler();
    }

    protected function _loadPanelView($contentView, $contentData = array())
    {
        //Add General Components
        $this->complementHandler->addViewComplement("jquery");
        $this->complementHandler->addViewComplement("bootstrap");
        $this->complementHandler->addViewComplement("metisMenu");
        $this->complementHandler->addViewComplement("sb-admin-2");

        $contentData["complementHandler"] = $this->complementHandler;
        $contentData["contentView"] = $contentView;

        $this->load->view($this->_panelTmpl, array("contentData" => $contentData));
    }
}

class PublicController extends PrivateController {
    
    protected $gnTemplate;

    public function __construct() {    	
        parent::__construct();
    }
}
