(function(window, document, BX) {

	const placemarkDefaults = {
		preset: 'islands#blueStretchyIcon',
	}

	const setActive = (current, items) => {
		if(!current.classList.contains('active')) {
			for(item of items) {
				item.classList.remove('active')
			}

			current.classList.add('active')

			current.parentElement.scrollBy({
				top: current.offsetTop,
				behavior: 'smooth'
			})
		}
	}

	const init = () => {

		const collection = new ymaps.GeoObjectCollection()
		const items = document.querySelectorAll('[data-values]')

		window.map = new ymaps.Map('map', {
			center: window.JSYmapsItems[0].coords.split(', '),
			zoom: 1,
			behaviors: ['drag', 'multiTouch', 'dblClickZoom'],
			duration: 1000,
			controls: ['zoomControl']
		})

		Array.prototype.forEach.call(items, item => {

			const values = JSON.parse(item.dataset.values)
			const coords = values.coords.split(', ')

			const office = new ymaps.Placemark(coords, {
				//balloonContentHeader: values.name,
				balloonContentBody: item.innerHTML
			}, placemarkDefaults)

			office.events.add('click', event => {
				const element = document.getElementById(`office_${values.id}`);

				setActive(element, items);
			})

			collection.add(office)

			item.addEventListener('click', event => {
				window.map.setCenter(coords);

				window.map.balloon.open(coords, item.innerHTML, {
					closeButton: true
				});

				//window.map.setZoom(13);

				setActive(item, items);
			})
		})

		window.map.geoObjects.add(collection)
		window.map.setBounds(collection.getBounds())
	}

	ymaps.ready(init)

})(window, document, BX)