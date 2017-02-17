<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**

 * Module Name: Portfolio

 * Description: Display portfolio custom post type

 */

class Themify_Portfolio_Posts_Module extends Themify_Builder_Module {

	function __construct() {

		parent::__construct(array(

			'name' => __('Portfolio', 'themify-portfolio-posts'),

			'slug' => 'portfolio'

		));

	}



	public function get_title( $module ) {

		$type = isset( $module['mod_settings']['type_query_portfolio'] ) ? $module['mod_settings']['type_query_portfolio'] : 'category';

		$category = isset( $module['mod_settings']['category_portfolio'] ) ? $module['mod_settings']['category_portfolio'] : '';

		$slug_query = isset( $module['mod_settings']['query_slug_portfolio'] ) ? $module['mod_settings']['query_slug_portfolio'] : '';



		if ( 'category' == $type ) {

			return sprintf( '%s : %s', __('Category', 'themify-portfolio-posts'), $category );

		} else {

			return sprintf( '%s : %s', __('Slugs', 'themify-portfolio-posts'), $slug_query );

		}

	}



	public function get_options() {

		$image_sizes = themify_get_image_sizes_list( false );

		$options = array(

			array(

				'id' => 'mod_title_portfolio',

				'type' => 'text',

				'label' => __('Module Title', 'themify-portfolio-posts'),

				'class' => 'large'

			),

			array(

				'id' => 'layout_portfolio',

				'type' => 'layout',

				'label' => __('Portfolio Layout', 'themify-portfolio-posts'),

				'options' => array(

					array('img' => 'grid4.png', 'value' => 'grid4', 'label' => __('Grid 4', 'themify-portfolio-posts')),

					array('img' => 'grid3.png', 'value' => 'grid3', 'label' => __('Grid 3', 'themify-portfolio-posts')),

					array('img' => 'grid2.png', 'value' => 'grid2', 'label' => __('Grid 2', 'themify-portfolio-posts')),

					array('img' => 'fullwidth.png', 'value' => 'fullwidth', 'label' => __('fullwidth', 'themify-portfolio-posts'))

				)

			),

			array(

				'id' => 'type_query_portfolio',

				'type' => 'radio',

				'label' => __('Query by', 'themify-portfolio-posts'),

				'options' => array(

					'category' => __('Category', 'themify-portfolio-posts'),

					'post_slug' => __('Slug', 'themify-portfolio-posts')

				),

				'default' => 'category',

				'option_js' => true,

			),

			array(

				'id' => 'category_portfolio',

				'type' => 'query_category',

				'label' => __('Category', 'themify-portfolio-posts'),

				'options' => array(

					'taxonomy' => 'portfolio-category'

				),

				'help' => sprintf(__('Add more <a href="%s" target="_blank">portfolio posts</a>', 'themify-portfolio-posts'), admin_url('post-new.php?post_type=portfolio')),

				'wrap_with_class' => 'tf-group-element tf-group-element-category'

			),

			array(

				'id' => 'query_slug_portfolio',

				'type' => 'text',

				'label' => __('Portfolio Slugs', 'themify-portfolio-posts'),

				'class' => 'large',

				'wrap_with_class' => 'tf-group-element tf-group-element-post_slug',

				'help' => '<br/>' . __( 'Insert Portfolio slug. Multiple slug should be separated by comma (,)', 'themify-portfolio-posts')

			),

			array(

				'id' => 'post_per_page_portfolio',

				'type' => 'text',

				'label' => __('Limit', 'themify-portfolio-posts'),

				'class' => 'xsmall',

				'help' => __('number of posts to show', 'themify-portfolio-posts')

			),

			array(

				'id' => 'offset_portfolio',

				'type' => 'text',

				'label' => __('Offset', 'themify-portfolio-posts'),

				'class' => 'xsmall',

				'help' => __('number of post to displace or pass over', 'themify-portfolio-posts')

			),

			array(

				'id' => 'order_portfolio',

				'type' => 'select',

				'label' => __('Order', 'themify-portfolio-posts'),

				'help' => __('Descending = show newer posts first', 'themify-portfolio-posts'),

				'options' => array(

					'desc' => __('Descending', 'themify-portfolio-posts'),

					'asc' => __('Ascending', 'themify-portfolio-posts')

				)

			),

			array(

				'id' => 'orderby_portfolio',

				'type' => 'select',

				'label' => __('Order By', 'themify-portfolio-posts'),

				'options' => array(

					'date' => __('Date', 'themify-portfolio-posts'),

					'id' => __('Id', 'themify-portfolio-posts'),

					'author' => __('Author', 'themify-portfolio-posts'),

					'title' => __('Title', 'themify-portfolio-posts'),

					'name' => __('Name', 'themify-portfolio-posts'),

					'modified' => __('Modified', 'themify-portfolio-posts'),

					'rand' => __('Rand', 'themify-portfolio-posts'),

					'comment_count' => __('Comment Count', 'themify-portfolio-posts')

				)

			),

			array(

				'id' => 'display_portfolio',

				'type' => 'select',

				'label' => __('Display', 'themify-portfolio-posts'),

				'options' => array(

					'content' => __('Content', 'themify-portfolio-posts'),

					'excerpt' => __('Excerpt', 'themify-portfolio-posts'),

					'none' => __('None', 'themify-portfolio-posts')

				)

			),

			array(

				'id' => 'hide_feat_img_portfolio',

				'type' => 'select',

				'label' => __('Hide Featured Image', 'themify-portfolio-posts'),

				'empty' => array(

					'val' => '',

					'label' => ''

				),

				'options' => array(

					'yes' => __('Yes', 'themify-portfolio-posts'),

					'no' => __('No', 'themify-portfolio-posts')

				)

			),

			array(

				'id' => 'image_size_portfolio',

				'type' => 'select',

				'label' => Themify_Builder_Model::is_img_php_disabled() ? __('Image Size', 'themify-portfolio-posts') : false,

				'empty' => array(

					'val' => '',

					'label' => ''

				),

				'hide' => Themify_Builder_Model::is_img_php_disabled() ? false : true,

				'options' => $image_sizes

			),

			array(

				'id' => 'img_width_portfolio',

				'type' => 'text',

				'label' => __('Image Width', 'themify-portfolio-posts'),

				'class' => 'xsmall'

			),

			array(

				'id' => 'img_height_portfolio',

				'type' => 'text',

				'label' => __('Image Height', 'themify-portfolio-posts'),

				'class' => 'xsmall'

			),

			array(

				'id' => 'unlink_feat_img_portfolio',

				'type' => 'select',

				'label' => __('Unlink Featured Image', 'themify-portfolio-posts'),

				'empty' => array(

					'val' => '',

					'label' => ''

				),

				'options' => array(

					'yes' => __('Yes', 'themify-portfolio-posts'),

					'no' => __('No', 'themify-portfolio-posts')

				)

			),

			array(

				'id' => 'hide_post_title_portfolio',

				'type' => 'select',

				'label' => __('Hide Post Title', 'themify-portfolio-posts'),

				'empty' => array(

					'val' => '',

					'label' => ''

				),

				'options' => array(

					'yes' => __('Yes', 'themify-portfolio-posts'),

					'no' => __('No', 'themify-portfolio-posts')

				)

			),

			array(

				'id' => 'unlink_post_title_portfolio',

				'type' => 'select',

				'label' => __('Unlink Post Title', 'themify-portfolio-posts'),

				'empty' => array(

					'val' => '',

					'label' => ''

				),

				'options' => array(

					'yes' => __('Yes', 'themify-portfolio-posts'),

					'no' => __('No', 'themify-portfolio-posts')

				)

			),

			array(

				'id' => 'hide_post_date_portfolio',

				'type' => 'select',

				'label' => __('Hide Post Date', 'themify-portfolio-posts'),

				'empty' => array(

					'val' => '',

					'label' => ''

				),

				'options' => array(

					'yes' => __('Yes', 'themify-portfolio-posts'),

					'no' => __('No', 'themify-portfolio-posts')

				)

			),

			array(

				'id' => 'hide_post_meta_portfolio',

				'type' => 'select',

				'label' => __('Hide Post Meta', 'themify-portfolio-posts'),

				'empty' => array(

					'val' => '',

					'label' => ''

				),

				'options' => array(

					'yes' => __('Yes', 'themify-portfolio-posts'),

					'no' => __('No', 'themify-portfolio-posts')

				)

			),

			array(

				'id' => 'hide_page_nav_portfolio',

				'type' => 'select',

				'label' => __('Hide Page Navigation', 'themify-portfolio-posts'),

				'options' => array(

					'yes' => __('Yes', 'themify-portfolio-posts'),

					'no' => __('No', 'themify-portfolio-posts')

				)

			)

		);

		return $options;

	}



