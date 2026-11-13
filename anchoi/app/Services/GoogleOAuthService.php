<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Exception;

class GoogleOAuthService
{
    private $clientId;
    private $clientSecret;
    private $redirectUri;
    private $scopes;

    public function __construct()
    {
        $this->clientId = config('services.google.client_id');
        $this->clientSecret = config('services.google.client_secret');
        $this->redirectUri = config('services.google.redirect_uri');
        $this->scopes = [
            'https://www.googleapis.com/auth/places',
            'https://www.googleapis.com/auth/places.readonly'
        ];
    }

    /**
     * Tạo URL để authorization
     */
    public function getAuthorizationUrl()
    {
        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'scope' => implode(' ', $this->scopes),
            'response_type' => 'code',
            'access_type' => 'offline',
            'prompt' => 'consent'
        ];

        return 'https://accounts.google.com/o/oauth2/auth?' . http_build_query($params);
    }

    /**
     * Đổi authorization code thành access token
     */
    public function exchangeCodeForToken($code)
    {
        $response = Http::post('https://oauth2.googleapis.com/token', [
            'code' => $code,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'grant_type' => 'authorization_code'
        ]);

        if (!$response->successful()) {
            throw new Exception('Failed to exchange code for token: ' . $response->body());
        }

        $data = $response->json();
        
        // Lưu tokens vào cache/database
        $this->storeTokens($data);
        
        return $data;
    }

    /**
     * Refresh access token bằng refresh token
     */
    public function refreshAccessToken()
    {
        $refreshToken = $this->getStoredRefreshToken();
        
        if (!$refreshToken) {
            throw new Exception('No refresh token available');
        }

        $response = Http::post('https://oauth2.googleapis.com/token', [
            'refresh_token' => $refreshToken,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'refresh_token'
        ]);

        if (!$response->successful()) {
            throw new Exception('Failed to refresh token: ' . $response->body());
        }

        $data = $response->json();
        
        // Cập nhật access token mới
        $this->updateAccessToken($data['access_token'], $data['expires_in'] ?? 3600);
        
        return $data['access_token'];
    }

    /**
     * Lấy access token hiện tại (tự động refresh nếu cần)
     */
    public function getValidAccessToken()
    {
        $accessToken = Cache::get('google_access_token');
        
        if (!$accessToken) {
            // Thử refresh token
            return $this->refreshAccessToken();
        }
        
        return $accessToken;
    }

    /**
     * Lưu tokens vào cache
     */
    private function storeTokens($tokenData)
    {
        $expiresIn = $tokenData['expires_in'] ?? 3600;
        
        // Lưu access token với thời gian hết hạn
        Cache::put('google_access_token', $tokenData['access_token'], now()->addSeconds($expiresIn - 60));
        
        // Lưu refresh token (không hết hạn)
        if (isset($tokenData['refresh_token'])) {
            Cache::forever('google_refresh_token', $tokenData['refresh_token']);
        }
    }

    /**
     * Cập nhật access token mới
     */
    private function updateAccessToken($accessToken, $expiresIn)
    {
        Cache::put('google_access_token', $accessToken, now()->addSeconds($expiresIn - 60));
    }

    /**
     * Lấy refresh token đã lưu
     */
    private function getStoredRefreshToken()
    {
        return Cache::get('google_refresh_token');
    }

    /**
     * Kiểm tra xem đã có tokens chưa
     */
    public function hasValidTokens()
    {
        return Cache::has('google_access_token') || Cache::has('google_refresh_token');
    }

    /**
     * Xóa tất cả tokens (logout)
     */
    public function clearTokens()
    {
        Cache::forget('google_access_token');
        Cache::forget('google_refresh_token');
    }

    /**
     * Gọi Google API với access token
     */
    public function makeApiRequest($method, $url, $data = null, $additionalHeaders = [])
    {
        $accessToken = $this->getValidAccessToken();
        
        $headers = array_merge([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json'
        ], $additionalHeaders);
        
        $request = Http::withHeaders($headers);

        if ($method === 'GET') {
            return $request->get($url);
        } elseif ($method === 'POST') {
            return $request->post($url, $data);
        }

        throw new Exception("Unsupported HTTP method: {$method}");
    }
} 