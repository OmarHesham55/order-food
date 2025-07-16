@extends('layouts.app')
@section('title','Restaurant home')
@section('stylesheet')
    <link rel="stylesheet" href="{{asset('/assets/customers/home/style.css')}}">
@endsection
@section('navbar')
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Talabat</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas">
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
                                            @if($restaurant->meals->count())
                                                <ul class="list-group list-group-flush">
                                                    @foreach($restaurant->meals as $meal)
                                                        <li class="list-group-item meal-item">
                                                            <div>
                                                                <h4>{{ $meal->name }}</h4>
                                                                <span class="price">{{ number_format($meal->price, 2) }}LE</span>
                                                            </div>
                                                            <button class="btn btn-success add-to-cart-btn"
                                                                    data-meal-id="{{ $meal->id }}"
                                                                    data-meal-name="{{ $meal->name }}"
                                                                    data-meal-price="{{ $meal->price }}">
                                                                Add to cart
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="no-meals">No Meals</p>
                                            @endif
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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Total</h5>
                        <h5 class="mb-0" id="cart-total-price">$0.00</h5>
                    </div>
                    <button class="btn btn-primary w-100" id="checkout-button">Complete Order</button>
                    <button class="btn btn-outline-danger w-100 mt-2" id="clear-cart-button">remove items</button>
                </div>
            </div>
        </div>
    @endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('/assets/customers/home/main.js')}}"></script>
@endsection
