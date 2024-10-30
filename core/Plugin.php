<?php

namespace Master_Blocks\core;

final class Plugin {
	public static $_instance;
	public static $freemius;
	public static $plugin, $cached_plugin, $transient_names;

	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'master-blocks' ), '1.0.0' );
	}

	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'master-blocks' ), '1.0.0' );
	}

	public static function instance() {
		if ( null === self::$_instance ) {
			self::$_instance = new self();
			do_action( 'master_blocks/loaded' );
		}

		return self::$_instance;
	}

	private function __construct() {
		new Helpers_Core();
		$this->load_plugin_textdomain();
		$this->set_vars();
		$this->set_plugin_info_transient();
		$this->clean_plugin_transients();
		$this->plugin_page_template();
		new WP_KSES();
		new Constants();
		new Helpers();
		new Helpers_Frontend();
		new Enqueue();
		new Gutenberg();
		new Frontend_CSS();
		$this->settings_page();
	}

	public function load_plugin_textdomain() {
		add_action( 'plugins_loaded', function() {
			load_plugin_textdomain( 'master-blocks' );
		} );
	}

	public function set_vars() {
		$plugin = get_plugin_data( MASTER_BLOCKS_PLUGIN_FILE );

		self::$plugin = [
			'name'         => $plugin['Name'],
			'description'  => $plugin['Description'],
			'uri'          => $plugin['PluginURI'],
			'version'      => $plugin['Version'],
			'author'       => $plugin['Author'],
			'author_name'  => $plugin['AuthorName'],
			'author_uri'   => $plugin['AuthorURI'],
			'text_domain'  => $plugin['TextDomain'],
			'title'        => $plugin['Title'],
			'slug'         => basename( MASTER_BLOCKS_PLUGIN_DIR ),
			'snake_slug'   => str_replace( '-', '_', basename( MASTER_BLOCKS_PLUGIN_DIR ) ),
			'base'         => plugin_basename( MASTER_BLOCKS_PLUGIN_FILE ),
			'path'         => plugin_dir_path( MASTER_BLOCKS_PLUGIN_FILE ),
			'url'          => plugin_dir_url( MASTER_BLOCKS_PLUGIN_FILE ),
			'document_uri' => get_file_data( MASTER_BLOCKS_PLUGIN_FILE, [ 'Document URI' ] )[0],
		];

		self::$transient_names = [
			'class_paths' => self::$plugin['snake_slug'] . '_class_paths',
			'plugin_info' => self::$plugin['snake_slug'] . '_plugin_info',
			'all_widgets' => self::$plugin['snake_slug'] . '_all_widgets',
		];
	}

	public function set_plugin_info_transient() {
		self::$cached_plugin = get_transient( self::$transient_names['plugin_info'] );

		if ( ! empty( self::$cached_plugin ) ) return self::$cached_plugin;

		self::$cached_plugin = self::$plugin;

		set_transient( self::$transient_names['plugin_info'], self::$cached_plugin );

		return self::$cached_plugin;
	}

	public function clean_plugin_transients() {
		if (
			self::$cached_plugin['version'] !== self::$plugin['version'] ||
			self::$cached_plugin['name'] !== self::$plugin['name'] ||
			self::$cached_plugin['path'] !== self::$plugin['path'] ||
			self::$cached_plugin['url'] !== self::$plugin['url']
		) {
			foreach ( self::$transient_names as $name ) {
				delete_transient( $name );
			}
		}
	}

	public function plugin_page_template() {
		add_action( 'plugins_loaded', [ Page_Template::class, 'get_instance' ] );
	}

	public function settings_page() {
		add_theme_support( 'recommend_plugins', [
			'gutenberg'      => esc_html__( 'Gutenberg', 'master-blocks' ),
			'contact-form-7' => esc_html__( 'Contact Form 7', 'master-blocks' ),
		] );
		new Settings_Page();
	}
}
