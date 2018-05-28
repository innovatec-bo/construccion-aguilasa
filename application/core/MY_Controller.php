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

    public function __construct()
    {
        parent::__construct();
        $this->_ci = &get_instance();
        $this->load->driver('session');
        $this->load->library('form_validation');
        $this->_panelTmpl = "default-template";
        $this->complementHandler = new ComplementHandler();

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

    protected function _encryptPassword($password)
    {
        $options = [
            'cost' => 10,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, $options);
        return $passwordHash;
    }
}

class PrivateController extends PublicController
{
    /**
     * @var Model_User
     */
    protected $sessionUser;

    public function __construct()
    {
        parent::__construct();
        //Add General Components
        $this->complementHandler->addViewComplement("font-awesome");
        $this->_validateSession();
    }

    protected function _loadPanelView($contentView, $contentData = array())
    {
        $contentData["complementHandler"] = $this->complementHandler;
        $contentData["contentView"] = $contentView;
        $contentData["sessionUser"] = $this->sessionUser;
        $featureList = unserialize($this->sessionUser->featureList);
        $treeFeatureHtml = Model_feature::drawTreeHtml(NULL,$featureList,array());
        $contentData["treeFeatureHtml"] = $treeFeatureHtml;

        $this->load->view($this->_panelTmpl."/panel/master/master", array("contentData" => $contentData));
    }

    private function _validateSession()
    {
        if ($this->session->has_userdata("authenticated") && $this->session->userdata("authenticated") === 1)
        {
//            $this->allowedStructure->initFromSession();
//            $this->gnNavigation->initFromSession();
            $this->sessionUser = $this->session->userdata("sessionUser");
//            $this->viewConfig["sessUserId"] = $this->sessUser->getId();
//            $this->viewConfig["isSuperAdmin"] = $this->gnSecurity->isSuperAdmin();
        }
        else
        {
            $this->session->set_flashdata("errorMessage","Your session has expired!");
            redirect(base_url("Login"));
        }
    }

    protected function _validateFeature($securityString)
    {
        $featureList = unserialize($this->sessionUser->featureList);
        $key = array_search($securityString, array_column($featureList, 'securitystring_fes'));
        if($key === FALSE)
        {
            $this->session->set_flashdata("errorMessage", "Permission denied!");
            redirect(base_url("panel/Home"));
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
        return $response;
    }
}

