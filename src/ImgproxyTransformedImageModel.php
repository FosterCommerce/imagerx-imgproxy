<?php

namespace fostercommerce\imagerx\imgproxy;

use craft\elements\Asset;
use fostercommerce\imgproxy\Options;
use spacecatninja\imagerx\models\TransformedImageInterface;

class ImgproxyTransformedImageModel implements TransformedImageInterface
{
	public function __construct(
		private readonly string $url,
		private readonly Asset|string $source,
		private readonly Options $options
	) {
	}

	/**
	 * Get URL
	 */
	public function getUrl(): string
	{
		return $this->url;
	}

	/**
	 * Get width
	 */
	public function getWidth(): int
	{
		return $this->options->getWidth() ?? 0;
	}

	/**
	 * Get height
	 */
	public function getHeight(): int
	{
		return $this->options->getHeight() ?? 0;
	}

	/**
	 * Get format
	 */
	public function getFormat(): ?string
	{
		return $this->options->getFormat();
	}

	/**
	 * Get size
	 */
	public function getSize(string $unit = 'b', int $precision = 2): mixed
	{
		return 0;
	}

	/**
	 * Get MIME type
	 */
	public function getMimeType(): string
	{
		$format = $this->getFormat();

		if ($format === null) {
			if ($this->source instanceof Asset) {
				$mimeType = $this->source->getMimeType();
				if ($mimeType !== null) {
					return $mimeType;
				}
			}

			return 'application/octet-stream';
		}

		$formats = [
			'jpg' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'png' => 'image/png',
			'gif' => 'image/gif',
			'webp' => 'image/webp',
			'avif' => 'image/avif',
		];

		return $formats[$format] ?? 'application/octet-stream';
	}

	/**
	 * Is image
	 */
	public function getIsImage(): bool
	{
		return true;
	}

	/**
	 * Get extension
	 */
	public function getExtension(): string
	{
		return $this->options->getFormat() ?? 'jpg';
	}

	/**
	 * Get path
	 */
	public function getPath(): string
	{
		return $this->url;
	}

	/**
	 * Get data URI
	 */
	public function getDataUri(): string
	{
		// Not applicable for remote transformations
		return '';
	}

	/**
	 * Get image string
	 */
	public function getImageString(): ?string
	{
		return null;
	}

	/**
	 * Get the source image
	 */
	public function getSource(): Asset|string
	{
		return $this->source;
	}

	/**
	 * Get filename
	 */
	public function getFilename(): string
	{
		$pathInfo = pathinfo($this->url);
		return $pathInfo['filename'];
	}

	/**
	 * Is the image newly created
	 */
	public function getIsNew(): bool
	{
		return false;
	}

	/**
	 * Get base64 encoded image
	 */
	public function getBase64Encoded(): string
	{
		return '';
	}

	/**
	 * Get a placeholder
	 *
	 * @param array<array-key, mixed> $settings
	 */
	public function getPlaceholder(array $settings = []): string
	{
		return '';
	}
}
