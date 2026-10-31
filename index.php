<?php

use Kirby\Cms\App as Kirby;

Kirby::plugin('owebstudio/detect-adblock', [
    'options' => [
        'title' => null,
        'text' => null,
        'button' => null,
    ],
    'snippets' => [
        'detect-adblock' => __DIR__ . '/snippets/detect-adblock.php',
        'detect-adblock-overlay' => __DIR__ . '/snippets/detect-adblock-overlay.php',
    ],
    'translations' => [
        'de' => require __DIR__ . '/translations/de.php',
        'en' => require __DIR__ . '/translations/en.php',
        'tr' => require __DIR__ . '/translations/tr.php',
    ]
]);
