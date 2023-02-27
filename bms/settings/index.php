<?php 

require_once __DIR__ . '/../../bootstrap.php';

$parent = 'settings/';
$file = $parent;
$page = 'Settings';

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
                        <form method="post" action="<?= $config->site->url ?>/bms/http/users/edit/" enctype="multipart/form-data">
                            <input name="user_id" type="hidden" value="<?= $userId ?>">
                            <div class="card-header">
                                <h6 class="mb-0">Name</h6>
                            </div>
                        
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username:</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?= $username ?>" disabled>
                                    <p class="text-muted mt-1 fs-sm">Username cannot be changed</p>
                                </div>

                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name:</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $firstName ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name:</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $lastName ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="website" class="form-label">Display Name:</label>
                                    <?php $getDisplayNames = Utility::getDisplayNames($username, $firstName, $lastName) ?>
                                    
                                    <select class="form-select" id="display_name" name="display_name">
                                    <?php foreach ($getDisplayNames as $dname) : ?>
                                        <option <?= ($dname == $displayName) ? 'selected' : '' ?>><?= $dname ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="card-header">
                                <h6 class="mb-0">Contact Info</h6>
                            </div>

                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email: <span class="text-warning">(Required)</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required value="<?= $email ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="website" class="form-label">Website:</label>
                                    <input type="text" class="form-control" id="website" name="website" value="<?= $website ?>">
                                    <p class="text-muted mt-1">https://example.com</p>
                                </div>
                            </div>

                            <div class="card-header">
                                <h6 class="mb-0">About <?= (!defined('PROFILE')) ? 'User' : 'Yourself' ?></h6>
                            </div>
                            
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="bio" class="form-label">Biographical Info:</label>
                                    <textarea rows="5" class="form-control" id="bio" name="bio"><?= $bio ?></textarea>
                                    <p class="text-muted mt-1">Share a little biographical information to fill out your profile. This may be shown publicly.</p>
                                </div>

                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Avatar:</label>
                                    <div class="mt-2 d-flex align-items-center gap-5">
                                        <div class="avatar">
                                            <img id="avatarPreview" src="<?= $user->getAvatar($userId) ?>" width="96">
                                        </div>

                                        <div class="d-flex flex-column gap-2">
                                            <div class="upload-avatar">
                                                <button id="avatarUpload" type="button" class="btn btn-light btn-sm"><?= (is_null($avatar)) ? 'Upload' : 'Change' ?> Avatar</button>
                                                <input type="file" name="avatar" id="avatarInput" style="display: none;">
                                            </div>
                                            <?php if (!is_null($user->get('avatar', $userId)['avatar'])) : ?>
                                                <div class="remove-button">
                                                    <button id="avatarRemove" type="button" class="btn btn-danger btn-sm">Remove Avatar</button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-header">
                                <h6 class="mb-0">Account Management</h6>
                            </div>
                            
                            <div class="card-body">
                                <div class="mb-3 position-relative">
                                    <div class="mb-2">
                                        <label for="password" class="form-label">Password:</label>
                                        <button id="setNewPasswordGen" aria-expanded="false" type="button" class="btn btn-light btn-sm generate-badge-absolute mx-3">Set New Password</button>
                                    </div>
                                    
                                    <div id="setNewPassword" class="position-relative d-none">
                                        <div class="position-relative" style="flex-grow: 1; margin-right: 5px;">
                                            <input type="text" class="form-control badge-indicator-absolute" id="password" name="password">
                                            <span class="badge password-indicator-badge-absolute position-absolute end-0 top-50 translate-middle-y me-2"></span>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-flat-primary btn-sm" id="passwordToggle"><i class="ph-eye-slash"></i> <span class="mx-1">Hide</span></button>
                                            <button type="button" class="btn btn-flat-primary btn-sm" id="passwordCancel">Cancel</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">Role:</label>
                                    <select class="form-select" id="role" name="role">
                                        <?php foreach((new Core\Models\Role($connection))->getAll('id, name', ['orderBy' => ['id DESC']]) as $role) : ?>
                                            <option <?= ($assignedRole == $role['id']) ? 'selected' : '' ?> value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Update <?= (!defined('PROFILE')) ? 'User' : 'Profile' ?></button>
                            </div>
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