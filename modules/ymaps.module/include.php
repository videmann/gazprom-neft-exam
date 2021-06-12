<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

\Bitrix\Main\Loader::registerAutoLoadClasses(
	'ymaps.module',
	[
		'Ymaps\\Demo' => 'classes/general/Demo.php'
	]
);