<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * @var $arParams
 * @var $arResult
 */
$asset = \Bitrix\Main\Page\Asset::getInstance();
$asset->addJs('//api-maps.yandex.ru/2.1/?apikey='.$arParams['API_KEY'].'&lang=ru_RU');
$asset->addCss('//stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css');
$asset->addString('<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"/>');

CJSCore::Init(['popup']);
?>

<div class="center-container">
	<div class="map">
		<div id="map" class="map__map"></div>
		<div class="map__sticker">
			<ul class="offices-list offices-list--thin">
                <?foreach ($arResult['ITEMS'] as $office):?>
					<li class="offices-list__item office"
						data-values='<?=\Bitrix\Main\Web\Json::encode($office)?>'
						id="office_<?=$office['id']?>">

						<h5 class="office__title"><?=$office['name']?></h5>
						<p class="office__city"><?=$office['city']?></p>
						<ul class="office__contacts contacts-list">
							<li class="office-contact contact-list__contact">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
									<path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
									<path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
								</svg>
								<a href="tel:<?=$office['phone']?>"
								   class="office-link office-contact--phone"><?=$office['phone']?></a>
							</li>
							<li class="office-contact contact-list__contact">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
									<path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
								</svg>
								<a href="mailto:<?=$office['mail']?>"
								   class="office-link office-contact--email"><?=$office['email']?></a>
							</li>
						</ul>
					</li>
                <?endforeach;?>
			</ul>
		</div>
	</div>
</div>

<script>
	window.JSYmapsItems = <?=CUtil::PhpToJSObject($arResult['ITEMS'])?>;
</script>