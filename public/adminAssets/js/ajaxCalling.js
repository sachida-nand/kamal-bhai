// remove update popup messages
function removeUpdtateMsg() {
	setTimeout(function() {
		$('.alert-section').children().first().remove();
	}, 4000);
}

function successMsg(result) {
	$('.alert-section').append(`
		<div class="custome_alert alerts show">
			<span class="icon"><i class="far fa-check-circle"></i></span>
			<span class="msg">${result.msg}</span>
			<span class="cross" ><i class="fas fa-times"></i></span>
		</div>`);
}

function errorMsg(result) {
	$('.alert-section').append(`
		<div class="error_alert alerts show">
			<span class="icon"><i class="far fa-check-circle"></i></span>
			<span class="msg">${result.msg}</span>
			<span class="cross" ><i class="fas fa-times"></i></span>
		</div>`);
}
// const { post } = require("jquery");

//************************ product section start **************************/

// product Image remove
const _token = $('meta[name="csrf-token"]').attr('content');
$(document).on('click', '.cancel', function() {
	if ($(this).attr('id') > 0) {
		$_this = $(this);
		ProductImageId = $(this).attr('id');
		ImageType = $(this).attr('data');
		$.ajax({
			url: imageRemoveUrl,
			method: 'POST',
			data: { ProductImageId: ProductImageId, ImageType: ImageType, _token: _token },
			dataType: 'json',
			success: function(result) {
				if (result.status == 'success') {
					$('#remove').remove();
					$_this.closest('div').remove();
				}
			}
		});
	} else {
		// document.getElementById('thumbnail_img').value = '';
		$(this).closest('div').remove();
	}
});

//product is featured update
$(document).on('click', 'input[name= "is_featured"]', function() {
		productId = $(this).attr('id');
		$.ajax({
			url: isFeaturedUpdateUrl,
			method: 'POST',
			data: { productId: productId, _token: _token },
			dataType: 'json',
			success: function(result) {
				if (result.status == 'Success') {
					// console.log(result);
					successMsg(result);
				} else {
                    errorMsg(result);
				}
				removeUpdtateMsg();
			}
		});
});

//product is trending update
$(document).on('click', 'input[name= "is_trending"]', function() {
		productId = $(this).attr('id');
		$.ajax({
			url: isTrendingUpdateUrl,
			method: 'POST',
			data: { productId: productId, _token: _token },
			dataType: 'json',
			success: function(result) {
				// console.log(result);
				if (result.status == 'Success') {
					successMsg(result);
				} else {
                    errorMsg(result);
				}
				removeUpdtateMsg();
			}
		});
});

//product is today Deal update
$(document).on('click', 'input[name= "today_deal"]', function() {
		productId = $(this).attr('id');
		$.ajax({
			url: isTodayDealUpdateUrl,
			method: 'POST',
			data: { productId: productId, _token: _token },
			dataType: 'json',
			success: function(result) {
				// console.log(result);
				if (result.status == 'Success') {
					successMsg(result);
				} else {
                    errorMsg(result);
				}
				removeUpdtateMsg();
			}
		});
});

//product published status
$(document).on('click', 'input[name= "status"]', function() {
		productId = $(this).attr('id');
		console.log('clicked');
		$.ajax({
			url: changePublishedStatusUrl,
			method: 'POST',
			data: { productId: productId, _token: _token },
			dataType: 'json',
			success: function(result) {
				console.log(result);
				if (result.status == 'Success') {
					successMsg(result);
				} else {
                    errorMsg(result);
				}
				removeUpdtateMsg();
			}
		});
});
