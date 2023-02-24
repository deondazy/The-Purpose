<?php 

use Core\Utility;
use Atlas\Query\Select;

require_once __DIR__ . '/../../bootstrap.php';

$parent = 'comments/';
$file = $parent;
$page = 'Comments';

$comment = new Core\Models\Comment($connection);

$allCommentsCount = $comment->count()['count'];
$myCommentsCount = $comment->getUserCommentCount(1)[0]['count']; // TODO: Use current user ID.
$pendingCommentsCount = $comment->count(['status' => 'PENDING'])['count'];
$approvedCommentsCount = $comment->count(['status' => 'APPROVED'])['count'];
$spamCommentsCount = $comment->count(['status' => 'SPAM'])['count'];
$trashCommentsCount = $comment->count(['status' => 'TRASH'])['count'];

$status = $_GET['comment_status'] ?? null;

if (!is_null($status) && !in_array($status, ['mine', 'pending', 'approved', 'spam', 'trash'])) {
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
    .warn-border {
        border-left: 4px solid var(--warning);
    }
</style>

    <!-- Content area -->
    <div class="content pt-0 position-relative">
        <div class="mb-2">
            <a <?= is_null($status) ? "class='text-black fw-bold'" : '' ?> href="<?= $config->site->url ?>/bms/comments/">All (<?= (($allCommentsCount - $spamCommentsCount) - $trashCommentsCount) ?>)</a> 

            <span class="text-muted fs-xs mx-1">|</span>
            
            <a <?= activeStatus('mine') ? "class='text-black fw-bold'" : '' ?> href="<?= $config->site->url ?>/bms/comments/status/mine/">Mine (<?= $myCommentsCount ?>)</a> 

            <span class="text-muted fs-xs mx-1">|</span>
            
            <a <?= activeStatus('pending') ? "class='text-black fw-bold'" : '' ?> href="<?= $config->site->url ?>/bms/comments/status/pending/">Pending (<?= $pendingCommentsCount ?>)</a> 

            <span class="text-muted fs-xs mx-1">|</span>
            
            <a <?= activeStatus('approved') ? "class='text-black fw-bold'" : '' ?> href="<?= $config->site->url ?>/bms/comments/status/approved/">Approved (<?= $approvedCommentsCount ?>)</a>

            <span class="text-muted fs-xs mx-1">|</span>
            
            <a <?= activeStatus('spam') ? "class='text-black fw-bold'" : '' ?> href="<?= $config->site->url ?>/bms/comments/status/spam/">Spam (<?= $spamCommentsCount ?>)</a>

            <span class="text-muted fs-xs mx-1">|</span>
            
            <a <?= activeStatus('trash') ? "class='text-black fw-bold'" : '' ?> href="<?= $config->site->url ?>/bms/comments/status/trash/">Trash (<?= $trashCommentsCount ?>)</a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped datatable-basic">
                            <thead>
                                <tr>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>Post</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 

                                // $query = Select::new($connection)
                                // ->columns(
                                //     "p.id AS postId",
                                //     "p.title AS post",
                                //     "p.slug AS slug",
                                //     "c.id AS comment_id",
                                //     "u.id AS user_id",
                                //     "c.status AS comment_status",
                                //     "(SELECT COUNT(id) FROM comments c WHERE c.post_id = p.id) AS comment_count",
                                //     "(SELECT username FROM users u WHERE c.user_id = u.id) AS comment_user",
                                //     "CASE
                                //         WHEN c.user_id = 0 THEN c.author_name
                                //         ELSE COALESCE(u.display_name, c.author_name)
                                //     END AS author",
                                //     "CONCAT(c.content) AS comment",
                                //     "c.created_at AS date", 
                                //     "COALESCE(u.email, c.author_email) AS email", 
                                //     "COALESCE(u.website, c.author_website) AS website",
                                //     "CASE
                                //         WHEN c.parent > 0 THEN CONCAT('In reply to <a href=\"', pc.author_website, '\">', COALESCE(pcu.display_name, pc.author_name), '</a> ')
                                //         ELSE ''
                                //     END AS in_reply_to"
                                // )
                                // ->from('comments c')
                                // ->join('LEFT', 'users u', 'c.user_id = u.id')
                                // ->join('', 'posts p', 'c.post_id = p.id')
                                // ->join('LEFT', 'comments pc', 'c.parent = pc.id')
                                // ->join('LEFT', 'users pcu', 'pc.user_id = pcu.id');
                                // ->whereSprintf("(pc.id IS NOT NULL OR c.parent = 0)");

                                $query = Select::new($connection)
                                    ->columns(
                                        "p.id AS postId",
                                        "p.title AS post",
                                        "p.slug AS slug",
                                        "c.id AS comment_id",
                                        "c.parent AS parent_id",
                                        "u.id AS user_id",
                                        "c.status AS comment_status",
                                        "(SELECT COUNT(id) FROM comments c WHERE c.post_id = p.id) AS comment_count",
                                        "c.content AS comment",
                                        "c.created_at AS date",
                                        "COALESCE(u.email, c.author_email) AS email",
                                        "COALESCE(u.website, c.author_website) AS website",
                                        "CASE 
                                            WHEN c.user_id = 0 THEN c.author_name
                                            ELSE u.username
                                        END AS author",
                                        "CASE 
                                            WHEN c.parent = 0 THEN NULL
                                            ELSE 
                                                CASE 
                                                    WHEN pc.user_id = 0 THEN pc.author_name
                                                    ELSE pu.username
                                                END
                                        END AS in_reply_to"
                                    )
                                    ->from("comments c")
                                    ->join("LEFT", "users u", "c.user_id = u.id")
                                    ->join("", "posts p", "c.post_id = p.id")
                                    ->join("LEFT", "comments pc", "c.parent = pc.id")
                                    ->join("LEFT", "users pu", "pc.user_id = pu.id")
                                    ->whereSprintf("(pc.id IS NOT NULL OR c.parent = 0)");

                                    // dd($query->fetchAll());

                                if ($status && $status == 'mine') {
                                    $query->catWhereSprintf(" AND u.id = 1"); // TODO: use current use ID
                                } 
                                
                                if ($status && $status != 'mine') {
                                    $query->catWhereSprintf(" AND c.status = %s", $status);
                                } else {
                                    $query->catWhereSprintf(" AND c.status != %s AND c.status != %s", 'spam', 'trash');
                                }
                                    
                                $query->orderBy("date DESC");
                                
                                $comments = $query->fetchAll();
                                
                                foreach ($comments as $comment) : ?>
                                <tr <?= ($comment['comment_status'] == 'PENDING') ? 'class="table-warning warn-border"' : '' ?>>
                                    <td>
                                        <div class="d-flex gap-2 fs-sm">
                                            <span class="">
                                                <img src="<?= (new Core\Models\User($connection))->getAvatar($comment['user_id']) ?>" height="32" width="32">
                                            </span>
                                            <span class="">
                                                <span class="fw-bold"><?= $comment['author'] ?></span><br />
                                                <a target="_blank" href="mailto:<?= $comment['email'] ?>"><?= $comment['email'] ?></a>
                                            </span>
                                        </div>
                                        <?php if (!empty($comment['website'])) : ?>
                                            <p><a target="_blank" href="<?= $comment['website'] ?>"><?= $comment['website'] ?></a></p>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fs-sm">
                                        <?php if (!empty($comment['in_reply_to'])): ?>
                                            <p>In reply to <a href="<?= $config->site->url ?>/blog/<?= $comment['slug'] ?>/#comment-<?= $comment['parent_id'] ?>"><?= $comment['in_reply_to'] ?></a></p>
                                        <?php endif ?>
                                        <?= $comment['comment'] ?>
                                        
                                        <div class="actions fs-sm mt-1">
                                            <?php if ($comment['comment_status'] == 'APPROVED' || $comment['comment_status'] == 'PENDING') : ?>
                                                <?php if ($comment['comment_status'] == 'APPROVED') : ?>
                                                    <a class="text-warning" href="<?= $config->site->url ?>/bms/http/comments/status/pending/<?= $comment['comment_id'] ?>/">Unapprove</a>
                                                <?php else : ?>
                                                    <a class="text-success" href="<?= $config->site->url ?>/bms/http/comments/status/approved/<?= $comment['comment_id'] ?>/">Approve</a>
                                                <?php endif; ?>
                                                    
                                                <span class="text-muted fs-xs mx-1">|</span>

                                                <a class="text-danger" href="<?= $config->site->url ?>/bms/http/comments/status/spam/<?= $comment['comment_id'] ?>/">Spam</a>

                                                <span class="text-muted fs-xs mx-1">|</span>

                                                <a class="text-danger" href="<?= $config->site->url ?>/bms/http/comments/status/trash/<?= $comment['comment_id'] ?>/">Trash</a>
                                            <?php elseif ($comment['comment_status'] == 'SPAM') : ?>
                                                <a class="text-success" href="<?= $config->site->url ?>/bms/http/comments/status/notspam/<?= $comment['comment_id'] ?>/">Not Spam</a>

                                                <span class="text-muted fs-xs mx-1">|</span>

                                                <a class="text-danger" href="<?= $config->site->url ?>/bms/http/comments/delete/<?= $comment['comment_id'] ?>/" onclick="return confirm('You are about to permanently delete this comment. This action cannot be undone. OK to delete?')">Delete Permanently</a>
                                            <?php else : ?>
                                                <a class="text-danger" href="<?= $config->site->url ?>/bms/http/comments/status/spam/<?= $comment['comment_id'] ?>/">Spam</a>

                                                <span class="text-muted fs-xs mx-1">|</span>

                                                <a class="text-success" href="<?= $config->site->url ?>/bms/http/comments/status/restore/<?= $comment['comment_id'] ?>/">Restore</a>

                                                <span class="text-muted fs-xs mx-1">|</span>

                                                <a class="text-danger" href="<?= $config->site->url ?>/bms/http/comments/delete/<?= $comment['comment_id'] ?>/" onclick="return confirm('You are about to permanently delete this comment. This action cannot be undone. OK to delete?')">Delete Permanently</a>
                                            <?php endif; ?>
                                                </div>


                                    </td>
                                    <td class="fs-sm">
                                        <a class="fw-bold" href="<?= $config->site->url ?>/bms/posts/edit/<?= $comment['postId'] ?>/">
                                            <?= $comment['post'] ?>
                                        </a>
                                        <div class="mt-1">
                                            <a href="<?= $config->site->url ?>/blog/<?= $comment['slug'] ?>/">View Post</a>
                                        </div>
                                        <div class="mt-1">
                                            Post Comments: <?= $comment['comment_count'] ?>
                                        </div>
                                    </td>
                                    <td class="fs-sm"><?= Utility::formatDate($comment['date'], 'Y/m/d \a\t h:i a'); ?></td>
                                </tr>
                                <?php endforeach; ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>Post</th>
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
            order: [[3, 'desc']],
            autoWidth: true,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                emptyTable: 'No comments found.',
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