<?php

namespace Master_Blocks;

use Master_Blocks\core\Plugin;

class Loader {
	public $class_paths, $transient_name, $plugin_snake_slug;

	public function __construct() {
		$this->plugin_snake_slug = str_replace( '-', '_', basename( MASTER_BLOCKS_PLUGIN_DIR ) );
		$this->transient_name    = $this->plugin_snake_slug . '_class_paths';
		$this->class_paths       = get_transient( $this->transient_name );

		spl_autoload_register( [ $this, 'autoload' ] );
	}

	public function autoload( $class_name ) {
		if ( stripos( $class_name, __NAMESPACE__ ) !== 0 ) return;

		if ( isset( $this->class_paths[ $class_name ] ) && file_exists( $this->class_paths[ $class_name ] ) ) {
			require_once $this->class_paths[ $class_name ];

			return;
		}

		$file_name = preg_replace( '/^' . __NAMESPACE__ . '\\\/', '', $class_name );
		$file_name = str_replace( '\\', '/', $file_name );

		$file_path = sprintf( '%s/%s.php', MASTER_BLOCKS_PLUGIN_DIR, $file_name );

		if ( file_exists( $file_path ) ) {
			require_once $file_path;

			$this->class_paths[ $class_name ] = $file_path;

			set_transient( $this->transient_name, $this->class_paths );

			return;
		}
	}
}

new Loader();
Plugin::instance();

