<?php 

$parent = 'posts/';
$file = $parent;
$page = 'Manage Posts';

include __DIR__ . '/../header.php'; 
?>

    <!-- Content area -->
    <div class="content pt-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table datatable-basic">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Categories</th>
                                    <th>Tags</th>
                                    <th>Comments</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $postCategory = new Core\Models\PostCategory();
                                $postTag = new Core\Models\PostTag();
                                $tag = new Core\Models\Tag();
                                $posts = new Core\Models\Post($postCategory, $postTag, $tag);

                                foreach ($posts->get(['id', 'title', 'author', 'created_at'], ['orderBy' => ['created_at', 'DESC']]) as $post) : ?>
                                    <tr>
                                        <td><?= $post->title; ?></td>
                                        <td><?= $post->author; ?></td>
                                        <td><?= $posts->categories($post->id)->category_id; ?></td>
                                        <td>Tag One</td>
                                        <td>Comment One</td>
                                        <td><?= $post->created_at; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /content area -->

<script src="<?= $config->site->url; ?>/bms/assets/js/vendor/datatables.min.js"></script>
<script>
    // Basic initialization
$('.datatable-basic').DataTable({
	autoWidth: false,
	dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
	language: {
		search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
		searchPlaceholder: 'Type to filter...',
		lengthMenu: '<span class="me-3">Show:</span> _MENU_',
		paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '←' : '→', 'previous': document.dir == "rtl" ? '→' : '←' }
	}
});
</script>
<?php include __DIR__ . '/../footer.php'; ?>