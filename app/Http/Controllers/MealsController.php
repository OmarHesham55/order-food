<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealRequest;
use App\Models\Meal;
use App\Models\Restaurant;
use App\Services\ImageUploadService;
use App\Services\MealService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MealsController extends Controller
{
    protected $service;
    public function __construct(MealService $service)
    {
        $this->service = $service;
    }

    public function index(Meal $meal)
    {
        $restaurants = Restaurant::all();
        $meals = Meal::with('restaurant')->get();
        return view('admin.meals.index',compact('meals','restaurants'));
    }

    public function store(MealRequest $request)
    {
        $meal = $this->service->create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Meal Created Successfully',
        ],200);

    }

    public function update(MealRequest $request,$id)
    {
        $meal = Meal::findOrFail($id);

        $updated = $this->service->update($request->validated(),$meal);

        return $updated
            ? response()->json([
                'status' => 'success',
                'message' => 'Updated successfully'
            ])
            : response()->json([
                'status' => 'error',
                'message' => 'Failed to update'
            ], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        $deleted = $this->service->delete($meal);

        return $deleted
            ? response()->json([
                'status' => 'success',
                'message' => 'deleted successfully'
            ])
            : response()->json([
                'status' => 'error',
                'message' => 'failed to delete'
            ],500);
    }

    public function getByRestaurant($id)
    {
        $meals = Meal::where('restaurant_id',$id)->with('restaurant')->get();
        return response()->json(['status'=>'success','meals'=>$meals]);
    }

}
