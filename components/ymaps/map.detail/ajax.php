<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

\Bitrix\Main\Loader::includeModule('ymaps.module');

die(\Bitrix\Main\Web\Json::encode(\Ymaps\Demo::getInstance()->getList()));