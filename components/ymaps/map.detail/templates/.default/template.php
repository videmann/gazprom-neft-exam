<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * @var $arParams
 * @var $arResult
 */
$asset = \Bitrix\Main\Page\Asset::getInstance()
    ->addJs('//api-maps.yandex.ru/2.1/?apikey='.$arParams['API_KEY'].'&lang=ru_RU');
?>

<div id="map" class="map-container"></div>
<script>
	window.JSYmapsItems = <?=CUtil::PhpToJSObject($arResult['ITEMS'])?>;
</script>