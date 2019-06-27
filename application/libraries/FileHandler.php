<?php
/**
 * Class to handle file uploading and downloading
 */
class FileHandler
{
    private $config;

    public function __construct()
    {
        $ci = &get_instance();
        $this->config = $ci->config->item('fileHandler');
        
        $ci->load->library('image_lib');
    }

    /**
     * Upload the file to a configured path in the project or to an especified
     * path
     * with original name or custom name.
     *
     * @param array $file One item of global $_FILE array
     * @param string $fileName (Optional) The new name for the upladed file
     * @param string $filePath (Optional) The new path for the uploaded file.
     * @throws Exeption On config not found
     * @return Model_File
     */
    public function fileUpload($file, $fileName = "", $filePath = "", $typeUpload="image")
    {
        if ($this->config["uploadMode"] === "normal")
        {
            return $this->uploadNormal($file, $fileName, $filePath, $typeUpload);
        }
        else
        {
            throw new Exception("The updload mode is not configurated properly");
        }
    }

    public function fileMultiUpload($fileArray, $filePath = "")
    {
        //TODO: Implement logit for file Multi Upload
    }

    /**
     * Returns the file url of a given Model_File id
     * @param int $id Model_File id
     * @return string
     */
    public function fileShow($id)
    {
        return base_url(Model_File::getById($id)->getUrl());
    }

    /**
     * Start Downloading of file by its Model_File.id
     * @param int $id Model_File id
     * @param string $newFileName (Optional) the filename shown in download
     */
    public function downloadById($id, $newFileName = '')
    {
        $file = Model_File::getById($id);
        $this->download($file, $newFileName);
    }

    /**
     * Start Downloading of file by its Model_File.hash
     * @param string $hash Model_File hash
     * @param string $newFileName (Optional) the filename shown in download
     */
    public function downloadByHash($hash, $newFileName = '')
    {
        $file = Model_File::getByHash($hash);
        $this->download($file, $newFileName);
    }

    /**
     * start Download of a File related to Model_File object
     * @param Model_File $file
     * @param string $newFileName (Optional) the filename shown in download
     */
    public function download(Model_File $file, $newFileName = '')
    {
        $fileName = $file->getFilename();
        if (!empty($newFileName))
        {
            $fileName = $newFileName . '.' . $file->getExtension();
        }

        // headers to send your file
        header("Content-Type: " . $file->getMimetype());
        header("Content-Length: " . $file->getSize());
        header('Content-Disposition: attachment; filename="' . $fileName . '"');

        // upload the file to the user and quit
        readfile($this->config["basePath"] . $file->getFilepath() . $file->getFilename());
        exit ;
    }

    /**
     * The commmon way to duplaod a file in the web server.
     * @param array $file Global php $_FILE item
     * @param string $newFileName (optional) An optional name for the uploading
     * file
     * @param string $subDirectory (optional) An alternative subdirectory to save
     * the
     * uploading file.
     * @return Model_File
     */
    private function uploadNormal($file, $newFileName = "", $subDirectory = "", $typeUpload)
    {
        if (empty($file["tmp_name"]))
        {
            //TODO: VALIDATE THE FILE SIZE BEFORE IT IS ULPLOADED TO THE TMP
            // DIRECTORY
            throw new Exception("The file could not be uploaded");
        }
        $filePath = $this->config['mainPath'];
        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        $fileSize = filesize($file['tmp_name']);
        
        if (!empty($subDirectory))
        {
            $filePath .= $subDirectory . "/";
        }

        $fullPath = $this->config['basePath'] . $filePath;
        if (!file_exists($fullPath))
        {
            mkdir($fullPath);
        }
        $uploadFileName = $this->sanitize($file['name']);
        if (!empty($newFileName))
        {
            $fileName = $this->sanitize($newFileName) . "." . strtolower($fileExt);
        }
        else
        {
            $fileName = $uploadFileName;
        }
        $fileName=time()."_".$fileName;
        $url = $filePath . $fileName;
        $fullFilePath = $this->config["basePath"] . $url;
//        $hash = sha1_file($file['tmp_name']);
        $hash = hash("sha256", $fileName);
        $imageInfo = getimagesize($file['tmp_name']);

        $width = "";
        $height = "";
        if ($imageInfo !== false)
        {
            $width = $imageInfo[0];
            $height = $imageInfo[1];
        }
        $dbFile = new Model_file($uploadFileName,$fileName,$filePath,$fileExt,$fileSize,$width,$height,$mimeType,$hash,$url);

        $this->validate($dbFile,$typeUpload);
        if (!is_writable($fullPath)) {
            throw new Exception("The destiny directory is not writable");
        }
        if (move_uploaded_file($file['tmp_name'], $fullFilePath) === false)
        {
            throw new Exception("The file could not be uploaded");
        }        
        chmod($fullFilePath, 0775);
        if(exif_imagetype($fullFilePath) !== false){
            $thumbnailPath = $this->config["basePath"].$filePath . "thumbnails/";
            $thumbnailName=str_replace($fileExt,"",$fileName);
            $thumbnailsToDelete=glob($thumbnailPath."*".$thumbnailName."*");       
            foreach ($thumbnailsToDelete as $thumbnail) { 
                if (file_exists($thumbnail)){
                    unlink($thumbnail);
                }
            }        
        }          
        return $dbFile;
    }

