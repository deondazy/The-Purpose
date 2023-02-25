<?php

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

$flash = $container->get(Core\Flash::class);

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
        Utility::redirect($config->site->url . '/bms/tags/');
    }

    $tag = $container->get(Core\Models\Tag::class);

    $tagId = $tag->create($input);

    if ($tagId > 0) {
        $flash->set('success', 'New Tag Added');
        Utility::redirect($config->site->url . '/bms/tags/');
    }

    $flash->set('error', 'Error Adding New Tag');
    Utility::redirect($config->site->url . '/bms/tags/');
} catch (Exception $e) {
    $flash->set('error', 'An error occurred while adding new tag');
    Utility::redirect($config->site->url . '/bms/tags/');
}
