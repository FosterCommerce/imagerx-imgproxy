<?php

namespace fostercommerce\imagerx\imgproxy\models;

use craft\base\Model;

class Settings extends Model
{
	/**
	 * The base URL for imgproxy
	 */
	public string $baseUrl;

	/**
	 * The signing key for imgproxy
	 */
	public ?string $key = null;

	/**
	 * The signing salt for imgproxy
	 */
	public ?string $salt = null;

	/**
	 * Whether to use URL encoding
	 */
	public bool $encoded = true;

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
			[['key', 'salt'],
				'string',
				'skipOnEmpty' => true],
			[['encoded'], 'boolean'],
		];
	}
}
