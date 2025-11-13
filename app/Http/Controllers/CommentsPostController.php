<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\CommentsPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dotenv\Exception\ValidationException;

class CommentsPostController extends Controller
{

    public function index(Post $post)
    {
        // $getCommentsPost = CommentsPost::where('post_id', $post->id);
        // return response()->json($getCommentsPost, 200);
        $comments = $post->comments()->with('user:id,name')->get();

        return response()->json([
            'post_id' => $post->id,
            'comments' => $comments
        ], 200);
    }

    public function store(Request $request, Post $post)

    {
        try {
            // 1. التحقق من صحة البيانات المدخلة
            $validatedData = $request->validate([
                'comment_text' => 'required|string|max:1000',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                // 'errors' => $e->errors()
            ], 422);
        }

        // 2. التحقق من وجود مستخدم مصادق عليه
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $userId = Auth::id();

        // 3. إنشاء التعليق
        $comment = CommentsPost::create([ // تم تغيير CommentsPost إلى Comment
            'comment_text' => $validatedData['comment_text'], // استخدم $validatedData
            'post_id' => $post->id, // استخدم $post->id القادم من الـ URL
            'user_id' => $userId,
        ]);

        // 4. تحميل علاقة المستخدم وإرجاع الاستجابة
        $comment->load('user:id,name');
        return response()->json([
            'message' => 'Comment added successfully.',
            'comment' => $comment
        ], 201);
    }

    public function update(Request $request, CommentsPost $commentsPost)
    {
        $commentsPost->update([
            'comment_text' => $request->comment_text
        ]);
        $commentsPost->load('user:id,name');
        return response()->json($commentsPost, 200);
    }

    public function destroy(CommentsPost $commentsPost)
    {
        //
    }
}
