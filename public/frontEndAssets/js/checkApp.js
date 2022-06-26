
function showHidePaymentOption(classes) {
	if ($('.payment_method').hasClass('active')) {
		$('.payment_method').removeClass('active');
	}
	$('.' + classes).addClass('active');
}

$('#myForm').on('submit', function(e){
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


$('#addnewaddressinput').on('change', function(){
    $('.add_input').css('display','block')
    $('.payment_details').css('display','none');
    $('.new_add_button').css('display','block')
    $('.add_new_form_section').append(`<div class="add_new_section">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="mobile">Mobile <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="mobile" id="mobile"
                                                placeholder="10-digit mobile number" required>
                                        </div>
                    
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="pincode">Pin/Zip code</label>
                                            <input type="text" class="form-control" name="pincode" placeholder="Pincode" id="pincode">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="city">City/Town <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="city" id="city" placeholder="City/Town" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="address">
                                    <div class="form-group">
                                        <label for="flate">Flate/House No./Building/Comapany/Apartment <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="address_one" id="flate" placeholder="Address"
                                            required>
                                    </div>
                                </div>
                                <div class="address_two">
                                    <div class="form-group">
                                        <label for="area">Area/Colony/Sector/Village</label>
                                        <input type="text" class="form-control" name="address_two" id="area" placeholder="Address">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="landmark">Landmark</label>
                                            <input type="text" class="form-control" name="landmark" id="landmark"
                                                placeholder="E.g. Near Ghati Chock">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label for="district">District <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="district" placeholder="District" id="district" required>
                                    </div>
                                </div>
                                <p class="mb-2">Address Type <span class="text-danger">*</span></p>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-check">
                                             <input type="radio" name="address_type" id="home" value="HOME" required>
                                            <label class="form-check-label" for="home">
                                                Home (Delivery between 7 AM - 9 PM)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-check">
                                           <input type="radio" name="address_type" id="work" value="WORK" required>
                                            <label class="form-check-label" for="work">
                                                Work (Delivery between 10 AM - 5 PM)
                                            </label>
                                        </div>
                                    </div> 
                                </div>
                            </div>`);
});

$('#Cancel').on('click', function(){
    $('#addnewaddressinput').prop('checked', false);
    $('.new_add_button').css('display','none');
    $('.add_input').css('display','none')
    $('.add_new_section').remove();
})

function hideAddNewAddressFrom(id)
{ 
    $('#addnewaddressinput').prop('checked', false);
    $('.payment_details').css('display','block');
    $('.new_add_button').css('display','none');
    $('.add_input').css('display','none')
    $('.add_new_section').remove();
}
