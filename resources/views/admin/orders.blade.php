@extends('layouts.frondEndApp')
@section('title-section')
Orders Received | {{ @config('constants.site_name') }}
@endsection
@section('content')
 <div class="orders mt-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('your-account') }}">Your Account</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Your Orders</li>
                </ol>
            </nav>
             @if (isset($msg))
                <div class="error_msg">
                    <h5><b><i class="fas fa-exclamation-triangle" style="color: #ffa707"></i> There's a problem loading this order</b></h5>
                    <p>We're working on fixing this. Please come back and try again later.</p>
                </div>
             @endif
            <div class="heading mb-2">
                <h3>Your Orders</h3>
            </div>
           <div class="d_mode_">
                <div class="card">
                    @if (!$Orders->isEmpty())
                         <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-warning">
                                    <tr>
                                        <th scope="col">Order#</th>
                                        <th scope="col">Order Date</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">No. of Product</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Delivery Status</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Orders as $Order)
                                        <tr>
                                            <th>{{ $Order->order_id }}</th>
                                            <td>{{ date_format($Order->created_at,"j M Y") }}</td>
                                            <td>{{ $Order->name }}</td>
                                            <td>2</td>
                                            <td>{{ number_format($Order->total_amount,2) }}</td>
                                            <td class="{{ $Order->order_status == 'Cancel' ? 'text-danger' :'text-success' }}">{{ $Order->order_status }}</td>
                                            <td>{{ $Order->payment_status }}</td>
                                            <td><a href="{{ url('order-details/order_id='.$Order->order_id) }}">view order</a> 
                                        </tr>
                                   @endforeach     
                                </tbody>
                            </table>
                        </div>
                    @else
                       <div class="text-center mt-3">
                            <h5>
                                <b>You have no Order any item yet!</b>
                            </h5>
                            <p>Click <a href="{{ url('/') }}">here</a> to continue shopping.</p>
                        </div>
                    @endif
                </div>
           </div>
        </div>
        <div class="m_mode_">
            <div class="card">
                @forelse ($Orders as $Order)
                    <div class="order_list">
                        <p><b>Order#:</b> {{ $Order->order_id }}</p>
                        <p><b>Order Date:</b> {{ date_format($Order->created_at,"j M Y") }}</p>
                        <p><b>Name:</b> {{ $Order->name }}</p>
                        <p><b>No. of Product:</b> 2</p>
                        <p><b>Amount:</b> {{ number_format($Order->total_amount,2) }}</p>
                        <p><b>Delivery Status:</b> {{ $Order->order_status }}</p>
                        <p><b>Payment Status:</b> {{ $Order->payment_status }}</p>
                        <p><a class="pb-2" href="{{ url('order-details/order_id='.$Order->order_id) }}">View Order</a> &nbsp;&nbsp;&nbsp;
                    </div>
                @empty
                    <div class="text-center mt-3">
                        <h5>
                            <b>You have no Order any item yet!</b>
                        </h5>
                        <p>Click <a href="{{ url('/') }}">here</a> to continue shopping.</p>
                    </div>
                @endforelse
                
            </div> 
        </div>
    </div>
@endsection
@section('script')

@endsection