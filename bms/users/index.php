<?php 

use Core\Utility;
use Atlas\Query\Select;

require_once __DIR__ . '/../../bootstrap.php';

$parent = 'users/';
$file = $parent;
$page = 'Manage Users';

$user = new Core\Models\User($connection);

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
            <a href="<?= $config->site->url; ?>/bms/users/new/" class="btn btn-primary">Add New User</a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped datatable-basic">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-center">Posts</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php 
                                $query = Select::new($connection)
                                    ->columns(
                                        'users.id',
                                        'users.username',
                                        "CONCAT(users.first_name, ' ', users.last_name) AS name",
                                        'users.email',
                                        "MAX(roles.name) AS role",
                                        "COUNT(posts.id) AS posts",
                                    )
                                    ->from('users')
                                    ->join('LEFT', 'user_roles', 'users.id = user_roles.user_id')
                                    ->join('LEFT', 'roles', 'user_roles.role_id = roles.id')
                                    ->join('LEFT', 'posts', 'users.id = posts.author')
                                    ->groupBy('users.id')
                                    ->orderBy('id');
                                    
                                    $users = $query->fetchAll();
                                    
                                    foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?= $user['id'] ?></td>
                                        <td class="fw-bold">
                                            <div class="d-flex gap-2">
                                                <div class="avatar align-bottom">
                                                    <img src="<?= (new Core\Models\User($connection))->getAvatar($user['id']) ?>" width="40">
                                                </div>
                                                <div class="text-muted">
                                                    <span class="align-top"><?= $user['username'] ?></span>
                                                    <div class="actions fs-sm fw-medium">
                                                        <a href="<?= $config->site->url ?>/bms/users/<?= ($user['id'] != $auth->currentUserId()) ? "edit/{$user['id']}/" : 'profile/' ?>">Edit</a> 
                                                        
                                                        <span class="text-muted fs-xs mx-1">|</span>
        
                                                        <?php if ($user['id'] != $auth->currentUserId()) : ?>
                                                            <a class="text-danger" href="<?= $config->site->url ?>/bms/http/users/delete/<?= $user['id'] ?>/" onclick="return confirm('User cannot be recovered after delete. OK to Delete?')">Delete</a>
                                                            <span class="text-muted fs-xs mx-1">|</span>
                                                        <?php endif; ?>
                                                        
        
                                                        <a href="<?= $config->site->url ?>/bms/author/<?= strtolower($user['username']) ?>/">View</a> 
        
                                                    </div>
                                                </div>
                                            </div>

                                        </td>

                                        <td class="fs-sm align-top"><?= (!empty(trim($user['name']))) ? $user['name'] : ' — ' ?></td>
                                        
                                        <td class="fs-sm align-top"><a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a></td>
                                        
                                        <td class="fs-sm align-top"><?= $user['role'] ?></td>
                                        
                                        <td class="fs-sm align-top text-center"><?= $user['posts'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-center">Posts</th>
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
            columnDefs: [
                { "targets": 0, "visible": false }
            ],
            order: [[0, 'desc']],
            autoWidth: false,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                emptyTable: 'No users found',
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