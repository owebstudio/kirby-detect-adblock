<?php snippet('detect-adblock-overlay') ?>

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
