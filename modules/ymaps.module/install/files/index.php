<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

$APPLICATION->SetTitle("Карта офисов");

$APPLICATION->IncludeComponent(
	"ymaps:map.detail",
	"",
	array(
		'API_KEY' => '490bb441-7e3b-42b6-9685-e45bb327ee7c',
		'ZOOM' => 7
	)
);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>