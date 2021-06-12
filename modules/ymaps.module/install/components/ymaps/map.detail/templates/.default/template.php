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
	var items = <?=CUtil::PhpToJSObject($arResult['ITEMS'])?>;
	ymaps.ready(function() {
		window.map = new ymaps.Map('map', {
			center: items[0].COORDS.split(', '),
			zoom: 7
		});

		window.collection = new ymaps.GeoObjectCollection(null, {
			preset: 'islands#blueIcon'
		});

		Array.prototype.forEach.call(items, function(item) {
			window.collection.add(
				new ymaps.Placemark(item.COORDS.split(', '))
			)
		});

		window.map.geoObjects.add(window.collection);
	})
</script>