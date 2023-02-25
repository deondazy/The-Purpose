<?php

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$tagId = $_POST['tag_id'] ?? null;

$tag = $container->get(Core\Models\Tag::class);
$flash = $container->get(Core\Flash::class);

if (!$tag->get('id', $tagId)) {
    $flash->set('error', 'Invalid Action');
    Utility::redirect($config->site->url . '/bms/tags/');
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
        Utility::redirect($config->site->url . '/bms/tags/edit/' . $tagId);
    }

    $affected = $tag->update(['id' => $tagId], $input);

    if ($affected > 0) {
        $flash->set('success', 'Tag Updated');
        Utility::redirect($config->site->url . '/bms/tags/edit/' . $tagId);
    } 

    $flash->set('error', 'No changes to update');
    Utility::redirect($config->site->url . '/bms/tags/edit/' . $tagId);
} catch (Exception $e) {
    $flash->set('error', 'An error occurred while updating tag.');
    Utility::redirect($config->site->url . '/bms/tags/edit/' . $tagId);
}
