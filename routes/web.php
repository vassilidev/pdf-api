<?php

Route::get('test', function () {
    $url = "https://manu.qwile.com/wp-content/uploads/sites/7/2024/03/Asset-2@4x-8.png";

    $options = [
        'ssl' => [
            'verify_peer'      => false,
            'verify_peer_name' => false,
        ],
    ];

    $context = stream_context_create($options);

    dump(file_get_contents($url, false, $context));
});