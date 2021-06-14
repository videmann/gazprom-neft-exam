<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadLanguageFile(__FILE__);

$arComponentDescription = array(
	"NAME" => Loc::getMessage('COMPONENT_NAME'),
	"DESCRIPTION" => Loc::getMessage('COMPONENT_DESCRIPTION'),
	"PATH" => array(
		"ID" => "Сторонние компоненты",
		"CHILD" => array(
			"ID" => "Карта офисов",
			"NAME" => Loc::getMessage('COMPONENT_NAME')
		)
	)
);