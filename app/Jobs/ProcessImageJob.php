<?php

namespace App\Jobs;

use App\Models\Image;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProcessImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $image;

    public function __construct(Image $image)
    {
        $this->image = $image;  // ✅ Store the image in $this->image
    }

    public function handle(): void
    {
        // ✅ Use $this->image (NOT $image)
        $this->image->update(['status' => 'processing']);

        $path = storage_path('app/public/' . $this->image->file_path);

        // Check if file exists
        if (!File::exists($path)) {
            $this->image->update(['status' => 'failed']);
            Log::error("❌ Image not found: " . $this->image->original_name);
            return;
        }

        // Create thumbnail
        $imageInfo = getimagesize($path);
        $mimeType = $imageInfo['mime'];

        switch ($mimeType) {
            case 'image/jpeg':
                $img = imagecreatefromjpeg($path);
                break;
            case 'image/png':
                $img = imagecreatefrompng($path);
                break;
            case 'image/gif':
                $img = imagecreatefromgif($path);
                break;
            default:
                $this->image->update(['status' => 'failed']);
                Log::error("❌ Unsupported image type: " . $mimeType);
                return;
        }

        // Get dimensions
        $width = imagesx($img);
        $height = imagesy($img);

        // Calculate thumbnail size
        $thumbWidth = 200;
        $thumbHeight = intval($height * ($thumbWidth / $width));

        // Create thumbnail
        $thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);

        if ($mimeType === 'image/png') {
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
        }

        imagecopyresampled(
            $thumb,
            $img,
            0,
            0,
            0,
            0,
            $thumbWidth,
            $thumbHeight,
            $width,
            $height
        );

        // Save thumbnail
        $thumbName = 'thumb_' . basename($this->image->file_path);
        $thumbPath = 'thumbnails/' . $thumbName;

        if (!File::exists(storage_path('app/public/thumbnails'))) {
            File::makeDirectory(storage_path('app/public/thumbnails'), 0777, true);
        }

        switch ($mimeType) {
            case 'image/jpeg':
                imagejpeg($thumb, storage_path('app/public/' . $thumbPath));
                break;
            case 'image/png':
                imagepng($thumb, storage_path('app/public/' . $thumbPath));
                break;
            case 'image/gif':
                imagegif($thumb, storage_path('app/public/' . $thumbPath));
                break;
        }

        imagedestroy($img);
        imagedestroy($thumb);

        // ✅ Use $this->image
        $this->image->update([
            'thumbnail_path' => $thumbPath,
            'status' => 'completed'
        ]);

        Log::info("✅ Image processed: " . $this->image->original_name);
    }

    public function failed(\Throwable $e): void
    {
        // ✅ Use $this->image
        $this->image->update(['status' => 'failed']);
        Log::error("❌ Image job failed: " . $e->getMessage());
    }
}
