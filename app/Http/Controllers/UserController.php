<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function showUsers(Request $request)
    {
        $token = Cache::get('api_token');
        Log::info('Token fetched:', ['token' => $token]);

        if (!$token) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $baseUrl = config('services.api.base_url');

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->get("{$baseUrl}/auth/userList", [
            'page' => $page,
            'limit' => $limit,
        ]);

        Log::info('API response status:', ['status' => $response->status()]);

        if ($response->unauthorized()) {
            return redirect()->route('login')->with('error', 'Unauthorized. Please login again.');
        }

        if ($response->failed()) {
            return back()->with('error', 'Could not fetch users. Please try again later.');
        }

        $users = $response->json('result.data') ?? [];
        $pagination = $response->json('result.meta') ?? [];

        $debugInfo = [
            'token' => $token,
            'status' => $response->status(),
            'page' => $page,
            'limit' => $limit,
        ];

        if (!is_array($users)) {
            Log::warning('Unexpected structure for $users:', ['users' => $users]);
            $users = [];
        }

        return view('admin.users', compact('users', 'pagination', 'debugInfo'));
    }

    public function viewUser($id)
    {
        $token = Cache::get('api_token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }
        $baseUrl = config('services.api.base_url');

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->get("{$baseUrl}/auth/user/{$id}");

        if ($response->failed()) {
            return back()->with('error', 'Could not fetch user details.');
        }

        $user = $response->json('result') ?? [];

        return view('admin.user-view', compact('user'));
    }

    public function showUserRequests(Request $request)
    {
        $token = Cache::get('api_token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $baseUrl = config('services.api.base_url');

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->get("{$baseUrl}/auth/requestList", [
            'page' => $page,
            'limit' => $limit,
        ]);

        if ($response->failed()) {
            return back()->with('error', 'Could not fetch user requests.');
        }

        $requests = $response->json('result.data') ?? [];
        $pagination = $response->json('result.meta') ?? [];

        $debugInfo = [
            'token' => $token,
            'status' => $response->status(),
            'page' => $page,
            'limit' => $limit,
        ];

        return view('admin.users-request', compact('requests', 'pagination', 'debugInfo'));
    }
    public function approveUser($id)
    {
        $token = Cache::get('api_token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }
        $baseUrl = config('services.api.base_url');

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->patch("{$baseUrl}/auth/updateUserRequest/{$id}", [
            'status' => 'APPROVED',
        ]);
        if ($response->failed()) {
            Log::error('User approval failed', ['response' => $response->body()]);
            return back()->with('error', 'User approval failed.');
        }

        return redirect()->route('users.requests')->with('success', 'User approved successfully.');
    }

    public function getUserData(Request $request)
{
    $token = Cache::get('api_token');

    if (!$token) {
        return response()->json([
            'error' => 'Session expired. Please login again.'
        ], 401);
    }

    $page = $request->input('page', 1);
    $limit = $request->input('limit', 10);
    $baseUrl = 'https://che.inheritinitiative.org/api/v1'; // Direct external API as per your request

    $response = Http::withHeaders([
        'Authorization' => "Bearer {$token}",
        'Accept' => 'application/json',
    ])->get("{$baseUrl}/auth/userList", [
        'page' => $page,
        'limit' => $limit,
    ]);

    if ($response->unauthorized()) {
        return response()->json([
            'error' => 'Unauthorized. Please login again.'
        ], 401);
    }

    if ($response->failed()) {
        return response()->json([
            'error' => 'Failed to fetch user data.'
        ], $response->status());
    }

    return response()->json($response->json());
}

}
