<?php

namespace App\Http\Controllers;

use App\Models\Category; 
use App\Models\Post;     
use Illuminate\Http\Request;

class CategoryPostController extends Controller
{
    // عرض جميع الفئات التي ينتمي إليها منشور معين
    // GET /api/posts/{post}/categories
    public function indexForPost(Post $post)
    {
        return response()->json($post->categories, 200);
    }

    // ربط منشور موجود بفئة أو فئات موجودة
    // POST /api/posts/{post}/categories
    public function attachCategories(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id', // تحقق أن الـ IDs موجودة
        ]);

        $post->categories()->syncWithoutDetaching($validatedData['category_ids']);

        return response()->json(['message' => 'Categories attached successfully', 'post' => $post->load('categories')], 200);
    }

    // فصل فئة أو فئات عن منشور معين
    // DELETE /api/posts/{post}/categories/{category} (لفصل فئة واحدة)
    public function detachCategory(Post $post, Category $category)
    {
        if (!$post->categories->contains($category->id)) {
            return response()->json(['message' => 'Category not attached to this post'], 404);
        }
        $post->categories()->detach($category->id);

        return response()->json(['message' => "Category '{$category->name}' detached from post successfully"], 200);
    }
}