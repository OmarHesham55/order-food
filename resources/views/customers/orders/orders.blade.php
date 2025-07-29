@extends('layouts.app')
@section('title','my-orders')
@section('stylesheet')
    <link rel="stylesheet" href="{{asset('/assets/customers/orders/style.css')}}">
@endsection
@section('navbar')
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route('order_food.home')}}">Talabat</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link active">Hello {{ auth()->user()->name }}</a>
                        </li>
                    @endauth
                </ul>
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Logout</button>
                            </form>
                        </li>
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas">
                            <div class="cart-icon-container">
                                <i class="fas fa-shopping-cart"></i> Cart
                                <span class="cart-count" id="cart-item-count"></span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endsection
@section('content')
    <div class="container">
        <h2 class="mb-4">🛒 My Orders</h2>
        <h5 class="mb-4">{{\Illuminate\Support\Facades\Auth::user()->name}}</h5>
        @if($orders->count() > 0)
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Order #</th>
                    <th>Restaurant</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Placed At</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{$order->id}}</td>
                    <td>{{$order->restaurant->name ?? 'N/A'}}</td>
                    <td>{{number_format($order->total_price,2)}} LE</td>
                    <td>{{$order->status}}</td>
                    <td>{{$order->created_at->format('d M Y h:i A')}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>You have no orders yet.</p>
        @endif
    </div>
@endsection
