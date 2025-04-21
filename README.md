# ImagerX Imgproxy Transformer

This module provides an [imgproxy](https://imgproxy.net/) transformer for [ImagerX](https://github.com/spacecatninja/craft-imager-x).

## Requirements

- Craft CMS 5.0.0+
- ImagerX 5.1.0+
- PHP 8.2+

## Installation

```bash
composer require fostercommerce/imagerx-imgproxy
php craft plugin/install imagerx-imgproxy
```

## Configuration

Add the imgproxy configuration to your ImagerX config file (`config/imagerx-imgproxy.php`):

```php
return [
    'baseUrl' => getenv('IMGPROXY_BASE_URL'),
    'key' => getenv('IMGPROXY_KEY') ?: null,
    'salt' => getenv('IMGPROXY_SALT') ?: null,
    'customSignature' => getenv('IMGPROXY_CUSTOM_SIGNATURE') ?: null,
    'encoded' => true,
    'defaultParams' => [],
];
```

## Usage

Once installed and configured, you can use the transformer with ImagerX:

```twig
{% set transformedImages = craft.imagerx.transformImage(rawImage, [
  { width: 74, height: 74 },
  { width: 120, height: 120 },
  { width: 172, height: 172 },
  { width: 254, height: 254 }
], {
  mode: 'crop',
  transformerParams: {
    padding: 10,
    background: '255:0:0',
  },
}) %}
```

## Notes

Take a look at the Imgproxy [processing options](https://docs.imgproxy.net/usage/processing#processing-options) for a list of available options to use in the `defaultParams` and `transformerParams` arrays.

This transformer uses [fostercommerce/imgproxy](https://github.com/fostercommerce/imgproxy-php) under the hood. Take a look there for more usage information.