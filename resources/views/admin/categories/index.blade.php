@extends('layouts.app')
@section('title','Categories Management')
@section('stylesheet')
    <link rel="stylesheet" href="{{asset('assets/categories/css/style.css')}}">
@endsection

@section('content')
<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{route('dashboard')}}">Admin Control Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link allCategoriesBtn" type="button">All Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('restaurants.all')}}">Restaurants</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('meals.index')}}">Meals</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Add New Category</h2>
            </div>
            <div class="card-body">
                <form action="{{route('categories.store')}}" method="POST" id="categoryForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" required>
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" placeholder="Enter slug (e.g., category-name)" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" id="addCategory">Add Category</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4 allCategories d-none">
            <div class="card-header">
                <h2 class="mb-0">Categories List</h2>
            </div>
            <div class="card-body">
                <table class="table table-hover tablelist">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('assets/categories/js/main.js')}}"></script>
@endsection
