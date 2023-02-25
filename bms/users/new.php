<?php 

require_once __DIR__ . '/../../bootstrap.php';

$parent = 'users/';
$file = 'users/new/';
$page = 'Add New User';

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
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="<?= $config->site->url ?>/bms/http/users/new/">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username: <span class="text-warning">(Required)</span></label>
                                <input type="text" class="form-control" id="username" name="username" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email: <span class="text-warning">(Required)</span></label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name:</label>
                                <input type="text" class="form-control" id="first_name" name="first_name">
                            </div>

                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name:</label>
                                <input type="text" class="form-control" id="last_name" name="last_name">
                            </div>

                            <div class="mb-3">
                                <label for="website" class="form-label">Website:</label>
                                <input type="text" class="form-control" id="website" name="website">
                            </div>

                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label">Password: <span class="text-warning">(Required)</span></label>
                                
                                <div class="position-relative d-flex">
                                    <div class="position-relative" style="flex-grow: 1; margin-right: 5px;">
                                        <input type="text" class="form-control badge-indicator-absolute" id="password" name="password">
                                        <span class="badge password-indicator-badge-absolute position-absolute end-0 top-50 translate-middle-y me-2"></span>
                                    </div>
                                    
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-flat-primary btn-sm" id="passwordToggle"><i class="ph-eye-slash"></i> <span class="mx-1">Hide</span></button>
    
                                        <button type="button" class="btn btn-primary btn-sm generate-badge-absolute ">Generate password</button>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Role:</label>
                                <select class="form-control" id="role" name="role">
                                    <?php foreach(($container->get(Core\Models\Role::class))->getAll('id, name', ['orderBy' => ['id DESC']]) as $role) : ?>
                                        <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Add New User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /content area -->

<script src="<?= $config->site->url ?>/bms/assets/js/vendor/passy.js"></script>

<script> 
const $inputLabelAbsolute = $('.badge-indicator-absolute');
const $outputLabelAbsolute = $('.password-indicator-badge-absolute');

$.passy.requirements.length.min = 6;

$(document).ready(function() {
    $inputLabelAbsolute.passy('generate', 24);
});

const feedbackLabel = [
    {color: 'bg-danger', text: 'Weak'},
    {color: 'bg-secondary', text: 'Normal'},
    {color: 'bg-primary', text: 'Good'},
    {color: 'bg-success', text: 'Strong'}
];

// Absolute positioned badge
$inputLabelAbsolute.passy(function(strength) {
    $outputLabelAbsolute.text(feedbackLabel[strength].text);
    $outputLabelAbsolute.addClass(feedbackLabel[strength].color);
});

// Absolute badge
$('.generate-badge-absolute').on('click', function() {
    $inputLabelAbsolute.passy('generate', 24);
});

$('#passwordToggle').click(function() {
    $passBox = $('#password');
    $passType = $passBox.attr('type');

    if ($passType == 'text') {
        $passBox.attr('type', 'password');
        $(this).html('<i class="ph-eye"></i> <span class="mx-1">Show</span>');
    } else {
        $(this).html('<i class="ph-eye-slash"></i> <span class="mx-1">Hide</span>');
        $passBox.attr('type', 'text');
    }
})
</script>

<?php include __DIR__ . '/../includes/flash.php'; ?>
<?php include __DIR__ . '/../footer.php'; ?>