<?php

namespace App\Jobs;

use App\Models\Upload;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $upload;

    public function __construct(Upload $upload)
    {
        $this->upload = $upload;
    }

    public function handle(): void
    {
        // This is "slow" work
        $path = Storage::disk('public')->path($this->upload->file_path);

        // Create thumbnail (slow)
        $img = Image::make($path);
        $img->resize(200, 200);

        // Save thumbnail (slow)
        $thumbPath = 'thumbnails/' . $this->upload->file_name;
        Storage::disk('public')->put($thumbPath, (string) $img->encode());

        $this->upload->update(['processed' => true]);

        Log::info("Image processed: " . $this->upload->id);
    }
}
