# Kirby Detect Ad Block

This plugin helps you detect ad blockers and manage the warning messages that will be displayed for Kirby 3.

## Installation

1. Download the latest release
2. Unzip downloaded file
3. Copy/paste unzipped folder in your `/site/plugins` folder

## Usage

You can use sample basic snippet of plugin:

```php
<?php snippet('detect-ad-block') ?>
```

If you want to customize overlay, you can override `detect-ad-block-overlay` snippet:

```php
 <div id="custom-modal">
    <h3>Warning!</h3>
    <p>Looks like you are using ad blocker. Please disable and refresh the page!</p>
    <button type="button" onclick="location.reload();">OK</button>
</div>
```

## Options

The default values of the package are:

| Option | Type    | Default                                                   | Description         |
|:-------|:--------|:----------------------------------------------------------|:--------------------|
| title  | string  | Ad block detected!                                        | Overlay title       |
| text   | string | Please disable AdBlock and refresh to see requested page. | Overlay text        |
| button | string | Refresh the page                                          | Overlay button text |

All the values can be updated in the `config.php` file and prefixed with `clicktonext.detect-ad-block.`.

## Sample options

```php
<?php

// /site/config/config.php
return [
    'clicktonext.detect-ad-block' => [
        'title' => 'Warning! ',
        'text' => 'Looks like you are using ad blocker. Please disable and refresh the page!',
        'button' => 'OK',
    ]
];
```
