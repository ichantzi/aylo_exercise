<?php

namespace App\Console\Commands;

use App\Services\DownloadPornstarImagesService;
use Illuminate\Console\Command;

class DownloadPornstarImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:pornstar-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download pornstar images';

    /**
     * Execute the console command.
     */
    public function handle(DownloadPornstarImagesService $service)
    {
        try {
            $service->downloadImages();
            $this->info('Pornstar images downloaded successfully.');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }

    }
}
