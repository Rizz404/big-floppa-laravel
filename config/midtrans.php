<?php

return [
  'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
  'client_key' => env('MIDTRANS_CLIENT_KEY'),
  'server_key' => env('MIDTRANS_SERVER_KEY'),

  'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
  'is_3ds' => env('MIDTRANS_IS_3DS', true),
  'is_sanitize' => env('MIDTRANS_IS_SANITIZE', true),
];
