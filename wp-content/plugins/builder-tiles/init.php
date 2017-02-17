<?php
/*
Plugin Name:  Builder Tiles
Plugin URI:   http://themify.me/addons/tiles
Version:      1.1.2
Author:       Themify
Description:  A Builder addon to make flippable Tiles like Windows 8 Metro layouts. It requires to use with a Themify theme (framework 2.0.6+) or the Builder plugin (v 1.2.5).
Text Domain:  builder-tiles
Domain Path:  /languages
*/

defined( 'ABSPATH' ) or die( '-1' );

if( ! class_exists( 'Builder_Tiles' ) ) {
	class Builder_Tiles {

		private static $instance = null;
		var $url;
		var $dir;
		var $version;
		var $mobile_breakpoint = 768;

		/**
		 * Creates or returns an instance of this class.
		 *
		 * @return	A single instance of this class.
		 */
		public static function get_instance() {
			return null == self::$instance ? self::$instance = new self : self::$instance;
		}

		private function __construct() {
			$this->constants();
			add_action( 'init', array( $this, 'i18n' ), 5 );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 15 );
			add_action( 'themify_builder_setup_modules', array( $this, 'register_module' ) );
			add_action( 'themify_builder_admin_enqueue', array( $this, 'admin_enqueue' ), 15 );
			add_action( 'wp_head', array( $this, 'dynamic_css' ) );
			add_action( 'init', array( $this, 'updater' ) );
		}

		public function constants() {
		$data = get_file_data( __FILE__, array( 'Version' ) );
		$this->version = $data[0];
			$this->url = defined( 'BUILDER_TILES_URL' ) ? BUILDER_TILES_URL : trailingslashit( plugin_dir_url( __FILE__ ) );
			$this->dir = defined( 'BUILDER_TILES_DIR' ) ? BUILDER_TILES_DIR : trailingslashit( plugin_dir_path( __FILE__ ) );
		}

		public function i18n() {
			load_plugin_textdomain( 'builder-tiles', false, '/languages' );
		}

		public function enqueue() {
			wp_enqueue_style( 'builder-tiles', $this->url . 'assets/style.css', null, $this->version );
			wp_enqueue_script( 'themify-smartresize', $this->url . 'assets/jquery.smartresize.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( 'themify-widegallery', $this->url . 'assets/themify.widegallery.js', array( 'jquery', 'jquery-masonry' ), $this->version, true );
			wp_enqueue_script( 'builder-tiles', $this->url . 'assets/script.js', array( 'jquery', 'jquery-masonry' ), $this->version, true );
			wp_localize_script( 'builder-tiles', 'BuilderTiles', apply_filters( 'builder_tiles_script_vars', array(
				'ajax_nonce'	=> wp_create_nonce('ajax_nonce'),
				'ajax_url'		=> admin_url( 'admin-ajax.php' ),
				'networkError'	=> __('Unknown network error. Please try again later.', 'builder-tiles'),
				'termSeparator'	=> ', ',
				'galleryFadeSpeed' => '300',
				'galleryEvent' => 'click',
				'transition_duration' => 750,
				'isOriginLeft' => is_rtl() ? 0 : 1,
			) ) );
		}

		public function admin_enqueue() {
			wp_enqueue_style( 'builder-tiles-admin', $this->url . 'assets/admin.css' );
			wp_enqueue_script( 'builder-tiles-admin', $this->url . 'assets/admin.js', array( 'jquery' ), $this->version, true );
		}

		public function register_module( $ThemifyBuilder ) {
			$ThemifyBuilder->register_directory( 'templates', $this->dir . 'templates' );
			$ThemifyBuilder->register_directory( 'modules', $this->dir . 'modules' );
		}

		public function get_tile_sizes() {
			return apply_filters( 'builder_tiles_sizes', array(
				'square-large' => array( 'label' => __( 'Square Large', 'builder-tiles' ), 'width' => 480, 'height' => 480, 'mobile_width' => 280, 'mobile_height' => 280, 'image' => $this->url . 'assets/size-sl.png' ),
				'square-small' => array( 'label' => __( 'Square Small', 'builder-tiles' ), 'width' => 240, 'height' => 240, 'mobile_width' => 140, 'mobile_height' => 140, 'image' => $this->url . 'assets/size-ss.png' ),
				'landscape' => array( 'label' => __( 'Landscape', 'builder-tiles' ), 'width' => 480, 'height' => 240, 'mobile_width' => 280, 'mobile_height' => 140, 'image' => $this->url . 'assets/size-l.png' ),
				'portrait' => array( 'label' => __( 'Portrait', 'builder-tiles' ), 'width' => 240, 'height' => 480, 'mobile_width' => 140, 'mobile_height' => 280, 'image' => $this->url . 'assets/size-p.png' ),
			) );
		}

		public function dynamic_css() {
			$css = '';
			foreach( $this->get_tile_sizes() as $key => $size ) {
				$css .= sprintf( '
			.module-tile.size-%1$s,
			.module-tile.size-%1$s .tile-background img,
			.module-tile.size-%1$s .map-container {
				width: %2$spx;
				height: %3$spx;
			}
			@media (max-width: ' . $this->mobile_breakpoint . 'px) {
				.module-tile.size-%1$s,
				.module-tile.size-%1$s .tile-background img,
				.module-tile.size-%1$s .map-container {
					width: %4$spx;
					height: %5$spx;
				}
			}',
					$key,
					$size['width'],
					$size['height'],
					$size['mobile_width'],
					$size['mobile_height']
				);
			}
			echo sprintf( '<style>%s</style>', $css );
		}

		public function updater() {
			if( class_exists( 'Themify_Builder_Updater' ) ) {
				if ( ! function_exists( 'get_plugin_data') ) 
					include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				
				$plugin_basename = plugin_basename( __FILE__ );
				$plugin_data = get_plugin_data( trailingslashit( plugin_dir_path( __FILE__ ) ) . basename( $plugin_basename ) );
				new Themify_Builder_Updater( array(
					'name' => trim( dirname( $plugin_basename ), '/' ),
					'nicename' => $plugin_data['Name'],
					'update_type' => 'addon',
				), $this->version, trim( $plugin_basename, '/' ) );
			}
		}
	}
	Builder_Tiles::get_instance();
}