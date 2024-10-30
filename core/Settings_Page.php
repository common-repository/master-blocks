<?php

namespace Master_Blocks\core;

class Settings_Page {
	public $config, $recommend_plugins;

	public function __construct() {
		$this->recommend_plugins = get_support( 'recommend_plugins' );
		$this->config            = [
			'page_title'           => sprintf(
				/* translators: %s: plugin name */
				esc_html__( 'About %s', 'master-blocks' ),
				PLUGIN_NAME
			),
			'welcome_title'        => sprintf(
				/* translators: 1: plugin name, 2: plugin version */
				esc_html__( 'Welcome to %1$s %2$s', 'master-blocks' ),
				str_replace( '- Gutenberg Site Builder', '', PLUGIN_NAME),
				PLUGIN_VERSION
			),
			'welcome_text' => __( 'Welcome to the future of site building with Gutenberg and Master Blocks!', 'master-blocks' ),
			'text'                 => [
				'install'  => __( 'Install Now', 'master-blocks' ),
				'activate' => __( 'Activate', 'master-blocks' ),
				'detail'   => __( 'Detail', 'master-blocks' ),
			],
			'getting_started'      => [
				'document'   => [
					'title'   => __( 'Read full documentation', 'master-blocks' ),
					'content' => sprintf(
						/* translators: %s: plugin name */
						__( 'Need more details? Please check our full documentation for detailed information on how to use %s.', 'master-blocks' ),
						PLUGIN_NAME
					),
					'link'    => [
						'url'    => PLUGIN_DOCUMENT_URI,
						'text'   => __( 'View documentation', 'master-blocks' ),
						'target' => '_blank',
						'class'  => 'button-primary',
					],
				],
				'support'    => [
					'title'   => __( 'Having trouble, need support?', 'master-blocks' ),
					'content' => sprintf(
						/* translators: %s: plugin name */
						__( 'Support for %s plugin is conducted through WordPress forum system.', 'master-blocks' ),
						PLUGIN_NAME
					),
					'link'    => [
						'url'    => sprintf( 'https://wordpress.org/support/plugin/%s/', PLUGIN_SLUG ),
						'text'   => __( 'Create a new topic', 'master-blocks' ),
						'target' => '_blank',
						'class'  => 'button-secondary',
					],
				],
			],
		];

		add_action( 'admin_menu', [ $this, 'create_welcome_menu' ] );

		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
	}

	public function create_welcome_menu() {
		$count = $this->get_recommended_action_count();

		if ( $count > 0 ) {
			/* translators: 1: actions count */
			$update_label = sprintf( _n( '%1$s recommend action', '%1$s recommend actions', $count, 'master-blocks' ), $count );
			$number       = sprintf( '<span class="update-plugins count-%1$s" title="%2$s"><span class="update-count">%3$s</span></span>', esc_attr( $count ), esc_attr( $update_label ), number_format_i18n( $count ) );
			$menu_title   = sprintf( '%1$s %2$s', 'Master Blocks', $number );
		} else {
			$menu_title = 'Master Blocks';
		}

		add_menu_page(
			$this->config['page_title'],
			$menu_title,
			'manage_options',
			'master-blocks',
			[ $this, 'plugin_info' ],
			get_plugin_url( ASSETS_DIR . 'logo.svg' ),
			2
		);

		add_submenu_page(
			'master-blocks',
			$this->config['page_title'],
			__( 'Welcome', 'master-blocks' ),
			'manage_options',
			'master-blocks',
			[ $this, 'plugin_info' ]
		);
	}

	public function enqueue_admin_scripts() {
		$screen = get_current_screen();

		wp_enqueue_style( PLUGIN_SLUG, get_plugin_url( ASSETS_DIR . 'css/admin.css' ) );

		if ( strpos( $screen->id, PLUGIN_SLUG ) !== false ) {
			wp_enqueue_style( 'plugin-install' );
			wp_enqueue_script( 'plugin-install' );
			wp_enqueue_script( 'updates' );
			add_thickbox();
		}
	}

	public function plugin_info() {
		$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : null; // WPCS: CSRF ok.

		$html = '<div class="wrap about-wrap plugin_info_wrapper">';
		$html .= sprintf( '<h1>%s</h1>', $this->config['welcome_title'] );
		$html .= sprintf( '<div class="about-text">%s</div>', PLUGIN_DESC );
		$html .= sprintf( '<div class="plugin-badge"><a href="%s"><img src="%s" alt=""></a></div>', PLUGIN_AUTHOR_URI, get_plugin_url(ASSETS_DIR.'color-logo.svg') );
		$html .= sprintf( '<h2 class="nav-tab-wrapper">%s</h2>', $this->tabs_navigation( $active_tab ) );

		if ( null === $active_tab ) {
			$html .= $this->tab_getting_started();
		} elseif ( $active_tab === 'premium_version' ) {
			$html .= $this->tab_premium_version();
		} elseif ( $active_tab === 'recommended_actions' ) {
			$html .= $this->tab_recommended_actions( $this->recommend_plugins );
		} elseif ( $active_tab === 'changelog' ) {
			$html .= $this->tab_changelog();
		}

		$html .= '</div>';

		echo wp_kses( $html, 'default' );
	}

