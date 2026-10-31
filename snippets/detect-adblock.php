<?php

/**
 * @var \Kirby\Cms\App $kirby
 * @var string|null $mode `overlay` or `banner`
 * @var int|null $remember Days to hide the banner after it was closed
 * @var string|array|null $title Title of the warning, or one per language code
 * @var string|array|null $text Text of the warning, or one per language code
 * @var string|array|null $button Text of the reload button, or one per language code
 * @var string|array|null $close Label of the close button, or one per language code
 */

$kirby ??= kirby();
$mode ??= option('owebstudio.detect-adblock.mode', 'overlay');
$remember ??= option('owebstudio.detect-adblock.remember', 7);

$translate = function (string $key, string|array|null $value, string|null $translation = null): string {
    $value ??= option('owebstudio.detect-adblock.' . $key);

    if (is_array($value) === true) {
        return (string)t($value);
    }

    return $value ?? (string)t($translation ?? 'owebstudio.detect-adblock.' . $key);
};

$options = [
    'mode' => $mode,
    'remember' => (int)$remember,
    'bait' => $kirby->plugin('owebstudio/detect-adblock')?->asset('prebid.js')?->url(),
];

snippet('detect-adblock-overlay', [
    'mode' => $mode,
    'title' => $translate('title', $title ?? null),
    'text' => $translate('text', $text ?? null, $mode === 'banner' ? 'owebstudio.detect-adblock.text.banner' : null),
    'button' => $translate('button', $button ?? null),
    'close' => $translate('close', $close ?? null),
]);
?>

<script nonce="<?= esc($kirby->nonce(), 'attr') ?>">
  (function () {
    const options = <?= json_encode($options, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES) ?>;
    const nonce = document.currentScript ? document.currentScript.nonce : '';

    function isHidden(element) {
      if (element.isConnected === false || element.offsetParent === null || element.offsetHeight === 0) {
        return true;
      }

      const style = getComputedStyle(element);

      return style.display === 'none' || style.visibility === 'hidden';
    }

    function createBait(attributes) {
      const bait = document.createElement('div');

      Object.assign(bait, attributes);
      bait.setAttribute('aria-hidden', 'true');
      bait.style.cssText = 'position: absolute; top: -10000px; left: -10000px; width: 1px; height: 1px;';
      bait.textContent = '\u00a0';
      document.body.appendChild(bait);

      return bait;
    }

    // ad blockers hide elements that look like ads
    function detectHiddenBaits() {
      const baits = [
        createBait({ className: 'ad-slot adslot ad_unit sponsored-ad' }),
        createBait({ id: 'ad_banner' })
      ];
      const start = Date.now();

      return new Promise((resolve) => {
        (function check() {
          const hidden = baits.some(isHidden);

          if (hidden === true || Date.now() - start >= 2000) {
            baits.forEach((bait) => bait.remove());
            resolve(hidden);
            return;
          }

          setTimeout(check, 200);
        })();
      });
    }

    // ad blockers block or replace scripts that look like ad scripts
    function detectBlockedScript() {
      return new Promise((resolve) => {
        if (!options.bait || navigator.onLine === false) {
          resolve(false);
          return;
        }

        const script = document.createElement('script');

        script.src = options.bait;
        script.async = true;
        script.nonce = nonce;
        script.onload = () => resolve(window.detectAdblockBait !== true);
        script.onerror = () => {
          // only count it as blocked when the file itself can be loaded
          fetch(options.bait, { cache: 'no-store' })
            .then((response) => resolve(response.ok))
            .catch(() => resolve(false));
        };

        setTimeout(() => resolve(false), 5000);
        document.head.appendChild(script);
      });
    }

    function detect() {
      return new Promise((resolve) => {
        let pending = 2;

        const done = (detected) => {
          pending--;

          if (detected === true || pending === 0) {
            resolve(detected);
          }
        };

        detectHiddenBaits().then(done);
        detectBlockedScript().then(done);
      });
    }

    function isDismissed() {
      try {
        const time = Number(localStorage.getItem('detect-adblock'));

        return Date.now() - time < options.remember * 86400000;
      } catch (error) {
        return false;
      }
    }

    function dismiss(notice) {
      if (typeof notice.close === 'function') {
        notice.close();
      } else {
        notice.hidden = true;
      }

      if (options.remember > 0) {
        try {
          localStorage.setItem('detect-adblock', String(Date.now()));
        } catch (error) {}
      }
    }

    function showNotice() {
      const notice = document.querySelector('[data-detect-adblock]') || document.getElementById('detectAdBlockOverlay');

      if (notice === null) {
        return;
      }

      if (options.mode === 'banner') {
        if (isDismissed() === true) {
          return;
        }

        if (typeof notice.show === 'function') {
          notice.show();
        } else {
          notice.hidden = false;
        }

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

    function start() {
      detect().then((detected) => {
        window.adBlockRunning = detected;

        if (detected === true) {
          showNotice();
        }
      });
    }

    document.addEventListener('click', (event) => {
      if (event.target.closest('[data-detect-adblock-reload]')) {
        location.reload();
      }

      const close = event.target.closest('[data-detect-adblock-close]');
      const notice = close ? close.closest('[data-detect-adblock]') : null;

      if (notice && options.mode === 'banner') {
        dismiss(notice);
      }
    });

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', start);
    } else {
      start();
    }
  })();
</script>
