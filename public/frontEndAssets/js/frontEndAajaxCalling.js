const _token = $('meta[name="csrf-token"]').attr('content');

//load cart items when you click add to cart button
function loadCartItemsAjax() {
	$.ajax({
		url: '/count-cart-item',
		data: { _token: _token },
		success: function(response) {
			// console.log(response);
			$('.chart_number').text(response.count);
		}
	});
}

// add to card ajax
$('.add_to_cart a').on('click', function() {
	$(this).html('Adding...');
	$(this).prop('disabled', true);
	ProductId = $(this).attr('id');
	scope = $(this).attr('items'); // for identify from which page add to card requested
	qty = 1;

	if (scope == 'details') {
		qty = $('.quantity_input input').val();
	}
	$.ajax({
		url: '/add-to-cart',
		method: 'POST',
		cache: false,
		data: {
			ProductId: ProductId,
			_token: _token,
			qty: qty
		},
		success: function(data) {
			loadCartItemsAjax();
			$('.add_to_cart a').html('<i class="fas fa-cart-plus"></i> Add to Cart');
			$('.add_to_cart a').prop('disabled', false);
			Swal.fire({
				position: 'center',
				icon: 'success',
				title: '' + data.P_name,
				text: '' + data.status,
				showConfirmButton: true,
				timer: 2000
			});
		}
	});
});

// call ajax automaticaly to save shoping item from cookie to database
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

// increase and decrease quantity
$('.increase').on('click', function() {
	var ProductId = $(this).attr('product_id');
	var qty = parseInt($(this).parents('.Quantity').find('.quenty_value').val()) + 1;
	QuantityIncreseAjax(ProductId, qty);
});

$('.decrease').on('click', function() {
	var ProductId = $(this).attr('product_id');
	var qty = parseInt($(this).parents('.Quantity').find('.quenty_value').val()) - 1;
	if (qty <= 0) {
		qty = 1;
	}
	QuantityIncreseAjax(ProductId, qty);
});

$('.quenty_value').on('change', function() {
	var ProductId = $(this).parents('.Quantity').find('.quantity_op').attr('product_id');
	var qty = parseInt($(this).parents('.Quantity').find('.quenty_value').val());
	if (qty <= 0) {
		qty = 1;
	}
	QuantityIncreseAjax(ProductId, qty);
});

// increase and decrease quatity ajax
function QuantityIncreseAjax(ProductId, qty) {
	$.ajax({
		url: '/update_cart_qty',
		method: 'GET',
		cache: false,
		data: { ProductId: ProductId, qty: qty, _token: _token },
		success: function(data) {
			window.location.reload();
		}
	});
}

// remove cart product ajax
$('.delete').on('click', function() {
	var ProductId = $(this).attr('product_id');

	$.ajax({
		url: '/delete-cart-item',
		type: 'DELETE',
		data: { ProductId: ProductId, _token: _token },
		success: function(data) {
			//    console.log(data);
			window.location.reload();
		}
	});
});

// Add new adress from checkout page
$('#AddnewAddress').on('submit', function(e) {
	e.preventDefault();
	$('.savee').prop('disabled', true);
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: AddnewAddress,
		method: 'POST',
		data: $(this).serialize(),
		success: function(data) {
			// console.log(data);
			if (data.status == 'success') {
				$('.savee').prop('disabled', false);
				$('#addnewaddressinput').prop('checked', false);
				$('.new_add_button').css('display', 'none');
				$('.add_input').css('display', 'none');
				$('.add_new_section').remove();
				//  $('.card_container').load(location.href + ' .card_container');
				location.reload(true);
			}
		}
	});
});

$('.address_remove').on('click', function(e){
	e.preventDefault();
	let AddressId = $(this).attr('address_id')
	let addressDiv = $(this).closest('.add');
	var isConfirm =	swal.fire({
		title: "Are you sure ? You want to delete this address",
		html:"<b>Note: </b> Deleting this address will not delete any pending orders being shipped to this address. To ensure uninterrupted fulfillment of future orders.",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Confirm',
		cancelButtonText: "Cancel",
	}).then((result) => {
		if(result.isConfirmed){
			$.ajax({
				url : removeAddress,
				method : 'POST',
				dataType : 'JSON',
				data : {AddressId : AddressId, _token : _token},
				cache : false,
				success : function(data){
					if(data.Status == 'Success'){
					  addressDiv.remove();
                      $('.error').css('display','block');
					}else{
                      $('.error').css('display','block');
                      $('.error').removeClass('alert-success');
                      $('.error').addClass('alert-warning');
                      $('.error h4').text('Error!');
                      $('.error h4').text('Sorry your request can\'t be completed you will fixed it please try after some time');
					}
				}
			})
		}
	});
})

$(function() {
	ajaxCallForSentItemCookieTodb();
	loadCartItemsAjax();
});