<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);

class WSerxio_Module extends CModule
{
	var $MODULE_ID = 'wserxio.module';
	var $MODULE_NAME = 'wserxio.module';
	var $MODULE_DESCRIPTION = 'Модуль-решение тестового задания';
	var $MODULE_VERSION = '00.00.01';
	var $MODULE_VERSION_DATE = '2021-06-11 23:06:00';

	public function DoInstall()
	{
		global $DB, $APPLICATION, $step;
		$APPLICATION->IncludeAdminFile(
			Loc::getMessage('FORM_INSTALL_TITLE'),
			__DIR__.'../step1.php'
		);

		$this->InstallDemo();
		/**
		 * Создать highload блок:
		 * 1. code 'map-data'
		 * 2. поля:
		 * - UF_NAME
		 * - UF_PHONE
		 * - UF_EMAIL
		 * - UF_COORDS
		 * - UF_CITY
		 */

		/**
		 * Создать 5-6 записей
		 * Можно создать Json файл с демо-данными
		 */
	}
}