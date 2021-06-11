<?php


namespace WSerxioModule;
use Bitrix\Main\Loader;

class Install extends Main
{
	public static function installDemo()
	{
		self::getInstance()
			->createIblock('demo', 2)
			->fillData(
				Main::getDataFromJson(__DIR__.'/demo.json')
			);

		return true;
	}
}