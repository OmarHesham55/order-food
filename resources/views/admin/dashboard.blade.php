@extends('layouts.app');
@section('content');
<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{route('dashboard')}}">Admin Control Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Dashboard</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <h5 class="card-title">Categories</h5>
                                <p class="card-text">Manage your categories</p>
                                <a href="{{route('categories.index')}}" class="btn btn-primary">Go to Categories</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <h5 class="card-title">Restaurants</h5>
                                <p class="card-text">Manage restaurants</p>
                                <a href="{{route('restaurants.index')}}" class="btn btn-primary">Go to Restaurants</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <h5 class="card-title">Meals</h5>
                                <p class="card-text">Manage meals</p>
                                <a href="{{route('meals.index')}}" class="btn btn-primary">Go to Meals</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
