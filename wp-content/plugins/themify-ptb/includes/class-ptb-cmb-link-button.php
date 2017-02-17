<?php
/**
 * Custom meta box class of type Link Button
 *
 * @link       http://themify.me
 * @since      1.0.0
 *
 * @package    PTB
 * @subpackage PTB/includes
 */

/**
 * Custom meta box class of type Link Button
 *
 *
 * @package    PTB
 * @subpackage PTB/includes
 * @author     Themify <ptb@themify.me>
 */
class PTB_CMB_Link_Button extends PTB_CMB_Base {

	/**
	 * Adds the custom meta type to the plugin meta types array
	 *
	 * @since 1.0.0
	 *
	 * @param array $cmb_types Array of custom meta types of plugin
	 *
	 * @return array
	 */
	public function filter_register_custom_meta_box_type( $cmb_types ) {

		$cmb_types[ $this->get_type() ] = array(
			'name' => __( 'Link Button', 'ptb' )
		);

		return $cmb_types;

	}

	/**
	 * Renders the meta boxes on post edit dashboard
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Post $post
	 * @param string $meta_key the same as meta box internal id
	 * @param array $args
	 */
	public function render_post_type_meta( $post, $meta_key, $args ) {

		$wp_meta_key = sprintf( '%s_%s', $this->get_plugin_name(), $meta_key );

		$value = get_post_meta( $post->ID, $wp_meta_key, true );
		$name  = esc_attr( sprintf( '%s[]', $meta_key ) );

		?>
		<div class="ptb_table_row">
			<input name="<?php print( $name ); ?>" type="text" value="<?php ! empty( $value ) && print( $value[0] ) ?>"
			       class="ptb_table_cell ptb_post_cmb_link_button_text"/>

			<div class="ptb_table_cell ptb_table_fill">
				<div class="ptb_table ptb_table_fill">
					<span class="ptb_table_cell ptb_post_cmb_link_button_link_label"><?php _e( 'Link','ptb' ) ?><span
							class="ti-arrow-right"></span></span>
					<input name="<?php print( $name ); ?>" type="text"
					       value="<?php ! empty( $value ) && print( $value[1] ) ?>"/>
				</div>
			</div>
		</div>
	<?php


	}

	/**
	 * Renders the meta boxes for themplates
	 *
	 * @since 1.0.0
	 *
	 * @param string $id the metabox id
	 * @param string $type the type of the page(Arhive or Single)
	 * @param array $args Array of custom meta types of plugin
	 * @param array $data saved data
	 * @param array $languages languages array
	 */
	public function action_them_themplate( $id, $type, $args, $data = array(), array $languages = array() ) {
		$pluginame = $this->get_plugin_name();
		?>
		<div class="<?php echo $pluginame ?>_back_active_module_row">
                    <div class="<?php echo $pluginame ?>_back_active_module_label">
                        <label for="<?php echo $pluginame?>_<?php echo $id?>_link_color"><?php  _e( 'Button Color', 'ptb' ) ?></label>
                    </div>
			<div class="<?php echo $pluginame ?>_back_active_module_input">
				<div class="<?php echo $pluginame ?>_custom_select">
					<select id="<?php echo $pluginame?>_<?php echo $id?>_link_color" name="[<?php echo $id ?>][color]">
						<option
							<?php if (isset( $data['color'] ) && $data['color'] == '#b5e4fb'): ?>selected="selected"<?php endif; ?>
							value="#b5e4fb"><?php  _e( 'blue', 'ptb' ) ?></option>
						<option
							<?php if (isset( $data['color'] ) && $data['color'] == '#4EB59D'): ?>selected="selected"<?php endif; ?>
							value="#4EB59D"><?php  _e( 'green', 'ptb' ) ?></option>
						<option
							<?php if (isset( $data['color'] ) && $data['color'] == '#ff0000'): ?>selected="selected"<?php endif; ?>
							value="#ff0000"><?php  _e( 'red', 'ptb' ) ?></option>
						<option
							<?php if (isset( $data['color'] ) && $data['color'] == '#fff'): ?>selected="selected"<?php endif; ?>
							value="#fff"><?php  _e( 'white', 'ptb' ) ?>
						</option>
						<option
							<?php if (isset( $data['color'] ) && $data['color'] == '#000'): ?>selected="selected"<?php endif; ?>
							value="#000"><?php  _e( 'black', 'ptb' ) ?></option>
					</select>
				</div>
			</div>
		</div>
                <?php
                self::module_text_before_after( $id, $data, $languages );
		self::module_text_before_after( $id, $data, $languages, false );
                ?>
	<?php
	}

	/**
	 * Renders the meta boxes  in public
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Array of custom meta types of plugin
	 * @param array $data themplate data
	 * @param array $meta_data post data
	 * @param string $lang language code
	 * @param boolean $is_single single page
	 */
	public function action_public_themplate( $args, $data, $meta_data, $lang = false, $is_single = false ) {
		$pluginame = $this->get_plugin_name();

		if ( ! empty( $meta_data ) ) {
			if ( isset( $data['text_before'][ $lang ] ) ) {
				$this->get_text_before( $data['text_before'][ $lang ] );
			}
			?>
			<div class="<?php echo $pluginame ?>_link">
				<a style="color:<?php echo $data['color'] ?>"
				   href="<?php echo $meta_data[1] ?>"><?php echo $meta_data[0] ?></a>
			</div>
			<?php
			if ( isset( $data['text_after'][ $lang ] ) ) {
				$this->get_text_after( $data['text_after'][ $lang ] );
			}
		}
	}

}