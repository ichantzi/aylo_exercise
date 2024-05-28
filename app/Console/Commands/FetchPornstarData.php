<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FetchPornstarDataService;
use App\Services\ProcessPornstarDataService;

class FetchPornstarData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:pornstardata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch pornstar data from the JSON feed and update the database';

    protected $fetchService;
    protected $processService;

    public function __construct(FetchPornstarDataService $fetchService, ProcessPornstarDataService $processService)
    {
        parent::__construct();
        $this->fetchService = $fetchService;
        $this->processService = $processService;
    }

    public function handle()
    {
        ini_set('memory_limit', '1G');

        try {
            $data = $this->fetchService->fetchData();
            $this->processService->process($data);
            $this->info('Pornstar data fetched and processed successfully.');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
