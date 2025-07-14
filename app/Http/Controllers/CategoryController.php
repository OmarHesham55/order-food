<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $categories = Category::all();
            return response()->json(['categories'=>$categories]);
        }
        $categories = Category::all();
        return view('admin.categories.index',compact('categories'));
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
           'name' => 'required',
           'slug' => 'required'
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->slug)
        ]);
        if($category)
        {
            return response()->json(['status' => 'success','message'=>$category->name.' added successfully','category'=>$category]);
        }
        return response()->json(['status' => 'error','message'=>'failed to create ']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if($category)
        {
            $category->delete();
            return response()->json(['status' => 'success','message'=>'deleted successfully']);
        }
        return response()->json(['status'=>'error','message'=>'failed to delete']);
    }
}
