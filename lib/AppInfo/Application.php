<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: bitfire web engineering <info@bitfire.at>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\PushDemo\AppInfo;

use OCA\PushDemo\Listener\AddEventListener;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCA\DAV\Events\CalendarObjectCreatedEvent;

class Application extends App implements IBootstrap {
	public const APP_ID = 'pushdemo';

	public function __construct() {
		parent::__construct(self::APP_ID);
	}

	public function register(IRegistrationContext $context): void
	{
		$context->registerEventListener(CalendarObjectCreatedEvent::class, AddEventListener::class);
	}

	public function boot(IBootContext $context): void
	{
		// Nothing to do here
	}
}
