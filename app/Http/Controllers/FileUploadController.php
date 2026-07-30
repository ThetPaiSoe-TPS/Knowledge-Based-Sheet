<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;

class FileUploadController extends Controller
{
    //
    public function index()
    {
        $uploads = Upload::latest()->paginate(10);
        return response()->json([
            'success' => true,
            'data' => $uploads,
        ]);
    }

    public function upload(Request $res)
    {
        $res->validate(['file' => 'required|file|max:5120|mimes:jpg,jpeg,png,gif,pdf,csv']);

        try {
            $file = $res->file('file');
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('uploads', $fileName, 'public');

            $upload = Upload::create([
                'file_name' => $fileName,
                'original_name' => $originalName,
                'file_path' => $path,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'data' => $upload,
                'preview_url' => $this->getPrevieUrl($upload)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function preview($id)
    {
        $upload = Upload::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $upload,
            'preview_url' => $this->getPreviewUrl($upload),
            'file_info' => [
                'name' => $upload->original_name,
                'size' => $upload->formatted_size,
                'type' => $upload->file_type,
                'uploaded_at' => $upload->created_at->format('Y-m-d H:i:s')
            ]
        ]);
    }

    public function delete($id)
    {
        try {
            $upload = Upload::findOrFail($id);

            if (Storage::disk('public')->exists($upload->file_path)) {
                Storage::disk('public')->delete($upload->file_path);
            }

            $upload->delete();

            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Deleted failed: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getPreviewUrl($upload)
    {
        $path= asset('storage/' . $upload->file_path);

        if(str_contains($upload->file_type, 'image')){
            return $path;
        }

        if($upload->file_type=== 'application/pdf'){
            return $path;
        }

        return $path;

    }
}
