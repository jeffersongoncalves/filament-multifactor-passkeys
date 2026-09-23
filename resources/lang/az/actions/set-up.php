<?php

return [
    'label' => 'Quraşdır',
    'modal' => [
        'heading' => 'Passkey təsdiqini quraşdırın',
        'description' => 'Bu cihazda passkey qeydiyyatdan keçirin. Barmaq izi, üz, ekran kilidi və ya təhlükəsizlik açarından istifadə etməyiniz istəniləcək. Qeydiyyatdan sonra bu passkey ilə daxil ola biləcəksiniz.',
        'form' => [
            'name' => [
                'label' => 'Passkey adı',
                'placeholder' => 'məs. MacBook Touch ID, YubiKey 5C',
            ],
            'submit' => [
                'label' => 'Passkey qeydiyyatdan keçir',
                'loading_label' => 'Cihaz gözlənilir...',
            ],
            'errors' => [
                'failed' => 'Passkey-inizi qeydiyyatdan keçirə bilmədik. Yenidən cəhd edin.',
            ],
        ],
        'actions' => [
            'cancel' => [
                'label' => 'Bağla',
            ],
        ],
    ],
    'notifications' => [
        'enabled' => [
            'title' => 'Passkey uğurla qeydiyyatdan keçdi',
        ],
    ],
];
