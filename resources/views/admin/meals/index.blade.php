@extends('layouts.app')
@section('title','New Meal')
@section('content')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{route('dashboard')}}">Admin Control Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('categories.index')}}">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('restaurants.index')}}">Restaurants</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="text-center text-primary fw-bold">Meals</h2>
                <p class="lead text-center text-muted">Add New Meal</p>
                <hr class="my-4">
            </div>
        </div>

        <div class="card shadow-sm mb-5">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>New Meal</h4>
            </div>
            <div class="card-body">
                <form id="meal-form" class="row g-3 needs-validation" method="POST" enctype="multipart/form-data" action="{{route('meals.store')}}" novalidate>
                    @csrf
                    <div class="col-md-6">
                        <label for="mealName" class="form-label">Meal Name</label>
                        <input type="text" class="form-control" id="mealName" name="name" placeholder="Grilled chicken" required>
                    </div>
                    <div class="col-md-6">
                        <label for="mealPrice" class="form-label">Price</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="mealPrice" name="price" placeholder="ex:150" required>
                            <span class="input-group-text">LE</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="mealImage" class="form-label fw-semibold">Image</label>
                        <input type="file" class="form-control"
                               id="mealImage" name="image" accept="image/*">
                        <small class="form-text text-muted mt-2 d-block">Maximum File is 2MB: JPG, PNG, GIF.</small>
                    </div>
                    <div class="col-md-6">
                        <label for="mealDescription" class="form-label">description</label>
                        <textarea class="form-control" id="mealDescription" name="description" rows="1"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="restaurantSelect" class="form-label">Restaurant</label>
                        <select class="form-select" id="restaurantSelect" name="restaurant_id" required>
                            <option value="" disabled selected>Choose Restaurant</option>
                            @foreach($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success btn-lg mt-3">
                            <i class="fas fa-save me-2"></i>add meal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div id="restaurant-buttons" class="mb-3 d-flex gap-2 flex-wrap">
            @foreach($restaurants as $restaurant)
                <button class="btn btn-outline-primary restaurant-btn" data-id="{{ $restaurant->id }}">
                    {{ $restaurant->name }}
                </button>
            @endforeach
        </div>

        <table id="meals-table" class="table table-hover table-striped" style="width:100%">
            <thead class="bg-light">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('assets/meals/js/main.js')}}"></script>
@endsection
