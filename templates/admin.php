<?php
// SPDX-FileCopyrightText: bitfire web engineering GmbH <info@bitfire.at>
// SPDX-License-Identifier: AGPL-3.0-or-later

/** @var $l \OCP\IL10N */
/** @var $_ array */

use OCP\IConfig;

script('pushdemo', 'admin');   // adds a JavaScript file

if (isset($_GET["director_endpoint"])) {
    /** @var IConfig $config */
    $config = $_['config'];
    $config->setAppValue('pushdemo', 'endpoint', $_GET["director_endpoint"]);
    echo 'push-endpoint-updated-correctly';
} else if (isset($_GET["auth_arg"])) {
    /** @var IConfig $config */
    $config = $_['config'];
    $config->setAppValue('pushdemo', 'auth_arg', $_GET["auth_arg"]);
    echo 'auth-arg-updated-correctly';
} else {
	?>

    <h2 style="margin-left: 30px; margin-top: 10px"><?php p($l->t('PUSH Demo')); ?></h2>

	<form id="pushdemo-director" class="section">
        <p>
            <?php p($l->t('Introduce the URL of the Director endpoint. This will be used for notifying all the clients about DAV updates.')); ?>
        </p>
        <p>
            <?php p($l->t('Please, make sure that the URL is correctly formatted, and that all the required GET parameters can just be appended to the end.')); ?>
        </p>

        <p>
            <label for="director_endpoint"><?php p($l->t('Director Endpoint')); ?></label>
            <input id="director_endpoint" name="director_endpoint" type="url" value="<?php echo $_['endpoint'] ?>" style="width: 400px"/>
        </p>

        <button type="submit"><?php p($l->t('Save')); ?></button>
    </form>

    <form id="pushdemo-auth_arg" class="section">
        <p>
            <?php p($l->t('Introduce the authentication argument. It will be appended to the director endpoint through a GET argument called "auth"')); ?>
        </p>

        <p>
            <label for="auth_arg"><?php p($l->t('Auth Arg')); ?></label>
            <input id="auth_arg" name="auth_arg" type="text" value="<?php echo $_['auth_arg'] ?>" style="width: 400px"/>
        </p>

        <button type="submit"><?php p($l->t('Save')); ?></button>
	</form>
	<?php
}
?>

