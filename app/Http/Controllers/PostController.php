<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // استرجاع جميع المنشورات
        $posts = Post::orderBy('created_at', 'desc')->get();

        // تحويل كل منشور لإرسال حقل 'title' بدلاً من 'title'
        $formattedPosts = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title, // هذا هو التعديل الضروري: تحويل title إلى title
                'body' => $post->body,
                'user_id' => $post->user_id,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
                // يمكنك إضافة حقول أخرى هنا إن وجدت
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
            'userId'    
        ]);

        $post = Post::create([
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

        return response()->json($formattedPost, 201);
    }

    /**
     * عرض منشور محدد (GET /api/posts/{post}).
     * يتم تحويل حقل 'title' إلى 'title' ليتوافق مع React.
     */
    public function show(Post $post)
    {
        // تحويل حقل 'title' إلى 'title' قبل الإرسال
        $formattedPost = [
            'id' => $post->id,
            'title' => $post->title, // هذا هو التعديل الضروري: تحويل title إلى title
            'body' => $post->body,
            'user_id' => $post->user_id,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
        ];

        return response()->json($formattedPost);
    }


    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:1000',
            'body' => 'required|string|max:1000',
        ]);

        // التحديث: تخزين قيمة 'title' في عمود 'title'
        $post->update([
            'title' => $validatedData['title'],
            'body' => $validatedData['body'],
            'user_id' => $request['user_id'],
        ]);

        // نقوم بإعادة المنشور المُحدَّث مع تحويل حقل 'title' إلى 'title'
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

    /**
     * حذف منشور محدد (DELETE /api/posts/{post}).
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['massage' => 'Post Was Deleted'], 200);
    }
}
