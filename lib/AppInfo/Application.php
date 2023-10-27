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
use OCA\DAV\Events\CalendarObjectDeletedEvent;
use OCA\DAV\Events\CalendarObjectUpdatedEvent;
use OCA\DAV\Events\CardCreatedEvent;
use OCA\DAV\Events\CardDeletedEvent;
use OCA\DAV\Events\CardUpdatedEvent;

class Application extends App implements IBootstrap {
	public const APP_ID = 'pushdemo';

	public function __construct() {
		parent::__construct(self::APP_ID);
	}

	public function register(IRegistrationContext $context): void
	{
        $context->registerEventListener(CalendarObjectCreatedEvent::class, AddEventListener::class);
        $context->registerEventListener(CalendarObjectDeletedEvent::class, AddEventListener::class);
        $context->registerEventListener(CalendarObjectUpdatedEvent::class, AddEventListener::class);

        $context->registerEventListener(CardCreatedEvent::class, AddEventListener::class);
        $context->registerEventListener(CardDeletedEvent::class, AddEventListener::class);
        $context->registerEventListener(CardUpdatedEvent::class, AddEventListener::class);
	}

	public function boot(IBootContext $context): void
	{
		// Nothing to do here
	}
}
