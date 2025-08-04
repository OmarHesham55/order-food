<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequest;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Restaurant;
use App\Services\ImageUploadService;
use App\Services\RestaurantService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RestaurantsController extends Controller
{
    protected $service;

    public function __construct(RestaurantService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $categories = Category::all();
        return view("admin.restaurants.index",compact('categories'));
    }

    public function store(RestaurantRequest $request)
    {
        $restaurant = $this->service->create($request->all());
        return $restaurant
            ? response()->json([
                'status' => 'success',
                'message' => 'Restaurant added successfully',
                'restaurant' => $restaurant
            ])
            : response()->json([
                'status' => 'error',
                'message' => "can't added the restaurant"
            ]);
    }

    public function show(Restaurant $restaurant)
    {
        return response()->json([
            'status' => 'success',
            'restaurant' => $restaurant
        ]);
    }

    public function update(RestaurantRequest $request, Restaurant $restaurant)
    {
        $updated = $this->service->update($restaurant,$request->all());

        return $updated
            ? response()->json([
                'status' => 'success',
                'message' => 'Updated Successfully'
            ],200)
            : response()->json([
                'status' => 'error',
                'message' => 'Failed to Update'
            ],500);
    }

    public function destroy(Restaurant $restaurant)
    {

            if ($restaurant->image && File::exists(public_path('assets/restaurants/uploads/' . $restaurant->image))) {
                File::delete(public_path('assets/restaurants/uploads/' . $restaurant->image));
            }

            $restaurant->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'deleted successfully'
            ]);
    }

    public function all()
    {
        $categories = Category::all();
        $restaurants = Restaurant::with('category')->latest()->paginate(10);
        return view('admin.restaurants.allRestaurants',compact('restaurants','categories'));
    }
}
