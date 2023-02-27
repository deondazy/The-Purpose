<?php

use Core\Utility;
use Carbon\Carbon;

require_once __DIR__ . '/../../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$categories = $_POST['categories'] ?? 1; // TODO: Use default category from settings
$tags = $_POST['items'] ?? [];
$tagsNew = $_POST['items_new'] ?? [];
$featuredImage = $_FILES['featured-image'] ?? null;
$dashDraft = isset($_POST['dash_draft']);

$date = isset($_POST['date']) ? Carbon::createFromFormat('m/d/Y', $_POST['date'])->format('Y-m-d H:i:s') : Carbon::now();

try {
    $filename = handleFeaturedImage($featuredImage);

    $input = [
        'title'          => Utility::escape($_POST['title']),
        'slug'           => empty($_POST['slug']) ? Utility::slug($_POST['title']) : Utility::escape($_POST['slug']),
        'content'        => $_POST['content'],
        'featured_image' => $filename,
        'author'         => empty($_POST['author']) ? $auth->currentUserId() : Utility::escape($_POST['author']),
        'status'         => isset($_POST['publish']) ? 'publish': 'draft',
        'created_at'     => $date,
        'updated_at'     => $date,
    ];

    $validator = new Core\Validator([
        'title'   => 'required',
        'author'  => 'required|numeric',
    ]);

    $messages = [
        'title' => [
            'required' => 'Post title can not be empty',
        ]
    ];

    if (!$validator->validate($input, $messages)) {
        foreach ($validator->getErrors() as $error) {
            $flash->set('error', $error[0]);
        }
        Utility::redirect($config->site->url . ($dashDraft ? '/bms/' : '/bms/posts/new'));
    }

    $postCategory = new Core\Models\PostCategory($connection);
    $postTag = new Core\Models\PostTag($connection);
    $tag = new Core\Models\Tag($connection);
    $post = new Core\Models\Post($connection, $postCategory, $postTag, $tag);

    $postId = $post->create($input);

    if ($postId > 0) {
        $postCategory->saveCategories($postId, $categories);
        $post->saveTags($postId, $tags, $tagsNew);

        $status = ($input['status'] == 'publish') ? 'published' : 'saved';
        
        $flash->set('success', 'Post ' .$status. ' successfully');
        Utility::redirect($config->site->url . ($dashDraft ? '/bms/' : '/bms/posts/'));
    }

    $flash->set('error', 'Error creating post');
    Utility::redirect($config->site->url . ($dashDraft ? '/bms/' : '/bms/posts/new'));
} catch (Exception $e) {
    $flash->set('error', 'An error occurred while creating post.');
    Utility::redirect($config->site->url . ($dashDraft ? '/bms/' : '/bms/posts/new'));
}

function handleFeaturedImage($file): ?string
{
    global $flash, $config;

    if (empty($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $uploader = new Core\ImageUploader(CORE_ROOT . '/public/uploads/posts/featured-images/');

    try {
        return $uploader->upload($file);
    } catch (Core\Exception\FileSizeExceededException $e) {
        $flash->set('error', $e->getMessage());
        Utility::redirect($config->site->url . '/bms/posts/new');
    } catch (Core\Exception\UnsupportedFileTypeException $e) {
        $flash->set('error', $e->getMessage());
        Utility::redirect($config->site->url . '/bms/posts/new');
    } catch (Core\Exception\InvalidFileException $e) {
        $flash->set('error', $e->getMessage());
        Utility::redirect($config->site->url . '/bms/posts/new');
    } catch (Core\Exception\InvalidImageException $e) {
        $flash->set('error', $e->getMessage());
        Utility::redirect($config->site->url . '/bms/posts/new');
    } catch (Exception $e) {
        $flash->set('error', 'Something went wrong, please try again.');
        Utility::redirect($config->site->url . '/bms/posts/new');
    }
}
