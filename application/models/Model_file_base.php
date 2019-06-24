<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_file_base extends MY_Model
{
    const TABLE_NAME = "sys_files";
    const TABLE_ID = "id_fil";
    const ATTRIB_SUFIX = "_fil";

    protected $_originalFileName;
    protected $_fileName;
    protected $_filePath;
    protected $_extension;
    protected $_size;
    protected $_height;
    protected $_width;
    protected $_mimeType;
    protected $_hash;
    protected $_url;

    public function __construct($originalFileName = "", $fileName = "", $filePath = "", $extension = "", $size = "", $height = "", $width = "", $mimeType = "", $hash = "", $url = "")
    {
        parent::__construct();
        $this->_originalFileName = $originalFileName;
        $this->_fileName = $fileName;
        $this->_filePath = $filePath;
        $this->_extension = $extension;
        $this->_size = $size;
        $this->_height = $height;
        $this->_width = $width;
        $this->_mimeType = $mimeType;
        $this->_hash = $hash;
        $this->_url = $url;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_fil" => $this->_id,
            "uploadfilename_fil" => $this->_originalFileName,
            "filename_fil" => $this->_fileName,
            "filepath_fil" => $this->_filePath,
            "extension_fil" => $this->_extension,
            "size_fil" => $this->_size,
            "height_fil" => $this->_height,
            "width_fil" => $this->_width,
            "mimetype_fil" => $this->_mimeType,
            "hash_fil" => $this->_hash,
            "url_fil" => $this->_url,
            "deleted_fil" => $this->_deleted,
            "createdon_fil" => $this->_createdOn,
            "createdby_fil" => $this->_createdBy,
            "editedon_fil" => $this->_editedOn,
            "editedby_fil" => $this->_editedBy

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
                $object->uploadfilename_fil,
                $object->filename_fil,
                $object->filepath_fil,
                $object->extension_fil,
                $object->size_fil,
                $object->height_fil,
                $object->width_fil,
                $object->mimetype_fil,
                $object->hash_fil,
                $object->url_fil
            );
            $instance->_id = $object->id_fil;

            $instance->_deleted = $object->deleted_fil;
            $instance->_createdOn = $object->createdon_fil;
            $instance->_createdBy = $object->createdby_fil;
            $instance->_editedOn = $object->editedon_fil;
            $instance->_editedBy = $object->editedby_fil;
            $response = $instance;
        }
        return $response;
    }

    public function getExtension()
    {
        return $this->_extension;
    }

    public function getSize()
    {
        return $this->_size;
    }

    public function getWidth()
    {
        return $this->_width;
    }

    public function getHeight()
    {
        return $this->_height;
    }

    public function getUrl()
    {
        return $this->_url;
    }

    public function getOriginalFileName()
    {
        return $this->_originalFileName;
    }
}