<?php

namespace App;

class App {

    /** @var \Core\FileDB **/
    public static $db;
    
    /** @var \Core\Session **/
    public static $session;

    public function __construct() {
        self::$db = new \Core\FileDB(DB_FILE);
        self::$db->load();
        
        self::$session = new \Core\Session();
    }

    public function isAuthenticated() {
        return $this->getAuthUser() ? true : false;
    }

    public function getAuthUser() {
        $user_id = $_SESSION['id'] ?? false;

        if ($user_id) {
            $model = new \App\Users\Model();
            $user = $model->get(['row_id' => $user_id]);

            if ($user) {
                return $user;
            }
        }

        return false;
    }

    public function __destruct() {
        self::$db->save();
    }

}
