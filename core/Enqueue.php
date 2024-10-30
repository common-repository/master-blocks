<?php

namespace Master_Blocks\core;

const MASTER_BLOCKS          = PLUGIN_SLUG;
const MASTER_BLOCKS_FONT     = PLUGIN_SLUG . '-font';
const MASTER_BLOCKS_FRONTEND = PLUGIN_SLUG . '-frontend';
const MASTER_BLOCKS_EDITOR   = PLUGIN_SLUG . '-editor';
const MASTER_BLOCKS_STYLE    = PLUGIN_SLUG . '-style';
const GOOGLE_MAP             = 'google-map';

class Enqueue extends Enqueue_Base {
	public function __construct() {
		parent::__construct();

		$this->frontend_assets = [
			'styles'  => [
				MASTER_BLOCKS_FRONTEND => [
					'src'     => get_plugin_url( ASSETS_DIR . 'css/frontend.css' ),
					'version' => filemtime( get_plugin_path( ASSETS_DIR . 'css/frontend.css' ) ),
				],
				'fancybox'             => [
					'src' => get_plugin_url( LIBS_DIR . 'fancybox/jquery.fancybox.min.css' ),
				],
			],
			'scripts' => [
				'intersection-observer' => [
					'src' => get_plugin_url( LIBS_DIR . 'intersection-observer/intersection-observer.js' ),
				],
				'jarallax'              => [
					'src'      => get_plugin_url( LIBS_DIR . 'jarallax/jarallax.js' ),
					'have_min' => true,
				],
				'jarallax-video'        => [
					'src'      => get_plugin_url( LIBS_DIR . 'jarallax/jarallax-video.js' ),
					'have_min' => true,
				],
				'fancybox'              => [
					'src'  => get_plugin_url( LIBS_DIR . 'fancybox/jquery.fancybox.min.js' ),
					'deps' => [ 'jquery' ],
				],
				GOOGLE_MAP              => [
					'src'       => "https://maps.googleapis.com/maps/api/js?libraries=places&key=$this->api_key",
					'in_footer' => false,
				],
				MASTER_BLOCKS_FONT      => [
					'src'     => get_plugin_url( ASSETS_DIR . 'js/font.js' ),
					'deps'    => [ 'lodash' ],
					'version' => filemtime( get_plugin_path( ASSETS_DIR . 'js/font.js' ) ),
				],
				MASTER_BLOCKS_FRONTEND  => [
					'src'     => get_plugin_url( ASSETS_DIR . 'js/frontend.js' ),
					'version' => filemtime( get_plugin_path( ASSETS_DIR . 'js/frontend.js' ) ),
				],
			],
		];

		$this->block_assets = [
			'styles' => [
				MASTER_BLOCKS_STYLE => [
					'src'     => get_plugin_url( ASSETS_DIR . 'css/style.css' ),
					'version' => filemtime( get_plugin_path( ASSETS_DIR . 'css/style.css' ) ),
				],
			],
		];

		$this->editor_assets = [
			'styles'  => [
				MASTER_BLOCKS_EDITOR => [
					'src'     => get_plugin_url( ASSETS_DIR . 'css/editor.css' ),
					'deps'    => [ 'wp-edit-blocks' ],
					'version' => filemtime( get_plugin_path( ASSETS_DIR . 'css/editor.css' ) ),
				],
			],
			'scripts' => [
				GOOGLE_MAP           => [
					'src'       => "https://maps.googleapis.com/maps/api/js?libraries=places&key=$this->api_key",
					'in_footer' => false,
				],
				MASTER_BLOCKS_FONT   => [
					'src'     => get_plugin_url( ASSETS_DIR . 'js/font.js' ),
					'version' => filemtime( get_plugin_path( ASSETS_DIR . 'js/font.js' ) ),
				],
				MASTER_BLOCKS        => [
					'src'            => $this->get_block_js(),
					'version'        => $this->get_block_js_version(),
					'deps'           => [
						'lodash',
						'wp-api-fetch',
						'wp-blocks',
						'wp-components',
						'wp-compose',
						'wp-data',
						'wp-edit-post',
						'wp-editor',
						'wp-element',
						'wp-hooks',
						'wp-i18n',
						'wp-plugins',
						'wp-api',
					],
					'have_translate' => true,
				],
			],
		];
	}

	public function enqueue_frontend_assets() {
		wp_enqueue_style( 'fancybox' );
		wp_enqueue_style( MASTER_BLOCKS_FRONTEND );

		if ( $this->api_key ) {
			wp_enqueue_script( GOOGLE_MAP );
		}

		wp_enqueue_script( 'intersection-observer' );
		wp_enqueue_script( 'jarallax' );
		wp_enqueue_script( 'jarallax-video' );
		wp_enqueue_script( 'fancybox' );
		wp_enqueue_script( MASTER_BLOCKS_FRONTEND );
		wp_enqueue_script( MASTER_BLOCKS_FONT );

		wp_localize_script( MASTER_BLOCKS_FRONTEND, 'masterBlocks', [
			'webFontLoaded'         => true,
			'headingFont'           => get_post_meta( get_the_ID(), 'master_blocks_heading_font', true ),
			'headingFontVariants'   => get_post_meta( get_the_ID(), 'master_blocks_heading_font_variants', true ),
			'bodyFont'              => get_post_meta( get_the_ID(), 'master_blocks_body_font', true ),
			'bodyFontVariants'      => get_post_meta( get_the_ID(), 'master_blocks_body_font_variants', true ),
			'highlightFont'         => get_post_meta( get_the_ID(), 'master_blocks_highlight_font', true ),
			'highlightFontVariants' => get_post_meta( get_the_ID(), 'master_blocks_highlight_font_variants', true ),
		] );
	}

	public function enqueue_block_assets() {
		wp_enqueue_style( MASTER_BLOCKS_STYLE );
	}

	public function enqueue_editor_assets() {
		wp_dequeue_style( 'common' );
		wp_enqueue_style( 'common' );
		wp_enqueue_style( MASTER_BLOCKS_EDITOR );

		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( MASTER_BLOCKS, 'master-blocks' );
		}

		wp_enqueue_script( MASTER_BLOCKS_FONT );
		wp_enqueue_script( GOOGLE_MAP );
		wp_enqueue_script( MASTER_BLOCKS );

		wp_localize_script( MASTER_BLOCKS, 'masterBlocks', [
			'pluginUrl'             => get_plugin_url(),
			'isDev'                 => is_dev(),
			'headingFont'           => get_post_meta( get_the_ID(), 'master_blocks_heading_font', true ),
			'headingFontVariants'   => get_post_meta( get_the_ID(), 'master_blocks_heading_font_variants', true ),
			'bodyFont'              => get_post_meta( get_the_ID(), 'master_blocks_body_font', true ),
			'bodyFontVariants'      => get_post_meta( get_the_ID(), 'master_blocks_body_font_variants', true ),
			'highlightFont'         => get_post_meta( get_the_ID(), 'master_blocks_highlight_font', true ),
			'highlightFontVariants' => get_post_meta( get_the_ID(), 'master_blocks_highlight_font_variants', true ),
		] );
	}
}
