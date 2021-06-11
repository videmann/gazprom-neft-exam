(function (global, scope, BX) {

	var init = function() {
		global.map = new ymaps.Map('map', {
			center: [],
			zoom: 7
		})
	}

	ymaps.ready()

})(window, document, BX);