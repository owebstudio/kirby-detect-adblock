<?php

/**
 * @var \Kirby\Cms\App $kirby
 * @var string $title Title of the warning
 * @var string $text Text of the warning
 * @var string $button Text of the reload button
 */

$kirby ??= kirby();
?>
<style nonce="<?= esc($kirby->nonce(), 'attr') ?>">
    .detect-adblock {
        box-sizing: border-box;
        max-width: calc(100% - 2rem);
        padding: 3rem;
        border: none;
        border-radius: .25rem;
        color: black;
        background: white;
        text-align: center;
    }

    .detect-adblock::backdrop {
        background-color: rgba(0, 0, 0, 0.75);
    }

    .detect-adblock h2 {
        margin: 0 0 1rem;
        font-size: 2em;
    }

    .detect-adblock p {
        margin: 0;
    }

    .detect-adblock button {
        margin-top: 1rem;
        background-color: #333;
        border: none;
        color: white;
        padding: .5rem 1rem;
        font: inherit;
        text-align: center;
        text-decoration: none;
        border-radius: .25rem;
        cursor: pointer;
    }
</style>

<dialog class="detect-adblock" aria-labelledby="detect-adblock-title" aria-describedby="detect-adblock-text" data-detect-adblock>
    <h2 id="detect-adblock-title"><?= esc($title) ?></h2>
    <p id="detect-adblock-text"><?= esc($text) ?></p>
    <button type="button" data-detect-adblock-reload><?= esc($button) ?></button>
</dialog>
