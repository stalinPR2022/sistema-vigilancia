<?php

return [
    'smtp_destinatario' => env(
        'NOTIFICACION_SMTP_DESTINATARIO',
        'operador@example.com'
    ),

    'telegram_token' => env('TELEGRAM_BOT_TOKEN'),

    'telegram_chat_id' => env('TELEGRAM_CHAT_ID'),

    'telegram_timeout' => (int) env(
        'TELEGRAM_TIMEOUT',
        5
    ),
];
