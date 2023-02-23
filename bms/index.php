<?php 

require_once __DIR__ . '/../bootstrap.php';

$parent = '';
$file = '';
$page = 'Dashboard';

$postCategory = new Core\Models\PostCategory($connection);
$postTag = new Core\Models\PostTag($connection);
$tag = new Core\Models\Tag($connection);
$post = new Core\Models\Post($connection, $postCategory, $postTag, $tag);
$comment = new Core\Models\Comment($connection);
$user = new Core\Models\User($connection);
$gallery = new Core\Models\Gallery($connection);

include __DIR__ . '/header.php'; ?>

<style> 
textarea {
  resize: none; /* disable the default resizing behavior */
  height: auto; /* set the initial height to auto so it adjusts to the content */
  overflow: auto; /* hide any overflow content */
  max-height: 600px;
}
</style>

    <!-- Content area -->
    <div class="content pt-0">

        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Overview</h6>
                    </div>
                    
                    <div class="card-body">

                        <div class="d-flex justify-content-between">
                            <div class>
                                <p class="post-count mb-3">
                                    <span class="me-2 ph-pencil-line"></span>
                                    <a href="<?= $config->site->url ?>/bms/posts/"><?= $post->count()['count'] ?> Posts</a>
                                </p>
                                <p class="post-count">
                                    <span class="me-2 ph-chats"></span>
                                    <a href="<?= $config->site->url ?>/bms/comments/"><?= $comment->count()['count'] ?> Comments</a>
                                </p>
                            </div>
                            <div class="me-5">
                                <p class="post-count mb-3">
                                    <span class="me-2 ph-users"></span>
                                    <a href="<?= $config->site->url ?>/bms/users/"><?= $user->count()['count'] ?> Users</a>
                                </p>
                                <p class="post-count">
                                    <span class="me-2 ph-image"></span>
                                    <a href="<?= $config->site->url ?>/bms/gallery/"><?= $gallery->count()['count'] ?> Gallery Images</a>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Recent Activities</h6>
                    </div>
                    
                    <div class="card-body">

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Quick Draft</h6>
                    </div>
                    
                    <div class="card-body">
                        <form action="<?= $config->site->url . '/bms/http/posts/new/' ?>" method="post">
                            <input type="hidden" name="dash_draft">

                            <div class="mb-3">
                                <label class="form-label">Title:</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Content:</label>
                                <textarea rows="4" cols="3" class="form-control textarea" placeholder="What's on your mind?" name="content" oninput="autoResize(this)"></textarea>
                            </div>


                            <button type="submit" class="btn btn-primary">Save Draft</button>
                        </form>
                    </div>
                    <hr />
                </div>
            </div>
        </div>

    </div>
    <!-- /content area -->
<script>
function autoResize(textarea) {
  textarea.style.height = "auto"; // reset the height to auto
  textarea.style.height = textarea.scrollHeight + "px"; // adjust the height to match the content
}
</script>
<?php include __DIR__ . '/includes/flash.php'; ?>
<?php include __DIR__ . '/footer.php'; ?>