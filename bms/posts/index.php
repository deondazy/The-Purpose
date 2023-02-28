<?php 

use Core\Utility;
use Atlas\Query\Select;

require_once __DIR__ . '/../../bootstrap.php';

$parent = 'posts/';
$file = $parent;
$page = 'Manage Posts';

$postCategory = new Core\Models\PostCategory($connection);
$postTag = new Core\Models\PostTag($connection);
$tag = new Core\Models\Tag($connection);
$post = new Core\Models\Post($connection, $postCategory, $postTag, $tag);

$allPostsCount = $post->count();
$publishedPostsCount = $post->count(['status' => 'PUBLISH']);
$draftPostsCount = $post->count(['status' => 'DRAFT']);
$trashPostsCount = $post->count(['status' => 'TRASH']);

$status = $_GET['post_status'] ?? null;

if (!is_null($status) && !in_array($status, ['published', 'draft', 'trash'])) {
    $flash->set('error', 'What are you doing?');
    Utility::redirect($config->site->url . '/bms/posts/');
}

// What status is active
function activeStatus($active) {
    global $status;

    return ($active == $status);
}

include __DIR__ . '/../header.php'; 
?>

<style>
    .actions {
        visibility: hidden;
    }
    tr:hover .actions {
        visibility: visible;
    }
