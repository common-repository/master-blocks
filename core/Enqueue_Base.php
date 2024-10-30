<?php

namespace Master_Blocks\core;

abstract class Enqueue_Base
{
    public  $frontend_assets ;
    public  $block_assets ;
    public  $editor_assets ;
    public  $api_key ;
    public function __construct()
    {
        $this->api_key = get_option( 'master_blocks_google_api_key' );
        // Register scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'register_frontend_assets' ] );
        add_action( 'enqueue_block_assets', [ $this, 'register_block_assets' ] );
        add_action( 'enqueue_block_editor_assets', [ $this, 'register_block_editor_assets' ] );
        // Enqueue scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_assets' ] );
        add_action( 'enqueue_block_assets', [ $this, 'enqueue_block_assets' ] );
        add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_editor_assets' ] );
        // Browser-sync
        add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_bs_script' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_bs_script' ], 999 );
    }
    
    public abstract function enqueue_frontend_assets();
    
    public abstract function enqueue_block_assets();
    
    public abstract function enqueue_editor_assets();
    
    public function register_frontend_assets()
    {
        if ( !empty($this->frontend_assets['styles']) ) {
            foreach ( $this->frontend_assets['styles'] as $handle => $args ) {
                $this->reg_style( $handle, $args );
            }
        }
        if ( !empty($this->frontend_assets['scripts']) ) {
            foreach ( $this->frontend_assets['scripts'] as $handle => $args ) {
                $this->reg_script( $handle, $args );
            }
        }
    }
    
    public function register_block_assets()
    {
        if ( !empty($this->block_assets['styles']) ) {
            foreach ( $this->block_assets['styles'] as $handle => $args ) {
                $this->reg_style( $handle, $args );
            }
        }
        if ( !empty($this->block_assets['scripts']) ) {
            foreach ( $this->block_assets['scripts'] as $handle => $args ) {
                $this->reg_script( $handle, $args );
            }
        }
    }
    
    public function register_block_editor_assets()
    {
        if ( !empty($this->editor_assets['styles']) ) {
            foreach ( $this->editor_assets['styles'] as $handle => $args ) {
                $this->reg_style( $handle, $args );
            }
        }
        if ( !empty($this->editor_assets['scripts']) ) {
            foreach ( $this->editor_assets['scripts'] as $handle => $args ) {
                $this->reg_script( $handle, $args );
            }
        }
    }
    
    public function reg_style( $handle, $args )
    {
        $args = wp_parse_args( $args, [
            'deps'    => false,
            'version' => null,
            'media'   => 'all',
            'has_rtl' => false,
        ] );
        wp_register_style(
            $handle,
            esc_url( $args['src'] ),
            $args['deps'],
            $this->flatten_version( $args['version'] ),
            $args['media']
        );
        if ( $args['has_rtl'] ) {
            wp_style_add_data( $handle, 'rtl', 'replace' );
        }
    }
    
    public function reg_script( $handle, $args )
    {
        $args = wp_parse_args( $args, [
            'deps'           => [],
            'version'        => null,
            'in_footer'      => true,
            'have_min'       => false,
            'have_translate' => false,
        ] );
        
        if ( $args['have_min'] === true && strpos( '.min.js', $args['src'] ) === false && !is_dev() ) {
            $src = str_replace( '.js', '.min.js', $args['src'] );
        } else {
            $src = $args['src'];
        }
        
        if ( function_exists( 'wp_set_script_translations' ) && !empty($args['have_translate']) ) {
            wp_set_script_translations( $handle, PLUGIN_SLUG );
        }
        wp_register_script(
            $handle,
            esc_url( $src ),
            $args['deps'],
            $this->flatten_version( $args['version'] ),
            $args['in_footer']
        );
    }
    
    private function flatten_version( $version )
    {
        if ( empty($version) ) {
            return null;
        }
        $parts = explode( '.', $version );
        if ( count( $parts ) === 2 ) {
            $parts[] = '0';
        }
        return implode( '', $parts );
    }
    
    public function get_block_js()
    {
        
        if ( is_dev() ) {
            $url = 'http://localhost:8080/editor.js';
            $headers = @get_headers( $url );
            $response_code = substr( $headers[0], 9, 3 );
            if ( $response_code === '200' ) {
                return $url;
            }
            return get_plugin_url( ASSETS_DIR . 'js/editor.js' );
        }
        
        return get_plugin_url( ASSETS_DIR . 'js/editor-lite.js' );
    }
    
    public function get_block_js_version()
    {
        return filemtime( get_plugin_path( ASSETS_DIR . 'js/editor-lite.js' ) );
    }
    
    public function enqueue_bs_script()
    {
        if ( !is_dev() ) {
            return;
        }
        $host = wp_parse_url( get_stylesheet_directory_uri() )['host'];
        $url = sprintf( 'http://%s:3000/browser-sync/browser-sync-client.js', $host );
        $response_code = wp_remote_retrieve_response_code( wp_remote_head( $url ) );
        if ( $response_code === 200 ) {
            wp_enqueue_script( '__bs_script__', $url );
        }
    }

}