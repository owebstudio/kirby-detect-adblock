<?php

use Kirby\Cms\App as Kirby;

Kirby::plugin('clicktonext/detect-adblock', [
    'options' => [
        'title' => 'AdBlock detected!',
        'text' => 'Please disable AdBlock and refresh to see requested page.',
        'button' => 'Refresh the page',
    ],
    'snippets' => [
        'detect-adblock' => __DIR__ . '/snippets/detect-adblock.php',
        'detect-adblock-overlay' => __DIR__ . '/snippets/detect-adblock-overlay.php',
    ]
]);
