<?php

use Core\Utility;

require_once __DIR__ . '/../../bootstrap.php';

$parent = 'categories/';
$file = $parent;
$page = 'Edit Category';

$catId = $_GET['category_id'] ?? null;

$category = new Core\Models\Category($connection);

if (!$category->get('id', $catId)) {
    $flash->set('error', 'Invalid Action');
    Utility::redirect($config->site->url . '/bms/categories/');
}

include __DIR__ . '/../header.php'; 
?>

    <!-- Content area -->
    <div class="content pt-0">
        <div class="row">
            <div class="col-lg-6 position-relative">
                <div class="float-end position-absolute d-flex" style="margin-top:-48px;margin-bottom: 0.5rem;z-index:999;right:10px;top:-12px;">
                    <a href="<?= $config->site->url; ?>/bms/categories/" class="btn btn-light">Go to Categories</a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="<?= $config->site->url ?>/bms/http/categories/edit/">
                            <input type="hidden" name="category_id" value="<?= $catId ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required autofocus value="<?= $category->get('name', $catId)['name'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug:</label>
                                <input type="text" class="form-control" id="slug" name="slug" required value="<?= $category->get('slug', $catId)['slug'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea rows="4" cols="3" class="form-control" id="description" name="description"><?= $category->get('description', $catId)['description'] ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>

                            <?php if ($catId != 1) : ?>
                                <a href="<?= $config->site->url ?>/bms/http/categories/delete/<?= $catId ?>/" class="btn btn-danger" onclick="return confirm('You are about to permanently delete this category. This action cannot be undone. OK to delete?')">Delete</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /content area -->
<?php include __DIR__ . '/../includes/flash.php'; ?>
<?php include __DIR__ . '/../footer.php'; ?>