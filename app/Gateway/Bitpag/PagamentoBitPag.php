<?php

namespace App\Gateway\Bitpag;

use App\Services\NotificacaoExceptionBitPagService;
use Illuminate\Support\Facades\Http;

class PagamentoBitPag extends BaseClientBitpag
{
    public function consultarPagamentos(?int $page = 1, ?string $search = ''): array
    {
        try {
            $response = Http::withHeaders($this->getHeaders())->get(
                $this->getBaseAuth()['baseUrl'] . '/payment', [
                'page' => $page,
                'search' => $search,
            ]);
            
            if (! empty($response->json()['errors'])) {
                throw new \Exception($response->json()['message'], $response->status());
            }

            return $response->json();
        } catch (\Exception $e) {
            new NotificacaoExceptionBitPagService($e->getMessage());
            
            return [
                'status' => $e->getCode(),
                'data' => $e->getMessage(),
            ];
        }
    }
}