<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequest;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Restaurant;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RestaurantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view("admin.restaurants.index",compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RestaurantRequest $request)
    {
        $imageName = null;
        if($request->hasFile('image'))
        {
            $imageName = ImageUploadService::handleImageUpload($request->file('image'),'assets/restaurants/uploads/');
        }
        $restaurant = Restaurant::create([
           'name' => $request->name,
           'slug' => Str::slug($request->slug),
            'address' => $request->address,
            'phone' => $request->phone,
            'image' => $imageName,
            'categories_id' => $request->categories_id
        ]);

        if ($restaurant)
        {
            return response()->json([
                'status' => 'success',
                'message'=>'Restaurant added successfully',
                'restaurant' => $restaurant
            ]);
        }
        return response()->json([
            'status'=>'error',
            'message'=>"can't add the restaurant",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        return response()->json([
            'status' => 'success',
            'restaurant' => $restaurant
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RestaurantRequest $request, Restaurant $restaurant)
    {
        $imageName = $restaurant->image;
        if ($request->hasFile('image')) {
            $imageName = ImageUploadService::handleImageUpload($request->file('image'),$restaurant->image);
        }
        $updated = $restaurant->update([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'address' => $request->address,
            'phone' => $request->phone,
            'image' => $imageName,
            'categories_id' => $request->categories_id
        ]);
        if ($updated)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'updated successfully'
            ],200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'failed to update'
        ],500);

    }

    /**
     * Remove the specified resource from storage.
     */
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
