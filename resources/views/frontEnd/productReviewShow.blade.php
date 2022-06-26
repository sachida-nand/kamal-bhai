@extends('layouts.frondEndApp')
@section('title-section')
Your Review | {{ @config('constants.site_name') }}
@endsection
@section('content')
<div class="container">
        <div class="reply_ticket">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('your-account') }}">My Account</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Your review</li>
                </ol>
            </nav>
            @if (session()->has('msg'))
                <div class="alert {{ session()->has('status') == 'Error' ? 'alert-warning' : 'alert-success' }}" role="alert">
                    <h4 class="alert-heading">{{ session()->get('status') }}!</h4>
                    <p>{{session()->get('msg') }}</p>
                </div>
            @endif
            @if(!$Reviews->isEmpty())
              @foreach ($Reviews as $Review)
                  <div class="review-item">
                    <div class="card">
                        <div class="card-header">
                            <div class="reviews mb-2">
                                <div class="customer_img">
                                    <img src="{{asset('storage/userprofile/'.$Review->UserDetails->image) }}" alt="customer">
                                </div>
                                <div class="message mt-3">
                                    <h5 class="mb-0">{{ $Review->UserDetails->name }}</h5>
                                    <small>Reviewed a product - {{ date_format($Review->created_at,'j M Y') }}</small>
                                </div>
                            </div>                            
                        </div>
                        <div class="card-body">
                            <div class="star mb-2">
                                @for ($i =1; $i<=5; $i++)
                                   @if ($i<=$Review->star)
                                      <i class="fas fa-star rated"></i>
                                   @else
                                      <i class="fas fa-star not-rated"></i>
                                   @endif    
                                @endfor
                                &nbsp;&nbsp;<span class="text"> Verified purchase</span>
                            </div>
                               
                            <div>
                                <h5 class="mt-0">{{ $Review->heading }}</h5>
                                <p>{{ $Review->description }}</p>
                            </div>
                            <a href="{{ url('product/'.$Review->Product->slug) }}">
                                <div class="card py-3 px-2">
                                <div class="row">
                                    <div class="col-2 pr-3">
                                        <div class="ship_img">
                                            <img src="{{ asset('storage/product_images/'.$Review->pImage->image) }}" alt="" width="50">
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <p style="margin-bottom: 0; margin-left:10px;">
                                          {{ $Review->Product->product_name }}
                                         </p>
                                    </div>
                                </div>
                            </div>
                            </a>
                            <div class="button">
                                <div class="mb-3 mt-4 write_review ">
                                    <a href="{{ url('product-review/for_product='.$Review->Product->slug.'&order_id='.$Review->order_id) }}" class="review">Edit</a>
                                    <a href="{{ url('product-review/delete-review/'.$Review->id) }}" class="review delete_review">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              @endforeach
              @else
                <div class="text-center mt-3">
                    <h5>
                        <b>You have no any review yet!</b>
                    </h5>
                    <p>Click <a href="{{ url('/') }}">here</a> to continue shopping.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
<script>

     $('.delete_review').on('click', function(e){
         e.preventDefault();
         href = $(this).attr('href');
        swal.fire({
             title : 'Are You sire?',
             text : 'Want to delete this review',
             icon : 'warning',
             showCancelButton: true,
             confirmButtonColor : '#DD6B55',
             confirmButtonText : 'Confirm',
             cancelButtonText : 'Cancel',
         }).then((result) => {
             if(result.isConfirmed){
                 window.location = href
             }
         });
     });
</script>
@endsection