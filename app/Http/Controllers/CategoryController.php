<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Events\ResponsePrepared;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return response()->json([$categories], 200);
    }

    public function store(Request $request)
    {
        $newCat = Category::create([
            'name' => $request->name,
        ]);
        return response()->json([$newCat], 200);
    }

    public function show(Category $category)
    {
        // $cateId = $category->id;
        // $catsPost = Category::where('id', $cateId)->get();
        // return response()->json([$catsPost], 200);c
        $category->load('posts');
        return response()->json($category, 200);
    }

    public function update(Request $request, Category $category)
    {
        $category->update([
            'name' => $request->name,
        ]);
        return response()->json(['message' => 'The category Updating', 'category' => $category], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'Category Wsa Deleted'], 200);
    }
}
