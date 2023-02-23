<?php

use Core\Utility;
use Carbon\Carbon;

require_once __DIR__ . '/../../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    var_dump($_SERVER['REQUEST_METHOD']);
    exit('Method Not Allowed');
}

$postId = $_POST['post_id'];
$categories = $_POST['categories'];
$tags = $_POST['items'] ?? [];
$tagsNew = $_POST['items_new'] ?? [];

$postCategory = new Core\Models\PostCategory($connection);
$postTag = new Core\Models\PostTag($connection);
$tag = new Core\Models\Tag($connection);
$post = new Core\Models\Post($connection, $postCategory, $postTag, $tag);

if (!$post->getAll('id', ['where' => ['id' => $postId]])) {
    $flash->set('error', 'Invalid Post');
    Utility::redirect($config->site->url . '/bms/posts/');
}

try {
    $filename = ($_FILES['featured-image']['error'] > 0) 
    ? $post->getAll('featured_image', ['where' => ['id' => $postId]])[0]['featured_image']
    : handleFeaturedImage($_FILES['featured-image']);

    $input = [
        'title'          => $_POST['title'],
        'slug'           => $_POST['slug'],
        'content'        => $_POST['content'],
        'featured_image' => $filename,
        'author'         => $_POST['author'],
        'status'         => isset($_POST['publish']) ? 'publish': 'draft',
        'updated_at'     => Carbon::now(),
    ];

    $validator = new Core\Validator([
        'title'   => 'required|min:3|max:255',
        'slug'    => 'required|min:3|max:255',
        'author'  => 'required|numeric',
    ]);

    if (!$validator->validate($input)) {
        foreach ($validator->getErrors() as $error) {
            $flash->set('error', $error[0]);
        }
        Utility::redirect($config->site->url . '/bms/posts/new/');
    }

    $post->update(['id' => $postId], $input);

    $postCategory->saveCategories($postId, $categories);
    $post->saveTags($postId, $tags, $tagsNew);

    $status = ($input['status'] == 'publish') ? 'published' : 'saved';
    
    $flash->set('success', 'Post ' .$status. ' successfully');
    Utility::redirect($config->site->url . '/bms/posts/');

    $flash->set('error', 'Error creating post');
    Utility::redirect($config->site->url . '/bms/posts/edit/' . $postId);
} catch (Exception $e) {
    $flash->set('error', 'An error occurred while creating your post');
    Utility::redirect($config->site->url . '/bms/posts/edit/' . $postId);
}

function handleFeaturedImage($file): ?string
{
    global $flash, $config, $postId;

    if (empty($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    try {
        $uploader = new Core\ImageUploader(CORE_ROOT . '/public/uploads/posts/featured-images/');
        return $uploader->upload($file);
    } catch (Core\Exception\FileSizeExceededException $e) {
        $flash->set('error', $e->getMessage());
        Utility::redirect($config->site->url . '/bms/posts/edit/'.$postId);
    } catch (Core\Exception\UnsupportedFileTypeException $e) {
        $flash->set('error', $e->getMessage());
        Utility::redirect($config->site->url . '/bms/posts/edit/'.$postId);
    } catch (Core\Exception\InvalidFileException $e) {
        $flash->set('error', $e->getMessage());
        Utility::redirect($config->site->url . '/bms/posts/edit/'.$postId);
    } catch (Core\Exception\InvalidImageException $e) {
        $flash->set('error', $e->getMessage());
        Utility::redirect($config->site->url . '/bms/posts/edit/'.$postId);
    } catch (Exception $e) {
        $flash->set('error', 'Something went wrong, please try again.');
        Utility::redirect($config->site->url . '/bms/posts/edit/'.$postId);
    }
}
