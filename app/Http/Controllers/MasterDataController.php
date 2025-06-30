<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MasterDataController extends Controller
{
    public function showMasterData(Request $request)
    {
        $type = $request->query('type', 'growth'); // default to growth
        $token = Cache::get('api_token');

        if (!$token) {
            return back()->with('error', 'API token not found.');
        }

        $growthCategories = [];
        $projectCategories = [];
        $storiesCategories = [];
        $trainingCategories = [];

        // Fetch Growth Categories
        if ($type === 'growth' || $type === 'all') {
            $growthResponse = Http::withToken($token)
                ->get('https://che.inheritinitiative.org/api/v1/master/getAll/growthCategory');

            if ($growthResponse->ok()) {
                $growthCategories = $growthResponse->json('result') ?? [];
            }
        }

        // Fetch Project Categories
        if ($type === 'project' || $type === 'all') {
            $projectResponse = Http::withToken($token)
                ->get('https://che.inheritinitiative.org/api/v1/master/getAll/projectCategory');

            if ($projectResponse->ok()) {
                $projectCategories = $projectResponse->json('result') ?? [];
            }
        }

        // Fetch Stories Categories
        if ($type === 'stories' || $type === 'all') {
            $storiesResponse = Http::withToken($token)
                ->get('https://che.inheritinitiative.org/api/v1/master/getAll/storiesCategory'); 

            if ($storiesResponse->ok()) {
                $storiesCategories = $storiesResponse->json('result') ?? [];
            }
        }

        // Fetch Training Categories
        if ($type === 'training' || $type === 'all') {
            $trainingResponse = Http::withToken($token)
                ->get('https://che.inheritinitiative.org/api/v1/master/getAll/trainingCategory');

            if ($trainingResponse->ok()) {
                $trainingCategories = $trainingResponse->json('result') ?? [];
            }
        }

        return view('master', [
            'type' => $type,
            'categories' => $growthCategories,
            'projectCategories' => $projectCategories,
            'storiesCategories' => $storiesCategories,
            'trainingCategories'=>$trainingCategories
        ]);
    }
}
