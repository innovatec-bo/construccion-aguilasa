<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_feature_base extends MY_Model
{
    const TABLE_NAME = "sec_features";
    const TABLE_ID = "id_fes";
    const ATTRIB_SUFIX = "_fes";

    protected $_featureName;
    protected $_securityString;
    protected $_featureIcon;
    protected $_link;
    protected $_description;
    protected $_parentFeatureId;
    protected $_order;
    protected $_isMenu;

    public function __construct($featureName, $securityString, $featureIcon, $link, $description, $parentFeatureId, $order, $isMenu)
    {
        parent::__construct();
        $this->_featureName = $featureName;
        $this->_securityString = $securityString;
        $this->_featureIcon = $featureIcon;
        $this->_link = $link;
        $this->_description = $description;
        $this->_parentFeatureId = $parentFeatureId;
        $this->_order = $order;
        $this->_isMenu = $isMenu;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_fes" => $this->_id,
            "featurename_fes" => $this->_featureName,
            "securitystring_fes" => $this->_securityString,
            "featureicon_fes" => $this->_featureIcon,
            "link_fes" => $this->_link,
            "description_fes" => $this->_description,
            "parent_feature_id_fes" => $this->_parentFeatureId,
            "order_fes" => $this->_order,
            "is_menu_fes" => $this->_isMenu,
            "deleted_fes" => $this->_deleted,
            "createdon_fes" => $this->_createdOn,
            "createdby_fes" => $this->_createdBy,
            "editedon_fes" => $this->_editedOn,
            "editedby_fes" => $this->_editedBy
        );
        return $tableAttributes;
    }

    /**
     * @param $className
     * @param $object
     * @return object
     */
    protected static function recast($className, $object)
    {
        $response =  null;
        if ($object instanceof stdClass)
        {
            if (!class_exists($className))
                throw new InvalidArgumentException(sprintf('Inexistant class %s.', $className));

            //Let's set the values to payment object using the data from stdObject
            $instance = new $className(
                $object->featurename_fes,
                $object->securitystring_fes,
                $object->featureicon_fes,
                $object->link_fes,
                $object->description_fes,
                $object->parent_feature_id_fes,
                $object->order_fes,
                $object->is_menu_fes
            );
            $instance->_id = $object->id_fes;

            $instance->_deleted = $object->deleted_fes;
            $instance->_createdOn = $object->createdon_fes;
            $instance->_createdBy = $object->createdby_fes;
            $instance->_editedOn = $object->editedon_fes;
            $instance->_editedBy = $object->editedby_fes;
            $response = $instance;
        }
        return $response;
    }
// begin - setters
    public function setName($name)
    {
        $this->_featureName = $name;
    }

    public function setSecurityString($securityString)
    {
        $this->_securityString = $securityString;
    }

    public function setIcon($icon)
    {
        $this->_featureIcon = $icon;
    }

    public function setLink($link)
    {
        $this->_link = $link;
    }

    public function setDescription($description)
    {
        $this->_description = $description;
    }

    public function setIsMenu($isMenu)
    {
        $this->_isMenu = $isMenu;
    }
// end - setters

}