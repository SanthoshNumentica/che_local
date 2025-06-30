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
        $pagination['perPage'] = $limit;

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
        $pagination['perPage'] = $limit;

        $debugInfo = [
            'token' => $token,
            'status' => $response->status(),
            'page' => $page,
            'limit' => $limit,
        ];
        if ($request->ajax()) {
            return view('admin.partials.request-table', compact('requests', 'pagination'));
        }

        return view('admin.users-request', compact('requests', 'pagination', 'debugInfo'));
    }
    public function create(Request $request)
    {
        $token = Cache::get('api_token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        return view('admin.user-add');
    }
    public function save(Request $request)
    {
        $token = Cache::get('api_token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }
        $baseUrl = config('services.api.base_url');

        $payload = [
            'firstName'        => $request->input('first_name'),
            'lastName'         => $request->input('last_name'),
            'mobileNo'         => $request->input('mobile_no'),
            'emailId'          => $request->input('email'),
            'password'         => $request->input('password'),
            'address'          => $request->input('address'),
            'remarks'          => $request->input('remarks'),
            'admin0'           => $request->input('state'),
            'admin1'           => $request->input('country'),
            'isWhatsapp'       => $request->has('is_whatsapp'),
            'isSignal'         => $request->has('is_onesignal'),
            'referrerName'     => $request->input('referrer_name'),
            'referrerEmail'    => $request->input('referrer_email'),
            'referrerMobileNo' => $request->input('referrer_mobile_no'),
        ];

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post("{$baseUrl}/auth/createAccount", $payload);
        if ($response->failed()) {
            Log::error('User save failed', ['payload' => $payload, 'response' => $response->body(),]);

            $errorMessage = 'User save failed.';

            // Try to extract specific API error message
            $errorData = $response->json();
            if (isset($errorData['message'])) {
                $errorMessage = $errorData['message'];
            } elseif (isset($errorData['error'])) {
                $errorMessage = $errorData['error'];
            }

            return redirect()->route('admin.users.requests')->with('error', $errorMessage);
        }

        return redirect()->route('admin.users.requests')->with('success', 'User Created Successfully.');
    }
    public function approveUser(Request $request, $id)
    {
        $token = Cache::get('api_token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }
        $baseUrl = config('services.api.base_url');
        $status = $request->input('status');

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->patch("{$baseUrl}/auth/updateUserRequest/{$id}", [
            'status' => $status,
        ]);
        if ($response->failed()) {
            Log::error('User approval failed', ['response' => $response->body()]);
            $errorData = $response->json();
            if (isset($errorData['message'])) {
                $errorMessage = $errorData['message'];
            } elseif (isset($errorData['error'])) {
                $errorMessage = $errorData['error'];
            }
            return redirect()->route('admin.users.requests')->with('error', $errorMessage);
        }

        // Determine the success message based on status
        $message = $status === 'APPROVED' ? 'User Approved successfully' : ($status === 'REJECTED' ? 'User Rejected successfully' : 'User Status updated');
        // Choose redirect route based on status
        $redirectRoute = $status === 'APPROVED' ? 'admin.users' : 'admin.users.requests';

        return redirect()->route($redirectRoute)->with('success', $message);
    }
}
