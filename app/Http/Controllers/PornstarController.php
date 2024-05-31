<?php

namespace App\Http\Controllers;

use App\Interfaces\Repositories\PornstarRepositoryInterface;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class PornstarController extends Controller
{
    protected $pornstarRepository;

    public function __construct(PornstarRepositoryInterface $pornstarRepository)
    {
        $this->pornstarRepository = $pornstarRepository;
    }

    public function index()
    {
        return inertia('PornstarIndex');
    }

    public function search(Request $request) // todo validate
    {
        $query = $request->input('query');
        $pornstars = $this->pornstarRepository->searchByName($query);
        return response()->json($pornstars);
    }

    public function show($id)
    {
        $pornstar = $this->pornstarRepository->find($id);

        if (!$pornstar) {
            abort(404, 'Pornstar not found');
        }

        $imageKey = "pornstar_image:{$id}_pc"; // todo serve per client media request
        $compressedImage = Redis::get($imageKey);
        $image = $compressedImage ? gzuncompress($compressedImage) : '';

        return inertia('PornstarShow', [
            'pornstar' => $pornstar,
            'image' => $image ? base64_encode($image) : null,
        ]);
    }


}
