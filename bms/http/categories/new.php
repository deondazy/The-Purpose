<?php

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
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
        Utility::redirect($config->site->url . '/bms/categories/');
    }

    $category = new Core\Models\Category($connection);

    $categoryId = $category->create($input);

    if ($categoryId > 0) {
        $flash->set('success', 'New Category Added');
        Utility::redirect($config->site->url . '/bms/categories/');
    }

    $flash->set('error', 'Error Adding New Category');
    Utility::redirect($config->site->url . '/bms/categories/');
} catch (Exception $e) {
    $flash->set('error', 'An error occurred while adding new category.');
    Utility::redirect($config->site->url . '/bms/categories/');
}
