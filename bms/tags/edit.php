<?php

use Core\Utility;

require_once __DIR__ . '/../../bootstrap.php';

$parent = 'tags/';
$file = $parent;
$page = 'Edit Tag';

$tagId = $_GET['tag_id'] ?? null;

$tag = new Core\Models\Tag($connection);

if (!$tag->get('id', $tagId)) {
    $flash->set('error', 'Invalid Action');
    Utility::redirect($config->site->url . '/bms/tags/');
}

include __DIR__ . '/../header.php'; 
?>

    <!-- Content area -->
    <div class="content pt-0">
        <div class="row">
            <div class="col-lg-6 position-relative">
                <div class="float-end position-absolute d-flex" style="margin-top:-48px;margin-bottom: 0.5rem;z-index:999;right:10px;top:-12px;">
                    <a href="<?= $config->site->url; ?>/bms/tags/" class="btn btn-light">Go to Tags</a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="<?= $config->site->url ?>/bms/http/tags/edit/">
                            <input type="hidden" name="tag_id" value="<?= $tagId ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required autofocus value="<?= $tag->get('name', $tagId)['name'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug:</label>
                                <input type="text" class="form-control" id="slug" name="slug" required value="<?= $tag->get('slug', $tagId)['slug'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea rows="4" cols="3" class="form-control" id="description" name="description"><?= $tag->get('description', $tagId)['description'] ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>

                            <a href="<?= $config->site->url ?>/bms/http/tags/delete/<?= $tagId ?>/" class="btn btn-danger" onclick="return confirm('You are about to permanently delete this tag. This action cannot be undone. OK to delete?')">Delete</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /content area -->
<?php include __DIR__ . '/../includes/flash.php'; ?>
<?php include __DIR__ . '/../footer.php'; ?>