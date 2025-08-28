<?php

class Constant {
    const TYPE_MERCEDES_307 = 1;
    const TYPE_PEUGEUT_306  = 2;
    const TYPE_MAZADA_ECLIPSE  = 3;

    public static $array_select_type_car = [
        self::TYPE_MERCEDES_307 => "Mercedes 307",
        self::TYPE_PEUGEUT_306 => "Peugeot 306",
        self::TYPE_MAZADA_ECLIPSE => "Mazda eclipse",
    ];

    public static function isLogin() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            return true;
        }
        return false;
    }
    public static function getSessionUser() {
        if (isset($_SESSION['user_id']) && isset($_SESSION['name']) && isset($_SESSION['logged_in']) && isset($_SESSION['role'])) {
            return [
                'id' => $_SESSION['user_id'],
                'name' => $_SESSION['name'],
                'role' => $_SESSION['role'],
                'logged_in' => $_SESSION['logged_in'],
            ];
        }
        return [];
    }
}
?>