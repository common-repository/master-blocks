<?php

/**
 * Plugin Name: Master Blocks - Gutenberg Site Builder
 * Description: Next generation site builder for WordPress.
 * Version: 1.0.4
 * Tags: blocks, gutenberg, site builder, page builder, editor, layout, writing
 * Author: Master Blocks Team
 * Author URI: https://masterblocks.io
 * License: GNU General Public License version 3
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 * Document URI: https://masterblocks.io/documentation
 * Text Domain: master-blocks
 * @fs_premium_only /assets/js/editor.js
 */
function master_blocks_freemius()
{
    global  $master_blocks_freemius ;
    
    if ( !isset( $master_blocks_freemius ) ) {
        // Include Freemius SDK.
        require_once __DIR__ . '/freemius/start.php';
        $master_blocks_freemius = fs_dynamic_init( array(
            'id'             => '2827',
            'slug'           => 'master-blocks',
            'type'           => 'plugin',
            'public_key'     => 'pk_a8cd6dc0f0bfff8dedc801d8227b3',
            'is_premium'     => false,
            'has_addons'     => false,
            'has_paid_plans' => true,
            'menu'           => array(
            'slug'       => 'master-blocks',
            'first-path' => 'admin.php?page=master-blocks',
        ),
            'is_live'        => true,
        ) );
    }
    
    return $master_blocks_freemius;
}

// Init Freemius.
master_blocks_freemius();
// Signal that SDK was initiated.
do_action( 'master_blocks_freemius_loaded' );
define( 'MASTER_BLOCKS_PLUGIN_FILE', __FILE__ );
define( 'MASTER_BLOCKS_PLUGIN_DIR', __DIR__ );
function master_blocks_fail_php_version()
{
    /* translators: %s: PHP version */
    printf( '<div class="error"><p>%s</p></div>', sprintf( esc_html__( 'Master Blocks - Gutenberg Site Builder requires PHP version %s+, plugin is currently NOT RUNNING.', 'master-blocks' ), '5.6' ) );
}

( PHP_VERSION_ID < 50600 ? add_action( 'admin_notices', 'master_blocks_fail_php_version' ) : (require __DIR__ . '/loader.php') );