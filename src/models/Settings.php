<?php

namespace fostercommerce\imagerx\imgproxy\models;

use craft\base\Model;

class Settings extends Model
{
	/**
	 * The base URL for the imgproxy service
	 */
	public string $baseUrl;

	/**
	 * The signing key for the URL
	 */
	public ?string $key = null;

	/**
	 * The signing salt for the URL
	 */
	public ?string $salt = null;

	/**
	 * Whether to use base64 encode the source URL
	 */
	public bool $encoded = true;

	/**
	 * The custom signature to use if key and salt values are not provided
	 */
	public ?string $customSignature = null;

	/**
	 * @var array<non-empty-string, mixed> Default parameters for imgproxy transformations
	 */
	public array $defaultParams = [];

	/**
	 * @return array<array-key, mixed>
	 */
	public function rules(): array
	{
		return [
			[['baseUrl'], 'required'],
			[['key', 'salt', 'customSignature'],
				'string',
				'skipOnEmpty' => true],
			[['encoded'], 'boolean'],
		];
	}
}
