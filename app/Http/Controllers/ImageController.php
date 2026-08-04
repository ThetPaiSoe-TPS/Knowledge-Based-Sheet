<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessImageJob;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120'
        ]);

        $file = $request->file('image');
        $path = $file->store('images', 'public');

        $image = Image::create([
            'user_id' => $request->user()->id,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'status' => 'pending'
        ]);

        ProcessImageJob::dispatch($image);

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded! Processing in background.',
            'data' => $image
        ]);
    }

    public function status($id)
    {
        $image = Image::find($id);
        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $image->id,
                'original_name' => $image->original_name,
                'status' => $image->status,
                'image_url' => asset('storage/' . $image->file_path),
                'thumbnail_url' => $image->thumbnail_path ? asset('storage/' . $image->thumbnail_path) : null
            ]
        ]);
    }
}
