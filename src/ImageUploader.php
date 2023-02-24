<?php 

namespace Core;

use Core\Exception\FileSizeExceededException;
use Core\Exception\InvalidFileException;
use Core\Exception\InvalidImageException;
use Core\Exception\UnsupportedFileTypeException;

class ImageUploader 
{
    private const MAX_FILE_SIZE = 5; // 5MB
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif'];

    private $uploadPath;

    public function __construct(string $uploadPath) 
    {
        $this->uploadPath = $uploadPath;
    }

    public function upload(array $file): string
    {
        $filename = uniqid() . '_' . $file['name'];
        $tmpName = $file['tmp_name'];

        $this->validateImage($file);

        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }
            
        $targetPath = $this->uploadPath . '/' . $filename;
        move_uploaded_file($tmpName, $targetPath);
    
        return  $filename;
    }

    public function resizeImage(array $file, int $maxWidth, int $maxHeight): bool
    {
        $this->validateImage($file);

        // Load the image into memory using GD library
        $image = $this->loadImageFromFile($file);

        // Get image dimensions
        $origWidth = imagesx($image);
        $origHeight = imagesy($image);
        $type = exif_imagetype($file['tmp_name']);
    
        // Calculate aspect ratio
        $ratio = $origWidth / $origHeight;
    
        // Calculate new dimensions based on max width and height
        $newWidth = $maxWidth;
        $newHeight = $maxWidth / $ratio;
        
        if ($maxWidth / $maxHeight > $ratio) {
            $newWidth = $maxHeight * $ratio;
            $newHeight = $maxHeight;
        } 

        $newHeight = ceil($newHeight);
        $newWidth = ceil($newWidth);
    
        // Create new image using GD library
        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        // Resize image using GD library
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        // Output new image to file
        $this->saveImageToFile($newImage, $file, $type);
    
        // Free up memory
        imagedestroy($image);
        imagedestroy($newImage);

        return true;
    }

    private function loadImageFromFile(array $file)
    {
        $type = exif_imagetype($file['tmp_name']);

        switch ($type) {
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($file['tmp_name']);
            case IMAGETYPE_PNG:
                return imagecreatefrompng($file['tmp_name']);
            case IMAGETYPE_GIF:
                return imagecreatefromgif($file['tmp_name']);
            default:
                throw new InvalidImageException('Invalid image file.');
        }
    }

    private function saveImageToFile($image, $file, $type)
    {
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($image, $file['tmp_name'], 100);
                break;
            case IMAGETYPE_PNG:
                imagepng($image, $file['tmp_name'], 9);
                break;
            case IMAGETYPE_GIF:
                imagegif($image, $file['tmp_name']);
                break;
            default:
                throw new InvalidImageException('Invalid image file.');
        }
    }

    public function validateImage(array $file): bool
    {
        // Check if file was uploaded successfully
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            throw new InvalidFileException('No data sent');
        }
    
        // Get file details
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileTmpName = $file['tmp_name'];
    
        // Check if file is within the allowed size
        if ($fileSize > (self::MAX_FILE_SIZE * 1024 * 1024)) {
            throw new FileSizeExceededException('Maximum allowed file size is '.self::MAX_FILE_SIZE.'MB');
        }
    
        // Check if file extension is allowed
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        if (!in_array(strtolower($fileExtension), self::ALLOWED_EXTENSIONS)) {
            throw new UnsupportedFileTypeException('Only '.implode(', ', self::ALLOWED_EXTENSIONS).' are supported');
        }
    
        // Check if file is an image
        if (!is_readable($fileTmpName) || !getimagesize($fileTmpName)) {
            throw new InvalidImageException('Invalid image file.');
        }
    
        return true;
    }
}
