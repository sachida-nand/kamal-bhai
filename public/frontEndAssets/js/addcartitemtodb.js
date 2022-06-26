function ajaxCallForSentItemCookieTodb() {
	$.ajax({
		url: '/add-cookie-shoping-item-to-db',
		method: 'GET',
		cache: false,
		data: { _token: _token },
		success: function(data) {
			// console.log(data);
		}
	});
}