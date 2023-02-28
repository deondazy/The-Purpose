<?php 

require_once __DIR__ . '/../../bootstrap.php';

$parent = 'settings/';
$file = $parent;
$page = 'Settings';

$setting = new \Core\Models\Setting($connection);

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
                    <form method="post" action="<?= $config->site->url ?>/bms/http/settings/update/" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="site_name" class="form-label">Site Name:</label>
                                <input type="text" class="form-control" id="site_name" name="site_name" value="<?= $setting->getSetting('site_name') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="donate_link" class="form-label">Donate Link:</label>
                                <input type="url" class="form-control" id="donate_link" name="donate_link" value="<?= $setting->getSetting('donate_link') ?>">
                            </div>
                        
                            <div class="mb-3">
                                <label for="site_phone" class="form-label">Phone Number:</label>
                                <input type="phone" class="form-control" id="site_phone" name="site_phone" value="<?= $setting->getSetting('site_phone') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="site_email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="site_email" name="site_email" value="<?= $setting->getSetting('site_email') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="site_address" class="form-label">Address:</label>
                                <input type="url" class="form-control" id="site_address" name="site_address" value="<?= $setting->getSetting('site_address') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="site_twitter" class="form-label">Twitter:</label>
                                <input type="url" class="form-control" id="site_twitter" name="site_twitter" value="<?= $setting->getSetting('site_twitter') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="site_facebook" class="form-label">Facebook:</label>
                                <input type="url" class="form-control" id="site_facebook" name="site_facebook" value="<?= $setting->getSetting('site_facebook') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="site_instagram" class="form-label">Instagram:</label>
                                <input type="url" class="form-control" id="site_instagram" name="site_instagram" value="<?= $setting->getSetting('site_instagram') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="site_youtube" class="form-label">Youtube:</label>
                                <input type="url" class="form-control" id="site_youtube" name="site_youtube" value="<?= $setting->getSetting('site_youtube') ?>">
                            </div>

                            <button type="submit" class="btn btn-primary">Update Settings</button>
                        </div>
                    </form>
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