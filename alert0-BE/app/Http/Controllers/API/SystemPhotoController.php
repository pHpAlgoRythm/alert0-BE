<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use App\Models\SystemPhoto;
use Validator;

class SystemPhotoController extends Controller
{


public function storeSystemPhoto(Request $request): JsonResponse
{
   $validator =  validator::make($request->all(), [
        'photo_name' => 'required',
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
    ]);

    if($validator->fails()){

        return response()->json([
            'message' => 'validation error',
            ], 422);

    }

    $path = $request->file('photo')->store('system_photo', 'public');

    $systemPhotoUploaded = SystemPhoto::create([
        'photo_name'=> $request->photo_name,
        'photo' => $path
    ]);

    return response()->json([
        'message' => 'System Photo uploaded successfully',
        'system_photo_url' => asset('storage/' . $path),
    ], 200);
}


    public function updateSystemPhoto(Request $request, string $id)
    {
        $photos = SystemPhoto::find($id);

        if (!$photos) {
            return response()->json([
                'message' => 'Photo not found',
            ], 404);
        }

        $request->validate([
            'photo_name' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($photos->photo) {
            Storage::delete('public/' . $photos->photo);
        }

        $path = $request->file('photo')->store('system_photo', 'public');

        $photos->update(['photo' => $path]);

        return response()->json([
            'message' => 'System Photo updated successfully',
            'system_photo_url' => asset('storage/' . $path),
        ], 200);
    }


    public function displaySystemPhoto(): JsonResponse
{
    $photos = SystemPhoto::all();

    $photoData = $photos->map(function ($photo) {
        return [
            'title' => $photo->photo_name,
            'system_photo_url' => asset('storage/' . $photo->photo),
        ];
    });

    return response()->json([
        'photos' => $photoData->isEmpty()
            ? [['title' => 'Default Title', 'system_photo_url' => asset('default-avatar.jpg')]]
            : $photoData
    ]);
}

}
