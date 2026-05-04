<?php

return [
    'label' => 'Turn off',
    'modal' => [
        'heading' => 'Disable passkey verification',
        'description' => 'Are you sure you want to remove all of your registered passkeys? Disabling this will remove an extra layer of security from your account.',
        'actions' => [
            'submit' => [
                'label' => 'Disable passkey verification',
            ],
        ],
    ],
    'notifications' => [
        'disabled' => [
            'title' => 'Passkey verification has been disabled',
        ],
    ],
];
