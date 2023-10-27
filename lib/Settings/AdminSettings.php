<?php
// SPDX-FileCopyrightText: bitfire web engineering GmbH <info@bitfire.at>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\PushDemo\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\IL10N;
use OCP\Settings\IDelegatedSettings;
use OCP\Settings\ISettings;

class AdminSettings implements IDelegatedSettings {

	/** @var IConfig */
	private IConfig $config;

	/** @var IL10N */
	private IL10N $l;

	/**
	 * Admin constructor.
	 *
	 * @param IConfig $config
	 * @param IL10N $l
	 */
	public function __construct(IConfig $config,
								IL10N $l
	) {
		$this->config = $config;
		$this->l = $l;
	}

	/**
	 * @return TemplateResponse
	 */
	public function getForm(): TemplateResponse
	{
		$endpoint = $this->config->getAppValue('pushdemo', 'endpoint');

		$parameters = [
			'endpoint' => $endpoint,
			'config' => $this->config
		];

		return new TemplateResponse('pushdemo', 'admin', $parameters);
	}

	/**
	 * @return string the section ID, e.g. 'sharing'
	 */
	public function getSection(): string
	{
		return 'pushdemo';
	}

	/**
	 * @return int whether the form should be rather on the top or bottom of
	 * the admin section. The forms are arranged in ascending order of the
	 * priority values. It is required to return a value between 0 and 100.
	 */
	public function getPriority(): int
	{
		return 50;
	}

	public function getName(): ?string
	{
		return null;
	}

	public function getAuthorizedAppConfig(): array
	{
		return [];
	}

}
