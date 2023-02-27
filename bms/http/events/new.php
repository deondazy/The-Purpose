<?php

use Carbon\Carbon;
use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

try {
    $input = [
        'title'    => Utility::escape($_POST['title']),
        'link'     => Utility::escape($_POST['link']),
        'date'     => Utility::escape($_POST['date']),
        'hour'     => Utility::escape($_POST['hour']),
        'minute'   => Utility::escape($_POST['minute']),
        'meridiem' => Utility::escape($_POST['meridiem']),
        'image'    => $_FILES['image'],
    ];

    $validator = new Core\Validator([
        'title'    => 'required',
        'link'     => 'required|url',
        'date'     => 'required',
        'hour'     => 'required',
        'minute'   => 'required',
        'meridiem' => 'required',
        'image'    => 'required',
    ]);

    $messages = [
        'title' => [
            'required' => 'Title is required',
        ],
        'link' => [
            'required' => 'Link is required',
            'url' => 'Link must be a valid URL',
        ],
        'date' => [
            'required' => 'Date is required',
        ],
        'hour' => [
            'required' => 'Time is required',
        ],
        'minute' => [
            'required' => 'Time is required',
        ],
        'meridiem' => [
            'required' => 'Time is invalid'
        ],
        'image' => [
            'required' => 'Image is required'
        ],
    ];
    
    if (!$validator->validate($input, $messages)) {
        foreach ($validator->getErrors() as $error) {
            $flash->set('error', $error[0]);
        }
        Utility::redirect($config->site->url . '/bms/events/');
    }

    $image = handleFeaturedImage($input['image']);

    $formattedDateTime = Carbon::createFromFormat(
        'm/d/Y h:i a', 
        "{$input['date']} {$input['hour']}:{$input['minute']} {$input['meridiem']}")
    ->format('Y-m-d H:i:s');

    $input['event_date'] = $formattedDateTime;
    $input['image'] = $image;

    unset($input['date'], $input['hour'], $input['minute'], $input['meridiem']);

    if ((new Core\Models\Event($connection))->create($input) > 0) {
        $flash->set('success', 'New Event Added');
        Utility::redirect($config->site->url . '/bms/events/');
    }

    $flash->set('error', 'Error Adding New Event');
    Utility::redirect($config->site->url . '/bms/events/');
} catch (Exception $e) {
    $flash->set('error', $e->getMessage()); //'An error occurred, please try again.'
    Utility::redirect($config->site->url . '/bms/events/');
}

function handleFeaturedImage($file): ?string
{
    global $flash, $config;

    if (empty($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $uploader = new Core\ImageUploader(CORE_ROOT . '/public/uploads/events/');

    try {
        return $uploader->upload($file);
    } catch (Core\Exception\FileSizeExceededException $e) {
        $flash->set('error', $e->getMessage());
        Utility::redirect($config->site->url . '/bms/posts/new');
    } catch (Core\Exception\UnsupportedFileTypeException $e) {
        $flash->set('error', $e->getMessage());
        Utility::redirect($config->site->url . '/bms/posts/new');
    } catch (Core\Exception\InvalidFileException $e) {
        $flash->set('error', $e->getMessage());
        Utility::redirect($config->site->url . '/bms/posts/new');
    } catch (Core\Exception\InvalidImageException $e) {
        $flash->set('error', $e->getMessage());
        Utility::redirect($config->site->url . '/bms/posts/new');
    } catch (Exception $e) {
        $flash->set('error', 'Something went wrong, please try again.');
        Utility::redirect($config->site->url . '/bms/posts/new');
    }
}
