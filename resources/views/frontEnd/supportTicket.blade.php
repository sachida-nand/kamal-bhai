@extends('layouts.frondEndApp')
@section('title-section')
Support Ticket | {{ @config('constants.site_name') }}
@endsection
@section('content')
 <div class="container mt-3">
     <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('your-account') }}">My Account</a></li>
            <li class="breadcrumb-item active" aria-current="page">Your Ticket</li>
        </ol>
     </nav>
        <div class="heading">
            <h2>Support Ticket</h2>
        </div>
         @if (session()->has('msg'))
            <div class="alert {{ session()->has('status') == 'Error' ? 'alert-warning' : 'alert-success' }}" role="alert">
                <h4 class="alert-heading">{{ session()->get('status') }}!</h4>
                <p>{{session()->get('msg') }}</p>
            </div>
        @endif
        @if (isset($msg))
            <div class="error_msg">
                <h5><b><i class="fas fa-exclamation-triangle" style="color: #ffa707"></i> There's a problem loading Your Messages</b></h5>
                <p>We're working on fixing this. Please come back and try again later.</p>
            </div>
        @endif
        <div class="add-ticket text-cente">
            <a href="#" data-toggle="modal" data-target="#supportmodel">
                <div class="icon"><i class="fas fa-plus fa-3x"></i></div>
                <div class="text">
                    <h5 class="headers">Create a ticket</h5>
                </div>
            </a>
        </div>
         @if (!$Tickets->isEmpty())
            <div class="orders mt-4">
                    <div class="d_mode_">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-warning">
                                        <tr>
                                            <th scope="col">Ticket Number#</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Subject</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>     
                                       
                                            @foreach ($Tickets as $Ticket)
                                              <tr>
                                                <th scope="row">{{ $Ticket->ticket_number }}</th>
                                                <td>{{ date_format($Ticket->created_at,'j M Y') }}</td>
                                                <td>{{ $Ticket->subject }}</td>
                                                <td class="{{ $Ticket->status != 'Solved' ? 'bg-warning' : ''}}">{{ $Ticket->status }}</td>
                                                <td><a href="{{ url('reply-support-ticket/ticket_number='.$Ticket->ticket_number) }}">View Details</a></td>
                                             </tr>
                                            @endforeach
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <div class="m_mode_">
                    <div class="card">
                    @foreach ($Tickets as $Ticket)
                        <div class="order_list">
                            <p><b>Ticket Number#:</b> {{ $Ticket->ticket_number }}</p>
                            <p><b>Date:</b> {{ date_format($Ticket->created_at,'j M Y') }}</p>
                            <p><b>Subject:</b> {{ $Ticket->subject }}</p>
                            <p class="{{ $Ticket->status != 'Solved' ? 'bg-warning' : ''}} p-1"><b>Status:</b> {{ $Ticket->status }}</p>
                            <p><a href="{{ url('reply-support-ticket/ticket_number='.$Ticket->ticket_number) }}">View Details</a></p>
                        </div>
                     @endforeach
                    </div>
                </div>
            </div>
            @else
             <div class="text-center mt-3">
                 <h5>You don't have creat any ticket yet! click creat a ticket button to register problem/ticket.</h5>
             </div>
         @endif
    </div>
    <!-- Modal -->
    <div class="modal fade" id="supportmodel" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('create.ticket') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="subject">Subject *</label>
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Subject for ticket">
                        </div>
                        <div class="form-group">
                            <label for="ticket_desc">Provide a detailed description *</label>
                            <textarea class="form-control" id="ticket_desc" name="message" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="ticket_file" >Any File</label>
                            <input type="file" class="form-control" id="ticket_file" name="ticket_file">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
