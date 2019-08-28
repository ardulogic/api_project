<?php

namespace App\Users;

class User {

    private $data = [];

    public function __construct($data = null) {
        if ($data) {
            $this->setData($data);
        } else {
            $this->data = [
                'email' => null,
                'password' => null
            ];
        }
    }

    public function setData($array) {
        $this->setEmail($array['email'] ?? null);
        $this->setPassword($array['password'] ?? null);
    }

    public function getData() {
        return [
            'email' => $this->getEmail(),
            'password' => $this->getPassword()
        ];
    }

    public function setEmail(String $email) {
        $this->data['email'] = $email;
    }

    public function setPassword(String $password) {
        $this->data['password'] = $password;
    }

    public function getEmail() {
        return $this->data['email'];
    }

    public function getPassword() {
        return $this->data['password'];
    }

}
