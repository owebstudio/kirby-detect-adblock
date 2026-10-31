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
        document.body.style.overflow = 'hidden';
        document.getElementById("detectAdBlockOverlay").style.display = "block";
      }
    }, 1000);
  });

  document.addEventListener('click', function (event) {
    if (event.target.closest('[data-detect-adblock-reload]')) {
      location.reload();
    }
  });
</script>
