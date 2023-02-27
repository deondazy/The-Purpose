<?php 

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

$eventId = $_GET['event_id'];

$event = new Core\Models\Event($connection);

$id = ($event->get('id', $eventId)['id']) ?? null;

if ($id) {
    $file = $event->get('image', $id)['image'];

    if (file_exists(CORE_ROOT . '/public/uploads/events/' . $file)) {
        unlink(CORE_ROOT . '/public/uploads/events/' . $file);
    }

    if ($event->delete(['id' => $id]) == 0) {
        $flash->set('error', 'Error deleting event');
        Utility::redirect($config->site->url . '/bms/events/');  
    }

    $flash->set('success', 'Event permanently deleted');
    Utility::redirect($config->site->url . '/bms/events/');    
} else {
    $flash->set('error', 'Invalid action');
    Utility::redirect($config->site->url . '/bms/events/');
}