    /**
     * Validates if the Model_file object is permitted for uploading
     * @param Model_file $file
     * @throws Exeption
     */
    private function validate(Model_file $file, $typeUpload)
    {
        if($typeUpload=="document"){
            if (!in_array($file->getExtension(), $this->config['allowedDocuments']) && !in_array($file->getExtension(), $this->config['allowedExtensions']) && !in_array($file->getExtension(), $this->config['allowedVideos']) && !in_array($file->getExtension(), $this->config['allowedAudios']) && !in_array($file->getExtension(), $this->config['allowedCompressed']))
            {
                throw new Exception("The file extension: " . $file->getExtension() . " is not permitted.");
            }

            if ($file->getSize() > $this->config['maxDocFileSize'])
            {
                throw new Exception("The file size exceeds the max permitted");
            }

        }else{

            if (!in_array($file->getExtension(), $this->config['allowedExtensions']))
            {
                throw new Exception("The file extension: " . $file->getExtension() . " is not permitted.");
            }

            if ($file->getSize() > $this->config['maxFileSize'])
            {
                throw new Exception("The file size exceeds the max permitted");
            }

            if ($file->getWidth() > $this->config["maxFileWidth"] || $file->getHeight() > $this->config["maxFileHeight"])
            {
                throw new Exception("The file dimmension exceeds the max permitted");
            }
        }        
    }

    /**
     * Cleans the file name.
     * @param string $string The string to be sanitized
     * @param boolean $force_lowercase Default true to force lower case convert.
     */
    private function sanitize($string, $force_lowercase = true, $ranal = false)
    {
        $strip = array(
            "~",
            "`",
            "!",
            "@",
            "#",
            "$",
            "%",
            "^",
            "&",
            "*",
            "(",
            ")",
            //"_",
            "=",
            "+",
            "[",
            "{",
            "]",
            "}",
            "\\",
            "|",
            ";",
            ":",
            "\"",
            "'",
            "&#8216;",
            "&#8217;",
            "&#8220;",
            "&#8221;",
            "&#8211;",
            "&#8212;",
            "â€”",
            "â€“",
            ",",
            "<",
            // ".",
            ">",
            "/",
            "?"
        );
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($ranal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
        return ($force_lowercase) ? (function_exists('mb_strtolower')) ? mb_strtolower($clean, 'UTF-8') : strtolower($clean) : $clean;
    }

    /**
     * Adds a new Allowed file extension
     * @param string $fileExtension
     */
    public function addAllowedFileExtension($fileExtension)
    {
        $this->config['allowedExtensions'][] = $fileExtension;
    }

    public function setMaxHeight($maxHeight)
    {
        $this->config["maxFileHeight"] = $maxHeight;
    }

    public function setMaxWidth($maxWidth)
    {
        $this->config["maxFileWidth"] = $maxWidth;
    }

    public function setMaxSize($maxSize)
    {
        $this->config["maxFileSize"] = $maxSize;
    }

    public function getMaxSize()
    {
        return $this->config["maxFileSize"];
    }

    public function getMaxSizeInKb()
    {
        return $this->config["maxFileSize"] / 1000;
    }

    /**
     * Get the image thumbnail with especific max width and height.
     * It always preserve the aspect ratio of the image.
     * @param Model_File $image The image object in db
     * @param int $maxWidth The thumbnail max width in pixels
     * @param int $maxHeight The thumbnail max height in pixels
     * @return string the relative image path;
     */
    public function getThumbnail(Model_File $image, $maxWidth, $maxHeight)
    {
        $thumbnailPath = "";
        $fullFilePath = $this->config["basePath"] . $image->getFilepath() . $image->getFilename();
        if (file_exists($fullFilePath) && exif_imagetype($fullFilePath) !== false)
        {
            $thumbnailPath = $image->getFilepath() . "thumbnails/";
            $thumbnailName = "thumbnail_" . $maxWidth . "x" . $maxHeight . "_" . $image->getFilename();
            $thumbnailFullPath = $this->config["basePath"] . $thumbnailPath . $thumbnailName;
            if (!file_exists($thumbnailFullPath))
            {
                if (!file_exists($this->config["basePath"] . $thumbnailPath))
                {
                    mkdir($this->config["basePath"] . $thumbnailPath);
                }

                $config["source_image"] = $fullFilePath;
                $config['new_image'] = $thumbnailFullPath;
                $config["width"] = $maxWidth;
                $config["height"] = $maxHeight;
                $config['maintain_ratio'] = TRUE;
                
                $ci = &get_instance();
                $ci->image_lib->initialize($config);
                $ci->image_lib->resize();
                chmod($thumbnailFullPath, 0775);
            }
            return base_url($thumbnailPath . $thumbnailName);
        }
        else
        {
            $brokenLink = $this->config["basePath"] . "/static/lib/img/broken-link.jpg";
            $thumbnailPath = $this->config["mainPath"] . "thumbnails/";
            $thumbnailName = "thumbnail_" . $maxWidth . "x" . $maxHeight . "_broken-link.jpg";
            $thumbnailFullPath = $this->config["basePath"] . $thumbnailPath . $thumbnailName;
            if (!file_exists($thumbnailFullPath))
            {
                $config["source_image"] = $brokenLink;
                $config['new_image'] = $thumbnailFullPath;
                $config["width"] = $maxWidth;
                $config["height"] = $maxHeight;
                $config['maintain_ratio'] = TRUE;
                $ci = &get_instance();
                
                $ci->image_lib->initialize($config);
                $result = $ci->image_lib->resize();
            }

            return base_url($thumbnailPath . $thumbnailName);
        }
    }
    public function getMaxWidth()
    {
        return $this->config["maxFileWidth"];
    }

    public function getMaxHeight()
    {
        return $this->config["maxFileHeight"];
    }

}
