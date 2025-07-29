<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealRequest;
use App\Models\Meal;
use App\Models\Restaurant;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MealsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Meal $meal)
    {
        $restaurants = Restaurant::all();
        $meals = Meal::with('restaurant')->get();
        return view('admin.meals.index',compact('meals','restaurants'));
    }

    public function store(MealRequest $request)
    {

        $imageName = null;
        if($request->hasFile('image')){
            $imageName = ImageUploadService::handleImageUpload($request->image,'assets/meals/uploads/');
        }
        $meal = Meal::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imageName,
            'restaurant_id' => $request->restaurant_id
        ]);
        if($meal)
        {
            return response()->json(['status'=>'success','message'=>'meal saved successfully']);
        }

        return response()->json(['status'=>'error','message'=>'error while saving']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0'
        ]);

        $meal = Meal::findOrFail($id);
        $meal->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Updated successfully'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        if($meal)
        {
            if ($meal->image && File::exists(public_path('assets/meals/uploads/' . $meal->image))) {
                File::delete(public_path('assets/restaurants/uploads/' . $meal->image));
            }
            $meal->delete();
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

    public function getByRestaurant($id)
    {
        $meals = Meal::where('restaurant_id',$id)->with('restaurant')->get();
        return response()->json(['status'=>'success','meals'=>$meals]);
    }

}
