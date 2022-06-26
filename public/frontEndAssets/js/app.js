// navbar toggle
const burgerToggle = document.querySelector('.burger');
burgerToggle.addEventListener('click', function() {
	const navbar = document.querySelector('.second-nav');
	navbar.classList.toggle('active');
});

// tuncate word after 50 character
document.querySelectorAll('.p_name').forEach((element) => {
	if (element.innerHTML.length > 30) {
		text = element.innerHTML;
		element.innerHTML = text.substring(0, 30) + '...';
	}
});

// const signin = document.getElementById('sign');

// if(signin){

// }
$('#sign').on('click',function(){
    var dd = document.querySelector('.submenu');
    dd.classList.toggle('active')
})

// decription and review section hide and show
function showHide(classes, links) {
	if ($('.tab-items').hasClass('active')) {
		$('.tab-items').removeClass('active');
		$('.item_links').removeClass('active');
	}
	$('.' + classes).addClass('active');
	$('.' + links).addClass('active');
}

// quenty decrease and increase
$(function() {
	var selling_price = parseFloat($('.selling_pricee').html());
	$('#sub_total_value').html(selling_price + '.00');

	$('.decrease').on('click', function() {
		var value = $(this).parents('.Quantity').find('.quenty_value').val();
		if (value != 1) {
			$(this).parents('.Quantity').find('.quenty_value').val(value - 1);
			$('#sub_total_value').html(selling_price * (value - 1) + '.00');
		}
	});

	$('.increase').on('click', function() {
		// alert(stock)
		var value = parseInt($(this).parents('.Quantity').find('.quenty_value').val());
		console.log(value);
		if(value < stock && value < minpurchageqty){
				 $(this).parents('.Quantity').find('.quenty_value').val(value + 1);
		         $('#sub_total_value').html(selling_price * (value + 1) + '.00');
		}else{
			 $('.error').addClass('alert')
		     $('.error').html('We\'re sorry. This item has a limited purchase quantity. We have changed your purchase quantity to the maximum allowable.')

			 setTimeout(() => {
				 $('.error').removeClass('alert')
		         $('.error').html('')
			 }, 5000);
		}
	});

	$('.quenty_value').on('change', function() {
		var value = parseInt($('.quenty_value').val());
        
		if (value < 1 || isNaN(value)) {
			$('.quenty_value').val(1);
		}else{
			$('#sub_total_value').html(selling_price * value + '.00');
		}

		if(value > stock || value > minpurchageqty){
			if(stock < minpurchageqty){
				parseInt($('.quenty_value').val(stock))
			    $('#sub_total_value').html(selling_price * stock + '.00');
			}else{
                parseInt($('.quenty_value').val(minpurchageqty))
			    $('#sub_total_value').html(selling_price * minpurchageqty + '.00');
			}
		   $('.error').addClass('alert')
		   $('.error').html('We\'re sorry. This item has a limited purchase quantity. We have changed your purchase quantity to the maximum allowable.')

		   setTimeout(() => {
				 $('.error').removeClass('alert')
		         $('.error').html('')
			 }, 5000);
		}
	});
});

//show hide payment options 
function showHidePaymentOption(classes) {
	if ($('.payment_method').hasClass('active')) {
		$('.payment_method').removeClass('active');
	}
	$('.' + classes).addClass('active');
}

// checkout form validation 
$('.myFromsection form').on('submit', function(e){
    if($('input[type=radio][name=address]:checked').length == 0){
        $('.error').addClass('alert');
        $('.error').html('Address Field is required');
        return false;
    }

    if($('input[type=radio][name=payment]:checked').length == 0){
         $('.error').addClass('alert');
         $('.error').html('Payment is required Field is required');
         return false;
    }
    return true;
})

// order itels page order status 
$('#order_in_mobile').on('click', function() {
	document.getElementById('ss').classList.toggle('active');
	var icon = document.getElementById('icon');
	if (icon.classList.contains('fa-angle-up')) {
		icon.classList.remove('fa-angle-up');
		icon.classList.add('fa-angle-down');
	} else {
		icon.classList.add('fa-angle-up');
	}
});

//cancel order confirmation model
$('.cancel_single_order').on('click', function(){
	var isConfirm =	swal.fire({
		title: "Are you sure ?",
		text: "You want to cancel this order!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Confirm',
		cancelButtonText: "Cancel",
	}).then((result) => {
		if(result.isConfirmed){
			$('#exampleModal').modal('show');
		}
	});

})

// swiper js code
function swiperJs(clasName) {
	var swiper = new Swiper(clasName, {
		spaceBetween: 25,
		// slidesPerGroup: 5,
		// loop: true,
		pagination: {
			el: '.swiper-pagination',
			type: 'fraction'
		},
		autoplay: {
			delay: 3000,
			disableOnInteraction: false
		},
		breakpoints: {
			'@0.00': {
				slidesPerView: 2,
				spaceBetween: 10,
				slidesPerGroup: 1
			},
			'@0.75': {
				slidesPerView: 3,
				slidesPerGroup: 2
			},
			'@1.50': {
				slidesPerView: 4,
				slidesPerGroup: 3
			},
			'@2': {
				slidesPerView: 6,
				slidesPerGroup: 5
			}
		},
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev'
		}
	});
}
swiperJs('.mySwiper');
swiperJs('.mySwiperr');
