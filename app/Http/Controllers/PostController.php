<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();

        $formattedPosts = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'body' => $post->body,
                'user_id' => $post->user_id,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ];
        });

        return response()->json($formattedPosts);
    }

    public function store(Request $request)
    {
        $userId = Auth::user()->id;

        $validatedData = $request->validate([
            'title' => 'required|string|max:1000',
            'body' => 'required|string|max:1000',
        ]);

        $post = Post::create([
            'title' => $validatedData['title'],
            'body' => $validatedData['body'],
            'user_id' => $userId,
            'category_id' => $request->category_id,
        ]);

        $formattedPost = [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'user_id' => $userId,
            'category' => Category::where('id', $post->category_id)->get('name'),
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
        ];

        return response()->json($formattedPost, 201);
    }


    public function show(Post $post)
    {
        $userId = Auth::user()->id;
        $formattedPost = [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'user_id' => $post->user_id,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
        ];

        return response()->json($formattedPost);
    }


    public function update(Request $request, Post $post)
    {
        $userId = Auth::user()->id;

        $validatedData = $request->validate([
            'title' => 'required|string|max:1000',
            'body' => 'required|string|max:1000',
        ]);
        if ($post->user_id === $userId) {
            $post->update([
                'title' => $validatedData['title'],
                'body' => $validatedData['body'],
                'user_id' => $userId,
            ]);

            $formattedPost = [
                'id' => $post->id,
                'title' => $post->title,
                'body' => $post->body,
                'user_id' => $post->user_id,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ];
            return response()->json(['massage' => 'Editing Succecfuly', $formattedPost]);
        } else return response()->json(['massage' => 'You Cannt Edit The Post'], 403);
    }

    public function destroy(Post $post)
    {
        $userId = Auth::user()->id;
        if ($post->user_id === $userId) {
            $post->delete();
            return response()->json(['massage' => 'Post Was Deleted'], 200);
        } else return response()->json(['massage' => 'You Cannt Delete The Post'], 403);
    }
}
