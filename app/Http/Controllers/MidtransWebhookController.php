<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        $signatureKey = $payload['signature_key'];
        $orderId = $payload['order_id'];
        $statusCode = $payload['status_code'];
        $grossAmount = $payload['gross_amount'];
        $serverKey = config('midtrans.server_key');

        // * 1. Verifikasi Signature Key
        $mySignatureKey = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        if ($signatureKey !== $mySignatureKey) {
            Log::warning('Midtrans webhook signature mismatch.', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // * 2. Cari Order dan Payment
        $order = Order::find($orderId);
        if (!$order) {
            Log::warning('Midtrans webhook: Order not found.', ['order_id' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        $payment = $order->payment;
        if (!$payment) {
            Log::warning('Midtrans webhook: Payment record not found for order.', ['order_id' => $orderId]);
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // * 3. Update Status Berdasarkan Notifikasi
        try {
            DB::transaction(function () use ($payload, $order, $payment) {
                $transactionStatus = $payload['transaction_status'];
                $fraudStatus = $payload['fraud_status'] ?? null;

                $payment->status = $transactionStatus;
                $payment->external_transaction_id = $payload['transaction_id'];

                if ($transactionStatus == 'settlement') {
                    // * Pembayaran berhasil dan dana sudah masuk
                    $order->status = 'paid';
                    $payment->paid_at = now();
                } elseif ($transactionStatus == 'capture' && $fraudStatus == 'accept') {
                    // * Untuk kartu kredit, status capture + accept = berhasil
                    $order->status = 'paid';
                    $payment->paid_at = now();
                } elseif ($transactionStatus == 'pending') {
                    // * Pembayaran masih menunggu
                    $order->status = 'pending_payment';
                } elseif ($transactionStatus == 'deny' || $transactionStatus == 'cancel' || $transactionStatus == 'expire') {
                    // * Pembayaran gagal atau dibatalkan
                    $order->status = 'cancelled';
                }

                $order->save();
                $payment->save();
            });
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing Midtrans webhook.', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            return response()->json(['message' => 'Error processing webhook'], 500);
        }

        return response()->json(['message' => 'Webhook processed successfully']);
    }
}
