@extends('layouts.app')
@section('title', 'New Restaurant')
@section('stylesheet')
    <link rel="stylesheet" href="{{asset('assets/restaurants/style.css')}}">
@endsection

@section('content')

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{route('dashboard')}}">Admin Control Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{route('restaurants.all')}}">All Restaurants</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('categories.index')}}">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('meals.index')}}">Meals</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-gradient-primary text-white text-center py-4 rounded-top-4">
                        <h3 class="mb-0 fw-bold">Register new Restaurant</h3>
                        <p class="mb-0 text-white-75">Fill Data</p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('restaurants.store') }}" method="POST" id="restaurantForm" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">Restaurant Name</label>
                                <input type="text" class="form-control form-control-lg rounded-pill "
                                       id="name" name="name" value="{{ old('name') }}" >
                            </div>

                            <div class="mb-4">
                                <label for="slug" class="form-label fw-semibold">Slug</label>
                                <input type="text" class="form-control form-control-lg rounded-pill "
                                       id="slug" name="slug" value="{{ old('slug') }}">
                            </div>

                            <div class="mb-4">
                                <label for="categories_id" class="form-label fw-semibold">Category</label>
                                <select class="form-select form-select-lg rounded-pill"
                                        id="categories_id" name="categories_id">
                                    <option value="">-- choose restaurant --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('categories_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="address" class="form-label fw-semibold">Address</label>
                                <input type="text" class="form-control form-control-lg rounded-pill"
                                       id="address" name="address" value="{{ old('address') }}">
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                <input type="text" class="form-control form-control-lg rounded-pill"
                                       id="phone" name="phone" value="{{ old('phone') }}">
                            </div>

                            <div class="mb-4">
                                <label for="image" class="form-label fw-semibold">Image</label>
                                <input type="file" class="form-control form-control-lg rounded-pill"
                                       id="image" name="image" accept="image/*">
                                <small class="form-text text-muted mt-2 d-block">Maximum File is 2MB: JPG, PNG, GIF.</small>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold py-3" id="addBtn">
                                    <i class="bi bi-plus-circle me-2"></i> Add Restaurant
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('assets/restaurants/main.js')}}"></script>
@endsection
