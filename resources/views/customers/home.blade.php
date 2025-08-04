@extends('layouts.app')
@section('title','Restaurant home')
@section('stylesheet')
    <link rel="stylesheet" href="{{asset('/assets/customers/home/style.css')}}">
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
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('orders.show') }}">My Orders</a>
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
            <h1 class="my-4">Restaurants</h1>
            @if($restaurants->count())
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach($restaurants as $restaurant)
                        <div class="col">
                            <div class="card h-100 restaurant-card">
                                <div class="card-body">
                                    <h2 class="restaurant-name" data-id="{{$restaurant->id}}">{{ $restaurant->name }}</h2>
                                    <div class="meal-list">
                                        <button class="btn btn-primary w-100 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#mealsCollapse{{ $restaurant->id }}" aria-expanded="false" aria-controls="mealsCollapse{{ $restaurant->id }}">
                                            {{ $restaurant->name }} menu
                                        </button>
                                        <div class="collapse" id="mealsCollapse{{ $restaurant->id }}">
                                            @forelse($restaurant->meals as $meal)
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item meal-item">
                                                        <div>
                                                            <h4>{{$meal->name}}</h4>
                                                            <span class="price">{{number_format($meal->price,2)}}</span>
                                                        </div>
                                                        <button class="btn btn-success add-to-cart-btn" data-id="{{$meal->id}}">
                                                            add to cart
                                                        </button>
                                                    </li>
                                                </ul>
                                                @empty
                                                    <p class="no-meals">No Meals</p>
                                                @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="no-restaurants">No Restaurants</p>
            @endif

            <!-- Cart Offcanvas -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="cartOffcanvasLabel">Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body">
                    <ul id="cart-items-list" class="list-group mb-3">
                        <!-- Cart items will be dynamically loaded here -->
                    </ul>
                    <button class="btn btn-primary w-100" id="placeorder-btn">Place Order</button>
                    <button class="btn btn-outline-danger w-100 mt-2" id="clear-cart-button">Clear Cart</button>
                </div>

            </div>
        </div>
    @endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('/assets/customers/home/cart.js')}}"></script>
@endsection
