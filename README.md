# ImagerX Imgproxy Transformer

This module provides an [imgproxy](https://imgproxy.net/) transformer for [ImagerX](https://github.com/spacecatninja/craft-imager-x).

## Requirements

- Craft CMS 4.0.0+
- ImagerX 5.1.0+
- PHP 8.0+

## Installation

1. Add the module to your project:

```bash
composer require fostercommerce/imagerx-imgproxy
```

2. Add the module to your `config/app.php`:

```php
return [
    'modules' => [
        'imagerx-imgproxy' => [
            'class' => \fostercommerce\imagerx\imgproxy\Module::class,
        ],
    ],
    'bootstrap' => ['imagerx-imgproxy'],
];
```

## Configuration

Add the imgproxy configuration to your ImagerX config file (`config/imager-x.php`):

```php
<?php

return [
    // other ImagerX config...
    
    'imgproxyConfig' => [
        'default' => [
            'baseUrl' => 'https://imgproxy.example.com', 
            'key' => 'your-key', // Optional if not using signatures
            'salt' => 'your-salt', // Optional if not using signatures
            'signatureSize' => 32, // Default: 32
            'encoded' => true, // Default: true
        ],
        // You can define multiple profiles
        'another' => [
            // ...
        ],
    ],
];
```

## Usage

Once installed and configured, you can use the transformer with ImagerX:

```twig
{% set transforms = craft.imagerX.transformImage(asset, [
    {
        width: 400,
        height: 300,
        mode: 'crop',
        format: 'webp',
        transformer: 'imgproxy',
        imgproxyProfile: 'default' // Optional, defaults to 'default'
    }
]) %}

<img src="{{ transforms[0].url }}" width="{{ transforms[0].width }}" height="{{ transforms[0].height }}">
```

### Transformer Parameters

You can pass specific imgproxy parameters using the `transformerParams` key:

```twig
{% set transforms = craft.imagerX.transformImage(asset, [
    {
        width: 400,
        height: 300,
        mode: 'crop',
        transformer: 'imgproxy',
        transformerParams: {
            blur: 10,
            watermark: '/path/to/watermark.png',
            watermarkOpacity: 0.5
        }
    }
]) %}
```

## License

MIT License 
