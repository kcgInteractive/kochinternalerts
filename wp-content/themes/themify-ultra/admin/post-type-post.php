<?php
/**
 * Post Meta Box Options
 * @param array $args
 * @return array
 * @since 1.0.0
 */
function themify_theme_post_meta_box( $args = array() )  {
	return array(
		// Layout
		array(
			'name' 		=> 'layout',
			'title' 		=> __('Sidebar Option', 'themify'),
			'description' => '',
			'type' 		=> 'layout',
			'show_title' => true,
			'meta'		=> array(
				array('value' => 'default', 'img' => 'images/layout-icons/default.png', 'selected' => true, 'title' => __('Default', 'themify')),
				array('value' => 'sidebar1', 'img' => 'images/layout-icons/sidebar1.png', 'title' => __('Sidebar Right', 'themify')),
				array('value' => 'sidebar1 sidebar-left', 'img' => 'images/layout-icons/sidebar1-left.png', 'title' => __('Sidebar Left', 'themify')),
				array('value' => 'sidebar-none', 'img' => 'images/layout-icons/sidebar-none.png', 'title' => __('No Sidebar ', 'themify'))
			)
		),
		// Content Width
		array(
			'name'=> 'content_width',
			'title' => __('Content Width', 'themify'),
			'description' => '',
			'type' => 'layout',
			'show_title' => true,
			'meta' => array(
				array(
					'value' => 'default_width',
					'img' => 'themify/img/default.png',
					'selected' => true,
					'title' => __( 'Default', 'themify' )
				),
				array(
					'value' => 'full_width',
					'img' => 'themify/img/fullwidth.png',
					'title' => __( 'Fullwidth', 'themify' )
				)
			)
		),
		// Post Image
		array(
			'name' 		=> 'post_image',
			'title' 		=> __('Featured Image', 'themify'),
			'description' => '',
			'type' 		=> 'image',
			'meta'		=> array()
		),
		// Featured Image Size
		array(
			'name'	=>	'feature_size',
			'title'	=>	__('Image Size', 'themify'),
			'description' => sprintf(__('Image sizes can be set at <a href="%s">Media Settings</a> and <a href="%s">Regenerated</a>', 'themify'), 'options-media.php', 'admin.php?page=regenerate-thumbnails'),
			'type'		 =>	'featimgdropdown'
		),
		// Multi field: Image Dimension
		themify_image_dimensions_field(),
		// Image Filter
		array(
			'name'        => 'imagefilter_options',
			'title'       => __( 'Image Filter', 'themify' ),
			'description' => '',
			'type'        => 'dropdown',
			'meta'        => array(
				array( 'name' => '', 'value' => 'initial' ),
				array( 'name' => __( 'None', 'themify' ), 'value' => 'none' ),
				array( 'name' => __( 'Grayscale', 'themify' ), 'value' => 'grayscale' ),
				array( 'name' => __( 'Sepia', 'themify' ), 'value' => 'sepia' ),
				array( 'name' => __( 'Blur', 'themify' ), 'value' => 'blur' ),
			),
		),
		// Image Hover Filter
		array(
			'name'        => 'imagefilter_options_hover',
			'title'       => __( 'Image Hover Filter', 'themify' ),
			'description' => '',
			'type'        => 'dropdown',
			'meta'        => array(
				array( 'name' => '', 'value' => 'initial' ),
				array( 'name' => __( 'None', 'themify' ), 'value' => 'none' ),
				array( 'name' => __( 'Grayscale', 'themify' ), 'value' => 'grayscale' ),
				array( 'name' => __( 'Sepia', 'themify' ), 'value' => 'sepia' ),
				array( 'name' => __( 'Blur', 'themify' ), 'value' => 'blur' ),
			),
		),
		// Image Filter Apply To
		array(
			'name'        => 'imagefilter_applyto',
			'title'       => __( 'Apply to', 'themify' ),
			'description' => sprintf( __( 'Theme Default = can be set in <a href="%s" target="_blank">Themify > Settings > Theme Settings</a>', 'themify' ), admin_url( 'admin.php?page=themify#setting-theme_settings' ) ),
			'type'        => 'radio',
			'meta'        => array(
				array( 'value' => 'initial', 'name' => __( 'Theme Default', 'themify' ), 'selected' => true ),
				array( 'value' => 'featured-only', 'name' => __( 'Featured Images Only', 'themify' ), ),
				array( 'value' => 'all', 'name' => __( 'All Images', 'themify' ) )
			),
		),
		// Hide Post Title
		array(
			'name' 		=> 'hide_post_title',
			'title' 		=> __('Hide Post Title', 'themify'),
			'description' => '',
			'type' 		=> 'dropdown',
			'meta'		=> array(
				array('value' => 'default', 'name' => '', 'selected' => true),
				array('value' => 'yes', 'name' => __('Yes', 'themify')),
				array('value' => 'no',	'name' => __('No', 'themify'))
			)
		),
		// Unlink Post Title
		array(
			'name' 		=> 'unlink_post_title',
			'title' 		=> __('Unlink Post Title', 'themify'),
			'description' => __('Unlink post title (it will display the post title without link)', 'themify'),
			'type' 		=> 'dropdown',
			'meta'		=> array(
				array('value' => 'default', 'name' => '', 'selected' => true),
				array('value' => 'yes', 'name' => __('Yes', 'themify')),
				array('value' => 'no',	'name' => __('No', 'themify'))
			)
		),
		// Multi field: Hide Post Meta
		themify_multi_meta_field(),
		// Hide Post Date
		array(
			'name' 		=> 'hide_post_date',
			'title' 		=> __('Hide Post Date', 'themify'),
			'description' => '',
			'type' 		=> 'dropdown',
			'meta'		=> array(
				array('value' => 'default', 'name' => '', 'selected' => true),
				array('value' => 'yes', 'name' => __('Yes', 'themify')),
				array('value' => 'no',	'name' => __('No', 'themify'))
			)
		),
		// Hide Post Image
		array(
			'name' 		=> 'hide_post_image',
			'title' 		=> __('Hide Featured Image', 'themify'),
			'description' => '',
			'type' 		=> 'dropdown',
			'meta'		=> array(
				array('value' => 'default', 'name' => '', 'selected' => true),
				array('value' => 'yes', 'name' => __('Yes', 'themify')),
				array('value' => 'no',	'name' => __('No', 'themify'))
			)
		),
		// Unlink Post Image
		array(
			'name' 		=> 'unlink_post_image',
			'title' 		=> __('Unlink Featured Image', 'themify'),
			'description' => __('Display the Featured Image without link', 'themify'),
			'type' 		=> 'dropdown',
			'meta'		=> array(
				array('value' => 'default', 'name' => '', 'selected' => true),
				array('value' => 'yes', 'name' => __('Yes', 'themify')),
				array('value' => 'no',	'name' => __('No', 'themify'))
			)
		),
		// Video URL
		array(
			'name' 		=> 'video_url',
			'title' 		=> __('Video URL', 'themify'),
			'description' => __('Replace Featured Image with a video embed URL such as YouTube or Vimeo video url (<a href="http://themify.me/docs/video-embeds">details</a>).', 'themify'),
			'type' 		=> 'textbox',
			'meta'		=> array()
		),
		// External Link
		array(
			'name' 		=> 'external_link',
			'title' 		=> __('External Link', 'themify'),
			'description' => __('Link Featured Image and Post Title to external URL', 'themify'),
			'type' 		=> 'textbox',
			'meta'		=> array()
		),
		// Lightbox Link + Zoom icon
		themify_lightbox_link_field(),
		// Custom menu
		array(
			'name'        => 'custom_menu',
			'title'       => __( 'Custom Menu', 'themify' ),
			'description' => '',
			'type'        => 'dropdown',
			// extracted from $args
			'meta'        => $args['nav_menus'],
		),
	);
}

