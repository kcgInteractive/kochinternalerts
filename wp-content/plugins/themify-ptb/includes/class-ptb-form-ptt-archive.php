<?php

class PTB_Form_PTT_Archive extends PTB_Form_PTT_Them {

	public static $layouts = array(  'list-post' => 'checked', 'grid3' => '', 'grid2' => '', 'grid4' => '' );

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param string $plugin_name
	 * @param string $version
	 * @param PTB_Options $options the plugin options instance
	 * @param string themplate_id
	 *
	 */
	public function __construct( $plugin_name, $version, PTB_Options $options, $themplate_id ) {
		parent::__construct( $plugin_name, $version, $options, $themplate_id );

	}

	/**
	 * Arhive layout parametrs
	 *
	 * @since 1.0.0
	 */

	public function add_fields( $data = array() ) {
		$fieldname = $this->get_field_name( 'layout_post' );
		?>
		<div class="<?php echo $this->plugin_name ?>_lightbox_row <?php echo $this->plugin_name ?>_layout_post ">
			<div
				class="<?php echo $this->plugin_name ?>_lightbox_label"><?php  _e( 'Post Layout', 'ptb' ); ?></div>
			<div class="<?php echo $this->plugin_name ?>_lightbox_input">
				<?php foreach ( self::$layouts as $l => $ch ): ?>
					<?php $id = $this->get_field_id( 'layout_post_' . $l ); ?>
					<input id="<?php echo $id ?>" type="radio" value="<?php echo $l; ?>" name="<?php echo $fieldname ?>"
					       <?php if (( ! $data && $ch ) || ( isset( $data[ $fieldname ] ) && $data[ $fieldname ] == $l )): ?>checked="checked"<?php endif; ?>/>
					<label for="<?php echo $id ?>"
					       class="<?php echo $this->plugin_name ?>_grid <?php echo $this->plugin_name ?>_grid_<?php echo $l; ?>"></label>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="<?php echo $this->plugin_name ?>_lightbox_row <?php echo $this->plugin_name ?>_offset_post">
			<div
				class="<?php echo $this->plugin_name ?>_lightbox_label"><?php  _e( 'Post per page', 'ptb' ); ?></div>
			<div class="<?php echo $this->plugin_name ?>_lightbox_input">
				<?php $fieldname = $this->get_field_name( 'offset_post' ); ?>
				<input type="text" name="<?php echo $fieldname ?>"
				       <?php if ($data && isset( $data[ $fieldname ] )): ?>value="<?php echo $data[ $fieldname ] ?>"<?php endif; ?>/>
				<small><?php  _e( 'Leave blank to leave default setting (WordPress > Settings > Reading)', 'ptb' ); ?></small>
			</div>
		</div>
		<div class="<?php echo $this->plugin_name ?>_lightbox_row <?php echo $this->plugin_name ?>_orderby_post">
			<div
				class="<?php echo $this->plugin_name ?>_lightbox_label"><?php  _e( 'Order By', 'ptb' ); ?></div>
			<div class="<?php echo $this->plugin_name ?>_lightbox_input">
				<div class="<?php echo $this->plugin_name ?>_custom_select">
					<?php $fieldname = $this->get_field_name( 'orderby_post' ); ?>
					<select name="<?php echo $fieldname ?>">
						<option
							<?php if (isset( $data[ $fieldname ] ) && $data[ $fieldname ] == 'data'): ?>selected="selected"<?php endif; ?>
							value="date"><?php _e( 'Date', 'ptb' ); ?></option>
						<option
							<?php if (isset( $data[ $fieldname ] ) && $data[ $fieldname ] == 'id'): ?>selected="selected"<?php endif; ?>
							value="id"><?php _e( 'Id', 'ptb' ); ?></option>
						<option
							<?php if (isset( $data[ $fieldname ] ) && $data[ $fieldname ] == 'author'): ?>selected="selected"<?php endif; ?>
							value="author"><?php _e( 'Author', 'ptb' ); ?></option>
						<option
							<?php if (isset( $data[ $fieldname ] ) && $data[ $fieldname ] == 'title'): ?>selected="selected"<?php endif; ?>
							value="title"><?php _e( 'Title', 'ptb' ); ?></option>
						<option
							<?php if (isset( $data[ $fieldname ] ) && $data[ $fieldname ] == 'name'): ?>selected="selected"<?php endif; ?>
							value="name"><?php _e( 'Name', 'ptb' ); ?></option>
						<option
							<?php if (isset( $data[ $fieldname ] ) && $data[ $fieldname ] == 'modified'): ?>selected="selected"<?php endif; ?>
							value="modified"><?php _e( 'Modified', 'ptb' ); ?></option>
						<option
							<?php if (isset( $data[ $fieldname ] ) && $data[ $fieldname ] == 'rand'): ?>selected="selected"
							<?php endif; ?>value="rand"><?php _e( 'Rand', 'ptb' ); ?></option>
						<option
							<?php if (isset( $data[ $fieldname ] ) && $data[ $fieldname ] == 'comment_count'): ?>selected="selected"
							<?php endif; ?>value="comment_count"><?php _e( 'Comment count','ptb' ); ?></option>
					</select>
				</div>
			</div>
		</div>
		<div class="<?php echo $this->plugin_name ?>_lightbox_row <?php echo $this->plugin_name ?>_order_post">
			<div
				class="<?php echo $this->plugin_name ?>_lightbox_label"><?php  _e( 'Order', 'ptb' ); ?></div>
			<div class="<?php echo $this->plugin_name ?>_lightbox_input">
				<div class="<?php echo $this->plugin_name ?>_custom_select">
					<?php $fieldname = $this->get_field_name( 'order_post' ); ?>
					<select name="<?php echo $fieldname ?>">
						<option
							<?php if (isset( $data[ $fieldname ] ) && $data[ $fieldname ] == 'desc'): ?>selected="selected"<?php endif; ?>
							value="desc"><?php _e( 'Descending', 'ptb' ); ?></option>
						<option
							<?php if (isset( $data[ $fieldname ] ) && $data[ $fieldname ] == 'asc'): ?>selected="selected"<?php endif; ?>
							value="asc"><?php  _e( 'Ascending', 'ptb' ); ?></option>
					</select>
				</div>
			</div>
		</div>
		<?php

		$fieldname    = $this->get_field_name( 'pagination_post' );
		$field_id_yes = $this->get_field_id( 'pagination_post_yes' );
		$field_id_no  = $this->get_field_id( 'pagination_post_no' );
		?>
		<div class="<?php echo $this->plugin_name ?>_lightbox_row <?php echo $this->plugin_name ?>_pagination_post">
			<div
				class="<?php echo $this->plugin_name ?>_lightbox_label"><?php _e( 'Pagination', 'ptb'); ?></div>
			<div class="<?php echo $this->plugin_name ?>_lightbox_input">
				<input
					<?php if ( ! isset( $data[ $fieldname ] ) || ( isset( $data[ $fieldname ] ) && $data[ $fieldname ] == '1' )): ?>checked="checked"<?php endif; ?>
					type="radio" name="<?php echo $fieldname ?>" value="1" id="<?php echo $field_id_yes ?>"/>
				<label for="<?php echo $field_id_yes; ?>"><?php _e( 'Yes', 'ptb' ); ?></label>
				<input
					<?php if (isset( $data[ $fieldname ] ) && $data[ $fieldname ] == '0'): ?>checked="checked"<?php endif; ?>
					type="radio" name="<?php echo $fieldname ?>" value="0" id="<?php echo $field_id_no; ?>"/>
				<label for="<?php echo $field_id_no ?>"><?php _e( 'No', 'ptb' ); ?></label>
			</div>
		</div>
	<?php
	}


	/**
	 * Get layout
	 *
	 * @since 1.0.0
	 */
	public function get_layout() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . '/admin/partials/ptb-admin-display-edit-ptt-archive.php';
	}
}