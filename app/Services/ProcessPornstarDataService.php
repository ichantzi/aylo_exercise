<?php

namespace App\Services;

use App\Interfaces\Repositories\PornstarRepositoryInterface;
use App\Interfaces\Repositories\PornstarStatsRepositoryInterface;
use App\Interfaces\Repositories\AliasRepositoryInterface;
use App\Interfaces\Repositories\ThumbnailRepositoryInterface;
use Illuminate\Support\Facades\Log;

class ProcessPornstarDataService
{
    protected $pornstarRepo;
    protected $pornstarStatsRepo;
    protected $aliasRepo;
    protected $thumbnailRepo;

    public function __construct(
        PornstarRepositoryInterface $pornstarRepo,
        PornstarStatsRepositoryInterface $pornstarStatsRepo,
        AliasRepositoryInterface $aliasRepo,
        ThumbnailRepositoryInterface $thumbnailRepo
    ) {
        $this->pornstarRepo = $pornstarRepo;
        $this->pornstarStatsRepo = $pornstarStatsRepo;
        $this->aliasRepo = $aliasRepo;
        $this->thumbnailRepo = $thumbnailRepo;
    }

    public function process($data)
    {
        $this->insertPornstars($data);

        $idMap = $this->fetchPornstarIds();

        $this->populateRelatedTables($data, $idMap);
    }

    private function insertPornstars($data)
    {
        $pornstars = [];
        $items = $data['items'];
        foreach ($items as $item) {
            if (!isset($item['id'], $item['name'], $item['attributes'])) {
                continue;
            }

            $attributes = $item['attributes'];

            $pornstars[] = [
                'pornhub_id' => $item['id'],
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
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $this->processInBatches($pornstars, 'pornstarRepo');
    }

    private function fetchPornstarIds()
    {
        return $this->pornstarRepo->getPornstarIdMapping();
    }

    private function populateRelatedTables($data, $idMap)
    {
        $pornstarStats = [];
        $aliases = [];
        $thumbnails = [];

        $items = $data['items'];
        foreach ($items as $item) {
            if (!isset($item['id'], $idMap[$item['id']], $item['attributes'])) {
                continue;
            }

            $pornstarId = $idMap[$item['id']];
            $attributes = $item['attributes'];
            $stats = $attributes['stats'] ?? [];

            $pornstarStats[] = [
                'pornstar_id' => $pornstarId,
                'subscriptions' => $stats['subscriptions'] ?? 0,
                'monthlySearches' => $stats['monthlySearches'] ?? 0,
                'views' => $stats['views'] ?? 0,
                'videosCount' => $stats['videosCount'] ?? 0,
                'premiumVideosCount' => $stats['premiumVideosCount'] ?? 0,
                'whiteLabelVideoCount' => $stats['whiteLabelVideoCount'] ?? 0,
                'rank' => $stats['rank'] ?? 0,
                'rankPremium' => $stats['rankPremium'] ?? 0,
                'rankWl' => $stats['rankWl'] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (isset($item['aliases'])) {
                foreach ($item['aliases'] as $alias) {
                    $aliases[] = [
                        'pornstar_id' => $pornstarId,
                        'alias' => $alias,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (isset($item['thumbnails'])) {
                foreach ($item['thumbnails'] as $thumb) {
                    foreach ($thumb['urls'] as $url) {
                        $thumbnails[] = [
                            'pornstar_id' => $pornstarId,
                            'type' => $thumb['type'],
                            'height' => $thumb['height'] ?? 0,
                            'width' => $thumb['width'] ?? 0,
                            'url' => $url,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }
        }

        $this->processInBatches($pornstarStats, 'pornstarStatsRepo');
        $this->processInBatches($aliases, 'aliasRepo');
        $this->processInBatches($thumbnails, 'thumbnailRepo');
    }

    private function processInBatches(array $data, $repositoryName, $batchSize = 40000)
    {
        $repository = $this->$repositoryName;
        $chunks = array_chunk($data, $batchSize);

        foreach ($chunks as $chunk) {
            try {
                $repository->upsert($chunk);
            } catch (\Exception $e) {
                Log::error("Error processing batch in {$repositoryName}: " . $e->getMessage());
            }
        }
    }
}
