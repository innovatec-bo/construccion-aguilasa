<?php

class Model_file extends Model_file_base {

    public function __construct($originalFileName = "", $fileName = "", $filePath = "", $extension = "", $size = "", $height = "", $width = "", $mimeType = "", $hash = "", $url = "")
    {
        parent::__construct($originalFileName, $fileName, $filePath, $extension, $size, $height, $width, $mimeType, $hash, $url);
    }
}
