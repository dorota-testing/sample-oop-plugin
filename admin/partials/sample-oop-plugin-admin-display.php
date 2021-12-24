<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Sample_Oop_Plugin
 * @subpackage Sample_Oop_Plugin/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<!-- *** NOT IN USE HERE!!! FIELDS' NAMES  *** -->
<form action="options.php" method="post">
	<?php 
	settings_fields( '??' ); // this will be used to save fields in the db?
	do_settings_sections( '??' ); // get the proper name of the settings section (from function that registers them)
	?>
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<label for="my_input" id="my_input">My first field</label>
  <input type="text" name="my_input" id="my_input" value="<?= get_option( 'my_input' ) ?>">
  <p class="description">
  <?php esc_html_e( 'Enter some text.', 'sample-oop-plugin' ); ?>
  </p>

	<label for="my_textarea" id="my_textarea">My first Textarea</label>
	<textarea id="my_textarea" name="my_textarea"><?= get_option( 'my_textarea' )?></textarea>
	<p class="description">
	<?php esc_html_e( 'Consectetur adipiscing elit.', 'sample-oop-plugin' ); ?>
	</p>
	<button type="submit">Submit</button>
</form>