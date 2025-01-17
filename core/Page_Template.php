<?php

namespace Master_Blocks\core;

class Page_Template {
	private static $instance;
	protected      $templates;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->templates = [];

		if ( version_compare( (float) get_bloginfo( 'version' ), '4.7', '<' ) ) {
			add_filter( 'page_attributes_dropdown_pages_args', [ $this, 'register_project_templates' ] );
		} else {
			add_filter( 'theme_page_templates', [ $this, 'add_new_template' ] );
		}

		// Add a filter to the save post to inject out template into the page cache
		add_filter( 'wp_insert_post_data', [ $this, 'register_project_templates' ] );

		// Add a filter to the template include to determine if the page has our
		// template assigned and return it's path
		add_filter( 'template_include', [ $this, 'view_project_template' ] );

		// Add your templates to this array.
		$this->templates = [ 'master-blocks-template.php' => __( 'Master Blocks', 'master-blocks' ), ];
	}

	/**
	 * Adds our template to the page dropdown for v4.7+
	 *
	 * @param $posts_templates
	 *
	 * @return array
	 */
	public function add_new_template( $posts_templates ) {
		$posts_templates = array_merge( $posts_templates, $this->templates );

		return $posts_templates;
	}

	/**
	 * Adds our template to the pages cache in order to trick WordPress
	 * into thinking the template file exists where it doesn't really exist.
	 *
	 * @param $atts
	 *
	 * @return mixed
	 */
	public function register_project_templates( $atts ) {
		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

		// Retrieve the cache list.
		// If it doesn't exist, or it's empty prepare an array
		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) {
			$templates = [];
		}

		// New cache, therefore remove the old one
		wp_cache_delete( $cache_key, 'themes' );

		// Now add our template to the list of templates by merging our templates
		// with the existing templates array from the cache.
		$templates = array_merge( $templates, $this->templates );

		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates
		wp_cache_add( $cache_key, $templates, 'themes', 1800 );

		return $atts;

	}

	/**
	 * Checks if the template is assigned to the page
	 *
	 * @param $template
	 *
	 * @return string
	 */
	public function view_project_template( $template ) {
		// Get global post
		global $post;

		// Return template if post is empty
		if ( ! $post ) return $template;

		// Return default template if we don't have a custom one defined
		if ( ! isset( $this->templates[ get_post_meta( $post->ID, '_wp_page_template', true ) ] ) ) {
			return $template;
		}

		$file = get_plugin_path( get_post_meta( $post->ID, '_wp_page_template', true ) );

		// Just to be safe, we check if the file exist first
		if ( file_exists( $file ) ) return $file;

		echo $file;

		// Return template
		return $template;
	}
}

