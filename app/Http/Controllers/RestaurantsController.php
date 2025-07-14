<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RestaurantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Restaurant $restaurant)
    {
        $categories = Category::all();
        return view("admin.restaurants.index",compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:restaurants',
            'slug' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categories_id' => 'required|exists:categories,id',
            'address' => 'required',
            'phone' => [
                'required',
                'digits:11', // Ensures exactly 11 digits
                'regex:/^(010|011|012|015)\d{8}$/' // Starts with 010, 011, 012, or 015 followed by 8 digits
            ],
        ]);

        $imageName = null;
        if($request->hasFile('image'))
        {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('assets/restaurants/uploads/'),$imageName);
            $request->image = $imageName;
        }
        $restaurant = Restaurant::create([
           'name' => $request->name,
           'slug' => Str::slug($request->slug),
            'address' => $request->address,
            'phone' => $request->phone,
            'image' => $request->image,
            'categories_id' => $request->categories_id
        ]);

        if ($restaurant)
        {
            return response()->json(['status' => 'success','message'=>'Restaurant added successfully','restaurant' => $restaurant]);
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
        if($restaurant)
        {
            return response()->json([
                'status' => 'success',
                'restaurant' => $restaurant
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'errorrr'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required|unique:restaurants,name,' . $restaurant->id,
            'slug' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categories_id' => 'required|exists:categories,id',
            'address' => 'required',
            'phone' => [
                'required',
                'digits:11', // Ensures exactly 11 digits
                'regex:/^(010|011|012|015)\d{8}$/' // Starts with 010, 011, 012, or 015 followed by 8 digits
            ],
        ]);
        $imageName = $restaurant->image;
        if ($request->hasFile('image')) {
            if ($restaurant->image && file_exists(public_path('assets/restaurants/uploads/' . $restaurant->image))) {
                unlink(public_path('assets/restaurants/uploads/' . $restaurant->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('assets/restaurants/uploads/'), $imageName);
            $request->image = $imageName;
        }
        $updated = $restaurant->update([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'address' => $request->address,
            'phone' => $request->phone,
            'image' => $request->image,
            'categories_id' => $request->categories_id
        ]);
        if ($updated)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'updated successfully'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'failed to update'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        if($restaurant)
        {
            if ($restaurant->image && file_exists(public_path('assets/restaurants/uploads/' . $restaurant->image))) {
                unlink(public_path('assets/restaurants/uploads/' . $restaurant->image));
            }
            $restaurant->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'deleted successfully'
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'failed to delete'
        ]);
    }

    public function all()
    {
        $categories = Category::all();
        $restaurants = Restaurant::with('category')->latest()->paginate(10);
        return view('admin.restaurants.allRestaurants',compact('restaurants','categories'));
    }
}
