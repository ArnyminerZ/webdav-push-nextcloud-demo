<?php

namespace OCA\PushDemo\Listener;

use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCA\DAV\Events\CalendarObjectCreatedEvent;
use Psr\Log\LoggerInterface;

class AddEventListener implements IEventListener {

	/** @var LoggerInterface */
	private LoggerInterface $logger;

	public function __construct(LoggerInterface $logger) {
		$this->logger = $logger;
	}

	public function handle(Event $event): void {
		if (!($event instanceOf CalendarObjectCreatedEvent)) {
			$this->logger->error('AddEventListener received an unknown event.');
			return;
		}

		$this->logger->warning('Created new Calendar Event!');

		// TODO - send POST notification
	}
}
