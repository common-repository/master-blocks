<?php

namespace Master_Blocks\core;

use Master_Blocks\components\ContactForm\CF7;
use Master_Blocks\components\GoogleMap\GoogleMap;

class Gutenberg {
	public function __construct() {
		add_theme_support( 'align-wide' );

		add_action( 'init', [ $this, 'register_metas' ] );
		add_action( 'init', [ $this, 'register_settings' ] );

		new CF7();
		new GoogleMap();
	}

	public function register_metas() {
		register_post_meta( '', 'master_blocks_view_port', [
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		] );
		register_post_meta( '', 'master_blocks_heading_font', [
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		] );
		register_post_meta( '', 'master_blocks_heading_font_variants', [
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		] );
		register_post_meta( '', 'master_blocks_body_font', [
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		] );
		register_post_meta( '', 'master_blocks_body_font_variants', [
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		] );
		register_post_meta( '', 'master_blocks_highlight_font', [
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		] );
		register_post_meta( '', 'master_blocks_highlight_font_variants', [
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		] );
	}

	public function register_settings() {
		register_setting(
			'master_blocks_google_api_key',
			'master_blocks_google_api_key',
			[
				'type'              => 'string',
				'description'       => __( 'Google Map API key for the Gutenberg block plugin.', 'master-blocks' ),
				'sanitize_callback' => 'sanitize_text_field',
				'show_in_rest'      => true,
				'default'           => '',
			]
		);
	}
}
