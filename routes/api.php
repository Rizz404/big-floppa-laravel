<?php

use App\Http\Controllers\MidtransWebhookController;
use Illuminate\Support\Facades\Route;

Route::prefix('webhooks')->name('webhooks.')->group(function () {
  Route::post('/midtrans', [MidtransWebhookController::class, 'handle']);
});
