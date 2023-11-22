<!--
SPDX-FileCopyrightText: bitfire web engineering <info@bitfire.at>
SPDX-License-Identifier: CC0-1.0
-->

# Push Demo

The demo application for integrating DAV PUSH notifications on Nextcloud.

The scope of this app is really simple, just to test how listeners work in Nextcloud. The application adds event
listeners for all the DAV events, and once one is triggered, a POST request is made to a desired endpoint, which at
the end should be the PUSH director.

This is a demo application, and as such, it's not intended for end-users, just for developers to get an idea on how the
system is supposed to work. By any means this is a complete application, and may have bugs or security issues. Nor
Bitfire or any other contributors take any responsibility of the product offered.

Log levels are higher, and there are more log messages that it should. It's just to supervise and check for any
potential problem.

# Important repositories
- Main repository: https://github.com/bitfireAT/webdav-push
- Push director demo: https://github.com/bitfireAT/webdav-push-director-demo

# Supported Features
- Calendar (CalDAV)
  - Create Event
  - Delete Event
  - Update Event
- ~Contacts (CardDAV)~
  - ~Create Card~
  - ~Delete Card~
  - ~Update Card~

# Installation
> **Important!** The directory MUST be named `pushdemo`, use the clone command below for instructions.

To install, access the `workspace/server/apps-extra` directory on your server, if you are using Docker (or `apps` if
installed directly). Check the individual requirements for your specific installation. Then, use the command below to
clone the repository:
```shell
git clone https://github.com/ArnyminerZ/webdav-push-nextcloud-demo.git pushdemo
```
Then, in an administrator account at Nextcloud, go to `/settings/apps/disabled`, and enable the "Push Demo" app:
![Enable app](/img/enable.png)

## Configuration
Now access `/settings/admin/pushdemo` on a Nextcloud admin account, and configure your Push Endpoint and authentication
argument.

> See https://github.com/bitfireAT/webdav-push-director-demo for an example push director.

# Development
It's required to have a Nextcloud development installation in order to test the application.
You can follow the instructions at [Nextcloud](https://cloud.nextcloud.com/s/iyNGp8ryWxc7Efa?path=%2F1%20Setting%20up%20a%20development%20environment), to get your environment up and ready for development-

## Requirements
### Engine
- **Nextcloud:** `20 <= Nextcloud <= 28`
- **Node:** `^16.0.0`
- **NPM:** `^8.0.0`

> **Note:**
> Check in [package.json](./package.json) just in case this isn't updated.

### Dependencies
- **http-ext**:
  ```shell
  # Instruction for Ubuntu-based distros, check externally for your platform
  sudo apt update -y
  sudo apt install php-pear php-raphf php-dev -y
  sudo apt instal libcurl4-openssl-dev zlib1g libevent-dev libicu-dev libidn2-0
  sudo pecl install pecl_http
  ````

## Installation
To install the application, just copy the whole repository into `<nextcloud installation>/workspace/server/apps-extra/<repo>`.

You can modify the contents of the folder there whenever you want, so it's a valid approach to simply edit the project there.

# Reference

Just as a reference, for the event listener ([AddEventListener.php](/lib/Listener/AddEventListener.php)), calling
`getObjectData` on the event, eg
```php
implode(', ', $event->getObjectData())
```
returns data as follows:
```
30, 623CB73D-F0CD-482A-B649-A4F94424AB5A.ics, 1700650727, \"1e654a8af494642118ffbc43ac4791fe\", 1, 746, BEGIN:VCALENDAR\r\nPRODID:-//IDN nextcloud.com//Calendar app 4.5.3//EN\r\nCALSCALE:GREGORIAN\r\nVERSION:2.0\r\nBEGIN:VEVENT\r\nCREATED:20231122T105845Z\r\nDTSTAMP:20231122T105846Z\r\nLAST-MODIFIED:20231122T105846Z\r\nSEQUENCE:2\r\nUID:ffc256a6-0ea7-4064-9f9a-97aa0b79e200\r\nDTSTART, TZID=Europe/Madrid:20231122T120045\r\nDTEND, TZID=Europe/Madrid:20231122T130045\r\nSTATUS:CONFIRMED\r\nSUMMARY:asdfasdf\r\nEND:VEVENT\r\nBEGIN:VTIMEZONE\r\nTZID:Europe/Madrid\r\nBEGIN:DAYLIGHT\r\nTZOFFSETFROM:+0100\r\nTZOFFSETTO:+0200\r\nTZNAME:CEST\r\nDTSTART:19700329T020000\r\nRRULE:FREQ=YEARLY, BYMONTH=3, BYDAY=-1SU\r\nEND:DAYLIGHT\r\nBEGIN:STANDARD\r\nTZOFFSETFROM:+0200\r\nTZOFFSETTO:+0100\r\nTZNAME:CET\r\nDTSTART:19701025T030000\r\nRRULE:FREQ=YEARLY, BYMONTH=10, BYDAY=-1SU\r\nEND:STANDARD\r\nEND:VTIMEZONE\r\nEND:VCALENDAR, vevent, 0, 
```

And calling `getCalendarData`:
```php
json_encode($event->getCalendarData())
```
gives:
```json
{
  "id": 1,
  "uri": "personal",
  "principaluri": "principals/users/test",
  "{http://calendarserver.org/ns/}getctag": "http://sabre.io/ns/sync/29",
  "{http://sabredav.org/ns}sync-token": 29,
  "{urn:ietf:params:xml:ns:caldav}supported-calendar-component-set": {},
  "{urn:ietf:params:xml:ns:caldav}schedule-calendar-transp": {},
  "{DAV:}displayname": "Personal",
  "{urn:ietf:params:xml:ns:caldav}calendar-description": null,
  "{urn:ietf:params:xml:ns:caldav}calendar-timezone": null,
  "{http://apple.com/ns/ical/}calendar-order": 0,
  "{http://apple.com/ns/ical/}calendar-color": "#0082c9",
  "{http://nextcloud.com/ns}deleted-at": null,
  "{http://nextcloud.com/ns}owner-displayname": "test admin user"
}
```
