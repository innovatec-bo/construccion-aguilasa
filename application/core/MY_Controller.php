<?php
class PrivateController extends CI_Controller
{
    protected $_ci;
    /**
     * @var GN_ComplementHandler
     */
    protected $complementHandler;
    /**
     * @var Model_User
     */
    protected $sessUser;
    /**
     * @var string
     */
    protected $_panelTmpl;

    public function __construct()
    {
        parent::__construct();
        $this->_ci = &get_instance();
        $this->load->driver('session');
        $this->_panelTmpl = "default-template";
        $this->complementHandler = new ComplementHandler();
    }

    protected function _loadPanelView($contentView, $contentData = array())
    {
        //Add General Components
        $this->complementHandler->addViewComplement("jquery");
        $this->complementHandler->addViewComplement("bootstrap");
        $this->complementHandler->addViewComplement("metisMenu");
        $this->complementHandler->addViewComplement("sb-admin-2");
        $this->complementHandler->addViewComplement("font-awesome");

        $contentData["complementHandler"] = $this->complementHandler;
        $contentData["contentView"] = $contentView;

        $this->load->view($this->_panelTmpl."/panel/master/master", array("contentData" => $contentData));
    }
}

class PublicController extends PrivateController
{
    protected $gnTemplate;

    public function __construct()
    {
        parent::__construct();
        $this->complementHandler->addViewComplement("jquery");
        $this->complementHandler->addViewComplement("bootstrap");
        $this->complementHandler->addViewComplement("metisMenu");
        $this->complementHandler->addViewComplement("sb-admin-2");
    }

    protected function _loadPublicView($contentView, $contentData = array())
    {
        $contentData["complementHandler"] = $this->complementHandler;
        $contentData["contentView"] = $contentView;
        $this->load->view($this->_panelTmpl."/public/master/master", array("contentData" => $contentData));
    }
}