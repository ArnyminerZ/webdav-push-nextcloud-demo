<!--
SPDX-FileCopyrightText: bitfire web engineering <info@bitfire.at>
SPDX-License-Identifier: CC0-1.0
-->

# Push Demo

The demo application for integrating DAV PUSH notifications on Nextcloud.

The scope of this app is really simple, just to test how listeners work in Nextcloud. The application adds event
listeners for all the DAV events, and once one is triggered, a POST request is made to a desired endpoint, which at
the end should be the PUSH director.

# Important repositories
- Main repository: https://github.com/bitfireAT/webdav-push
- Push director demo: https://github.com/bitfireAT/webdav-push-director-demo
