<?php

namespace Master_Blocks\components\ContactForm;

class CF7 {
	public function __construct() {
		add_action( 'init', [ $this, 'register_block_type' ] );
	}

	public function register_block_type() {
		if ( ! function_exists( 'register_block_type' ) ) return;

		register_block_type( 'master-blocks/cf7', [
			'inserter'        => false,
			'attributes'      => [
				'formID' => [
					'type' => 'number',
				],
			],
			'render_callback' => [ $this, 'callback' ],
		] );
	}

	public function callback( $attributes ) {
		if ( empty( $attributes['formID'] ) ) return null;
		return do_shortcode( sprintf( '[contact-form-7 id="%s" ]', $attributes['formID'] ) );
	}
}
