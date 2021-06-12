/*(function(window, document, BX) {
	function init() {
		BX.ajax.runComponentAction('ymaps:map.detail', 'getList', {
			mode: 'ajax',
			method: 'GET'
		}).then(function(result) {
			new ymaps.Map('map', {
				center: result[0].COORDS,
				zoom: 7
			})
		})
	}

	ymaps.ready(init);
})(window, document, BX);*/