@extends('layouts.frondEndApp')
@section('title-section')
Login & Security | {{ @config('constants.site_name') }}
@endsection
@section('content')
 <div class="userlogin">
        <div class="container">
            <div class="reply_ticket">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('your-account') }}">My Account</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Login & Security</li>
                    </ol>
                </nav>
                <div class="heading">
                    <h3>Login & Security</h3>
                </div>
                 @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>You successfully changed your account!</p>
                    </div>
                 @endif
                    <div class="error alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>You successfully changed your profile picture!</p>
                    </div>
                @if (isset($msg))
                    <div class="error_msg">
                        <h5><b><i class="fas fa-exclamation-triangle" style="color: #ffa707"></i> There's a problem on changing your request.</b></h5>
                        <p>We're working on fixing this. Please come back and try again later.</p>
                    </div>
                @endif
                <div class="user-img">
                    <div class="imgsection">
                       <img src="{{ asset('storage/userprofile/'.Auth::user()->image) }}" alt="">
                    </div>
                    <form id="userprofile" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="actions">
                            <div class="write_review mt-2">
                                <label class="px-4 btn btn-outline-primary" for="imguser">Upload</label>
                                <input type="file" name="user_Profile" id="imguser">
                            </div>
                        </div>
                    </form>
                    
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-item-center">
                            <div class="name">
                                <h5 class="mb-0">Name:</h5>
                                <p class="mb-0"><b>{{ Auth::user()->name }}</b></p>
                            </div>
                            <div class="button">
                                <div class="write_review mt-2">
                                    <a href="{{ url('security-action/change_name') }}" class="px-4 btn btn-outline-primary">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-item-center">
                            <div class="name">
                                <h5 class="mb-0">E-mail:</h5>
                                <p class="mb-0"><b>{{ Auth::user()->email }}</b></p>
                            </div>
                            <div class="button">
                                <div class="write_review mt-2">
                                    <a href="{{ url('security-action/change_email') }}" class="px-4 btn btn-outline-primary">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-item-center">
                            <div class="name">
                                <h5 class="mb-0">Phone Number:</h5>
                                <p class="mb-0"><b>+977 - {{ Auth::user()->phone }}</b></p>
                            </div>
                            <div class="button">
                                <div class="write_review mt-2">
                                    <a href="{{ url('security-action/change_phone') }}" class="px-4 btn btn-outline-primary">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-item-center">
                            <div class="name">
                                <h5 class="mb-0">Password:</h5>
                                <p class="mb-0"><b>*********</b></p>
                            </div>
                            <div class="button">
                                <div class="write_review mt-2">
                                    <a href="{{ url('security-action/change_password') }}" class="px-4 btn btn-outline-primary">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-3">
                    <a href="{{ url('your-account') }}" class="btn btn-warning px-5 py-2">Done</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    var route = "{{ route('updateProfilePicAjax') }}";

    $('#imguser').on('change', function(){
        var file = $(this)[0].files[0];
        if(file.type == 'image/jpg' || file.type == 'image/jpeg' || file.type == 'image/png')
        {
          if(file.size >= 2097152){ //2MB
             alert('This image size is more then 2 MB select image size less then 2 MB') 
          }else{
              previewImg(this);
              uploadImage();
          }
        }else{
            alert('This is not image file choose jpeg/jpg/png type image')
        }
    });

    function previewImg(input){
        if(input.files && input.files[0]){
            var render = new FileReader();
            render.onload = function(e){
                $('.imgsection img').attr('src', e.target.result)
                $('.imgsection img').css('opacity','0.2')
            }
            render.readAsDataURL(input.files[0])
        }
    }

    function uploadImage(){
        let myFrom = document.getElementById('userprofile');
        let formData = new FormData(myFrom);

        $.ajax({
            url : route,
            method : 'POST',
            data : formData,
            dataType : 'json',
            contentType: false,
            processData:false,
            success:function(data){
                if(data.Status == 'Success'){
                    $('.error').css('display','block')
                    $('.imgsection img').css('opacity','1')
                }else{
                    $('.error').css('display','block')
                    $('.error h4').html('Error')
                    $('.error p').html('There\'s a problem on changing your request.')
                    $('.error').removeClass('alert-success')
                    $('.error').addClass('alert-danger')
                    console.log('not success');
                }
            }
        })
    }
</script>
@endsection