</style>

    <!-- Content area -->
    <div class="content pt-0 position-relative">
        <div class="float-end position-absolute d-flex" style="margin-top:-48px;margin-bottom: 0.5rem;z-index:999;right:20px;top:-12px;gap: 10px;">
            <a href="<?= $config->site->url; ?>/bms/posts/new/" class="btn btn-primary">Add New Post</a>
        </div>

        <div class="mb-2">
            <a <?= is_null($status) ? "class='text-black fw-bold'" : '' ?> href="<?= $config->site->url ?>/bms/posts/">All (<?= ($allPostsCount['count'] - $trashPostsCount['count']) ?>)</a> 

            <?php if ($publishedPostsCount['count'] > 0) : ?>
                <span class="text-muted fs-xs mx-1">|</span>
                <a <?= activeStatus('published') ? "class='text-black fw-bold'" : '' ?> href="<?= $config->site->url ?>/bms/posts/status/published/">Published (<?= $publishedPostsCount['count'] ?>)</a> 
            <?php endif; ?>
            
            <?php if ($draftPostsCount['count'] > 0) : ?>
                <span class="text-muted fs-xs mx-1">|</span>
                <a <?= activeStatus('draft') ? "class='text-black fw-bold'" : '' ?> href="<?= $config->site->url ?>/bms/posts/status/draft/">Draft (<?= $draftPostsCount['count'] ?>)</a> 
            <?php endif; ?>

            <?php if ($trashPostsCount['count'] > 0) : ?>
                <span class="text-muted fs-xs mx-1">|</span>
                <a <?= activeStatus('trash') ? "class='text-black fw-bold'" : '' ?> href="<?= $config->site->url ?>/bms/posts/status/trash/">Trash (<?= $trashPostsCount['count'] ?>)</a>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped datatable-basic">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Categories</th>
                                    <th>Tags</th>
                                    <th class="text-center">Comments</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $query = Select::new($connection)
                                    ->columns(
                                        'p.id',
                                        'p.title',
                                        'p.slug',
                                        'p.author',
                                        'p.status',
                                        'p.created_at',
                                        'p.updated_at',
                                        "GREATEST( p.created_at, p.updated_at ) as latest_date",
                                        "GROUP_CONCAT(DISTINCT c.name ORDER BY c.name SEPARATOR ', ') AS categories",
                                        "GROUP_CONCAT(DISTINCT t.name ORDER BY t.name SEPARATOR ', ') AS tags",
                                        "GROUP_CONCAT(DISTINCT c.slug ORDER BY c.name SEPARATOR ', ') AS category_slugs",
                                        "GROUP_CONCAT(DISTINCT t.slug ORDER BY t.name SEPARATOR ', ') AS tag_slugs",
                                        "COUNT(DISTINCT co.id) AS comment_count",
                                        "u.id AS author_id",
                                        "u.display_name AS author_display_name",
                                    )
                                    ->from('posts p')
                                    ->join('LEFT', 'post_categories pc', 'p.id = pc.post_id')
                                    ->join('LEFT', 'categories c', 'pc.category_id = c.id')
                                    ->join('LEFT', 'post_tags pt', 'p.id = pt.post_id')
                                    ->join('LEFT', 'tags t', 'pt.tag_id = t.id')
                                    ->join('LEFT', 'users u', 'p.author = u.id')
                                    ->join('LEFT', 'comments co', 'p.id = co.post_id');

                                    if ($status) {
                                        $status = ($status == 'published') ? 'publish' : $status;
                                        $query->whereEquals(['p.status' => $status]);
                                    } else {
                                        $query->where('p.status !=', 'trash');
                                    }
                                    
                                    $query->groupBy('p.id')
                                    ->orderBy("latest_date DESC");

                                    
                                    $posts = $query->fetchAll();
                                    
                                    foreach ($posts as $post) : ?>
                                    <tr>
                                        <td class="fw-bold">
                                            <?php if ($status != 'trash') : ?>
                                                <a href="<?= $config->site->url ?>/bms/posts/edit/<?= $post['id'] ?>">
                                                    <?= $post['title'] ?>
                                                </a>
                                                <span class="text-muted"><?= ($post['status'] == 'DRAFT' && $status == null) ? ' — <span class="badge bg-info me-1">Draft</span>' : '' ?></span>

                                                <div class="actions fs-sm fw-medium mt-1">
                                                    <a href="<?= $config->site->url ?>/bms/posts/edit/<?= $post['id'] ?>/">Edit</a> <span class="text-muted fs-xs mx-1">|</span>
                                                    <a class="text-danger" href="<?= $config->site->url ?>/bms/http/posts/trash/<?= $post['id'] ?>/">Trash</a> <span class="text-muted fs-xs mx-1">|</span>
                                                    <a href="<?= $config->site->url ?>/blog/<?= $post['slug'] ?>/" target="_blank">View</a>
                                                </div>
                                            <?php else : ?>
                                                <span class="text-muted"><?= $post['title'] ?></span>
                                                <div class="actions fs-sm fw-medium mt-1">
                                                    <a href="<?= $config->site->url ?>/bms/http/posts/restore/<?= $post['id'] ?>/">Restore</a> <span class="text-muted fs-xs mx-1">|</span>
                                                    <a class="text-danger" href="<?= $config->site->url ?>/bms/http/posts/delete/<?= $post['id'] ?>/" onclick="return confirm('Post cannot be recovered after delete. Continue?')">Delete Permanently</a>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="fs-base">
                                            <a href="<?= $config->site->url ?>/bms/posts/<?= $post['author_id'] ?>"><?= $post['author_display_name']; ?></a>
                                        </td>
                                        <?php
                                        // display categories with links
                                        $postCat = $post['categories'] ?? '';
                                        $catSlugs = $post['category_slugs'] ?? '';
                                        $categories = explode(",", $postCat);
                                        $categorySlugs = explode(", ", $catSlugs);
                                        $categoryLinks = [];
                                        for ($i = 0; $i < count($categories); $i++) {
                                            $categoryLinks[] = "<a href='category.php?slug=" . $categorySlugs[$i] . "'>" . $categories[$i] . "</a>";
                                        }
                                        echo "<td class=\"fs-sm\">" . implode(", ", $categoryLinks) . "</td>";
                                        
                                        // display tags with links
                                        if (!empty($post['tags'])) {
                                            $tags = explode(", ", $post['tags']);
                                            $tagSlugs = explode(", ", $post['tag_slugs']);
                                            $tagLinks = [];
                                            for ($i = 0; $i < count($tags); $i++) {
                                                $tagLinks[] = "<a href='tag.php?slug=" . $tagSlugs[$i] . "'>" . $tags[$i] . "</a>";
                                            }
                                            echo "<td class=\"fs-sm\">" . implode(", ", $tagLinks) . "</td>";
                                        } else {
                                            echo "<td class=\"fs-sm\"> — </td>";
                                        }
                                        ?>
                                        <td class="fs-sm text-center"><?= $post['comment_count'] ?></td>
                                        
                                        <td class="fs-sm" data-order="<?= $post['latest_date'] ?>">
                                            <?= ($post['status'] == 'DRAFT' || $post['status'] == 'TRASH') ? 'Last Modified' : 'Published' ?><br />
                                            <?= Utility::formatDate($post['latest_date'], 'm/d/Y \a\t h:i a'); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Categories</th>
                                    <th>Tags</th>
                                    <th class="text-center">Comments</th>
                                    <th>Date</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /content area -->

<script src="<?= $config->site->url; ?>/bms/assets/js/vendor/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('.datatable-basic').DataTable({
            order: [[5, 'desc']],
            autoWidth: true,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                emptyTable: 'No posts found in <?= !is_null($status) ? ucfirst($status) : 'table' ?>',
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '←' : '→', 'previous': document.dir == "rtl" ? '→' : '←' }
            }
        });
    })
</script>

<?php include __DIR__ . '/../includes/flash.php'; ?>
<?php include __DIR__ . '/../footer.php'; ?>