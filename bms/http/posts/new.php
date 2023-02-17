<?php 

require_once __DIR__ . '/../../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categories    = $_POST['categories'];
    $tags          = isset($_POST['items']) ? $_POST['items'] : [];
    $tagsNew       = isset($_POST['items_new']) ? $_POST['items_new'] : [];

    // Convert date to Y-m-d H:i:s format
    $date = DateTime::createFromFormat('m/d/Y', $_POST['date']);

    // Handle featured image
    if (isset($_FILES['featured-image']) && $_FILES['featured-image']['error'] == 0) {
        $uploader = new Core\ImageUploader(__DIR__ . '/../../uploads/posts/featured-images/');
        try {
            $filename = $uploader->upload($_FILES['featured-image']);
        } catch (Exception $e) {
            echo "Error uploading file: " . $e->getMessage();
        }
    }

    $input = [
        'title'          => $_POST['title'],
        'slug'           => $_POST['slug'],
        'content'        => $_POST['content'],
        'featured_image' => isset($filename) ? $filename : null,
        'author'         => $_POST['author'],
        'status'         => isset($_POST['publish']) ? 'publish': 'draft',
        'created_at'     => $date->format('Y-m-d H:i:s'),
    ];

    $validator = new Core\Validator([
        'title'         => 'required|min:3|max:255',
        'slug'          => 'required|min:3|max:255',
        'content'       => 'required|min:3',
        'author'        => 'required|numeric',
    ]);

    if ($validator->validate($input)) {
        // Save Post to database
        $postCategory = new Core\Models\PostCategory();
        $postTag = new Core\Models\PostTag();
        $tag = new Core\Models\Tag();
        $post = new Core\Models\Post($postCategory, $postTag, $tag);

        try {
            
            $database->beginTransaction();
            
            $postId = $post->create($input);
            
            if ($postId > 0) {
                // Save categories
                $post->saveCategories($postId, $categories);

                // Save tags
                $post->saveTags($postId, $tags, $tagsNew);

                // Redirect to posts page
                header('Location: /bms/');
            }

            $database->commit();
        } catch (Exception $e) {
            $database->rollBack();

            // TODO: Handle the error 
            // echo "Error: " . $e->getMessage();
        }
    } else {
        // TODO: Input is invalid, handle errors
        // $validator->getErrors();
    }
}
