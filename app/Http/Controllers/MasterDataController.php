<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MasterDataController extends Controller
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.api.base_url');
    }

    public function showMasterData(Request $request)
    {
        $type = $request->query('type', 'growth');
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 10);

        $token = Cache::get('api_token');
        if (!$token) {
            return back()->with('error', 'API token not found.');
        }

        // Setup
        $meta = ['pageCount' => 1, 'currentPage' => 1, 'previousPage' => null, 'nextPage' => null];
        $growthCategories = $projectCategories = $storiesCategories = $trainingCategories = [];

        // Endpoints
        $endpoints = [
            'growth' => '/master/growthCategory',
            'project' => '/master/projectCategory',
            'stories' => '/master/storiesCategory',
            'training' => '/master/trainingCategory',
        ];

        foreach ($endpoints as $key => $endpoint) {
            if ($type === $key || $type === 'all') {
                $response = Http::withToken($token)->get("{$this->baseUrl}{$endpoint}", [
                    'page' => $page,
                    'limit' => $limit,
                ]);

                if ($response->ok()) {
                    $json = $response->json();
                    $data = $json['result']['data'] ?? [];
                    $paginationMeta = $json['result']['meta'] ?? $meta;

                    switch ($key) {
                        case 'growth':
                            $growthCategories = $data;
                            break;
                        case 'project':
                            $projectCategories = $data;
                            break;
                        case 'stories':
                            $storiesCategories = $data;
                            break;
                        case 'training':
                            $trainingCategories = $data;
                            break;
                    }

                    if ($type === $key) {
                        $meta = $paginationMeta;
                    }
                }
            }
        }

        return view('master', [
            'type' => $type,
            'limit' => $limit,
            'categories' => $growthCategories,
            'projectCategories' => $projectCategories,
            'storiesCategories' => $storiesCategories,
            'trainingCategories' => $trainingCategories,
            'meta' => $meta,
        ]);
    }
}
