<?php

use Kirby\Cms\App as Kirby;

Kirby::plugin('clicktonext/detect-ad-block', [
    'options' => [
        'title' => 'Ad block detected!',
        'text' => 'Please disable AdBlock and refresh to see requested page.',
        'button' => 'Refresh the page',
    ],
    'snippets' => [
        'detect-ad-block' => __DIR__ . '/snippets/detect-ad-block.php',
        'detect-ad-block-overlay' => __DIR__ . '/snippets/detect-ad-block-overlay.php',
    ]
]);
