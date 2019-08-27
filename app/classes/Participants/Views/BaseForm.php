<?php

namespace App\Participants\Views;

class BaseForm extends \Core\Views\Form {

    public function __construct($data = []) {
        $this->data = [
            'attr' => [
                'method' => 'POST',
            ],
            'fields' => [
                'name' => [
                    'label' => 'Vardas',
                    'type' => 'text',
                ],
                'surname' => [
                    'label' => 'Pavarde',
                    'type' => 'text',
                ],
                'city' => [
                    'label' => 'Miestas',
                    'type' => 'text',
                ],
            ],
            'buttons' => [
                'submit' => [
                    'title' => 'Submit',
                    'extra' => [
                        'attr' => [
                            'class' => 'red-btn'
                        ]
                    ]
                ],
            ]
        ];
    }

}
