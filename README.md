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
- Contacts (CardDAV)
  - Create Card
  - Delete Card
  - Update Card

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
$event->getObjectData()
```
returns data as follows:
```
2F2AEAF46-B92A-4995-BB80-C98C49EE85DF.ics1698570435\"f335608aff66dfcf8911d153cc03cf59\"1370BEGIN:VCALENDAR\r\nPRODID:-//IDN nextcloud.com//Calendar app 4.5.2//EN\r\nCALSCALE:GREGORIAN\r\nVERSION:2.0\r\nBEGIN:VEVENT\r\nCREATED:20231029T090710Z\r\nDTSTAMP:20231029T090714Z\r\nLAST-MODIFIED:20231029T090714Z\r\nSEQUENCE:2\r\nUID:c2ad9b09-bca3-4354-bea8-a73db40e3b1e\r\nDTSTART;VALUE=DATE:20231029\r\nDTEND;VALUE=DATE:20231030\r\nSTATUS:CONFIRMED\r\nSUMMARY:test 1\r\nEND:VEVENT\r\nEND:VCALENDARvevent0
```
