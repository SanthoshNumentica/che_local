<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Laravel\Pail\ValueObjects\Origin\Console;

class CustomLogin extends Component
{
    public $userName;
    public $password;
    public $error;
    public $apiResult;

    public function login()
    {
        \Log::info('Login method triggered');
        logger('Login called with:', ['username' => $this->userName]);

        $baseUrl = config('services.api.base_url');


        $response = Http::post("{$baseUrl}/auth/login", [
            'userName' => $this->userName,
            'password' => $this->password,
        ]);
        
        if ($response->successful()) {
            $this->apiResult = $response->json();

            $token = $this->apiResult['result']['token'] ?? null;


            if ($token) {
                session(['api_token' => $token]);

                // Cache user data for 60 minutes
                Cache::put('api_token', $token, now()->addMinutes(960)); // 12 hours
                Cache::put('logged_in_user', $this->apiResult['result'], now()->addMinutes(960)); // 12 hours
                return redirect()->route('admin.home');
            } else {
                $this->error = 'Login succeeded, but token is missing.';
            }
        } else {
            $message = $response->json('message');
            $this->error = 'Login failed: ' . (is_array($message) ? implode(', ', $message) : ($message ?? 'Unknown error.'));
        }
    }

    public function render()
    {
        return view('livewire.custom-login')->layout('layouts.login');
    }
}
