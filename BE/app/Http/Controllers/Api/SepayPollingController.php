<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Goi;
use App\Services\SepayApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class SepayPollingController extends Controller
{
    public function createOrder(Request $request)
    {
        try {
            $request->validate([
                'id_goi' => ['nullable', 'exists:gois,id'],
                'amount' => ['required_without:id_goi', 'numeric', 'min:1000'],
                'customer_name' => ['nullable', 'string', 'max:255'],
                'customer_email' => ['nullable', 'email', 'max:255'],
            ]);

            $id_goi = $request->input('id_goi');
            $amount = (int) $request->input('amount');

            if ($id_goi) {
                $goi = Goi::find($id_goi);
                $amount = (int) $goi->gia_goi;
            }

            $orderCode = 'SE' . now()->format('YmdHis') . rand(1000, 9999);

            $order = Order::create([
                'id_goi' => $id_goi,
                'order_code' => $orderCode,
                'amount' => $amount,
                'status' => 'pending',
                'customer_name' => $request->input('customer_name'),
                'customer_email' => $request->input('customer_email'),
            ]);

            $qrUrl = 'https://qr.sepay.vn/img?' . http_build_query([
                'acc' => config('services.sepay.bank_account'),
                'bank' => config('services.sepay.bank_name'),
                'amount' => $order->amount,
                'des' => $order->order_code,
            ]);

            return response()->json([
                'success' => true,
                'order_code' => $order->order_code,
                'amount' => $order->amount,
                'status' => $order->status,
                'bank_account' => config('services.sepay.bank_account'),
                'bank_name' => config('services.sepay.bank_name'),
                'transfer_content' => $order->order_code,
                'qr_url' => $qrUrl,
            ]);
        } catch (\Exception $e) {
            \Log::error("Payment Creation Error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkStatus(string $orderCode, SepayApiService $sepayApi)
    {
        $order = Order::where('order_code', $orderCode)->firstOrFail();

        if ($order->status === 'paid') {
            return response()->json([
                'success' => true,
                'order_code' => $order->order_code,
                'status' => $order->status,
                'paid_at' => optional($order->paid_at)->toDateTimeString(),
            ]);
        }

        $transaction = $this->findMatchingTransaction($order, $sepayApi);

        if ($transaction) {
            $order->update([
                'status' => 'paid',
                'sepay_transaction_id' => (string)($transaction['id'] ?? ''),
                'sepay_reference_number' => $transaction['reference_number'] ?? null,
                'paid_at' => now(),
                'payment_meta' => $transaction,
            ]);
        }

        $order->refresh();

        return response()->json([
            'success' => true,
            'order_code' => $order->order_code,
            'status' => $order->status,
            'paid_at' => optional($order->paid_at)->toDateTimeString(),
        ]);
    }

    private function findMatchingTransaction(Order $order, SepayApiService $sepayApi): ?array
    {
        // Chỉ quét giao dịch từ lúc tạo đơn tới hiện tại, nới thêm 5 phút trước đó cho an toàn
        $query = [
            'amount_in' => $order->amount,
            'transaction_date_min' => Carbon::parse($order->created_at)->subMinutes(5)->format('Y-m-d H:i:s'),
            'transaction_date_max' => now()->format('Y-m-d H:i:s'),
            'limit' => 100,
        ];

        $data = $sepayApi->listTransactions($query);
        $transactions = $data['transactions'] ?? [];

        foreach ($transactions as $tx) {
            $amountIn = (int) round((float) ($tx['amount_in'] ?? 0));
            $code = (string) ($tx['code'] ?? '');
            $content = (string) ($tx['transaction_content'] ?? '');

            $matchedCode = $code === $order->order_code || str_contains($content, $order->order_code);
            $matchedAmount = $amountIn === (int) $order->amount;

            if ($matchedCode && $matchedAmount) {
                return $tx;
            }
        }

        return null;
    }
}