// hide error field 
setTimeout(() => {
	$('.alert').remove();
}, 5000);

// show and hide add and update all form
function showAddFormSEction() {
	const addButton = document.getElementById('form-section');
	addButton.classList.toggle('active');
}

// display and remove one image before upload into the server
function previewImageBeforeUpload(id) {
	const file = document.getElementById(id).files[0];
	$('#image_preview').html('');
	var reader = new FileReader();
	reader.addEventListener('load', function() {
		$('#image_preview').append(
			'<div><img src="' + this.result + '" alt=""><span class="cancel">&#10060;</span></div>'
		);
	});
	reader.readAsDataURL(file);
}

// display and remove multiple image before upload into the server
function previewFiles() {
	// console.log(document.getElementById('Product_img').files);
	$('#image_previews').html('');
	var files = document.getElementById('Product_img').files;

	function readAndPreview(file) {
		// Make sure `file.name` matches our extensions criteria
		if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
			var reader = new FileReader();

			reader.addEventListener('load', function() {
				$('#image_previews').append(
					'<div><input type="hidden" name="product_images[]" value="' +
						file.name +
						'"><img src="' +
						this.result +
						'" alt="" class="thumb-img" width="100%"><span class="cancel">&#10060;</span></div>'
				);
			});
			reader.readAsDataURL(file);
		} else {
			alert('this file not a image');
			document.getElementById('Product_img').value = '';
		}
	}
	if (files) {
		[].forEach.call(files, readAndPreview);
	}
}

// show and hide shipping details fields
function showShpmentArea(elem) {
	const shipDiv = document.getElementById('shipment');
	const shipCost = document.getElementById('shipping_cost');
	if (elem.checked && elem.value == 'no') {
		shipDiv.classList.add('active');
	} else {
		shipDiv.classList.remove('active');
		shipCost.value = '';
	}
}

// product form validation
function setErrorMsg(id, errorMag) {
	const element = document.getElementById(id);
	element.getElementsByClassName('error')[0].innerHTML = errorMag;
}

function formValidation() {
	const catagorie = document.forms['productForm']['catagorie'];
	const product_name = document.forms['productForm']['product_name'];
	const minimumPrchQty = document.forms['productForm']['min_purch_qty'];
	const unitPrice = document.forms['productForm']['unit_price'];
	let finalAmount = document.forms['productForm']['discount_price'];
	const quantity = document.forms['productForm']['quantity'];

	if (catagorie.value == '') {
		catagorie.focus();
		setErrorMsg('catagorie', 'catagorie is required');
		return false;
	}
	if (product_name.value.trim() <= 0) {
		product_name.classList.add('focus');
		setErrorMsg('product_name', 'product name is required');
		return false;
	}
	if (minimumPrchQty.value.trim() <= 0 || isNaN(minimumPrchQty.value)) {
		minimumPrchQty.classList.add('focus');
		setErrorMsg('minimum', 'Only number is allowed and this is required');
		return false;
	}

	if (unitPrice.value.trim() <= 0 || isNaN(unitPrice.value)) {
		unitPrice.classList.add('focus');
		setErrorMsg('unit_price', 'Only number is allowed and this is required');
		return false;
	}

	if (finalAmount.value >= unitPrice.value) {
		setErrorMsg('dicount', "Discount price can't greater or equal then unit price");
		return false;
	}

	if (quantity.value.trim() <= 0 || isNaN(quantity.value)) {
		quantity.classList.add('focus');
		setErrorMsg('quantity', 'Only number is allowed and this is required');
		return false;
	}
	return true;
}

document.forms['productForm']['catagorie'].addEventListener('change', function() {
	if (this.value != null) {
		setErrorMsg('catagorie', '');
	}
});

document.forms['productForm']['product_name'].addEventListener('change', function() {
	if (this.value != null) {
		this.classList.remove('focus');
		setErrorMsg('product_name', '');
	}
});

document.forms['productForm']['min_purch_qty'].addEventListener('change', function() {
	if (this.value != null) {
		this.classList.remove('focus');
		setErrorMsg('minimum', '');
	}
});

document.forms['productForm']['unit_price'].addEventListener('change', function() {
	if (this.value != null) {
		this.classList.remove('focus');
		setErrorMsg('unit_price', '');
	}
});

document.forms['productForm']['quantity'].addEventListener('change', function() {
	if (this.value != null) {
		this.classList.remove('focus');
		setErrorMsg('quantity', '');
	}
});

// price management
function calcPercentage() {
	let unitPrice = document.forms['productForm']['unit_price'].value;
	let finalAmount = document.forms['productForm']['discount_price'];
	let discount = document.forms['productForm']['discount'].value;
	let discounType = document.forms['productForm']['discount_type'].value;
	let ans = 0;

	if (discounType == 'flat') {
		finalAmount.value = unitPrice - discount;
	} else if (discounType == 'percentage') {
		finalAmount.value = unitPrice - discount / 100 * unitPrice;
	}
}

document.forms['productForm']['unit_price'].addEventListener('keyup', function() {
	let discount = document.forms['productForm']['discount'];

	if (discount.value != '') {
		calcPercentage();
	}
	setErrorMsg('dicount', '');
});

document.forms['productForm']['discount'].addEventListener('keyup', function() {
	const finalAmount = document.forms['productForm']['discount_price'];
	if (this.value != '') {
		calcPercentage();
	} else {
		finalAmount.value = '';
	}
	setErrorMsg('dicount', '');
});

document.forms['productForm']['discount_type'].addEventListener('change', function() {
	calcPercentage();
});

// remove alert section
$(document).on('click', '.cross', function(){
	$(this).closest('.alerts').remove();
})

// const items = document.querySelectorAll('.custome_alert');

// items.forEach(item => {
// 	setTimeout(function(){
//           $('.alert-section').children().last().remove();
//     },5000);
// })

