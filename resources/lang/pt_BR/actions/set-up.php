<?php

return [
    'label' => 'Configurar',
    'modal' => [
        'heading' => 'Configurar verificação por passkey',
        'description' => 'Registre uma passkey neste dispositivo. Você será solicitado a usar sua digital, rosto, bloqueio de tela ou uma chave de segurança. Após o registro, você poderá entrar usando essa passkey.',
        'form' => [
            'name' => [
                'label' => 'Nome da passkey',
                'placeholder' => 'ex.: MacBook Touch ID, YubiKey 5C',
            ],
            'submit' => [
                'label' => 'Registrar passkey',
                'loading_label' => 'Aguardando dispositivo...',
            ],
            'errors' => [
                'failed' => 'Não foi possível registrar sua passkey. Tente novamente.',
            ],
        ],
        'actions' => [
            'cancel' => [
                'label' => 'Fechar',
            ],
        ],
    ],
    'notifications' => [
        'enabled' => [
            'title' => 'Passkey registrada com sucesso',
        ],
    ],
];
