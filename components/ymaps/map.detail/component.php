<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(\Bitrix\Main\Loader::includeModule('ymaps.module'))
{
    $arResult['ITEMS'] = \Ymaps\Demo::getInstance()->getList();
}

$this->includeComponentTemplate();