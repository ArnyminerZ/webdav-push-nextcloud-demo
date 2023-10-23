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

# Development
It's required to have a Nextcloud development installation in order to test the application.
You can follow the instructions at [Nextcloud](https://cloud.nextcloud.com/s/iyNGp8ryWxc7Efa?path=%2F1%20Setting%20up%20a%20development%20environment), to get your environment up and ready for development-

## Requirements
### Engine
- **Nextcloud:** `20 <= Nextcloud <= 27`
- **Node:** `^16.0.0`
- **NPM:** `^8.0.0`

> **Note:**
> Check in [package.json](./package.json) just in case this isn't updated.

### Dependencies
- **http-ext**:
  ```shell
  sudo apt update -y
  sudo apt install php-pear php-raphf php-dev -y
  sudo pecl install pecl_http
  ````

## Installation
To install the application, just copy the whole repository into `<nextcloud installation>/workspace/server/apps-extra/<repo>`.

You can modify the contents of the folder there whenever you want, so it's a valid approach to simply edit the project there.
