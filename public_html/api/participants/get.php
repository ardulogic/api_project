<?php

require '../../../bootloader.php';

$model = new App\Participants\Model();

$conditions = $_POST ?? [];

$response = [
    'status' => null,
    'data' => [],
    'errors' => [],
];

$participants = $model->get($conditions);
if ($participants !== false) {
    $response['status'] = 'success';

    foreach ($participants as $person) {
        $response['data'][] = $person->getData();
    }
} else {
    $response['status'] = 'fail';
    $response['errors'][] = 'Database error!';
}

print json_encode($response);
