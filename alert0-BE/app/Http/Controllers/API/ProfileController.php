<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if($user->profile_picture)
        {
            Storage::delete('public/' . $user->profile_picture);
        }

        $path = $request->file('profile_picture')->store('profile_picture', 'public');

        $user->update(['profile_picture' => $path]);

        return response()->json([
            'message' => 'Profile Picture updated successfully',
            'profile_picture_url' => asset('storage/' .$path),
        ], 200);

    }

    public function retrieveProfilePicture()
    {
        $user = auth()->user();

        return response()->json([
            'profile_picture_url' => $user->profile_picture
                ? asset('storage/' . $user->profile_picture)
                : asset('default-avatar.jpg')
        ]);
    }

}