/**
 * Theme Appearance Tab for Themify Custom Panel
 *
 * @since 1.0.0
 *
 * @param array $args
 *
 * @return array
 */
function themify_theme_post_theme_design_meta_box( $args = array() ) {
	return array(
		// Background Color
		array(
			'name'        => 'body_background_color',
			'title'       => __( 'Body Background', 'themify' ),
			'description' => '',
			'type'        => 'color',
			'meta'        => array( 'default' => null ),
		),
		// Background image
		array(
			'name'        => 'body_background_image',
			'title'       => '',
			'type'        => 'image',
			'description' => '',
			'meta'        => array(),
			'before'      => '',
			'after'       => '',
		),
		// Background repeat
		array(
			'name'        => 'body_background_repeat',
			'title'       => '',
			'description' => __( 'Background Repeat', 'themify' ),
			'type'        => 'dropdown',
			'meta'        => array(
				array(
					'value' => 'fullcover',
					'name'  => __( 'Fullcover', 'themify' )
				),
				array(
					'value' => 'repeat',
					'name'  => __( 'Repeat', 'themify' )
				),
				array(
					'value' => 'no-repeat',
					'name'  => __( 'No Repeat', 'themify' )
				),
				array(
					'value' => 'repeat-x',
					'name'  => __( 'Repeat horizontally', 'themify' )
				),
				array(
					'value' => 'repeat-y',
					'name'  => __( 'Repeat vertically', 'themify' )
				),
			),
		),
		// Accent Color Mode, Presets or Custom
		array(
			'name'          => 'color_scheme_mode',
			'title'         => __( 'Accent Color', 'themify' ),
			'description'   => '',
			'type'          => 'radio',
			'show_title'    => true,
			'meta'          => array(
				array(
					'value'    => 'color-presets',
					'name'     => __( 'Presets', 'themify' ),
					'selected' => true
				),
				array(
					'value' => 'color-custom',
					'name' => __( 'Custom', 'themify' ),
				),
			),
			'enable_toggle' => true,
		),
		// Theme Color
		array(
			'name'        => 'color_design',
			'title'       => '',
			'description' => '',
			'type'        => 'layout',
			'show_title'  => true,
			'meta'        => $args['color_design_options'],
			'toggle'	=> 'color-presets-toggle',
		),
		// Accent Color
		array(
			'name'        => 'scheme_color',
			'title'       => '',
			'description' => '',
			'type'        => 'color',
			'meta'        => array( 'default' => null ),
			'after'		  => __( 'Accent Font Color', 'themify' ),
			'toggle'	=> 'color-custom-toggle',
		),
		array(
			'name'        => 'scheme_link',
			'title'       => '',
			'description' => '',
			'type'        => 'color',
			'meta'        => array( 'default' => null ),
			'after'		  => __( 'Accent Link Color', 'themify' ),
			'toggle'	=> 'color-custom-toggle',
		),
		array(
			'name'        => 'scheme_background',
			'title'       => '',
			'description' => '',
			'type'        => 'color',
			'meta'        => array( 'default' => null ),
			'after'		  => __( 'Accent Background Color', 'themify' ),
			'toggle'	=> 'color-custom-toggle',
		),

		// Typography Mode, Presets or Custom
		array(
			'name'          => 'typography_mode',
			'title'         => __( 'Typography', 'themify' ),
			'description'   => '',
			'type'          => 'radio',
			'show_title'    => true,
			'meta'          => array(
				array(
					'value'    => 'typography-presets',
					'name'     => __( 'Presets', 'themify' ),
					'selected' => true
				),
				array(
					'value' => 'typography-custom',
					'name' => __( 'Custom', 'themify' ),
				),
			),
			'enable_toggle' => true,
		),
		// Typography
		array(
			'name'        => 'font_design',
			'title'       => '',
			'description' => '',
			'type'        => 'layout',
			'show_title'  => true,
			'meta'        => $args['font_design_options'],
			'toggle'	  => 'typography-presets-toggle',
		),
		// Body font
		array(
			'name'        => 'body_font',
			'title'       => '',
			'description' => '',
			'type'        => 'dropdown',
			'meta'        => array_merge( themify_get_web_safe_font_list(), themify_get_google_web_fonts_list() ),
			'after'		  => ' ' . __( 'Body Font', 'themify' ),
			'toggle'	  => 'typography-custom-toggle',
		),
		// Body wrap text color
		array(
			'name'        => 'body_text_color',
			'title'       => '',
			'description' => '',
			'type'        => 'color',
			'meta'        => array( 'default' => null ),
			'after'		  => __( 'Body Font Color', 'themify' ),
			'toggle'	  => 'typography-custom-toggle',
		),
		// Body wrap link color
		array(
			'name'        => 'body_link_color',
			'title'       => '',
			'description' => '',
			'type'        => 'color',
			'meta'        => array( 'default' => null ),
			'after'		  => __( 'Body Link Color', 'themify' ),
			'toggle'	  => 'typography-custom-toggle',
		),
		// Heading font
		array(
			'name'        => 'heading_font',
			'title'       => '',
			'description' => '',
			'type'        => 'dropdown',
			'meta'        => array_merge( themify_get_web_safe_font_list(), themify_get_google_web_fonts_list() ),
			'after'		  => ' ' . __( 'Heading (h1 to h6)', 'themify' ),
			'toggle'	  => 'typography-custom-toggle',
		),
		// Heading color
		array(
			'name'        => 'heading_color',
			'title'       => '',
			'description' => '',
			'type'        => 'color',
			'meta'        => array( 'default' => null ),
			'after'		  => __( 'Heading Font Color', 'themify' ),
			'toggle'	  => 'typography-custom-toggle',
		),

		// Header Design
		array(
			'name'        => 'header_design',
			'title'       => __( 'Header Design', 'themify' ),
			'description' => '',
			'type'        => 'layout',
			'show_title'  => true,
			'meta'        => $args['header_design_options'],
			'hide'		  => 'none header-leftpane header-minbar boxed-content',
		),
		// Sticky Header
		array(
			'name'        => 'fixed_header',
			'title'       => __( 'Sticky Header', 'themify' ),
			'description' => '',
			'type'		  => 'radio',
			'meta'		  => themify_ternary_options(),
			'class'		  => 'hide-if none header-leftpane header-minbar boxed-content',
		),
		// Full Height Header
		array(
			'name'        => 'full_height_header',
			'title'       => __( 'Full Height Header', 'themify' ),
			'description' => __( 'Full height will display the container in 100% viewport height', 'themify' ),
			'type'		  => 'radio',
			'meta'		  => themify_ternary_options(),
			'class'		  => 'hide-if none header-horizontal header-leftpane header-minbar boxed-content',
		),
        // Header Elements
		array(
			'name' 	=> '_multi_header_elements',	
			'title' => __('Header Elements', 'themify'), 	
			'description' => '',	
			'type' 	=> 'multi',
			'class' => 'hide-if none',		
			'meta'	=> array(
				'fields' => array(
					// Show Site Logo
					array(
						'name' 	=> 'exclude_site_logo',
						'description' => '',
						'title' => __( 'Show Site Logo', 'themify' ),
						'type' 	=> 'dropdownbutton',
						'states' => themify_ternary_states( array(
							'icon_no' => THEMIFY_URI . '/img/ddbtn-check.png',
							'icon_yes' => THEMIFY_URI . '/img/ddbtn-cross.png', 
							) ),
						'class' => 'hide-if none',
						'after' => '<div class="clear"></div>',
					),
					// Show Site Tagline
					array(
						'name' 	=> 'exclude_site_tagline',
						'description' => '',
						'title' => __( 'Show Site Tagline', 'themify' ),
						'type' 	=> 'dropdownbutton',
						'states' => themify_ternary_states( array(
							'icon_no' => THEMIFY_URI . '/img/ddbtn-check.png',
							'icon_yes' => THEMIFY_URI . '/img/ddbtn-cross.png', 
							) ),
						'class' => 'hide-if none',
						'after' => '<div class="clear"></div>',
					),
					// Show Search Form
					array(
						'name' 	=> 'exclude_search_form',
						'description' => '',
						'title' => __( 'Show Search Form', 'themify' ),
						'type' 	=> 'dropdownbutton',
						'states' => themify_ternary_states( array(
							'icon_no' => THEMIFY_URI . '/img/ddbtn-check.png',
							'icon_yes' => THEMIFY_URI . '/img/ddbtn-cross.png', 
							) ),
						'class' => 'hide-if none',
						'after' => '<div class="clear"></div>',
					),
					// Show RSS Link
					array(
						'name' 	=> 'exclude_rss',
						'description' => '',
						'title' => __( 'Show RSS Link', 'themify' ),
						'type' 	=> 'dropdownbutton',
						'states' => themify_ternary_states( array(
							'icon_no' => THEMIFY_URI . '/img/ddbtn-check.png',
							'icon_yes' => THEMIFY_URI . '/img/ddbtn-cross.png', 
							) ),
						'class' => 'hide-if none',
						'after' => '<div class="clear"></div>',
					),
					// Show Header Widgets
					array(
						'name' 	=> 'exclude_header_widgets',
						'description' => '',
						'title' => __( 'Show Header Widgets', 'themify' ),
						'type' 	=> 'dropdownbutton',
						'states' => themify_ternary_states( array(
							'icon_no' => THEMIFY_URI . '/img/ddbtn-check.png',
							'icon_yes' => THEMIFY_URI . '/img/ddbtn-cross.png', 
							) ),
						'class' => 'hide-if none',
						'after' => '<div class="clear"></div>',
					),
					// Show Social Widget
					array(
						'name' 	=> 'exclude_social_widget',
						'description' => '',
						'title' => __( 'Show Social Widget', 'themify' ),
						'type' 	=> 'dropdownbutton',
						'states' => themify_ternary_states( array(
							'icon_no' => THEMIFY_URI . '/img/ddbtn-check.png',
							'icon_yes' => THEMIFY_URI . '/img/ddbtn-cross.png', 
							) ),
						'class' => 'hide-if none',
						'after' => '<div class="clear"></div>',
					),
					// Show Menu Navigation
					array(
						'name' 	=> 'exclude_menu_navigation',
						'description' => '',
						'title' => __( 'Show Menu Navigation', 'themify' ),
						'type' 	=> 'dropdownbutton',
						'states' => themify_ternary_states( array(
							'icon_no' => THEMIFY_URI . '/img/ddbtn-check.png',
							'icon_yes' => THEMIFY_URI . '/img/ddbtn-cross.png', 
							) ),
						'class' => 'hide-if none',
						'after' => '<div class="clear"></div>',
					),
				),
				'description' => '',
				'before' => '',
				'after' => '<div class="clear"></div>',
				'separator' => ''
			)
		),
		// Header Wrap
		array(
			'name'          => 'header_wrap',
			'title'         => __( 'Header Background', 'themify' ),
			'description'   => '',
			'type'          => 'radio',
			'show_title'    => true,
			'meta'          => array(
				array(
					'value'    => 'solid',
					'name'     => __( 'Solid Background', 'themify' ),
					'selected' => true
				),
				array(
					'value' => 'transparent',
					'name'  => __( 'Transparent Background', 'themify' ),
				),
				array(
					'value' => 'slider',
					'name' => __( 'Slider', 'themify' ),
				),
				array(
					'value' => 'video',
					'name' => __( 'Video', 'themify' ),
				),
				array(
					'value' => 'colors',
					'name' => __( 'Animating Colors', 'themify' ),
				),
			),
			'enable_toggle' => true,
			'class'     => 'hide-if none clear',
		),
		// Animated Colors
		array(
			'name' 		=> '_animated_colors',
			'title'		=> __('Animating Colors', 'themify'),
			'description' => sprintf( __('Animating Colors can be configured at <a href="%s">Themify > Settings > Theme Settings</a>', 'themify'), esc_url( add_query_arg( 'page', 'themify', admin_url( 'admin.php' ) ) ) ),
			'type' 		=> 'post_id_info',
			'toggle'	=> 'colors-toggle',
		),
		// Select Background Gallery
		array(
			'name' 		=> 'background_gallery',
			'title'		=> __('Header Slider', 'themify'),
			'description' => '',
			'type' 		=> 'gallery_shortcode',
			'toggle'	=> 'slider-toggle',
		),
		array(
			'type' => 'multi',
			'name' => '_video_select',
			'title' => __('Video', 'themify'),
			'meta' => array(
				'fields' => array(
					// Video File
					array(
						'name' 		=> 'video_file',
						'title' 	=> __('Video File', 'themify'),
						'description' => '',
						'type' 		=> 'video',
						'meta'		=> array(),
					),
				),
				'description' => __('Video format: mp4. Note: video background does not play on mobile, background image will be used as fallback.', 'themify'),
				'before' => '',
				'after' => '',
				'separator' => ''
			),
			'toggle'	=> 'video-toggle'
		),
		// Background Color
		array(
			'name'        => 'background_color',
			'title'       => '',
			'description' => '',
			'type'        => 'color',
			'meta'        => array( 'default' => null ),
			'toggle'      => array( 'solid-toggle', 'slider-toggle', 'video-toggle' ),
			'class'     => 'hide-if none',
		),
		// Background image
		array(
			'name'        => 'background_image',
			'title'       => '',
			'type'        => 'image',
			'description' => '',
			'meta'        => array(),
			'before'      => '',
			'after'       => '',
			'toggle'      => array( 'solid-toggle', 'video-toggle' ),
			'class'     => 'hide-if none',
		),
		// Background repeat
		array(
			'name'        => 'background_repeat',
			'title'       => '',
			'description' => __( 'Background Repeat', 'themify' ),
			'type'        => 'dropdown',
			'meta'        => array(
				array(
					'value' => 'fullcover',
					'name'  => __( 'Fullcover', 'themify' )
				),
				array(
					'value' => 'repeat',
					'name'  => __( 'Repeat', 'themify' )
				),
				array(
					'value' => 'no-repeat',
					'name'  => __( 'No Repeat', 'themify' )
				),
				array(
					'value' => 'repeat-x',
					'name'  => __( 'Repeat horizontally', 'themify' )
				),
				array(
					'value' => 'repeat-y',
					'name'  => __( 'Repeat vertically', 'themify' )
				),
			),
			'toggle'      => array( 'solid-toggle', 'video-toggle' ),
			'class'     => 'hide-if none',
		),
		// Header wrap text color
		array(
			'name'        => 'headerwrap_text_color',
			'title'       => __( 'Header Text Color', 'themify' ),
			'description' => '',
			'type'        => 'color',
			'meta'        => array( 'default' => null ),
			'class'     => 'hide-if none',
		),
		// Header wrap link color
		array(
			'name'        => 'headerwrap_link_color',
			'title'       => __( 'Header Link Color', 'themify' ),
			'description' => '',
			'type'        => 'color',
			'meta'        => array( 'default' => null ),
			'class'     => 'hide-if none',
		),
		// Footer Design
		array(
			'name'        => 'footer_design',
			'title'       => __( 'Footer Design', 'themify' ),
			'description' => '',
			'type'        => 'layout',
			'show_title'  => true,
			'meta'        => $args['footer_design_options'],
			'hide'		  => 'none',
		),
		// Footer Elements
		array(
			'name' 	=> '_multi_footer_elements',	
			'title' => __('Footer Elements', 'themify'), 	
			'description' => '',	
			'type' 	=> 'multi',
			'class' => 'hide-if none',		
			'meta'	=> array(
				'fields' => array(
					// Show Site Logo
					array(
						'name' 	=> 'exclude_footer_site_logo',
						'description' => '',
						'title' => __( 'Show Site Logo', 'themify' ),
						'type' 	=> 'dropdownbutton',
						'states' => themify_ternary_states( array(
							'icon_no' => THEMIFY_URI . '/img/ddbtn-check.png',
							'icon_yes' => THEMIFY_URI . '/img/ddbtn-cross.png', 
							) ),
						'class' => 'hide-if none',
						'after' => '<div class="clear"></div>',
					),
					// Show Footer Widgets
					array(
						'name' 	=> 'exclude_footer_widgets',
						'description' => '',
						'title' => __( 'Show Footer Widgets', 'themify' ),
						'type' 	=> 'dropdownbutton',
						'states' => themify_ternary_states( array(
							'icon_no' => THEMIFY_URI . '/img/ddbtn-check.png',
							'icon_yes' => THEMIFY_URI . '/img/ddbtn-cross.png', 
							) ),
						'class' => 'hide-if none',
						'after' => '<div class="clear"></div>',
					),
					// Show Menu Navigation
					array(
						'name' 	=> 'exclude_footer_menu_navigation',
						'description' => '',
						'title' => __( 'Show Menu Navigation', 'themify' ),
						'type' 	=> 'dropdownbutton',
						'states' => themify_ternary_states( array(
							'icon_no' => THEMIFY_URI . '/img/ddbtn-check.png',
							'icon_yes' => THEMIFY_URI . '/img/ddbtn-cross.png', 
							) ),
						'class' => 'hide-if none',
						'after' => '<div class="clear"></div>',
					),
					// Show Texts
					array(
						'name' 	=> 'exclude_footer_texts',
						'description' => '',
						'title' => __( 'Show Footer Text', 'themify' ),
						'type' 	=> 'dropdownbutton',
						'states' => themify_ternary_states( array(
							'icon_no' => THEMIFY_URI . '/img/ddbtn-check.png',
							'icon_yes' => THEMIFY_URI . '/img/ddbtn-cross.png', 
							) ),
						'class' => 'hide-if none',
						'after' => '<div class="clear"></div>',
					),
					// Show Back to Top
					array(
						'name' 	=> 'exclude_footer_back',
						'description' => '',
						'title' => __( 'Show Back to Top Arrow', 'themify' ),
						'type' 	=> 'dropdownbutton',
						'states' => themify_ternary_states( array(
							'icon_no' => THEMIFY_URI . '/img/ddbtn-check.png',
							'icon_yes' => THEMIFY_URI . '/img/ddbtn-cross.png', 
							) ),
						'class' => 'hide-if none',
						'after' => '<div class="clear"></div>',
					),
				),
				'description' => '',
				'before' => '',
				'after' => '<div class="clear"></div>',
				'separator' => ''
			)
		),
	);
}

