@extends('layouts.app')
@section('title', 'All Restaurants')
@section('stylesheet')
    <link rel="stylesheet" href="{{asset('assets/restaurants/allRestaurants.css')}}">
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
            <div class="col-md-12">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-gradient-success text-white text-center py-4 rounded-top-4">
                        <h3 class="mb-0 fw-bold">Restaurants List</h3>
                        <p class="mb-0 text-white-75">All restaurants in the system</p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show rounded-pill" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                            <div class="alert alert-info text-center rounded-pill" role="alert">
                                <a href="{{ route('restaurants.index') }}" class="alert-link">Add New Restaurant!</a>
                            </div>
                        @if($restaurants->isEmpty())
                                <div class="alert alert-info text-center rounded-pill" role="alert">
                                    No Restaurants Exist!
                                </div>
                            @else
                            <div class="table-responsive">
                                <table class="table table-hover table-striped align-middle text-center">
                                    <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Slug</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($restaurants as $index => $restaurant)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @if($restaurant->image)
                                                    <img src="{{ asset('assets/restaurants/uploads/' . $restaurant->image) }}" class="img-thumbnail rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                                                @endif
                                            </td>
                                            <td class="fw-bold">{{ $restaurant->name }}</td>
                                            <td>{{ $restaurant->slug }}</td>
                                            <td>{{ $restaurant->category->name ?? 'N/A'}}</td>
                                            <td>{{ $restaurant->address }}</td>
                                            <td>{{ $restaurant->phone }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill mx-1 editBtn"  data-bs-toggle="modal" data-bs-target="#editRestaurantModal"  title="edit" data-id={{$restaurant->id}}>
                                                    <i class="bi bi-pencil-square">Edit</i>
                                                </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger deleteBtn rounded-pill mx-1" title="delete" data-id = {{$restaurant->id}}>
                                                        <i class="bi bi-trash">Delete</i>
                                                    </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


                        {{--    ***************Edit Form*************************** --}}

    <div class="modal fade" id="editRestaurantModal" tabindex="-1" aria-labelledby="editRestaurantModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Restaurant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                                                {{-- Modal Body --}}
                <div class="modal-body">
                                                {{-- Modal Form --}}

                    <form id="editRestaurantForm" enctype="multipart/form-data" method="POST">
                        @csrf

                        <input type="hidden" id="restaurantId" name="id" value="">

                        <div class="mb-3">
                            <label for="restaurantName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="restaurantName" name="name" value="">
                        </div>
                        <div class="mb-3">
                            <label for="restaurantSlug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="restaurantSlug" name="slug" value="">
                        </div>

                        <div class="mb-4">
                            <label for="categories_id" class="form-label">Category</label>
                            <select class="form-select" id="categories_id" name="categories_id">
                                <option  class="defaultVal">Choose Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}"> {{$category->name}} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="restaurantAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="restaurantAddress" name="address" value="">
                        </div>

                        <div class="mb-3">
                            <label for="restaurantPhone" class="form-label">Phone</label>
                            <input class="form-control" id="restaurantPhone" value="" name="phone">
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="form-text text-muted mt-2 d-block">Maximum File is 2MB: JPG, PNG, GIF.</small>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="updateBtn">Update</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('assets/restaurants/allRestaurants.js')}}"></script>
@endsection
