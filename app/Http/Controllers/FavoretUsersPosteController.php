<?php

namespace App\Http\Controllers;

use App\Models\FavoretUsersPoste;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoretUsersPosteController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $favoret_post = FavoretUsersPoste::where('user_id', $userId)->get();
        return response()->json($favoret_post, 200);
    }

    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        if (!FavoretUsersPoste::where('user_id', $userId)->where('post_id', $request->post_id)->first()) {
            $favoret_post = FavoretUsersPoste::create([
                'user_id' => $userId,
                'post_id' => $request->post_id,
            ]);
            return response()->json($favoret_post, 200);
        } else return response()->json(['massage' => 'Post Was Favorated'], 200);
    }

    public function destroy(FavoretUsersPoste $favoret)
    {
        $userId = Auth::user()->id;

        // $UserPostEntity=FavoretUsersPoste::where('user_id',$userId)->where('post_id',$favoret)->first();
        // if ($UserPostEntity) {
        
        if ($favoret->user_id == $userId) {
            $favoret->delete();
            return response()->json(['message' => 'Favoret Post Was Deleted'], 200);
        } else return response()->json(['massage' => 'You Cannt Delete The Favoret Post'], 403);
    }
}
