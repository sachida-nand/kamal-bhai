@extends('layouts.frondEndApp')
@section('title-section')
Reply ticket | {{ @config('constants.site_name') }}
@endsection
@section('content')
<div class="container mt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('your-account') }}">My Account</a></li>
            <li class="breadcrumb-item"><a href="{{ url('support-ticket') }}">Support Ticket</a></li>
            <li class="breadcrumb-item active" aria-current="page">Suport details</li>
        </ol>
     </nav>
       <div class="reply_ticket">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Ticket# <b>{{ $Ticket->ticket_number }}</b></h6>
                <p class="mb-0"><b>Date: {{ date_format($Ticket->created_at,'j M Y') }}</b></p>
                <h6 >Subject: <b>{{ $Ticket->subject }}</b></h6>
            </div>
            <div class="card-body">
              @foreach ($Ticket->TicketReaply as $Reaply)
                <div class="row">
                    <div class="col-1 reviews">
                        {{-- @if ($Reaply->user_type == 'user')
                            <div class="customer_img d-sm-none">
                               <img src="{{ asset('storage/userprofile/'.Auth::user()->image) }}" alt="">
                            </div>
                        @endif --}}
                    </div>
                    <div class="col-11">
                       
                          <div class="chart_section {{ $Reaply->user_type == 'admin' ? 'admin' : 'customer'}} ">
                                <h4 class="mb-0">{{ $Reaply->user_type == 'admin' ? 'ADMIN' : Auth::user()->name}}</h4>
                                <small><b>{{ date_format($Reaply->created_at,'j F Y') }}</b></small>
                                <p class="reply mt-2">{{ $Reaply->message }}</p>
                                @if ($Reaply->document) 
                                <a class="btn btn-secondary text-dar py-2 px-3" href="{{ url('download_ticket_file/'.$Reaply->document) }}">Download file</a>      
                                @endif
                          </div><hr>
                        </div>
                    </div>
                 @endforeach

                @if ($Ticket->status != 'Solved')
                    <div class="formsection">
                        <h5 class="py-3">Reply </h5>
                        <form action="" id="msgReaply" method="Post">
                            @csrf
                            <input type="hidden" name="ticket_number" value="{{ $Ticket->ticket_number }}">
                            <div class="form-group">
                                <textarea class="form-control" id="ticket_desc" name="message" rows="3" required placeholder="Wrtite message..."></textarea>
                            </div>
                            <div class="form-group">
                                <label for="ticket_file">Any File</label>
                                <input type="file" class="form-control" id="ticket_file" name="ticket_file">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="reaplyBtn" class="btn btn-primary">Reply</button>
                            </div>
                        </form>
                    </div>
                    @else
                    <div class="formsection">
                        <h5 class="pt-3 mb-0">Your Problem has been solved.</h5>
                        <p> If you want to register new problem/ticket <a href="{{ url('support-ticket') }}">Click here</a> then click creat a ticket icon button.</p>
                    </div>
                @endif
            </div>
        </div>
       </div>
    </div>
@endsection
@section('script')
<script>
   $('#msgReaply').on('submit', function(e){
         e.preventDefault();
         var btn = document.getElementById('reaplyBtn');

         $('#reaplyBtn').html('Sending');
         $('#reaplyBtn').attr('disabled', true);
        //  btn.html('Sending...');
        //  btn.attr('disabled', true);
         var myFrom = document.getElementById('msgReaply');
         let formData = new FormData(myFrom);

         $.ajax({
             url: '{{ route('ticket.message.reaply') }}',
             method: 'POST',
             data: formData,
             dataType: 'JSON',
             contentType: false,
             processData: false,
             success:function(data){
                 if(data.Status == 'Success'){
                     $('#reaplyBtn').html('Reaply');
                     $('#reaplyBtn').prop('disabled', false);
                     location.reload();
                    
                 }else{

                 }
                 console.log(data);
             }
         })
   })
</script>
@endsection