<?
namespace WSerxioModule;

use Bitrix\Main\Localization\Loc;

class Main
{
	static $instance = null;
	static $obIblock = null;
	static $obElement = null;
	static $obProperty = null;

	static $ibid = null;

	function __construct()
	{
		self::$obIblock = new \CIBlock();
		self::$obElement = new \CIBlockElement();
		self::$obProperty = new \CIBlockProperty();
	}

	public static function getInstance()
	{
		if(is_null(self::$instance))
			self::$instance = new self();

		return self::$instance;
	}

	public function createIblock(string $code = 'demo', int $version = 2): this
	{
		self::$ibid = self::$obIblock->Add([
			'ACTIVE' => 'Y',
			'VERSION' => 2,
			'SITE_ID' => SITE_ID,
			'EXTERNAL_ID' => 'demo',
			'CODE' => 'demo'
		]);

		if(is_null(self::$ibid))
		{
			throw new \Exception(Loc::getMessage('IBLOCK_CREATION_FAILED'));
			return $this;
		}

		return $this;
	}

	public function fillData(array $items = []): array
	{
		$result = [];

		if(empty($items))
		{
			throw new \Exception(Loc::getMessage('DEMO_DATA_INSTALLATION_FAILED'));
			return $this;
		}

		foreach ($items as $item)
		{
			$result[] = self::$obElement->Add($item);
		}

		return $result;
	}

	public static function getDataFromJson(string $path)
	{
		$handle = fopen($path);

		while(!feof($handle))
		{
			yield(fgets($handle));
		}

		fclose($handle);
	}
}