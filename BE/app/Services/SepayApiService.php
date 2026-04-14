<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class SepayApiService
{
    public function listTransactions(array $query = []): array
    {
        $response = Http::acceptJson()
            ->withToken(config('services.sepay.token'))
            ->timeout(15)
            ->get(config('services.sepay.base_url') . '/transactions/list', $query);

        if ($response->status() === 429) {
            $retryAfter = $response->header('x-sepay-userapi-retry-after', 1);
            throw new RuntimeException("SePay rate limit. Retry after {$retryAfter}s");
        }

        $response->throw();

        return $response->json();
    }

    public function getTransactionDetails(string $transactionId): array
    {
        $response = Http::acceptJson()
            ->withToken(config('services.sepay.token'))
            ->timeout(15)
            ->get(config('services.sepay.base_url') . '/transactions/details/' . $transactionId);

        if ($response->status() === 429) {
            $retryAfter = $response->header('x-sepay-userapi-retry-after', 1);
            throw new RuntimeException("SePay rate limit. Retry after {$retryAfter}s");
        }

        $response->throw();

        return $response->json();
    }
}