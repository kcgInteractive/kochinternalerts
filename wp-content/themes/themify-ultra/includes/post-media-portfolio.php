<?php 
/**
 * Media Template.
 * If there's a Video URL in Themify Custom Panel it will show it, otherwise shows the featured image.
 * @package themify
 * @since 1.0.0
 */

/** Themify Default Variables
 *  @var object */
global $themify; ?>

<?php if ( $themify->hide_image != 'yes' ) : ?>
		
	<?php themify_before_post_image(); // Hook ?>

	<?php
	if ( themify_get( 'video_url' ) != '' ) : ?>

		<figure class="post-image">
			<?php
				global $wp_embed;
				echo $wp_embed->run_shortcode('[embed]' . themify_get('video_url') . '[/embed]');
			?>
		</figure>

	<?php else: ?>

		<?php
		if ( 'yes' == $themify->use_original_dimensions ) {
			$themify->width = themify_get( 'image_width' );
			$themify->height = themify_get( 'image_height' );
		}
		?>

		<?php if( $post_image = themify_get_image( 'ignore=true&w='.$themify->width.'&h='.$themify->height ) ) : ?>
		
			<figure class="post-image <?php echo $themify->image_align; ?>">

				<?php if ( $themify->unlink_image != 'yes' ) : ?>
					<a href="<?php echo themify_get_featured_image_link(); ?>" class="themify-lightbox">
				<?php endif; ?>
					<?php echo wp_kses_post( $post_image ); ?>
				<?php if ( $themify->hide_image != 'yes' ) : ?>
					<?php themify_zoom_icon(); ?>
				</a>
				<?php endif; ?>

			</figure>
	
		<?php endif; // if there's a featured image?>

	<?php endif; // video else image ?>

	<?php themify_after_post_image(); // Hook ?>

<?php endif; // hide image ?>