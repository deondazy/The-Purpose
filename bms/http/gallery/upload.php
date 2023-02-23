<?php 

require_once __DIR__ . '/../../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = CORE_ROOT;
    $filePath = '/public/uploads/gallery/'.date('Y').'/'.date('m').'/'.date('d').'/';

    $target_dir = $target_dir . $filePath;

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $uploaded_files = $_FILES['image-upload'];

    $upload_success = true;
  
    for ($i = 0; $i < count($uploaded_files['name']); $i++) {
        $image = uniqid() . '_' . basename($uploaded_files['name'][$i]);
        $target_file = $target_dir . $image;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($uploaded_files['tmp_name'][$i]);
  
        if ($check !== false) {
            if (move_uploaded_file($uploaded_files['tmp_name'][$i], $target_file)) {
                $gallery = new Core\Models\Gallery($connection);
                $result = $gallery->create([
                    'name' => $image,
                    'image' => $filePath . $image,
                    'user_id' => 1, // TODO: Use current user ID
                ]);
            } else {
                $error = 'Error uploading file ' . $target_file;
                $upload_success = false;
            }
        } else {
            $error = 'Invalid file format.';
            $upload_success = false;
        }
    }
  
    if ($upload_success) {
        echo $result;
    } else {
        echo $error;
    }
}
  