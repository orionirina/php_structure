<?php

class Constant {
    const CATEGORY_MINIBUS = 1;
    const CATEGORY_CAMION  = 2;
    const CATEGORY_PLAISIR = 4;
    const CATEGORY_MOTO    = 5;

    const TYPE_MERCEDES = 10;
    const TYPE_RENAULT = 11;
    const TYPE_TOYOTA = 12;
    const TYPE_MAZDA = 13;

    public static $array_select_type_car = [
        self::TYPE_MERCEDES => "Mercesdes 307",
        self::TYPE_RENAULT => "Renault Clio",
        self::TYPE_TOYOTA => "Toyota hiace",
        self::TYPE_MAZDA => "Mazda Eclipse",
    ];
}