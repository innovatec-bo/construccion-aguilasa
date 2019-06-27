<?php

class Model_file extends Model_file_base {

    public function __construct($originalFileName = "", $fileName = "", $filePath = "", $extension = "", $size = "", $height = "", $width = "", $mimeType = "", $hash = "", $url = "")
    {
        parent::__construct($originalFileName, $fileName, $filePath, $extension, $size, $height, $width, $mimeType, $hash, $url);
    }

    public static function getByHash($hash)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        select * from sys_files where hash_fil = ".$ci->db->escape($hash)."
        ";
        $query = $ci->db->query($sql);
        $response = static::recast(get_called_class(), $query->row());
        return $response;
    }
}
