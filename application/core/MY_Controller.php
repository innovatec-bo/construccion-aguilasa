<?php
class PrivateController extends CI_Controller
{
    protected $_panelTmpl;
    protected $publicTmpl;
    protected $viewConfig = array();
    protected $menuConfig = array();

    /**
     * @var GN_Security
     */
    protected $gnSecurity;
    /**
     * @var GN_Navigation
     */
    protected $gnNavigation;
    /**
     * @var GN_ComplementHandler
     */
    protected $complementHandler;
    /**
     * @var Model_Site
     */
    protected $site;
    /**
     * @var Model_AllowedStructure
     */
    protected $allowedStructure;
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
        $this->_manageSessionPermisions();
    }

    private function _manageSessionPermisions()
    {
//        if ($this->session->has_userdata("authenticated") && $this->session->userdata("authenticated") === "1")
//        {
//            $this->allowedStructure->initFromSession();
//            $this->gnNavigation->initFromSession();
//
//            $this->sessUser = Model_User::getById($this->session->userdata("userId"));
//            $this->viewConfig["sessUserId"] = $this->sessUser->getId();
//            $this->viewConfig["isSuperAdmin"] = $this->gnSecurity->isSuperAdmin();
//        }
    }

    protected function _loadPanelView($contentView, $contentData = array())
    {
        //Add General Components
        $this->gnComplementHandler->addViewComplement("jquery");
        $this->gnComplementHandler->addViewComplement("bootstrap");
        $this->gnComplementHandler->addViewComplement("metisMenu");
        $this->gnComplementHandler->addViewComplement("sb-admin-2");

        $contentData["complementHandler"] = $this->gnComplementHandler;
        $contentData["contentView"] = $contentView;

        $this->load->view($this->_panelTmpl, array("contentData" => $contentData));
    }
}

class PublicController extends PrivateController {
    
    protected $gnTemplate;
    protected $site;
    protected $contentStringRequired;
	protected $siteMenu;
	protected $events;
	
    public function __construct() {    	
        parent::__construct();
		
		$this->contenStringsRequired=array(
					"title",
					"short_aboutus",
					"short_contactus",
					"logo",
					"index"
					);
		
        $this->load->driver('session');
        $this->site = Model_Site::getCurrentSite();
        if ($this->site != null) {
        	$this->events=Model_Event::getAllEventActiveBySite($this->site->getId());
        	$this->siteMenu=Model_Sitemenu::getSiteMenuBySite($this->site->getId());			
            $this->gnTemplate = new GN_Template($this->site->getTemplatedir(), $this->site->getTemplatefile(), $this->site->getTemplateresource(), "/static/public/general-resources");
            $this->gnTemplate->addData(array("site" => $this->site,'siteMenu'=>$this->siteMenu,'events'=>$this->events));
        } else {
            //TODO: ASK HANS WHERE TO REDIRECT IN CASE THE SITE IS NOT FOUND.
        }
    }
}
