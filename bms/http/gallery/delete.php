<?php 

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

$imageId = $_GET['image_id'];

$gallery = new Core\Models\Gallery($connection);

$id = ($gallery->get('id', $imageId)['id']) ?? null;

if ($id) {
    $file = $gallery->get('image', $imageId)['image'];

    if (!file_exists(CORE_ROOT . $file)) {
        $flash->set('error', 'Invalid Image Location');
        Utility::redirect($config->site->url . '/bms/gallery/');  
    }

    if (!unlink(CORE_ROOT . $file)) {
        $flash->set('error', 'Unable to delete Image');
        Utility::redirect($config->site->url . '/bms/gallery/');  
    }

    if ($gallery->delete(['id' => $id]) == 0) {
        $flash->set('error', 'Error Removing Content');
        Utility::redirect($config->site->url . '/bms/gallery/');  
    }

    $flash->set('success', 'Image permanently deleted');
    Utility::redirect($config->site->url . '/bms/gallery/');    
} else {
    $flash->set('error', 'Invalid action');
    Utility::redirect($config->site->url . '/bms/gallery/');
}

