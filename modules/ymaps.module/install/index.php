<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\IO\Directory;

Loc::loadLanguageFile(__FILE__);

class Ymaps_Module extends CModule
{
	var $MODULE_ID = 'ymaps.module';
	var $MODULE_NAME = 'ymaps.module';
	var $MODULE_DESCRIPTION = 'Модуль-решение тестового задания';
	var $MODULE_VERSION = '00.00.01';
	var $MODULE_VERSION_DATE = '2021-06-11 23:06:00';

	static $demoInstance = null;

	public function getMODULEID() : string
	{
		return $this->MODULE_ID;
	}

	public function DoInstall()
	{
		global $APPLICATION;

		$from = __DIR__.'/components';
		$to = $_SERVER['DOCUMENT_ROOT'].'/local/components';

		CopyDirFiles($from, $to, true, true);

		RegisterModule($this->getMODULEID());

		if(!Directory::isDirectoryExists($_SERVER['DOCUMENT_ROOT'].'/ymaps'))
			Directory::createDirectory($_SERVER['DOCUMENT_ROOT'].'/ymaps');

		CopyDirFiles(__DIR__.'/files', $_SERVER['DOCUMENT_ROOT'].'/ymaps', true, true);

		\Bitrix\Main\Loader::includeModule('ymaps.module');

		\Ymaps\Demo::getInstance()
            ->createIblockType()
            ->createIblock()
            ->createIblockProperties(
                Loc::getMessage('PROPERTIES')
            )
            ->createIblockElements(
                Loc::getMessage('ELEMENTS')
            );

		$APPLICATION->IncludeAdminFile(
			"Установка модуля ".$this->getMODULEID(),
			__DIR__.'/step.php'
		);
	}

	public function DoUninstall()
	{
	    \Bitrix\Main\Loader::includeModule('ymaps.module');
		\Ymaps\Demo::getInstance()->delete(__DIR__);
	}
}