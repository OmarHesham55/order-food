@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">🛠️ Manage Orders</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($orders->count() > 0)
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Order #</th>
                    <th>User</th>
                    <th>Restaurant</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Placed At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->user->name ?? 'N/A'}}</td>
                    <td>{{$order->restaurant->name ?? 'N/A'}}</td>
                    <td>{{number_format($order->total_price,2)}}</td>
                    <td>{{ucfirst($order->status)}}</td>
                    <td>{{$order->created_at->format('d M Y h:i A')}}</td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input status-radio" type="radio" name="status_{{ $order->id }}" value="pending"
                                   data-order-id="{{ $order->id }}"
                                @checked($order->status == 'pending')>
                            <label class="form-check-label">Pending</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input status-radio" type="radio" name="status_{{ $order->id }}" value="preparing"
                                   data-order-id="{{ $order->id }}"
                                @checked($order->status == 'preparing')>
                            <label class="form-check-label">Preparing</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input status-radio" type="radio" name="status_{{ $order->id }}" value="delivered"
                                   data-order-id="{{ $order->id }}"
                                @checked($order->status == 'delivered')>
                            <label class="form-check-label">Delivered</label>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No orders found.</p>
        @endif
    </div>
@endsection
@section('scripts')
        <script type="text/javascript" src="{{asset('assets/orders/js/orders.js')}}"> </script>
@endsection
