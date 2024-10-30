<?php

namespace Master_Blocks\core;

class Frontend_CSS
{
    public function __construct()
    {
        add_action( 'wp_head', [ $this, 'get_block_css' ], 999 );
    }
    
    public function get_block_css()
    {
        if ( function_exists( 'has_blocks' ) && !has_blocks( get_the_ID() ) ) {
            return;
        }
        global  $post ;
        if ( !is_object( $post ) ) {
            return;
        }
        
        if ( function_exists( 'parse_blocks' ) ) {
            $blocks = parse_blocks( $post->post_content );
        } elseif ( function_exists( 'gutenberg_parse_blocks' ) ) {
            $blocks = gutenberg_parse_blocks( $post->post_content );
        } else {
            $blocks = null;
        }
        
        if ( !is_array( $blocks ) || empty($blocks) ) {
            return;
        }
        $css = '<style type="text/css" media="all" id="master-blocks-frontend">';
        $css .= font();
        foreach ( $blocks as $index => $block ) {
            
            if ( !empty($block['blockName']) && !empty($block['attrs']) && is_array( $block['attrs'] ) ) {
                $attrs = $block['attrs'];
                
                if ( !empty($attrs['uniqueID']) ) {
                    $css .= $this->mobile( $attrs );
                    $css .= $this->tablet( $attrs );
                    $css .= $this->desktop( $attrs );
                }
            
            }
        
        }
        $css .= '</style>';
        echo  $css ;
    }
    
    public function mobile( $attrs )
    {
        $css = sprintf( '#%s {', $attrs['uniqueID'] );
        $css .= background( $attrs );
        $css .= '}';
        $css .= spacing( $attrs, 2 );
        $css .= min_height( $attrs, 2 );
        $css .= padding( $attrs, 2 );
        $css .= overlay( $attrs );
        $css .= border( $attrs );
        $css .= title( $attrs, 2 );
        $css .= content( $attrs, 2 );
        $css .= primary_layout( $attrs, 2 );
        $css .= secondary_layout( $attrs, 2 );
        $css .= button( $attrs, 2 );
        $css .= features( $attrs );
        return $css;
    }
    
    public function tablet( $attrs )
    {
        $css = '';
        
        if ( isset( $attrs['spacing'][1] ) || isset( $attrs['layout'][1] ) || isset( $attrs['topDivider'][0] ) || isset( $attrs['bottomDivider'][0] ) || isset( $attrs['secondaryLayout'][1] ) || isset( $attrs['primaryLayout'][1] ) ) {
            $css .= '@media (min-width: 767px) {';
            $css .= spacing( $attrs, 1 );
            $css .= min_height( $attrs, 1 );
            $css .= padding( $attrs, 1 );
            $css .= title( $attrs, 1 );
            $css .= content( $attrs, 1 );
            $css .= primary_layout( $attrs, 1 );
            $css .= secondary_layout( $attrs, 1 );
            $css .= button( $attrs, 1 );
            $css .= '}';
        }
        
        return $css;
    }
    
    public function desktop( $attrs )
    {
        $css = '';
        
        if ( isset( $attrs['spacing'][0] ) || isset( $attrs['layout'][0] ) || isset( $attrs['topDivider'][0] ) || isset( $attrs['bottomDivider'][0] ) || isset( $attrs['secondaryLayout'][0] ) || isset( $attrs['primaryLayout'][0] ) ) {
            $css .= '@media (min-width: 1280px) {';
            $css .= spacing( $attrs, 0 );
            $css .= min_height( $attrs, 0 );
            $css .= padding( $attrs, 0 );
            $css .= layout( $attrs, 0 );
            $css .= title( $attrs, 0 );
            $css .= content( $attrs, 0 );
            $css .= primary_layout( $attrs, 0 );
            $css .= secondary_layout( $attrs, 0 );
            $css .= button( $attrs, 0 );
            $css .= '}';
        }
        
        return $css;
    }

}