<?php 

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

$tagId = $_GET['tag_id'];

$tag = $container->get(Core\Models\Tag::class);
$flash = $container->get(Core\Flash::class);

$id = ($tag->get('id', $tagId)['id']) ?? null;

if ($id) {
    $result = $tag->delete(['id' => $id]);

    if ($result > 0) {
        $flash->set('success', 'Tag deleted');
        Utility::redirect($config->site->url . '/bms/tags/');    
    } else {
        $flash->set('error', 'Unable to delete tag');
        Utility::redirect($config->site->url . '/bms/tags/');    
    }
} else {
    $flash->set('error', 'Invalid action');
    Utility::redirect($config->site->url . '/bms/tags/');
}

