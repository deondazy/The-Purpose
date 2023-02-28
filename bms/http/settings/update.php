<?php

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$setting = new Core\Models\Setting($connection);

try {

    foreach ($_POST as $name => $value) {
        $name = Utility::escape($name);
        $value = Utility::escape($value);
        
        $theSettingValue = $setting->getSetting($name);

        if (is_null($theSettingValue)) {
            $setting->addSetting($name, $value);
        } elseif ($theSettingValue != $value) {
            $setting->updateSetting($name, $value);
        }
    }

    $flash->set('success', 'Settings Updated');
    Utility::redirect($config->site->url . '/bms/settings/');
} catch (Exception $e) {
    $flash->set('error', 'An error occurred while updating settings.');
    Utility::redirect($config->site->url . '/bms/settings/');
}
