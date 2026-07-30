<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function index()
    {
        $items = Items::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $items,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|array|max:4',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('uploads', $filename, 'public');
                $imagePaths[] = 'storage/' . $path;
            }
        }

        $item = Items::create([
            'title' => $request->title,
            'description' => $request->description,
            'images' => $imagePaths
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Item created successfully',
            'data' => $item
        ], 201);
    }

    public function show($id)
    {
        $item = Items::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not foundj',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Items::find($id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|array|max:4',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'existing_images' => 'nullable|array',
            'removed_images' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Get current images
        $currentImages = $item->images ?? [];

        // Get removed images
        $removedImages = $request->removed_images ?? [];

        // Get existing images to keep
        $existingImages = $request->existing_images ?? [];

        // Delete removed images from storage
        foreach ($removedImages as $imagePath) {
            $this->deleteImageFile($imagePath);
        }

        // Handle new image uploads
        $newImagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('uploads', $filename, 'public');
                $newImagePaths[] = 'storage/' . $path;
            }
        }

        // Merge existing images with new ones
        $finalImages = array_merge($existingImages, $newImagePaths);

        // Update item
        $item->update([
            'title' => $request->title ?? $item->title,
            'description' => $request->description ?? $item->description,
            'images' => $finalImages
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Item updated successfully',
            'data' => $item
        ]);
    }

    public function destroy($id)
    {
        $item = Items::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found'
            ], 404);
        }

        if ($item->images) {
            foreach ($item->images as $imagePath) {
                $this->deleteImageFile($imagePath);
            }
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item deleted successfully'
        ]);
    }

    public function deleteImageFile($imagePath)
    {
        $path = str_replace('storage/', '', $imagePath);
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
