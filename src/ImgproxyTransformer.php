<?php

namespace fostercommerce\imagerx\imgproxy;

use craft\base\Component;
use craft\elements\Asset;
use fostercommerce\imgproxy\Options;
use fostercommerce\imgproxy\UrlBuilder;
use spacecatninja\imagerx\exceptions\ImagerException;
use spacecatninja\imagerx\transformers\TransformerInterface;

class ImgproxyTransformer extends Component implements TransformerInterface
{
	/**
	 * Main transform method
	 *
	 * @param array<array-key, array<array-key, mixed>> $transforms
	 * @return ImgproxyTransformedImageModel[]
	 *
	 * @throws ImagerException
	 */
	public function transform(Asset|string $image, array $transforms): ?array
	{
		$transformedImages = [];

		foreach ($transforms as $transform) {
			$transformedImages[] = $this->getTransformedImage($image, $transform);
		}

		return $transformedImages;
	}

	/**
	 * Transform one image
	 *
	 * @param array<array-key, mixed> $transform
	 *
	 * @throws ImagerException
	 */
	private function getTransformedImage(Asset|string $image, array $transform): ImgproxyTransformedImageModel
	{
		$config = Plugin::settings();

		try {
			// Create the UrlBuilder for imgproxy
			$urlBuilder = new UrlBuilder(
				$config->baseUrl,
				$config->key,
				$config->salt,
				$config->encoded,
				$config->customSignature,
			);

			$sourceUrl = $this->getSourceUrl($image);

			$imgproxyParams = [];

			if (isset($transform['width'])) {
				$imgproxyParams['width'] = $transform['width'];
			}

			if (isset($transform['height'])) {
				$imgproxyParams['height'] = $transform['height'];
			}

			if (isset($transform['format'])) {
				$imgproxyParams['format'] = $transform['format'];
			}

			if (isset($transform['ratio'])) {
				// Assuming ratio maps to zoom in imgproxy
				$imgproxyParams['zoom'] = $transform['ratio'];
			}

			if (isset($transform['mode'])) {
				// Assume mode maps to resizing_type in imgproxy
				$resizingTypeMap = [
					'crop' => 'fill',
					'fit' => 'fit',
					'stretch' => 'force',
					'auto' => 'auto',
				];
				$imgproxyParams['resizing_type'] = $resizingTypeMap[$transform['mode']] ?? 'fit';
			}

			$transformerParams = $transform['transformerParams'] ?? [];

			$options = new Options([
				// Ensure defaults are always applied
				...($config->defaultParams ?? []),
				// Apply standard ImagerX params
				...$imgproxyParams,
				// Apply any additional transform parameters
				...$transformerParams,
			]);

			// Generate the URL
			$url = $urlBuilder->buildUrl($sourceUrl, $options);

			return new ImgproxyTransformedImageModel($url, $image, $options);
		} catch (\Exception $exception) {
			throw new ImagerException($exception->getMessage(), $exception->getCode(), $exception);
		}
	}

	/**
	 * Get source URL for the image
	 *
	 * @throws ImagerException
	 */
	private function getSourceUrl(Asset|string $image): string
	{
		if ($image instanceof Asset) {
			return $image->getUrl() ?? '';
		}

		return $image;
	}
}
