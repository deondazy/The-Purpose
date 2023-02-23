<script src="<?= $config->site->url; ?>/bms/assets/js/vendor/noty.min.js"></script>

<script> 
Noty.overrideDefaults({
    theme: 'limitless',
    layout: 'topRight',
    type: 'alert',
    timeout: 2500
});
</script>

<?php
// Check for success messages and display them
if ($flash->has('success')) {
    echo "<script>new Noty({
        text: '{$flash->get('success')}',
        type: 'success'
    }).show();</script>";
}

// Check for error messages and display them
if ($flash->has('error')) {
    echo "<script>new Noty({
        text: '{$flash->get('error')}',
        type: 'error'
    }).show();</script>";
}
?>