	public function tabs_navigation( $active_tab ) {
		$count = $this->get_recommended_action_count();

		$tabs = sprintf(
			'<a href="?page=%1$s" class="nav-tab %2$s">%3$s</a>',
			PLUGIN_SLUG,
			null === $active_tab ? 'nav-tab-active' : null,
			__( 'Getting Started', 'master-blocks' )
		);

		if ( $count > 0 ) {
			$tabs .= sprintf(
				'<a href="?page=%1$s&tab=recommended_actions" class="nav-tab %2$s">%3$s%4$s</a>',
				PLUGIN_SLUG,
				$active_tab === 'recommended_actions' ? 'nav-tab-active' : null,
				__( 'Recommended Plugins', 'master-blocks' ),
				"<span class='theme-action-count'>$count</span>"
			);
		}

		$tabs .= sprintf(
			'<a href="?page=%1$s&tab=premium_version" class="nav-tab %2$s">%3$s</a>',
			PLUGIN_SLUG,
			$active_tab === 'premium_version' ? 'nav-tab-active' : null,
			__( 'Premium Version', 'master-blocks' )
		);

		$tabs .= sprintf(
			'<a href="?page=%1$s&tab=changelog" class="nav-tab %2$s">%3$s</a>',
			PLUGIN_SLUG,
			$active_tab === 'changelog' ? 'nav-tab-active' : null,
			__( 'Changelog', 'master-blocks' )
		);

		return $tabs;
	}

	public function tab_getting_started() {
		$html = '<div class="plugin_info info-tab-content"><div class="plugin_info_column clearfix">';
		$html .= '<div class="plugin_info_left">';
		$html .= sprintf( '<p class="about-description">%s</p>', $this->config['welcome_text']);
		foreach ( $this->config['getting_started'] as $block ) {
			$html .= '<div class="plugin_link">';
			$html .= sprintf( '<h3>%s</h3>', $block['title'] );
			$html .= sprintf( '<p class="about">%s</p>', $block['content'] );
			$html .= sprintf( '<p><a href="%1$s" class="button %2$s" target="%3$s">%4$s</a></p>', $block['link']['url'], $block['link']['class'], $block['link']['target'], $block['link']['text'] );
			$html .= '</div>';
		}
		$html .= '</div>';
		$html .= '<div class="plugin_info_right">';
		$html .= sprintf( '<img src="%s" alt="" />', get_plugin_url( ASSETS_DIR . 'svg/build-content.svg' ) );
		$html .= '</div>';
		$html .= '</div></div>';

		return $html;
	}

	public function tab_recommended_actions( $recommend_plugins ) {
		$html = '<div class="action-required-tab info-tab-content"><div id="plugin-filter" class="recommend-plugins action-required">';
		foreach ( $recommend_plugins as $plugin_slug => $plugin_name ) :
			if ( $plugin_slug === 'gutenberg' && function_exists( 'parse_blocks' ) ) continue;
			$html .= $this->render_recommend_plugin( $plugin_slug, $plugin_name );
		endforeach;
		$html .= '</div></div>';

		return $html;
	}

	public function tab_premium_version() {
		$html = '<div class="premium-version info-tab-content">';
		$html .= '<h2>Why upgrade to Premium Version of the plugin?! </h2>';
		$html .= '<p class="about-description">The premium version helps us to continue development of this plugin incorporating even more features and enhancements along with offering more responsive support. Following are some of the reasons why you may want to upgrade to the premium version of this plugin.</p>';
		$html .= '<h3>New Premium Blocks</h3>';
		$html .= '<p>Although the free version of the Master Blocks features a large repertoire of premium quality addons, the premium version does even more.</p>';
		$html .= '<ul>';
		$html .= '<li>Testimonials Block</li>';
		$html .= '<li>Portfolio Block</li>';
		$html .= '<li>Counter Block</li>';
		$html .= '<li>Partners Block</li>';
		$html .= '</ul>';
		$html .= '<h3>Additional Features</h3>';
		$html .= '<p>Along with incorporating many new blocks into premium version, the pro version is being updated with additional features for existing blocks</p>';
		$html .= '<ul>';
		$html .= '<li>Preset</li>';
		$html .= '<li>Gradient background</li>';
		$html .= '<li>Video background</li>';
		$html .= '<li>Pattern Overlay</li>';
		$html .= '</ul>';
		$html .= '<h3>Premium Support</h3>';
		$html .= '<p>We offer premium support for our paid customers with following benefits:</p>';
		$html .= '<ul>';
		$html .= '<li><b>Private Tickets</b> - Private tickets help you work with us directly regarding the issues you are facing in your site by sharing the details of your site securely.</li>';
		$html .= '<li><b>Faster turnaround</b> - The threads opened by paid customers will be attended to within 24 hours of opening a ticket.</li>';
		$html .= '<li><b>Bug fixes and Enhancements</b> - Any fixes and enhancements made to the elements will be prioritized to arrive quicker on the premium version.</li>';
		$html .= '</ul>';
		$html .= sprintf( '<a href="%s" class="button button-primary button-hero">%s</a>', admin_url( '/admin.php?page=master-blocks-pricing' ), __( 'Buy it now', 'master-blocks' ) );
		$html .= '</div>';

		return $html;
	}

