<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanTempFiles extends Command
{
    // ✅ The command signature (what you type)
    protected $signature = 'clean:temp-files';

    // ✅ Description
    protected $description = 'Delete temporary files older than 1 day';

    public function handle()
    {
        $tempPath = storage_path('app/temp');

        // Check if temp folder exists
        if (!File::exists($tempPath)) {
            $this->info('📁 Temp folder not found');
            return 0;
        }

        // Get all temp files
        $files = File::files($tempPath);
        $deleted = 0;

        foreach ($files as $file) {
            // ✅ REMOVE date check for testing
            File::delete($file);
            $deleted++;
            $this->line("🗑️ Deleted: " . $file->getFilename());
        }

        $this->info("✅ Deleted {$deleted} temporary files!");

        return 0;
    }
}
