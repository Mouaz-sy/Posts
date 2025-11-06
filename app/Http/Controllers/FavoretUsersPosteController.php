<?php

namespace App\Http\Controllers;

use App\Models\FavoretUsersPoste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoretUsersPosteController extends Controller
{
    public function index()
    {
        $favoret_post = FavoretUsersPoste::all();
        return response()->json($favoret_post, 200);
    }

    public function store(Request $request)
    {
        $userId=Auth::user()->id;

        $favoret_post = FavoretUsersPoste::create([
            'user_id'=>$userId,
            'post_id'=>$request->post_id,
        ]);
        return response()->json($favoret_post, 200);
    }

    public function destroy(FavoretUsersPoste $favoret)
    {
        $favoret->delete();
        return response()->json(['message' => 'Favoret Post Was Deleted'], 200);
    }
}
