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

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->get('http://che.inheritinitiative.org/api/v1/auth/userList', [
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

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->get("http://che.inheritinitiative.org/api/v1/auth/user/{$id}");

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

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->get('http://che.inheritinitiative.org/api/v1/auth/requestList', [
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
}
