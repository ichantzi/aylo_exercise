<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Alias;
use App\Models\Pornstar;
use App\Models\PornstarStats;
use App\Models\Thumbnail;

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

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('memory_limit', '512M');

        $response = Http::get('https://www.pornhub.com/files/json_feed_pornstars.json');

        if ($response->failed()) {
            $this->error('Failed to fetch data');
            return;
        }

        $data = $response->json();
        $generationDate = $data['generationDate'];
        $items = $data['items'];
        foreach ($items as $item) {

            if (!isset($item['id'], $item['name'], $item['attributes'])) {
                $this->error('Missing required fields in the data.');
                continue;
            }

            $attributes = $item['attributes'];
            $stats = $attributes['stats'] ?? [];

            $pornstar = Pornstar::updateOrCreate(
                ['pornhub_id' => $item['id']],
                [
                    'name' => $item['name'],
                    'link' => $item['link'] ?? '',
                    'license' => $item['license'] ?? '',
                    'wlStatus' => $item['wlStatus'] ?? '',
                    'hairColor' => $attributes['hairColor'] ?? '',
                    'ethnicity' => $attributes['ethnicity'] ?? '',
                    'tattoos' => $attributes['tattoos'] ?? false,
                    'piercings' => $attributes['piercings'] ?? false,
                    'breastSize' => $attributes['breastSize'] ?? 0,
                    'breastType' => $attributes['breastType'] ?? '',
                    'gender' => $attributes['gender'] ?? '',
                    'orientation' => $attributes['orientation'] ?? '',
                    'age' => $attributes['age'] ?? 0,
                ]
            );

            PornstarStats::updateOrCreate(
                ['pornstar_id' => $pornstar->id],
                [
                    'subscriptions' => $stats['subscriptions'] ?? 0,
                    'monthlySearches' => $stats['monthlySearches'] ?? 0,
                    'views' => $stats['views'] ?? 0,
                    'videosCount' => $stats['videosCount'] ?? 0,
                    'premiumVideosCount' => $stats['premiumVideosCount'] ?? 0,
                    'whiteLabelVideoCount' => $stats['whiteLabelVideoCount'] ?? 0,
                    'rank' => $stats['rank'] ?? 0,
                    'rankPremium' => $stats['rankPremium'] ?? 0,
                    'rankWl' => $stats['rankWl'] ?? 0,
                ]
            );

            if (isset($item['aliases'])) {
                foreach ($item['aliases'] as $alias) {
                    Alias::updateOrCreate(
                        ['pornstar_id' => $pornstar->id, 'alias' => $alias]
                    );
                }
            }

            if (isset($item['thumbnails'])) {
                foreach ($item['thumbnails'] as $thumb) {
                    $thumbnail = Thumbnail::updateOrCreate(
                        ['pornstar_id' => $pornstar->id, 'type' => $thumb['type']],
                        [
                            'height' => $thumb['height'] ?? 0,
                            'width' => $thumb['width'] ?? 0,
                            'url' => $thumb['urls'][0] ?? '',
                        ]
                    );
                }
            }
        }

        $this->info('Pornstar data fetched and processed successfully.');
    }
}
