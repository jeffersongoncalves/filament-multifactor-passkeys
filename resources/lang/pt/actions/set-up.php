<?php

return [
    'label' => 'Configurar',
    'modal' => [
        'heading' => 'Configurar verificação por chave de acesso',
        'description' => 'Registe uma chave de acesso neste dispositivo. Ser-lhe-á pedido que use a impressão digital, o rosto, o bloqueio de ecrã ou uma chave de segurança. Após o registo, poderá iniciar sessão com esta chave de acesso.',
        'form' => [
            'name' => [
                'label' => 'Nome da chave de acesso',
                'placeholder' => 'por ex. MacBook Touch ID, YubiKey 5C',
            ],
            'submit' => [
                'label' => 'Registar chave de acesso',
                'loading_label' => 'A aguardar o dispositivo...',
            ],
            'errors' => [
                'failed' => 'Não foi possível registar a sua chave de acesso. Tente novamente.',
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
            'title' => 'Chave de acesso registada com sucesso',
        ],
    ],
];
