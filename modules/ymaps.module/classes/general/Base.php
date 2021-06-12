<?php

namespace Ymaps;

class Base
{
    static $instance            = null;
    static $obIblock            = null;
    static $obIblockType        = null;
    static $obIblockProperty    = null;
    static $obIblockElement     = null;

    public function __construct()
    {
        \Bitrix\Main\Loader::includeModule('iblock');

        static::$obIblock             = new \CIBlock();
        static::$obIblockType         = new \CIBlockType();
        static::$obIblockProperty     = new \CIBlockProperty();
        static::$obIblockElement      = new \CIBlockElement();
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new __CLASS__;
        }

        return static::$instance;
    }
}