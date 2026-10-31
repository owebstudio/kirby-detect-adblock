<?php

/**
 * @var \Kirby\Cms\App $kirby
 * @var string|array|null $title Title of the warning, or one per language code
 * @var string|array|null $text Text of the warning, or one per language code
 * @var string|array|null $button Text of the reload button, or one per language code
 */

$kirby ??= kirby();

$translate = function (string $key, string|array|null $value): string {
    $value ??= option('owebstudio.detect-adblock.' . $key);

    if (is_array($value) === true) {
        return (string)t($value);
    }

    return $value ?? (string)t('owebstudio.detect-adblock.' . $key);
};

snippet('detect-adblock-overlay', [
    'title' => $translate('title', $title ?? null),
    'text' => $translate('text', $text ?? null),
    'button' => $translate('button', $button ?? null),
]);
?>

<script nonce="<?= esc($kirby->nonce(), 'attr') ?>">
  window.addEventListener('load', function () {
    let detectAdBlock = document.createElement("div");
    detectAdBlock.id = 'detectAdBlock';
    detectAdBlock.style.width = '1px';
    detectAdBlock.style.height = '1px';
    detectAdBlock.style.position = 'absolute';
    detectAdBlock.style.top = '-999em';
    detectAdBlock.style.left = '-999em';
    detectAdBlock.setAttribute('class', 'ads ad adsbox doubleclick ad-placement carbon-ads');
    document.body.appendChild(detectAdBlock);

    setTimeout(() => {
      window.adBlockRunning = function () {
        return (getComputedStyle(document.getElementById("detectAdBlock"))["display"] === "none") ? true : false;
      }();

      if (window.adBlockRunning === true) {
        showNotice();
      }
    }, 1000);
  });

  function showNotice() {
    let notice = document.querySelector('[data-detect-adblock]') || document.getElementById('detectAdBlockOverlay');

    if (notice === null) {
      return;
    }

    document.body.style.overflow = 'hidden';

    if (typeof notice.showModal === 'function') {
      notice.addEventListener('cancel', (event) => event.preventDefault());
      notice.addEventListener('close', () => notice.showModal());
      notice.showModal();
      return;
    }

    notice.hidden = false;
    notice.style.display = 'block';
  }

  document.addEventListener('click', function (event) {
    if (event.target.closest('[data-detect-adblock-reload]')) {
      location.reload();
    }
  });
</script>
