<?php

return [
    'label' => 'Sozlash',
    'modal' => [
        'heading' => 'Passkey tasdiqlashni sozlash',
        'description' => 'Ushbu qurilmada passkey roʻyxatdan oʻtkazing. Sizdan barmoq izi, yuz, ekran qulfi yoki xavfsizlik kalitidan foydalanish soʻraladi. Roʻyxatdan oʻtgandan soʻng ushbu passkey bilan tizimga kira olasiz.',
        'form' => [
            'name' => [
                'label' => 'Passkey nomi',
                'placeholder' => 'masalan, MacBook Touch ID, YubiKey 5C',
            ],
            'submit' => [
                'label' => 'Passkeyʼni roʻyxatdan oʻtkazish',
                'loading_label' => 'Qurilma kutilmoqda...',
            ],
            'errors' => [
                'failed' => 'Passkeyʼingizni roʻyxatdan oʻtkazib boʻlmadi. Qaytadan urinib koʻring.',
            ],
        ],
        'actions' => [
            'cancel' => [
                'label' => 'Yopish',
            ],
        ],
    ],
    'notifications' => [
        'enabled' => [
            'title' => 'Passkey muvaffaqiyatli roʻyxatdan oʻtkazildi',
        ],
    ],
];
