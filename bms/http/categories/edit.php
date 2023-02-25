<?php

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$catId = $_POST['category_id'] ?? null;

$category = $container->get(Core\Models\Category::class);

if (!$category->get('id', $catId)) {
    $flash->set('error', 'Invalid Action');
    Utility::redirect($config->site->url . '/bms/categories/');
}

try {
    $input = [
        'name'        => $_POST['name'],
        'slug'        => Utility::slug($_POST['slug']),
        'description' => $_POST['description'],
    ];

    $validator = new Core\Validator([
        'name'   => 'required|min:3|max:255',
        'slug'    => 'required|min:3|max:255',
    ]);

    if (!$validator->validate($input)) {
        foreach ($validator->getErrors() as $error) {
            $flash->set('error', $error[0]);
        }
        Utility::redirect($config->site->url . '/bms/categories/edit/' . $catId);
    }

    $affected = $category->update(['id' => $catId], $input);

    if ($affected > 0) {
        $flash->set('success', 'Category Updated');
        Utility::redirect($config->site->url . '/bms/categories/edit/' . $catId);
    } 

    $flash->set('error', 'No changes to update');
    Utility::redirect($config->site->url . '/bms/categories/edit/' . $catId);
} catch (Exception $e) {
    $flash->set('error', 'An error occurred while updating category.');
    Utility::redirect($config->site->url . '/bms/categories/edit/' . $catId);
}
