<?php 

require_once __DIR__ . '/../../bootstrap.php';

$parent = 'tags/';
$file = $parent;
$page = 'Tags';

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
    <div class="content pt-0">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Add New Tag</h6>
                    </div>
                    
                    <div class="card-body">
                        <form method="post" action="<?= $config->site->url ?>/bms/http/tags/new/">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug:</label>
                                <input type="text" class="form-control" id="slug" name="slug" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea rows="4" cols="3" class="form-control" id="description" name="description"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Add New Tag</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                    <table class="table table-striped datatable-basic">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Description</th>
                                    <th class="text-center">Post Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $postTag = new Core\Models\PostTag($connection);
                                $tag = (new Core\Models\Tag($connection));
                                $tags = $tag->getAll('*', ['orderBy' => ['id DESC']]);

                                foreach($tags as $tag) : ?>
                                    <tr>
                                        <td><?= $tag['id'] ?></td>
                                        <td>
                                            <a href="<?= $config->site->url ?>/bms/tags/edit/<?= $tag['id'] ?>/">
                                                <?= $tag['name'] ?>
                                            </a>

                                            <div class="actions fs-sm fw-medium mt-1">
                                                <a href="<?= $config->site->url ?>/bms/tags/edit/<?= $tag['id'] ?>/">Edit</a> <span class="text-muted fs-xs mx-1">|</span>

                                                <a class="text-danger" href="<?= $config->site->url ?>/bms/http/tags/delete/<?= $tag['id'] ?>/" onclick="return confirm('You are about to permanently delete this tag. This action cannot be undone. OK to delete?')">Delete</a> <span class="text-muted fs-xs mx-1">|</span>

                                                <a href="<?= $config->site->url ?>/tag/<?= $tag['slug'] ?>/" target="_blank">View</a>
                                            </div>
                                        </td>
                                        <td><?= $tag['slug'] ?></td>
                                        <td><?= !empty($tag['description']) ? $tag['description'] : ' — ' ?></td>
                                        <td class="text-center"><?= $postTag->count(['tag_id' => $tag['id']])['count'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Description</th>
                                    <th class="text-center">Post Count</th>
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
        var table = $('.datatable-basic').DataTable({
            columnDefs: [
                { "targets": 0, "visible": false }
            ],
            autoWidth: false,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                emptyTable: 'No categories found',
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '←' : '→', 'previous': document.dir == "rtl" ? '→' : '←' }
            }
        });
        table.order([0, 'desc']).draw();
    })
</script>

<script>
// Make Strings URL-safe
function slug(text) {
    return text.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
}

document.addEventListener('DOMContentLoaded', function() {
  const titleInput = document.querySelector('input[name="name"]');
  const slugInput = document.querySelector('input[name="slug"]');

  titleInput.addEventListener('keyup', function() {
    slugInput.value = slug(titleInput.value);
  });
});
</script>
<?php include __DIR__ . '/../includes/flash.php'; ?>
<?php include __DIR__ . '/../footer.php'; ?>