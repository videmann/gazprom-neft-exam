<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);

class WSerxioModule extends CModule
{
	var $MODULE_ID = 'wserxio.module';
	var $MODULE_NAME;

	public function DoInstall()
	{
		global $DB, $APPLICATION, $step;
		$APPLICATION->IncludeAdminFile(
			Loc::getMessage('FORM_INSTALL_TITLE'),
			__DIR__.'../step1.php'
		);
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