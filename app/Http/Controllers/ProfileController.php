<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $porfile = Profile::create([
            'user_id'=>$userId,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'image' => $request->image,
            'address' => $request->address,
            'bio' => $request->bio,
        ]);
        return response()->json($porfile,201);
    }
}
