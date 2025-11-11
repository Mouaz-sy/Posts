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
        if ($request->hasFile('image'))
            $userImage = $request->file('image')->store('my photo', 'public');
        $porfile = Profile::create([
            'user_id' => $userId,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'image' => $userImage,
            'address' => $request->address,
            'bio' => $request->bio,
        ]);
        return response()->json($porfile, 201);
    }
}
