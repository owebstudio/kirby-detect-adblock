<?php

/**
 * @var \Kirby\Cms\App $kirby
 * @var string $mode `overlay` or `banner`
 * @var string $title Title of the warning
 * @var string $text Text of the warning
 * @var string $button Text of the reload button
 * @var string $close Label of the close button
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

    .detect-adblock-banner {
        position: fixed;
        right: 1rem;
        bottom: 1rem;
        left: 1rem;
        z-index: 2147483647;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 1rem;
        max-width: 48rem;
        margin: 0 auto;
        padding: 1rem 1.5rem;
        box-shadow: 0 .5rem 2rem rgba(0, 0, 0, 0.25);
        text-align: left;
    }

    .detect-adblock-banner[hidden] {
        display: none;
    }

    .detect-adblock-banner p {
        flex: 1 1 16rem;
    }

    .detect-adblock-banner button {
        margin-top: 0;
    }

    .detect-adblock-banner .detect-adblock-close {
        padding: .25rem .5rem;
        background: none;
        color: inherit;
        font-size: 1.5rem;
        line-height: 1;
    }
</style>

<?php if ($mode === 'banner'): ?>
<div class="detect-adblock detect-adblock-banner" role="alert" data-detect-adblock hidden>
    <p><strong><?= esc($title) ?></strong> <?= esc($text) ?></p>
    <button type="button" data-detect-adblock-reload><?= esc($button) ?></button>
    <button type="button" class="detect-adblock-close" aria-label="<?= esc($close, 'attr') ?>" title="<?= esc($close, 'attr') ?>" data-detect-adblock-close>&times;</button>
</div>
<?php else: ?>
<dialog class="detect-adblock" aria-labelledby="detect-adblock-title" aria-describedby="detect-adblock-text" data-detect-adblock>
    <h2 id="detect-adblock-title"><?= esc($title) ?></h2>
    <p id="detect-adblock-text"><?= esc($text) ?></p>
    <button type="button" data-detect-adblock-reload><?= esc($button) ?></button>
</dialog>
<?php endif ?>
