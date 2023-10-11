<?php
/** @var $l \OCP\IL10N */
/** @var $_ array */

use OCP\IConfig;

script('pushdemo', 'admin');   // adds a JavaScript file

if (isset($_GET["director_endpoint"])) {
	/** @var IConfig $config */
	$config = $_['config'];
	$config->setAppValue('pushdemo', 'endpoint', $_GET["director_endpoint"]);
	echo 'push-endpoint-updated-correctly';
} else {
	?>

	<form id="pushdemo" class="section">
		<h2><?php p($l->t('PUSH Demo')); ?></h2>

		<p>
			<?php p($l->t('Introduce the URL of the Director endpoint. This will be used for notifying all the clients about DAV updates.')); ?>
		</p>

		<p>
			<label for="director_endpoint"><?php p($l->t('Director Endpoint')); ?></label>
			<input id="director_endpoint" name="director_endpoint" type="url" value="<?php echo $_['endpoint'] ?>"/>
		</p>

		<button type="submit"><?php p($l->t('Save')); ?></button>

	</form>
	<?php
}
?>

