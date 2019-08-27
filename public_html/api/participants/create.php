<?php

use App\Participants\Participant;

require '../../../bootloader.php';

$db = new Core\FileDB(DB_FILE);
$modelParticipants = new \App\Participants\Model($db);

$form = [
    'fields' => [
        'name' => [
            'label' => 'Vardas:',
            'type' => 'text',
            'extra' => [
                'validators' => [
                    'validate_not_empty',
                ]
            ],
        ],
        'surname' => [
            'label' => 'Pavarde:',
            'type' => 'text',
            'extra' => [
                'validators' => [
                    'validate_not_empty',
                    //validate float
                ]
            ],
        ],
        'city' => [
            'label' => 'Miestas:',
            'type' => 'text',
            'extra' => [
                'validators' => [
                    'validate_not_empty'
                ]
            ],
        ],
    ],
    'callbacks' => [
        'success' => 'form_success',
        'fail' => 'form_fail'
    ],
];

$filtered_input = get_form_input($form);
validate_form($filtered_input, $form);

function form_success($filtered_input, &$form) {
    $newParticipant = new App\Participants\Participant($filtered_input);
    $modelParticipants = new \App\Participants\Model();
    $id = $modelParticipants->insert($newParticipant);
    $newParticipant->setId($id);

    $response = [
        'status' => 'success',
        'data' => $newParticipant->getData(),
        'error' => []
    ];
    print json_encode($response);
}

function form_fail($filtered_input, &$form) {
    $errors = [];
    foreach ($form['fields'] as $field_id => $field) {
        if (isset($field['error'])) {
            $errors[$field_id] = $field['error'];
        }
    }

    $response = [
        'status' => 'fail',
        'data' => [],
        'errors' => $errors
    ];
    print json_encode($response);
}