<?php if(!is_single()) { global $more; $more = 0; } //enable more link ?>
<?php
/** Themify Default Variables
 *  @var object */
global $themify; ?>

<?php themify_post_before(); //hook ?>

<?php 
$categories = wp_get_object_terms(get_the_ID(), 'portfolio-category');
$class = '';
foreach($categories as $cat){
	$class .= ' cat-'.$cat->term_id;
}
?>

<article itemscope itemtype="http://schema.org/Article" id="portfolio-<?php the_ID(); ?>" class="<?php echo implode(' ', get_post_class('post clearfix portfolio-post' . $class)); ?>">

	<?php if ( is_singular( 'portfolio' ) ) : ?>

			<?php if ( $themify->hide_meta != 'yes' ): ?>
				<p class="post-meta entry-meta">
					<?php the_terms( get_the_ID(), get_post_type() . '-category', '<span class="post-category">', ' <span class="separator">/</span> ', ' </span>' ) ?>
				</p>
			<?php endif; //post meta ?>
		
			<?php if($themify->hide_title != 'yes'): ?>
				<<?php themify_theme_entry_title_tag(); ?> class="post-title entry-title" itemprop="name">
					<?php if($themify->unlink_title == 'yes'): ?>
						<?php the_title(); ?>
					<?php else: ?>
						<a href="<?php echo themify_get_featured_image_link(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
					<?php endif; //unlink post title ?>
				</<?php themify_theme_entry_title_tag(); ?>>
			<?php endif; //post title ?>

			<?php
			$client = get_post_meta( get_the_ID(), 'project_client', true );
			$services = get_post_meta( get_the_ID(), 'project_services', true );
			$date = get_post_meta( get_the_ID(), 'project_date', true );
			$launch = get_post_meta( get_the_ID(), 'project_launch', true );
			if ( $client || $services || $date || $launch ) : ?>
				<div class="project-meta">
					<?php if ( $client ) : ?>
						<div class="project-client">
							<strong><?php _e( 'Client', 'themify' ); ?></strong>
							<?php echo wp_kses_post( $client ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $services ) : ?>
						<div class="project-services">
							<strong><?php _e( 'Services', 'themify' ); ?></strong>
							<?php echo wp_kses_post( $services ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $date ): ?>
						<div class="project-date">
							<strong><?php _e( 'Date', 'themify' ); ?></strong>
							<?php echo wp_kses_post( $date ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $launch ) : ?>
						<div class="project-view">
							<strong><?php _e( 'View', 'themify' ); ?></strong>
							<a href="<?php echo esc_attr( $launch ); ?>"><?php _e( 'Launch Project', 'themify' ); ?></a>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; // $client || $services || $date || $launch ?>
		
	<?php endif; // is singular portfolio ?>

	<?php if ( ! is_singular( 'portfolio' ) ) : ?>

		<?php if( $themify->hide_image != 'yes' ) : ?>
			<?php get_template_part( 'includes/post-media', get_post_type() ); ?>
		<?php endif //hide image ?>

	<?php endif; // not singular portfolio ?>

	<div class="post-content">

		<?php if ( ! is_singular( 'portfolio' ) ) : ?>
			<div class="disp-table">
				<div class="disp-row">
					<div class="disp-cell valignmid">

						<?php if ( $themify->hide_meta != 'yes' ): ?>
							<p class="post-meta entry-meta">
								<?php the_terms( get_the_ID(), get_post_type() . '-category', '<span class="post-category">', ' <span class="separator">/</span> ', ' </span>' ) ?>
							</p>
						<?php endif; //post meta ?>
			
						<?php if($themify->hide_title != 'yes'): ?>
							<h2 class="post-title entry-title" itemprop="name">
								<?php if($themify->unlink_title == 'yes'): ?>
									<?php the_title(); ?>
								<?php else: ?>
									<a href="<?php echo themify_get_featured_image_link(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
								<?php endif; //unlink post title ?>
							</h2>
						<?php endif; //post title ?>

		<?php endif; // is singular portfolio ?>

						<div class="entry-content" itemprop="articleBody">

							<?php if ( 'excerpt' == $themify->display_content && ! is_attachment() ) : ?>

								<?php the_excerpt(); ?>

							<?php elseif ( 'none' == $themify->display_content && ! is_attachment() ) : ?>

							<?php else: ?>

								<?php the_content(themify_check('setting-default_more_text')? themify_get('setting-default_more_text') : __('More &rarr;', 'themify')); ?>

							<?php endif; //display content ?>

						</div><!-- /.entry-content -->

						<?php edit_post_link(__('Edit', 'themify'), '<span class="edit-button">[', ']</span>'); ?>

		<?php if ( ! is_singular( 'portfolio' ) ) : ?>

					</div>
					<!-- /.disp-cell -->
				</div>
				<!-- /.disp-row -->
			</div>
			<!-- /.disp-table -->
		<?php endif; // is singular portfolio ?>

	</div>
	<!-- /.post-content -->
</article>
<!-- /.post -->

<?php themify_post_after(); //hook ?>