	public function get_styling() {

		$styling = array(

			// Animation

			array(

				'id' => 'separator_animation',

				'title' => '',

				'description' => '',

				'type' => 'separator',

				'meta' => array('html'=>'<h4>'.__('Animation', 'themify-portfolio-posts').'</h4>'),

			),

			array(

				'id' => 'animation_effect',

				'type' => 'animation_select',

				'label' => __( 'Effect', 'themify-portfolio-posts' )

			),

			// Background

			array(

				'type' => 'separator',

				'meta' => array('html'=>'<hr />')

			),

			array(

				'id' => 'separator_image_background',

				'title' => '',

				'description' => '',

				'type' => 'separator',

				'meta' => array('html'=>'<h4>'.__('Background', 'themify-portfolio-posts').'</h4>'),

			),

			array(

				'id' => 'background_color',

				'type' => 'color',

				'label' => __('Background Color', 'themify-portfolio-posts'),

				'class' => 'small',

				'prop' => 'background-color',

				'selector' => array( '.module-portfolio .post' )

			),

			// Font

			array(

				'type' => 'separator',

				'meta' => array('html'=>'<hr />')

			),

			array(

				'id' => 'separator_font',

				'type' => 'separator',

				'meta' => array('html'=>'<h4>'.__('Font', 'themify-portfolio-posts').'</h4>'),

			),

			array(

				'id' => 'font_family',

				'type' => 'font_select',

				'label' => __('Font Family', 'themify-portfolio-posts'),

				'class' => 'font-family-select',

				'prop' => 'font-family',

				'selector' => array( '.module-portfolio .post-title', '.module-portfolio .post-title a' ),

			),

			array(

				'id' => 'font_color',

				'type' => 'color',

				'label' => __('Font Color', 'themify-portfolio-posts'),

				'class' => 'small',

				'prop' => 'color',

				'selector' => array( '.module-portfolio .post', '.module-portfolio h1', '.module-portfolio h2', '.module-portfolio h3:not(.module-title)', '.module-portfolio h4', '.module-portfolio h5', '.module-portfolio h6', '.module-portfolio .post-title', '.module-portfolio .post-title a' ),

			),

			array(

				'id' => 'multi_font_size',

				'type' => 'multi',

				'label' => __('Font Size', 'themify-portfolio-posts'),

				'fields' => array(

					array(

						'id' => 'font_size',

						'type' => 'text',

						'class' => 'xsmall'

					),

					array(

						'id' => 'font_size_unit',

						'type' => 'select',

						'meta' => array(

							array('value' => '', 'name' => ''),

							array('value' => 'px', 'name' => __('px', 'themify-portfolio-posts')),

							array('value' => 'em', 'name' => __('em', 'themify-portfolio-posts'))

						)

					)

				)

			),

			array(

				'id' => 'multi_line_height',

				'type' => 'multi',

				'label' => __('Line Height', 'themify-portfolio-posts'),

				'fields' => array(

					array(

						'id' => 'line_height',

						'type' => 'text',

						'class' => 'xsmall'

					),

					array(

						'id' => 'line_height_unit',

						'type' => 'select',

						'meta' => array(

							array('value' => '', 'name' => ''),

							array('value' => 'px', 'name' => __('px', 'themify-portfolio-posts')),

							array('value' => 'em', 'name' => __('em', 'themify-portfolio-posts')),

							array('value' => '%', 'name' => __('%', 'themify-portfolio-posts'))

						)

					)

				)

			),

			array(

				'id' => 'text_align',

				'label' => __( 'Text Align', 'themify-portfolio-posts' ),

				'type' => 'radio',

				'meta' => array(

					array( 'value' => '', 'name' => __( 'Default', 'themify-portfolio-posts' ), 'selected' => true ),

					array( 'value' => 'left', 'name' => __( 'Left', 'themify-portfolio-posts' ) ),

					array( 'value' => 'center', 'name' => __( 'Center', 'themify-portfolio-posts' ) ),

					array( 'value' => 'right', 'name' => __( 'Right', 'themify-portfolio-posts' ) ),

					array( 'value' => 'justify', 'name' => __( 'Justify', 'themify-portfolio-posts' ) )

				),

				'prop' => 'text-align',

				'selector' => '.module-portfolio .post',

			),

			// Link

			array(

				'type' => 'separator',

				'meta' => array('html'=>'<hr />')

			),

			array(

				'id' => 'separator_link',

				'type' => 'separator',

				'meta' => array('html'=>'<h4>'.__('Link', 'themify-portfolio-posts').'</h4>'),

			),

			array(

				'id' => 'link_color',

				'type' => 'color',

				'label' => __('Color', 'themify-portfolio-posts'),

				'class' => 'small',

				'prop' => 'color',

				'selector' => '.module-portfolio a'

			),

			array(

				'id' => 'text_decoration',

				'type' => 'select',

				'label' => __( 'Text Decoration', 'themify-portfolio-posts' ),

				'meta'	=> array(

					array('value' => '',   'name' => '', 'selected' => true),

					array('value' => 'underline',   'name' => __('Underline', 'themify-portfolio-posts')),

					array('value' => 'overline', 'name' => __('Overline', 'themify-portfolio-posts')),

					array('value' => 'line-through',  'name' => __('Line through', 'themify-portfolio-posts')),

					array('value' => 'none',  'name' => __('None', 'themify-portfolio-posts'))

				),

				'prop' => 'text-decoration',

				'selector' => '.module-portfolio a'

			),

			// Padding

			array(

				'type' => 'separator',

				'meta' => array('html'=>'<hr />')

			),

			array(

				'id' => 'separator_padding',

				'type' => 'separator',

				'meta' => array('html'=>'<h4>'.__('Padding', 'themify-portfolio-posts').'</h4>'),

			),

			array(

				'id' => 'multi_padding_top',

				'type' => 'multi',

				'label' => __('Padding', 'themify-portfolio-posts'),

				'fields' => array(

					array(

						'id' => 'padding_top',

						'type' => 'text',

						'class' => 'xsmall',

						'prop' => 'padding-top',

						'selector' => '.module-portfolio .post',

					),

					array(

						'id' => 'padding_top_unit',

						'type' => 'select',

						'description' => __('top', 'themify-portfolio-posts'),

						'meta' => array(

							array('value' => 'px', 'name' => __('px', 'themify-portfolio-posts')),

							array('value' => '%', 'name' => __('%', 'themify-portfolio-posts'))

						)

					),

				)

			),

			array(

				'id' => 'multi_padding_right',

				'type' => 'multi',

				'label' => '',

				'fields' => array(

					array(

						'id' => 'padding_right',

						'type' => 'text',

						'class' => 'xsmall',

						'prop' => 'padding-right',

						'selector' => '.module-portfolio .post',

					),

					array(

						'id' => 'padding_right_unit',

						'type' => 'select',

						'description' => __('right', 'themify-portfolio-posts'),

						'meta' => array(

							array('value' => 'px', 'name' => __('px', 'themify-portfolio-posts')),

							array('value' => '%', 'name' => __('%', 'themify-portfolio-posts'))

						)

					),

				)

			),

			array(

				'id' => 'multi_padding_bottom',

				'type' => 'multi',

				'label' => '',

				'fields' => array(

					array(

						'id' => 'padding_bottom',

						'type' => 'text',

						'class' => 'xsmall',

						'prop' => 'padding-bottom',

						'selector' => '.module-portfolio .post',

					),

					array(

						'id' => 'padding_bottom_unit',

						'type' => 'select',

						'description' => __('bottom', 'themify-portfolio-posts'),

						'meta' => array(

							array('value' => 'px', 'name' => __('px', 'themify-portfolio-posts')),

							array('value' => '%', 'name' => __('%', 'themify-portfolio-posts'))

						)

					),

				)

			),

			array(

				'id' => 'multi_padding_left',

				'type' => 'multi',

				'label' => '',

				'fields' => array(

					array(

						'id' => 'padding_left',

						'type' => 'text',

						'class' => 'xsmall',

						'prop' => 'padding-left',

						'selector' => '.module-portfolio .post',

					),

					array(

						'id' => 'padding_left_unit',

						'type' => 'select',

						'description' => __('left', 'themify-portfolio-posts'),

						'meta' => array(

							array('value' => 'px', 'name' => __('px', 'themify-portfolio-posts')),

							array('value' => '%', 'name' => __('%', 'themify-portfolio-posts'))

						)

					),

				)

			),

			// Margin

			array(

				'type' => 'separator',

				'meta' => array('html'=>'<hr />')

			),

			array(

				'id' => 'separator_margin',

				'type' => 'separator',

				'meta' => array('html'=>'<h4>'.__('Margin', 'themify-portfolio-posts').'</h4>'),

			),

			array(

				'id' => 'multi_margin_top',

				'type' => 'multi',

				'label' => __('Margin', 'themify-portfolio-posts'),

				'fields' => array(

					array(

						'id' => 'margin_top',

						'type' => 'text',

						'class' => 'xsmall',

						'prop' => 'margin-top',

						'selector' => '.module-portfolio .post',

					),

					array(

						'id' => 'margin_top_unit',

						'type' => 'select',

						'description' => __('top', 'themify-portfolio-posts'),

						'meta' => array(

							array('value' => 'px', 'name' => __('px', 'themify-portfolio-posts')),

							array('value' => '%', 'name' => __('%', 'themify-portfolio-posts'))

						)

					),

				)

			),

			array(

				'id' => 'multi_margin_right',

				'type' => 'multi',

				'label' => '',

				'fields' => array(

					array(

						'id' => 'margin_right',

						'type' => 'text',

						'class' => 'xsmall',

						'prop' => 'margin-right',

						'selector' => '.module-portfolio .post',

					),

					array(

						'id' => 'margin_right_unit',

						'type' => 'select',

						'description' => __('right', 'themify-portfolio-posts'),

						'meta' => array(

							array('value' => 'px', 'name' => __('px', 'themify-portfolio-posts')),

							array('value' => '%', 'name' => __('%', 'themify-portfolio-posts'))

						)

					),

				)

			),

			array(

				'id' => 'multi_margin_bottom',

				'type' => 'multi',

				'label' => '',

				'fields' => array(

					array(

						'id' => 'margin_bottom',

						'type' => 'text',

						'class' => 'xsmall',

						'prop' => 'margin-bottom',

						'selector' => '.module-portfolio .post',

					),

					array(

						'id' => 'margin_bottom_unit',

						'type' => 'select',

						'description' => __('bottom', 'themify-portfolio-posts'),

						'meta' => array(

							array('value' => 'px', 'name' => __('px', 'themify-portfolio-posts')),

							array('value' => '%', 'name' => __('%', 'themify-portfolio-posts'))

						)

					),

				)

			),

			array(

				'id' => 'multi_margin_left',

				'type' => 'multi',

				'label' => '',

				'fields' => array(

					array(

						'id' => 'margin_left',

						'type' => 'text',

						'class' => 'xsmall',

						'prop' => 'margin-left',

						'selector' => '.module-portfolio .post',

					),

					array(

						'id' => 'margin_left_unit',

						'type' => 'select',

						'description' => __('left', 'themify-portfolio-posts'),

						'meta' => array(

							array('value' => 'px', 'name' => __('px', 'themify-portfolio-posts')),

							array('value' => '%', 'name' => __('%', 'themify-portfolio-posts'))

						)

					),

				)

			),

			// Border

			array(

				'type' => 'separator',

				'meta' => array('html'=>'<hr />')

			),

			array(

				'id' => 'separator_border',

				'type' => 'separator',

				'meta' => array('html'=>'<h4>'.__('Border', 'themify-portfolio-posts').'</h4>'),

			),

			array(

				'id' => 'multi_border_top',

				'type' => 'multi',

				'label' => __('Border', 'themify-portfolio-posts'),

				'fields' => array(

					array(

						'id' => 'border_top_color',

						'type' => 'color',

						'class' => 'small',

						'prop' => 'border-top-color',

						'selector' => '.module-portfolio .post',

					),

					array(

						'id' => 'border_top_width',

						'type' => 'text',

						'description' => 'px',

						'class' => 'xsmall',

						'prop' => 'border-top-width',

						'selector' => '.module-portfolio .post',

					),

					array(

						'id' => 'border_top_style',

						'type' => 'select',

						'description' => __('top', 'themify-portfolio-posts'),

						'meta' => Themify_Builder_model::get_border_styles(),

						'prop' => 'border-top-style',

						'selector' => '.module-portfolio .post',

					),

				)

			),

			array(

				'id' => 'multi_border_right',

				'type' => 'multi',

				'label' => '',

				'fields' => array(

					array(

						'id' => 'border_right_color',

						'type' => 'color',

						'class' => 'small',

						'prop' => 'border-right-color',

						'selector' => '.module-portfolio .post',

					),

					array(

						'id' => 'border_right_width',

						'type' => 'text',

						'description' => 'px',

						'class' => 'xsmall',

						'prop' => 'border-right-width',

						'selector' => '.module-portfolio .post',

					),

					array(

						'id' => 'border_right_style',

						'type' => 'select',

						'description' => __('right', 'themify-portfolio-posts'),

						'meta' => Themify_Builder_model::get_border_styles(),

						'prop' => 'border-right-style',

						'selector' => '.module-portfolio .post',

					)

				)

			),

			array(

				'id' => 'multi_border_bottom',

				'type' => 'multi',

				'label' => '',

				'fields' => array(

					array(

						'id' => 'border_bottom_color',

						'type' => 'color',

						'class' => 'small',

						'prop' => 'border-bottom-color',

						'selector' => '.module-portfolio .post',

					),

					array(

						'id' => 'border_bottom_width',

						'type' => 'text',

						'description' => 'px',

						'class' => 'xsmall',

						'prop' => 'border-bottom-width',

						'selector' => '.module-portfolio .post',

					),

					array(

						'id' => 'border_bottom_style',

						'type' => 'select',

						'description' => __('bottom', 'themify-portfolio-posts'),

						'meta' => Themify_Builder_model::get_border_styles(),

						'prop' => 'border-bottom-style',

						'selector' => '.module-portfolio .post',

					)

				)

			),

			array(

				'id' => 'multi_border_left',

				'type' => 'multi',

				'label' => '',

				'fields' => array(

					array(

						'id' => 'border_left_color',

						'type' => 'color',

						'class' => 'small',

						'prop' => 'border-left-color',

						'selector' => '.module-portfolio .post',

					),

					array(

						'id' => 'border_left_width',

						'type' => 'text',

						'description' => 'px',

						'class' => 'xsmall',

						'prop' => 'border-left-width',

						'selector' => '.module-portfolio .post',

					),

					array(

						'id' => 'border_left_style',

						'type' => 'select',

						'description' => __('left', 'themify-portfolio-posts'),

						'meta' => Themify_Builder_model::get_border_styles(),

						'prop' => 'border-left-style',

						'selector' => '.module-portfolio .post',

					)

				)

			),

			// Additional CSS

			array(

				'type' => 'separator',

				'meta' => array( 'html' => '<hr/>')

			),

			array(

				'id' => 'css_portfolio',

				'type' => 'text',

				'label' => __('Additional CSS Class', 'themify-portfolio-posts'),

				'class' => 'large exclude-from-reset-field',

				'description' => sprintf( '<br/><small>%s</small>', __('Add additional CSS class(es) for custom styling', 'themify-portfolio-posts') )

			)

		);

		return $styling;

	}

}



///////////////////////////////////////

// Module Options

///////////////////////////////////////

Themify_Builder_Model::register_module( 'Themify_Portfolio_Posts_Module' );