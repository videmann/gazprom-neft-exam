(function(window, document, BX) {

	ymaps.ready(function() {

		window.map = new ymaps.Map('map', {
			center: window.JSYmapsItems[0].coords.split(', '),
			zoom: 7,
			controls: ['zoomControl']
		});

		window.collection = new ymaps.GeoObjectCollection();

		Array.prototype.forEach.call(window.JSYmapsItems, function(item) {

			office = new ymaps.Placemark(item.coords.split(', '), {
				balloonContentHeader: '<h5>'+item.name+'</h5>',
				balloonContentBody: [
					'<a href="'+'tel:'+item.phone.replace('/\s|\-|\(|\)/', '', item.phone)+'">'+item.phone+'</a>',
					'<a href="'+'email:'+item.email+'">'+item.email+'</a>'
				]
			}, {
				balloonPanelMaxMapArea: 0,
				draggable: "true",
				preset: "islands#blueStretchyIcon",
				openEmptyBalloon: true
			});

			window.collection.add(office);

		});

		window.map.geoObjects.add(window.collection);
		window.map.setBounds(window.collection.getBounds());
	})

})(window, document, BX);