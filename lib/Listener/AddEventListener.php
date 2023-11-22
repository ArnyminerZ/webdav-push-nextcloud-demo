<?php
// SPDX-FileCopyrightText: bitfire web engineering GmbH <info@bitfire.at>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\PushDemo\Listener;

use OCP\IConfig;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCA\DAV\Events\CalendarObjectCreatedEvent;
use OCA\DAV\Events\CalendarObjectDeletedEvent;
use OCA\DAV\Events\CalendarObjectUpdatedEvent;
use OCA\DAV\Events\CardCreatedEvent;
use OCA\DAV\Events\CardDeletedEvent;
use OCA\DAV\Events\CardUpdatedEvent;
use Psr\Log\LoggerInterface;

class AddEventListener implements IEventListener {

    /** @var LoggerInterface */
    private LoggerInterface $logger;

    /** @var IConfig */
    private IConfig $config;

    public function __construct(LoggerInterface $logger, IConfig $config) {
        $this->logger = $logger;
        $this->config = $config;
    }

    public function handle(Event $event): void {
        if (!($event instanceOf CalendarObjectCreatedEvent) && !($event instanceOf CalendarObjectDeletedEvent) &&
            !($event instanceOf CalendarObjectUpdatedEvent)) {
            $this->logger->error('AddEventListener received an unknown event.');
            return;
        }

        $endpoint = $this->config->getAppValue('pushdemo', 'endpoint');
        if ($endpoint == '') {
            $this->logger->error("Endpoint has not been configured");
            return;
        }

        $auth_arg = $this->config->getAppValue('pushdemo', 'auth_arg');
        if ($auth_arg == '') {
            $this->logger->error("Auth argument has not been configured");
            return;
        }

		$this->processCall($endpoint, $auth_arg, $event->getObjectData(), $event->getCalendarData());
    }

	public function processCall(string $endpoint, string $auth_arg, array $objectData, array $calendarData) {
		$topic = $calendarData['uri']; // Collection URI
		$encoded_topic = hash('sha512', $topic);

		$this->logger->info('Unhashed topic: ' . $topic . ', hashed topic: ' . $encoded_topic);

		$this->logger->info('Calling push director...');
        $response = file_get_contents(
            $endpoint . '?auth=' . $auth_arg . '&topic=' . $encoded_topic
        );
        $this->logger->info('Director result: ' . $response);

        $this->logger->warning('Sent update to PUSH director!');
	}
}
