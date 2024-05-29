<?php

namespace App\Http\Controllers;

use App\Repositories\PornstarRepository;
use Illuminate\Support\Facades\Redis;

class PornstarController extends Controller
{
    protected $pornstarRepository;

    public function __construct(PornstarRepository $pornstarRepository)
    {
        $this->pornstarRepository = $pornstarRepository;
    }

    public function show($id)
    {
        $pornstar = $this->pornstarRepository->find($id);

        $imageKey = "pornstar_image:{$id}_tablet"; // or whatever type you need
        $compressedImage = Redis::get($imageKey);
        $image = $compressedImage ? gzuncompress($compressedImage) : '';

        return inertia('PornstarShow', [
            'pornstar' => $pornstar,
            'image' => base64_encode($image),
        ]);
    }

}
