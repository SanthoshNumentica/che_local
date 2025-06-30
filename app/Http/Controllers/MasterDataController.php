<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MasterDataController extends Controller
{
    public function showMasterData()
{
    $token = Cache::get('api_token');

    if (!$token) {
        return back()->with('error', 'API token not found.');
    }

    $response = Http::withToken($token)
        ->get('https://che.inheritinitiative.org/api/v1/master/getAll/growthCategory');

    if ($response->failed()) {
        return back()->with('error', 'Failed to fetch growth categories.');
    }

    $growthCategories = $response->json('result') ?? [];

    return view('master', ['categories' => $growthCategories]);
}

}
