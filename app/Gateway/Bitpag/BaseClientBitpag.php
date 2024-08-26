<?php

namespace App\Gateway\Bitpag;

use Illuminate\Support\Facades\Http;

class BaseClientBitpag 
{
    private string $bearerToken;

    public array $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    private array $baseAuth;

    public function __construct()
    {
        $this->login();
    }

    public function login(): array
    {
        try {
            $this->baseAuth = $this->getBaseAuth();

            $response = Http::withHeaders($this->headers)->post(
                $this->baseAuth['baseUrl'] . '/login', [
                'email' => $this->baseAuth['user'],
                'password' => $this->baseAuth['password']
            ]);
            
            if (! empty($response->json()['errors'])) {
                throw new \Exception($response->json()['message'], $response->status());
            }
            
            $this->setBearerToken($response['token']);

            return [
                'status' => $response->status(),
                'data' => $response->json(),
            ];
        } catch (\Exception $e) {
            return [
                'status' => $e->getCode(),
                'data' => $e->getMessage(),
            ];
        }
    }

    public function getToken(): string {
        return $this->bearerToken;
    }

    public function getBaseAuth(): array
    {
        return config('app')['bitpag'];
    }

    private function setBearerToken(string $token): void
    {
        $this->bearerToken = $token;
    }

    public function getHeaders(): array
    {
        return array_merge($this->headers, ['Authorization' => $this->getToken()]);
    }
}