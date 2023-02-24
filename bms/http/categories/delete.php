<?php 

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

$catId = $_GET['category_id'];

$category = new Core\Models\Category($connection);

$id = ($category->get('id', $catId)['id']) ?? null;

if ($id) {
    $result = $category->delete(['id' => $id]);

    if ($result > 0) {
        $flash->set('success', 'Category deleted');
        Utility::redirect($config->site->url . '/bms/categories/');    
    } else {
        $flash->set('error', 'Unable to delete category');
        Utility::redirect($config->site->url . '/bms/categories/');    
    }
} else {
    $flash->set('error', 'Invalid action');
    Utility::redirect($config->site->url . '/bms/categories/');
}

