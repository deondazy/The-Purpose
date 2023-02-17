<?php 

namespace Core;

use Exception;

class ImageUploader 
{
    private $uploadPath;
    private $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
    private $maxFileSize = 5242880; // 5MB

    public function __construct($uploadPath) {
        $this->uploadPath = $uploadPath;
    }

    public function upload($file) {
        $filename = $file['name'];
        $tmpName = $file['tmp_name'];
        $size = $file['size'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array($ext, $this->allowedExtensions)) {
            throw new Exception('Invalid file type.');
        }

        if ($size > $this->maxFileSize) {
            throw new Exception('File is too large.');
        }

        $targetPath = $this->uploadPath . '/' . $filename;
        move_uploaded_file($tmpName, $targetPath);

        return $filename;
    }
}
