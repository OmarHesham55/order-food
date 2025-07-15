<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Restaurant;
use Illuminate\Http\Request;

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
            'name' => 'required|string',
            'description' => 'required|string',
            'restaurant_id' => 'required|exists:restaurants,id',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if(!$request->has('id'))
        {
            if($request->hasFile('image')){
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('assets/meals/uploads/'),$imageName);
                $request->image = $imageName;
            }
            $meal = Meal::create([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'image' => $request->image,
                'restaurant_id' => $request->restaurant_id
            ]);
            if($meal)
            {
                return response()->json(['status'=>'success','message'=>'meal saved successfully']);
            }
        }
        return response()->json(['status'=>'error','message'=>'error while saving']);

    }

    /**
     * Display the specified resource.
     */
    public function show(Meal $meal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meal $meal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meal $meal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        if($meal)
        {
            if($meal->image && file_exists(public_path('assets/meals/uploads/' . $meal->image)))
            {
                unlink(public_path('assets/meals/uploads/' . $meal->image));
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

    public function saveMeal(Request $request , $id)
    {

    }

    public function getByRestaurant($id)
    {
        $meals = Meal::where('restaurant_id',$id)->with('restaurant')->get();
        return response()->json(['status'=>'success','meals'=>$meals]);
    }

}