/**
 * Default Single Post Layout
 * @param array $data Theme settings data
 * @return string Markup for module.
 * @since 1.0.0
 */
function themify_default_post_layout( $data = array() ){
	$data = themify_get_data();

	/**
	 * Theme Settings Option Key Prefix
	 * @var string
	 */
	$prefix = 'setting-default_page_';

	/**
	 * Tertiary options <blank>|yes|no
	 * @var array
	 */
	$default_options = array(
		array('name' => '', 'value' => ''),
		array('name' => __('Yes', 'themify'), 'value' => 'yes'),
		array('name' => __('No', 'themify'), 'value' => 'no')
	);

	/**
	 * Sidebar placement options
	 * @var array
	 */
	$sidebar_location_options = array(
		array('value' => 'sidebar1', 'img' => 'images/layout-icons/sidebar1.png', 'selected' => true, 'title' => __('Sidebar Right', 'themify')),
		array('value' => 'sidebar1 sidebar-left', 'img' => 'images/layout-icons/sidebar1-left.png', 'title' => __('Sidebar Left', 'themify')),
		array('value' => 'sidebar-none', 'img' => 'images/layout-icons/sidebar-none.png', 'title' => __('No Sidebar', 'themify'))
	);
	/**
	 * Image alignment options
	 * @var array
	 */
	$alignment_options = array(
		array('name' => '', 'value' => ''),
		array('name' => __('Left', 'themify'), 'value' => 'left'),
		array('name' => __('Right', 'themify'), 'value' => 'right')
	);

	/**
	 * Module markup
	 * @var string
	 */
	$output = '';

	/**
	 * Post sidebar placement
	 */
	$output .= '<p>
					<span class="label">' . __('Post Sidebar Option', 'themify') . '</span>';
	$val = themify_get( $prefix . 'post_layout' );
	foreach($sidebar_location_options as $option){
		if(($val == '' || !$val || !isset($val)) && $option['selected']){
			$val = $option['value'];
		}
		if($val == $option['value']){
			$class = 'selected';
		} else {
			$class = '';
		}
		$output .= '<a href="#" class="preview-icon '.$class.'" title="'.$option['title'].'"><img src="'.THEME_URI.'/'.$option['img'].'" alt="'.$option['value'].'"  /></a>';
	}
	$output .= '	<input type="hidden" name="'.$prefix.'post_layout" class="val" value="'.$val.'" />
				</p>';

	/**
	 * Hide Post Title
	 */
	$output .= '<p>
					<span class="label">' . __('Hide Post Title', 'themify') . '</span>
					<select name="'.$prefix.'post_title">'.
						themify_options_module($default_options, $prefix.'post_title') . '
					</select>
				</p>';

	/**
	 * Unlink Post Title
	 */
	$output .= '<p>
					<span class="label">' . __('Unlink Post Title', 'themify') . '</span>
					<select name="'.$prefix.'unlink_post_title">'.
						themify_options_module($default_options, $prefix.'unlink_post_title') . '
					</select>
				</p>';

	/**
	 * Hide Post Meta
	 */
	$output .= themify_post_meta_options($prefix.'post_meta', $data);

	/**
	 * Hide Post Date
	 */
	$output .= '<p>
					<span class="label">' . __('Hide Post Date', 'themify') . '</span>
					<select name="'.$prefix.'post_date">'.
						themify_options_module($default_options, $prefix.'post_date') . '
					</select>
				</p>';

	/**
	 * Hide Featured Image
	 */
	$output .= '<p>
					<span class="label">' . __('Hide Featured Image', 'themify') . '</span>
					<select name="'.$prefix.'post_image">'.
						themify_options_module($default_options, $prefix.'post_image') . '
					</select>
				</p>';

	/**
	 * Unlink Featured Image
	 */
	$output .= '<p>
					<span class="label">' . __('Unlink Featured Image', 'themify') . '</span>
					<select name="'.$prefix.'unlink_post_image">'.
						themify_options_module($default_options, $prefix.'unlink_post_image') . '
					</select>
				</p>';
	/**
	 * Featured Image Sizes
	 */
	$output .= themify_feature_image_sizes_select('image_post_single_feature_size');

	/**
	 * Image dimensions
	 */
	$output .= '<p>
			<span class="label">' . __('Image Size', 'themify') . '</span>
					<input type="text" class="width2" name="setting-image_post_single_width" value="' . themify_get( 'setting-image_post_single_width' ) . '" /> ' . __('width', 'themify') . ' <small>(px)</small>
					<input type="text" class="width2" name="setting-image_post_single_height" value="' . themify_get( 'setting-image_post_single_height' ) . '" /> ' . __('height', 'themify') . ' <small>(px)</small>
					<br /><span class="pushlabel"><small>' . __('Enter height = 0 to disable vertical cropping with img.php enabled', 'themify') . '</small></span>
				</p>';

	/**
	 * Disable comments
	 */
	$pre = 'setting-comments_posts';
	$comments_posts_checked = themify_check( $pre ) ? 'checked="checked"': '';
	$output .= '<p><span class="label">' . __('Post Comments', 'themify') . '</span><label for="'.$pre.'"><input type="checkbox" id="'.$pre.'" name="'.$pre.'" '.$comments_posts_checked.' /> ' . __('Disable comments in all Posts', 'themify') . '</label></p>';

	/**
	 * Show author box
	 */
	$pre = 'setting-post_author_box';
	$author_box_checked = themify_check( $pre ) ? 'checked="checked"': '';

	$output .= '<p><span class="label">' . __('Show Author Box', 'themify') . '</span><label for="'.$pre.'"><input type="checkbox" id="'.$pre.'" name="'.$pre.'" '.$author_box_checked.' /> ' . __('Show author box in all Posts', 'themify') . '</label></p>';

	/**
	 * Remove Post Navigation
	 */
	$pre = 'setting-post_nav_';
	$output .= '<p>
					<span class="label">' . __('Post Navigation', 'themify') . '</span>
					<label for="'.$pre.'disable">
						<input type="checkbox" id="' . $pre . 'disable" name="' . $pre . 'disable" ' . checked( themify_get( $pre . 'disable' ), 'on', false ) . '/> ' . __( 'Remove Post Navigation', 'themify' ) . '
						</label>
					<span class="pushlabel vertical-grouped">
						<label for="'.$pre.'same_cat">
							<input type="checkbox" id="' . $pre . 'same_cat" name="' . $pre . 'same_cat" ' . checked( themify_get( $pre . 'same_cat' ), 'on', false ) . '/> ' . __( 'Show only posts in the same category', 'themify' ) . '
						</label>
					</span>
				</p>';

	return $output;
}
