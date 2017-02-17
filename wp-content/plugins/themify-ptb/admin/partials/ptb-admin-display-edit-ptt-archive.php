<?php

/**
 * Post Type Template Archive edit page
 *
 *
 * @link       http://themify.me
 * @since      1.0.0
 *
 * @package    PTB
 * @subpackage PTB/admin/partials
 */
?>

<form method="post"
      action="<?php echo admin_url( 'admin-ajax.php?action=' . $this->plugin_name . '_ajax_themes_save' ) ?>">
	<input type="hidden" value="<?php echo wp_create_nonce( $this->plugin_name . '_them_ajax' ); ?>"
	       name="<?php echo $this->plugin_name ?>_nonce"/>
	<?php do_settings_sections( $this->settings_section ) ?>

	<?php
            submit_button( __( 'Save', 'ptb' ) );
	?>
        <div id="<?= $this->plugin_name ?>_success_text" class="updated"></div>
</form>

<script type="text/javascript">
	jQuery(function () {
		PTB.init({
			prefix: '<?php echo $this->plugin_name?>'
		});
	});
</script>
