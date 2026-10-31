# Kirby Detect Ad Block

Detects ad blockers and shows your visitors a warning: a modal dialog that asks them to disable their ad blocker, or a banner they can close. The texts follow the language of your site.

## Requirements

- Kirby 5 or 6
- PHP 8.2 or newer (Kirby 6 needs PHP 8.3)

For Kirby 3 and 4, use version 1.x of this plugin.

## Installation

1. Download the latest release
2. Unzip downloaded file
3. Copy/paste unzipped folder in your `/site/plugins` folder

Or with Composer:

```
composer require owebstudio/kirby-detect-adblock
```

## Usage

Add the snippet to every page where you want to detect ad blockers, e.g. at the end of your footer:

```php
<?php snippet('detect-adblock') ?>
```

When an ad blocker is detected, a modal dialog asks the visitor to disable it and reload the page. The dialog can't be closed.

### Banner

For a gentler hint, show a banner at the bottom of the page instead:

```php
<?php

// /site/config/config.php
return [
    'owebstudio.detect-adblock' => [
        'mode' => 'banner'
    ]
];
```

Visitors can close the banner. It then stays hidden for 7 days (the `remember` option). This is stored in the browser's local storage, so no cookie is set.

### Snippet options

Every option can also be passed to the snippet, e.g. to show the banner only on some pages:

```php
<?php snippet('detect-adblock', [
    'mode' => 'banner',
    'text' => 'Ads keep this blog free. Please consider disabling your ad blocker.'
]) ?>
```

## How the detection works

The snippet adds a few invisible elements with class names and IDs that ad blockers hide, and loads a small script from the plugin with a file name that ad blockers block (`prebid.js`, served by your own site). If an element gets hidden, or the script is blocked or replaced, an ad blocker is detected. The check starts when the page is loaded and takes up to 2 seconds. No request goes to another domain.

No detection is perfect. Ad blockers and their filter lists change, and some visitors use lists that hide warnings like this one.

## Texts and translations

The texts are translated into English, German and Turkish. On multi-language sites, they follow the language of the page. To change them, set the options:

```php
<?php

// /site/config/config.php
return [
    'owebstudio.detect-adblock' => [
        'title' => 'Warning!',
        'text' => 'Looks like you are using an ad blocker. Please disable it and reload the page.',
        'button' => 'OK'
    ]
];
```

Each text can also be an array with one text per language code:

```php
'title' => [
    'en' => 'Ad blocker detected',
    'fr' => 'Bloqueur de publicités détecté'
]
```

On multi-language sites, you can also add the keys from `translations/en.php` to the translations of your language files.

## Custom warning

To change the markup of the warning, copy `snippets/detect-adblock-overlay.php` to `/site/snippets/detect-adblock-overlay.php` and edit it. The snippet gets `$mode`, `$title`, `$text`, `$button` and `$close`. The script looks for these attributes:

| Attribute | Element |
|:--- |:--- |
| `data-detect-adblock` | The warning. A `<dialog>` opens as a modal dialog (or a non-modal one in banner mode), any other element is shown by removing its `hidden` attribute. |
| `data-detect-adblock-reload` | A button that reloads the page |
| `data-detect-adblock-close` | A button that closes the banner (banner mode only) |

```html
<!-- /site/snippets/detect-adblock-overlay.php -->
<dialog class="custom-modal" aria-labelledby="custom-modal-title" data-detect-adblock>
    <h2 id="custom-modal-title">Warning!</h2>
    <p>Looks like you are using an ad blocker. Please disable it and reload the page!</p>
    <button type="button" data-detect-adblock-reload>OK</button>
</dialog>
```

## JavaScript

To react to ad blockers in your own way, e.g. to hide certain content or to count visitors with ad blockers, listen to these events on `document`:

| Event | |
|:--- |:--- |
| `adblock:checked` | The check is done. `event.detail.detected` is `true` or `false`. |
| `adblock:detected` | An ad blocker was detected. Call `event.preventDefault()` to skip the plugin's warning. |

```js
document.addEventListener('adblock:detected', (event) => {
  event.preventDefault();
  document.querySelector('.premium-video').remove();
});
```

`window.adBlockRunning` is `true` or `false` once the check is done.

Set the `mode` option to `false` to only run the check and fire the events, without any warning markup.

The inline scripts and styles use Kirby's nonce (`$kirby->nonce()`), so they work with a Content Security Policy.

## Options

All options are set in `config.php` with the `owebstudio.detect-adblock.` prefix.

| Option | Type | Default | Description |
|:--- |:--- |:--- |:--- |
| mode | string&#124;false | `'overlay'` | `'overlay'` for a modal dialog that can't be closed, `'banner'` for a banner that can be closed, `false` for no warning (events only) |
| remember | int | `7` | Days the banner stays hidden after it was closed. `0` shows it again on the next page. |
| title | string&#124;array&#124;null | `null` | Title of the warning |
| text | string&#124;array&#124;null | `null` | Text of the warning |
| button | string&#124;array&#124;null | `null` | Text of the reload button |
| close | string&#124;array&#124;null | `null` | Label of the close button of the banner |

`null` uses the translated default text.

## Upgrading from 1.x

- Kirby 5 and PHP 8.2 are required.
- The warning is a `<dialog>` element now, with the classes `detect-adblock` and `detect-adblock-banner`. The IDs `detectAdBlockOverlay` and `detectAdBlockInfo` are gone, so update your own CSS for them.
- The texts are escaped. To use HTML, override the `detect-adblock-overlay` snippet.
- The default texts changed and are translated. Set the options to keep your own texts.
- A custom `detect-adblock-overlay` snippet needs the `data-detect-adblock` attribute on the warning element. Custom snippets with the ID `detectAdBlockOverlay` still work. Replace `onclick="location.reload();"` with `data-detect-adblock-reload`, so it works with a Content Security Policy.

## License

MIT
