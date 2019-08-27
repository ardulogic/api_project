<?php

use App\Participants\Model;

require '../../../bootloader.php';


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
if ($_SESSION) {
    $participantsModel = new App\Participants\Model();
    //gauname areju su $drink objektais (siuo atveju viena objekta arejuje pagal paduota id
    $participants = $participantsModel->get(['row_id' => intval($_POST['id'])]);
//    var_dump('$drinks: ', $drinks);
    //is gauto arejaus pasiimame pagal paduota id $drink objekta
    $person = $participants[0];
//    var_dump($drink);
//
//    Grazina is paduoto $drink objekto array su $drink klases metodu getData():
//    var_dump($drink->getData());

    if (!$person) {
        print json_encode([
            'status' => 'fail',
            'errors' => [
                'Participant doesn`t exist'
            ]
        ]);
    } else {
        //idedame i data holderi naujas vertes, kurias ivede useris ir kurios atejo is javascripto is fetch_update.php
        $person->setName($filtered_input['name']);
        $person->setSurname($filtered_input['surname']);
        $person->setCity($filtered_input['city']);
        //vertes, kurias idejome auksciau i data holderi updatinam ir duombazeje FileDB ka daro $drinksModel->update($drink) metodas
        $participantsModel->update($person);
//        var_dump($drink->getData());
        print json_encode([
            'status' => 'success',
            'errors' => [],
            'data' => $person->getData()
        ]);
    }
}
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

//$_SESSION ifas tikrina ar useris prisilogines ir tik tada leidzia update drinko diva su visa info
