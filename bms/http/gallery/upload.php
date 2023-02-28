<?php 

require_once __DIR__ . '/../../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = CORE_ROOT;
    $filePath = '/public/uploads/gallery/'.date('Y').'/'.date('m').'/'.date('d').'/';

    $targetDir = $targetDir . $filePath;

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $uploadedFiles = $_FILES['image-upload'];

    $uploadSuccess = true;
  
    for ($i = 0; $i < count($uploadedFiles['name']); $i++) {
        $image = basename($uploadedFiles['name'][$i]);
        $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $newName = uniqid() . '.' . $imageFileType;
        
        $targetFile = $targetDir . $newName;

        $check = getimagesize($uploadedFiles['tmp_name'][$i]);
  
        if ($check !== false) {
            if (move_uploaded_file($uploadedFiles['tmp_name'][$i], $targetFile)) {
                $gallery = new Core\Models\Gallery($connection);
                $result = $gallery->create([
                    'name' => $newName,
                    'image' => $filePath . $newName,
                    'user_id' => $currentUserId,
                ]);
            } else {
                $error = 'Error uploading file ' . $targetFile;
                $uploadSuccess = false;
            }
        } else {
            $error = 'Invalid file format.';
            $uploadSuccess = false;
        }
    }
  
    if ($uploadSuccess) {
        echo $result;
    } else {
        echo $error;
    }
}
  