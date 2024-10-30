<?php

namespace Master_Blocks\core;

// Conditional
function is_plugin_install( $plugin ) {
	return isset( get_plugins()[ $plugin ] );
}

function is_ajax() {
	return defined( 'DOING_AJAX' ) && DOING_AJAX;
}

function is_script_debug() {
	return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
}

function is_debug() {
	return is_script_debug() && defined( 'WP_DEBUG' ) && WP_DEBUG;
}

function is_plugin_settings_page() {
	$current_screen = get_current_screen();

	return $current_screen && strpos( $current_screen->id, PLUGIN_SLUG ) !== false;
}

// Core
function get_class_name_from_file( $path_to_file, $include_namespace = true ) {
	$contents = get_contents( $path_to_file );

	$namespace         = '';
	$class             = '';
	$getting_namespace = false;
	$getting_class     = false;

	foreach ( token_get_all( $contents ) as $token ) {
		if ( is_array( $token ) ) {
			if ( $token[0] === T_NAMESPACE ) {
				$getting_namespace = true;
			}
			if ( $token[0] === T_CLASS ) {
				$getting_class = true;
			}
		}

		if ( $getting_namespace === true && $include_namespace ) {
			if ( is_array( $token ) && in_array( $token[0], [ T_STRING, T_NS_SEPARATOR ], true ) ) {
				$namespace .= $token[1];
			} elseif ( $token === ';' ) {
				$getting_namespace = false;
			}
		}

		if ( $getting_class === true && is_array( $token ) && $token[0] === T_STRING ) {
			$class = $token[1];
			break;
		}
	}

	return $namespace ? $namespace . '\\' . $class : $class;
}

function strip_namespace( $class_name ) {
	return substr( $class_name, strrpos( $class_name, '\\' ) + 1 );
}

function get_contents( $file ) {
	return $GLOBALS['wp_filesystem']->get_contents( $file );
}

class Helpers_Core {
	public function __construct() {
		global $wp_filesystem;

		if ( $wp_filesystem === null ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';

			WP_Filesystem();
		}

		if ( ! function_exists( 'get_plugins' ) ) require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
}
