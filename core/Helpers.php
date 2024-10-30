<?php

namespace Master_Blocks\core;

function filesystem() {
	global $wp_filesystem;

	if ( null === $wp_filesystem ) {
		require_once ABSPATH . '/wp-admin/includes/file.php';

		WP_Filesystem();
	}

	return $wp_filesystem;
}

function get_file_content( $file ) {
	return filesystem()->get_contents( $file );
}

function get_config( $file_path ) {
	return json_decode( get_file_content( get_plugin_path( $file_path ) ), true );
}

function get_client_ip() {
	$server_ip_keys = [
		'HTTP_CLIENT_IP',
		'HTTP_X_FORWARDED_FOR',
		'HTTP_X_FORWARDED',
		'HTTP_X_CLUSTER_CLIENT_IP',
		'HTTP_FORWARDED_FOR',
		'HTTP_FORWARDED',
		'REMOTE_ADDR',
	];

	foreach ( $server_ip_keys as $key ) {
		if ( isset( $_SERVER[ $key ] ) && filter_var( $_SERVER[ $key ], FILTER_VALIDATE_IP ) ) {
			return $_SERVER[ $key ];
		}
	}

	// Fallback local ip.
	return '127.0.0.1';
}

function get_site_domain() {
	return str_ireplace( 'www.', '', wp_parse_url( home_url(), PHP_URL_HOST ) );
}

function get_timezone_string() {
	$current_offset  = (float) get_option( 'gmt_offset' );
	$timezone_string = get_option( 'timezone_string' );

	// Create a UTC+- zone if no timezone string exists.
	if ( empty( $timezone_string ) ) {
		if ( 0 === $current_offset ) {
			$timezone_string = 'UTC+0';
		} elseif ( $current_offset < 0 ) {
			$timezone_string = 'UTC' . $current_offset;
		} else {
			$timezone_string = 'UTC+' . $current_offset;
		}
	}

	return $timezone_string;
}

function do_not_cache() {
	if ( ! defined( 'DONOTCACHEPAGE' ) ) {
		define( 'DONOTCACHEPAGE', true );
	}

	if ( ! defined( 'DONOTCACHEDB' ) ) {
		define( 'DONOTCACHEDB', true );
	}

	if ( ! defined( 'DONOTMINIFY' ) ) {
		define( 'DONOTMINIFY', true );
	}

	if ( ! defined( 'DONOTCDN' ) ) {
		define( 'DONOTCDN', true );
	}

	if ( ! defined( 'DONOTCACHCEOBJECT' ) ) {
		define( 'DONOTCACHCEOBJECT', true );
	}

	// Set the headers to prevent caching for the different browsers.
	nocache_headers();
}

function get_support( $feature ) {
	if ( empty( get_theme_support( $feature )[0] ) ) return [];

	return get_theme_support( $feature )[0];
}

// Plugin
function get_plugin_path( $dir = null ) {
	if ( empty( $dir ) ) return Plugin::$cached_plugin['path'];

	return Plugin::$cached_plugin['path'] . $dir;
}

function get_plugin_url( $dir = null ) {
	if ( empty( $dir ) ) return Plugin::$cached_plugin['url'];

	return Plugin::$cached_plugin['url'] . $dir;
}

function is_dev() {
	return ( defined( __NAMESPACE__ . '\DEV_MODE' ) && DEV_MODE !== 'disable' ) || isset( $_GET['dev'] );
}

class Helpers {}
