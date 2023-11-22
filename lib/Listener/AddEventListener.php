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

		$this->processCall($event->getObjectData(), $event->getCalendarData());
    }

	public function processCall(array $objectData, array $calendarData) {
		$split_data = explode(';', implode(';', $objectData));

		$uuid = trim($split_data[1], ".ics"); // Collection ID

		$this->logger->info('Event object data: ' . implode(', ', $split_data));
        // 30, 623CB73D-F0CD-482A-B649-A4F94424AB5A.ics, 1700650727, \"1e654a8af494642118ffbc43ac4791fe\", 1, 746, BEGIN:VCALENDAR\r\nPRODID:-//IDN nextcloud.com//Calendar app 4.5.3//EN\r\nCALSCALE:GREGORIAN\r\nVERSION:2.0\r\nBEGIN:VEVENT\r\nCREATED:20231122T105845Z\r\nDTSTAMP:20231122T105846Z\r\nLAST-MODIFIED:20231122T105846Z\r\nSEQUENCE:2\r\nUID:ffc256a6-0ea7-4064-9f9a-97aa0b79e200\r\nDTSTART, TZID=Europe/Madrid:20231122T120045\r\nDTEND, TZID=Europe/Madrid:20231122T130045\r\nSTATUS:CONFIRMED\r\nSUMMARY:asdfasdf\r\nEND:VEVENT\r\nBEGIN:VTIMEZONE\r\nTZID:Europe/Madrid\r\nBEGIN:DAYLIGHT\r\nTZOFFSETFROM:+0100\r\nTZOFFSETTO:+0200\r\nTZNAME:CEST\r\nDTSTART:19700329T020000\r\nRRULE:FREQ=YEARLY, BYMONTH=3, BYDAY=-1SU\r\nEND:DAYLIGHT\r\nBEGIN:STANDARD\r\nTZOFFSETFROM:+0200\r\nTZOFFSETTO:+0100\r\nTZNAME:CET\r\nDTSTART:19701025T030000\r\nRRULE:FREQ=YEARLY, BYMONTH=10, BYDAY=-1SU\r\nEND:STANDARD\r\nEND:VTIMEZONE\r\nEND:VCALENDAR, vevent, 0, 
		$this->logger->info('Event calendar data: ' . json_encode($calendarData));
        // {\"id\":1,\"uri\":\"personal\",\"principaluri\":\"principals\\/users\\/test\",\"{http:\\/\\/calendarserver.org\\/ns\\/}getctag\":\"http:\\/\\/sabre.io\\/ns\\/sync\\/29\",\"{http:\\/\\/sabredav.org\\/ns}sync-token\":29,\"{urn:ietf:params:xml:ns:caldav}supported-calendar-component-set\":{},\"{urn:ietf:params:xml:ns:caldav}schedule-calendar-transp\":{},\"{DAV:}displayname\":\"Personal\",\"{urn:ietf:params:xml:ns:caldav}calendar-description\":null,\"{urn:ietf:params:xml:ns:caldav}calendar-timezone\":null,\"{http:\\/\\/apple.com\\/ns\\/ical\\/}calendar-order\":0,\"{http:\\/\\/apple.com\\/ns\\/ical\\/}calendar-color\":\"#0082c9\",\"{http:\\/\\/nextcloud.com\\/ns}deleted-at\":null,\"{http:\\/\\/nextcloud.com\\/ns}owner-displayname\":\"test admin user\"}
        $this->logger->info('Principal URL: ' . $calendarData['principaluri']);
		$this->logger->info('Collection ID: ' . $uuid);
		$encoded_uuid = hash('sha512', $uuid);
		$this->logger->info('Encoded collection ID: ' . $encoded_uuid);

		$this->logger->debug('Calling push director...');
		$this->logger->info('Sending to topic ' . $uuid);
        $response = file_get_contents(
            $endpoint . '?auth=' . $auth_arg . '&topic=' . $encoded_uuid
        );
        $this->logger->info('Director result: ' . $response);

        $this->logger->warning('Sent update to PUSH director!');
	}
}