	public function tab_changelog() {
		$html = '<div class="changelog info-tab-content">';
		$html .= $this->get_changelog();
		$html .= '</div>';

		return $html;
	}

	private function render_recommend_plugin( $plugin_slug, $plugin_name, $args = [] ) {
		$plugin_path = $this->get_plugin_path( $plugin_slug );

		if ( is_plugin_active( $plugin_path ) ) return null;

		$args = wp_parse_args( $args, [
			'before'                  => '<div class="rcp">',
			'after'                   => '</div>',
			'show_plugin_name'        => true,
			'show_plugin_detail_link' => true,
		] );

		$plugin_is_installed = is_dir( WP_PLUGIN_DIR . DS . $plugin_slug );

		if ( $plugin_is_installed ) {
			$action_link = sprintf(
				'<a href="%1$s" data-slug="%2$s" class="activate-now button-primary">%3$s</a>',
				$this->create_action_link( 'activate', $plugin_path, $plugin_slug ),
				$plugin_slug,
				$this->config['text']['activate']
			);
		} else {
			$action_link = sprintf(
				'<a href="%1$s" data-slug="%2$s" class="install-now button">%3$s</a>',
				$this->create_action_link( 'install', $plugin_path, $plugin_slug ),
				$plugin_slug,
				$this->config['text']['install']
			);
		}

		$render_html = $args['before'];

		if ( ! empty( $args['show_plugin_name'] ) ) {
			$render_html .= sprintf( '<h4 class="rcp-name">%s</h4>', $plugin_name );
		}

		$render_html .= sprintf( '<p class="action-btn plugin-card-%1$s">%2$s</p>', $plugin_slug, $action_link );

		if ( ! empty( $args['show_plugin_detail_link'] ) ) {
			$render_html .= sprintf(
				'<a class="plugin-detail thickbox open-plugin-details-modal" href="%1$s">%2$s</a>',
				$this->create_detail_link( $plugin_slug ),
				$this->config['text']['detail']
			);
		}

		$render_html .= $args['after'];

		return $render_html;
	}

	private function create_detail_link( $plugin_slug ) {
		$query = [
			'tab'       => 'plugin-information',
			'plugin'    => $plugin_slug,
			'TB_iframe' => 'true',
			'width'     => '772',
			'height'    => '349',
		];

		$detail_link = add_query_arg( $query, network_admin_url( 'plugin-install.php' ) );

		return $detail_link;
	}

	private function get_recommended_action_count( $action_count = 0 ) {
		if ( empty( $this->recommend_plugins ) ) return $action_count;

		foreach ( $this->recommend_plugins as $plugin_slug => $plugin_name ) {
			if ( $plugin_slug === 'gutenberg' && function_exists( 'parse_blocks' ) ) continue;
			$plugin_path = $this->get_plugin_path( $plugin_slug );

			if ( ! is_plugin_active( $plugin_path ) ) $action_count++;
		}

		return $action_count;
	}

	private function get_changelog( $html = '' ) {
		$readme_content = get_file_content( get_plugin_path( 'readme.txt' ) );

		if ( is_wp_error( $readme_content ) ) return null;

		$readme_content = explode( PHP_EOL, $readme_content );

		foreach ( $readme_content as $readme_line ) {
			if ( 0 === strpos( $readme_line, '= 1' ) ) {
				$changelog_line = str_replace( [ '= ', ' =' ], [ 'Version ', '' ], $readme_line );

				$html .= "<h2>$changelog_line</h2>";
			} elseif ( 0 === strpos( $readme_line, '*' ) ) {
				$changelog_line = str_replace( '*', '-', $readme_line );

				$html .= "<p>$changelog_line</p>";
			}
		}

		return $html;
	}

	private function get_plugin_path( $plugin_slug ) {
		if ($plugin_slug === 'contact-form-7') {
			return sprintf( '%1$s/wp-%1$s.php', $plugin_slug );
		}
		return sprintf( '%1$s/%1$s.php', $plugin_slug );
	}

	private function create_action_link( $state, $plugin_path, $plugin_slug ) {
		switch ( $state ) {
			case 'install':
				$query       = [
					'action' => 'install-plugin',
					'plugin' => $plugin_slug,
				];
				$install_url = add_query_arg( $query, network_admin_url( 'update.php' ) );
				$install_url = wp_nonce_url( $install_url, 'install-plugin_' . $plugin_slug );

				return $install_url;

			case 'activate':
				$query = [
					'action'        => 'activate',
					'plugin'        => rawurlencode( $plugin_path ),
					'plugin_status' => 'all',
					'paged'         => '1',
					'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $plugin_path ),
				];

				return add_query_arg( $query, network_admin_url( 'plugins.php' ) );
		}
	}
}
