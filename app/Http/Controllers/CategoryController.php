<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function index()
    {
        return view('admin.categories.index');
    }

    public function getData()
    {
        $categories = Category::all();
        return response()->json([
            'message' => 'success',
            'categories' => $categories
        ],200);
    }

    public function store(StoreCategoryRequest $request)
    {
        $validate = $request->validated();

        if($request->has('id'))
        {
            $category = Category::find($request->id);
            if(!$category)
            {
                return response()->json([
                    'status'=>'error',
                    'message'=>'can\'t find this category'
                ]);
            }
            $category->update([
                'name' => $validate['name'],
                'slug' => $validate['slug']
            ]);

            return response()->json([
                'status'=>'success',
                'message'=>'Updated successfully'
            ]);
        }

        $category = Category::create([
            'name' => $validate['name'],
            'slug' => $validate['slug']
        ]);
        if($category)
        {
            return response()->json([
                'status' => 'success',
                'message'=>$category->name.' added successfully',
                'category'=>$category
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message'=>'failed to create '
        ]);
    }

    public function show($id)
    {
        $category = Category::find($id);
        return $category
            ? response()->json(['category' => $category],200)
            : response()->json(['message' => 'Category not found'],404);
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Deleted Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'=>'error',
                'message'=>'failed to delete'
            ]);

        }
    }
}
