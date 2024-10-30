<?php

namespace Master_Blocks\core;

function font() {
	$css = '';
	$css .= '[id^="master-blocks"][class^="master-blocks"] .title, [id^="master-blocks"].master-blocks-features .item h3, [id^="master-blocks"].master-blocks-features .item a.more {';
	if ( ! empty( get_post_meta( get_the_ID(), 'master_blocks_heading_font', true ) ) ) {
		$css .= sprintf( 'font-family: %s;', json_decode( get_post_meta( get_the_ID(), 'master_blocks_heading_font', true ), true )['label'] );
	} else {
		$css .= sprintf( 'font-family: %s;', 'Montserrat' );
	}
	$css .= '}';

	$css .= '[id^="master-blocks"][class^="master-blocks"] mark, [id^="master-blocks"][class^="master-blocks"] .title mark, [id^="master-blocks"][class^="master-blocks"] .content mark {';
	if ( ! empty( get_post_meta( get_the_ID(), 'master_blocks_highlight_font', true ) ) ) {
		$css .= sprintf( 'font-family: %s;', json_decode( get_post_meta( get_the_ID(), 'master_blocks_highlight_font', true ), true )['label'] );
	} else {
		$css .= sprintf( 'font-family: %s;', 'Playfair Display' );
	}
	$css .= '}';

	$css .= '[id^="master-blocks"][class^="master-blocks"] {';
	if ( ! empty( get_post_meta( get_the_ID(), 'master_blocks_body_font', true ) ) ) {
		$css .= sprintf( 'font-family: %s;', json_decode( get_post_meta( get_the_ID(), 'master_blocks_body_font', true ), true )['label'] );
	} else {
		$css .= sprintf( 'font-family: %s;', 'Open Sans' );
	}
	$css .= '}';

	return $css;
}

function background( $attrs, $index = 0 ) {
	$css = '';
	if ( ! empty( $attrs['backgroundType'] ) && $attrs['backgroundType'] === 'gradient' ) {
		$palette_string = [];
		if ( ! empty( $attrs['gradientBackground'][ $index ]['palette'] ) ) {
			foreach ( $attrs['gradientBackground'][ $index ]['palette'] as $palette ) {
				$palette_string[] = sprintf( '%s %s', $palette['color'], ( $palette['pos'] * 100 ) . '%' );
			}
			$palette_string = implode( ',', $palette_string );
		} else {
			$palette_string = '#7F7FD5, #86A8E7, #91EAE4';
		}

		$degree   = isset( $attrs['gradientBackground'][ $index ]['degree'] ) ? $attrs['gradientBackground'][ $index ]['degree'] : 90;
		$shape    = ! empty( $attrs['gradientBackground'][ $index ]['shape'] ) ? $attrs['gradientBackground'][ $index ]['shape'] : 'circle';
		$position = ! empty( $attrs['gradientBackground'][ $index ]['position'] ) ? $attrs['gradientBackground'][ $index ]['position'] : 'center';

		if ( ! empty( $attrs['gradientBackground'][ $index ]['orientation'] ) && $attrs['gradientBackground'][ $index ]['orientation'] === 'radial' ) {
			$css .= sprintf( '-webkit-background-image: radial-gradient(%s at %s, %s);', $shape, $position, $palette_string );
			$css .= sprintf( 'background-image: radial-gradient(%s at %s, %s);', $shape, $position, $palette_string );
		} else {
			$css .= sprintf( '-webkit-background-image: linear-gradient(%sdeg, %s);', $degree, $palette_string );
			$css .= sprintf( 'background-image: linear-gradient(%sdeg, %s);', $degree, $palette_string );
		}
	} elseif ( ! empty( $attrs['backgroundType'] ) && $attrs['backgroundType'] === 'video' ) {
		$css .= 'background:none';
	} else {
		if ( ! empty( $attrs['background'][ $index ]['color'] ) ) {
			$css .= sprintf( 'background-color: %s;', $attrs['background'][ $index ]['color'] );
		}
		if ( ! empty( $attrs['background'][ $index ]['url'] ) ) {
			$css .= sprintf( 'background-image: url("%s");', $attrs['background'][ $index ]['url'] );
			if ( $attrs['background'][ $index ]['type'] === 'image' ) {
				$css .= sprintf( 'background-size: %s;', $attrs['background'][ $index ]['size'] ? : 'auto' );
				if ( ! empty( $attrs['background'][ $index ]['positionX'] ) ) {
					$css .= sprintf( 'background-position-x: %s;', $attrs['background'][ $index ]['positionX'] );
				}
				if ( ! empty( $attrs['background'][ $index ]['positionY'] ) ) {
					$css .= sprintf( 'background-position-y: %s;', $attrs['background'][ $index ]['positionY'] );
				}
				if ( ! empty( $attrs['background'][ $index ]['repeat'] ) ) {
					$css .= sprintf( 'background-repeat: %s;', $attrs['background'][ $index ]['repeat'] );
				}
				if ( ! empty( $attrs['background'][ $index ]['attachment'] ) ) {
					$css .= sprintf( 'background-attachment: %s;', $attrs['background'][ $index ]['attachment'] );
				}
			}
		}
	}

	return $css;
}

function spacing( $attrs, $index = 0 ) {
	$css = '';
	if (
		isset( $attrs['spacing'][ $index ]['margin'][0] ) ||
		isset( $attrs['spacing'][ $index ]['margin'][2] ) ||
		isset( $attrs['spacing'][ $index ]['padding'][1] ) ||
		isset( $attrs['spacing'][ $index ]['padding'][3] )
	) {
		$css .= sprintf( '#%s {', $attrs['uniqueID'] );
		if ( isset( $attrs['spacing'][ $index ]['margin'][0] ) ) {
			$css .= sprintf( 'margin-top: %spx;', $attrs['spacing'][ $index ]['margin'][0] );
		}
		if ( isset( $attrs['spacing'][ $index ]['margin'][2] ) ) {
			$css .= sprintf( 'margin-bottom: %spx;', $attrs['spacing'][ $index ]['margin'][2] );
		}
		if ( isset( $attrs['spacing'][ $index ]['padding'][1] ) ) {
			$css .= sprintf( 'padding-right: %spx;', $attrs['spacing'][ $index ]['padding'][1] );
		}
		if ( isset( $attrs['spacing'][ $index ]['padding'][3] ) ) {
			$css .= sprintf( 'padding-left: %spx;', $attrs['spacing'][ $index ]['padding'][3] );
		}
		$css .= '}';
	}

	return $css;
}

function padding( $attrs, $index = 0 ) {
	$css = '';
	if ( isset( $attrs['spacing'][ $index ]['padding'][0] ) || isset( $attrs['spacing'][ $index ]['padding'][2] ) ) {
		$css .= sprintf( '#%s .wrapper {', $attrs['uniqueID'] );
		if ( isset( $attrs['spacing'][ $index ]['padding'][0] ) ) {
			$css .= sprintf( 'padding-top: %spx;', $attrs['spacing'][ $index ]['padding'][0] );
		}
		if ( isset( $attrs['spacing'][ $index ]['padding'][2] ) ) {
			$css .= sprintf( 'padding-bottom: %spx;', $attrs['spacing'][ $index ]['padding'][2] );
		}
		$css .= '}';
	}

	return $css;
}

function min_height( $attrs, $index = 0 ) {
	$css = '';

	if ( isset( $attrs['layout'][0]['minHeight'][ $index ] ) && $attrs['layout'][0]['minHeight'][ $index ] !== null ) {
		$css .= sprintf( '#%s .wrapper {', $attrs['uniqueID'] );
		$css .= sprintf( 'min-height: %svh;', $attrs['layout'][0]['minHeight'][ $index ] );
		$css .= '}';
	}

	return $css;
}

function overlay( $attrs ) {
	$css = '';
	if ( ! empty( $attrs['overlay'][0]['overlayColor'] ) ) {
		$css .= sprintf( '#%s::before {', $attrs['uniqueID'] );
		$css .= 'content:"";';
		$css .= sprintf( 'background-color: %s;', $attrs['overlay'][0]['overlayColor'] );
		if ( ! empty( $attrs['overlay'][0]['overlayOpacity'] ) ) {
			$css .= sprintf( 'opacity: %s;', $attrs['overlay'][0]['overlayOpacity'] );
		}
		$css .= '}';
	}

	return $css;
}

function overlay_pattern( $attrs ) {
	$css = '';
	if ( ! empty( $attrs['overlay'][0]['pattern']['patternName'] ) && $attrs['overlay'][0]['pattern']['patternName'] !== 'none' ) {
		$css .= sprintf( '#%s::after {', $attrs['uniqueID'] );
		$css .= 'content:"";';
		if ( ! empty( $attrs['overlay'][0]['pattern']['patternColor'] ) ) {
			$css .= sprintf( 'background-color: %s;', $attrs['overlay'][0]['pattern']['patternColor'] );
		}
		if ( ! empty( $attrs['overlay'][0]['pattern']['patternOpacity'] ) ) {
			$css .= sprintf( 'opacity: %s;', $attrs['overlay'][0]['pattern']['patternOpacity'] );
		}
		$css .= sprintf( '-webkit-mask-image: url(%s);', get_plugin_url( PATTERNS_DIR . $attrs['overlay'][0]['pattern']['patternName'] ) );
		$css .= sprintf( 'mask-image: url(%s);', get_plugin_url( PATTERNS_DIR . $attrs['overlay'][0]['pattern']['patternName'] ) );
		if ( ! empty( $attrs['overlay'][0]['pattern']['patternSize'] ) ) {
			$css .= sprintf( '-webkit-mask-size: %s;', $attrs['overlay'][0]['pattern']['patternSize'] . '%' );
			$css .= sprintf( 'mask-size: %s;', $attrs['overlay'][0]['pattern']['patternSize'] . '%' );
		}
		$css .= '}';
	}

	return $css;
}

function top_divider( $attrs, $index = 0 ) {
	$css = '';

	if ( ! empty( $attrs['topDivider'][0]['style'] ) ) {
		$css .= sprintf( '#%s .master-blocks-dividers--top {', $attrs['uniqueID'] );
		if ( ! empty( $attrs['topDivider'][ $index ]['height'] ) ) {
			$css .= sprintf( 'height: %spx;', $attrs['topDivider'][ $index ]['height'] );
		}
		if ( ! empty( $attrs['topDivider'][0]['flip'] ) ) {
			$css .= 'transform: scaleX(-1) scaleY(-1);';
		}
		if ( ! empty( $attrs['topDivider'][0]['underContent'] ) ) {
			$css .= 'z-index: 3;';
		}
		$css .= '}';
		$css .= sprintf( '#%s .master-blocks-dividers--top svg {', $attrs['uniqueID'] );
		if ( ! empty( $attrs['topDivider'][0]['color'] ) ) {
			$css .= sprintf( 'fill: %s;', $attrs['topDivider'][0]['color'] );
		}
		if ( ! empty( $attrs['topDivider'][ $index ]['width'] ) ) {
			$css .= sprintf( 'width: %s', $attrs['topDivider'][ $index ]['width'] ) . '%;';
		}
		$css .= '}';
	}

	return $css;
}

function bottom_divider( $attrs, $index = 0 ) {
	$css = '';
	if ( ! empty( $attrs['bottomDivider'][0]['style'] ) ) {
		$css .= sprintf( '#%s .master-blocks-dividers--bottom {', $attrs['uniqueID'] );
		if ( ! empty( $attrs['bottomDivider'][ $index ]['height'] ) ) {
			$css .= sprintf( 'height: %spx;', $attrs['bottomDivider'][ $index ]['height'] );
		}
		if ( ! empty( $attrs['bottomDivider'][0]['flip'] ) ) {
			$css .= 'transform: scaleX(-1);';
		}
		if ( ! empty( $attrs['bottomDivider'][0]['underContent'] ) ) {
			$css .= 'z-index: 3;';
		}
		$css .= '}';
		$css .= sprintf( '#%s .master-blocks-dividers--bottom svg {', $attrs['uniqueID'] );
		if ( ! empty( $attrs['bottomDivider'][0]['color'] ) ) {
			$css .= sprintf( 'fill: %s;', $attrs['bottomDivider'][0]['color'] );
		}
		if ( ! empty( $attrs['bottomDivider'][ $index ]['width'] ) ) {
			$css .= sprintf( 'width: %s', $attrs['bottomDivider'][ $index ]['width'] ) . '%;';
		}
		$css .= '}';
	}

	return $css;
}

function border( $attrs ) {
	$css = '';
	if ( ! empty( $attrs['border'][0] ) ) {
		$css .= sprintf( '#%s {', $attrs['uniqueID'] );
		if ( ! empty( $attrs['border'][0]['width'][0] ) ) {
			$css .= sprintf( 'border-top: %spx %s %s;', $attrs['border'][0]['width'][0], $attrs['border'][0]['type'], $attrs['border'][0]['color'] );
		}
		if ( ! empty( $attrs['border'][0]['width'][1] ) ) {
			$css .= sprintf( 'border-right: %spx %s %s;', $attrs['border'][0]['width'][1], $attrs['border'][0]['type'], $attrs['border'][0]['color'] );
		}
		if ( ! empty( $attrs['border'][0]['width'][2] ) ) {
			$css .= sprintf( 'border-bottom: %spx %s %s;', $attrs['border'][0]['width'][2], $attrs['border'][0]['type'], $attrs['border'][0]['color'] );
		}
		if ( ! empty( $attrs['border'][0]['width'][3] ) ) {
			$css .= sprintf( 'border-left: %spx %s %s;', $attrs['border'][0]['width'][3], $attrs['border'][0]['type'], $attrs['border'][0]['color'] );
		}
		$css .= '}';
	}

	return $css;
}

function title( $attrs, $index = 0 ) {
	$css = '';

	if ( $index === 2 && ! empty( $attrs['title'][0]['color'] ) ) {
		$css .= sprintf( '#%s .title {', $attrs['uniqueID'] );
		$css .= sprintf( 'color: %s;', $attrs['title'][0]['color'] );
		$css .= '}';
	}

	if ( $index === 2 && ! empty( $attrs['title'][0]['highlightColor'] ) ) {
		$css .= sprintf( '#%s .title mark {', $attrs['uniqueID'] );
		$css .= sprintf( 'color: %s;', $attrs['title'][0]['highlightColor'] );
		$css .= '}';
	}

	if ( $index === 2 && ! empty( $attrs['title'][0]['fontWeight'] ) ) {
		$css .= sprintf( '#%s .title {', $attrs['uniqueID'] );
		$css .= sprintf( 'font-weight: %s;', $attrs['title'][0]['fontWeight'] );
		$css .= '}';
	}

	if ( $index === 2 && ! empty( $attrs['title'][0]['letterSpacing'] ) ) {
		$css .= sprintf( '#%s .title {', $attrs['uniqueID'] );
		$css .= sprintf( 'letter-spacing: %sem;', $attrs['title'][0]['letterSpacing'] );
		$css .= '}';
	}

	if ( isset( $attrs['title'][ $index ]['padding'][0] ) ||
	     isset( $attrs['title'][ $index ]['padding'][1] ) ||
	     isset( $attrs['title'][ $index ]['padding'][2] ) ||
	     isset( $attrs['title'][ $index ]['padding'][3] )
	) {
		$css .= sprintf( '#%s .title {', $attrs['uniqueID'] );
		if ( isset( $attrs['title'][ $index ]['padding'][0] ) ) {
			$css .= sprintf( 'padding-top: %spx;', $attrs['title'][ $index ]['padding'][0] );
		}
		if ( isset( $attrs['title'][ $index ]['padding'][1] ) ) {
			$css .= sprintf( 'padding-right: %spx;', $attrs['title'][ $index ]['padding'][1] );
		}
		if ( isset( $attrs['title'][ $index ]['padding'][2] ) ) {
			$css .= sprintf( 'padding-bottom: %spx;', $attrs['title'][ $index ]['padding'][2] );
		}
		if ( isset( $attrs['title'][ $index ]['padding'][3] ) ) {
			$css .= sprintf( 'padding-left: %spx;', $attrs['title'][ $index ]['padding'][3] );
		}
		$css .= '}';
	}

	if ( isset( $attrs['title'][ $index ]['margin'][0] ) ||
	     isset( $attrs['title'][ $index ]['margin'][1] ) ||
	     isset( $attrs['title'][ $index ]['margin'][2] ) ||
	     isset( $attrs['title'][ $index ]['margin'][3] )
	) {
		$css .= sprintf( '#%s .title {', $attrs['uniqueID'] );
		if ( isset( $attrs['title'][ $index ]['margin'][0] ) ) {
			$css .= sprintf( 'margin-top: %spx;', $attrs['title'][ $index ]['margin'][0] );
		}
		if ( isset( $attrs['title'][ $index ]['margin'][1] ) ) {
			$css .= sprintf( 'margin-right: %spx;', $attrs['title'][ $index ]['margin'][1] );
		}
		if ( isset( $attrs['title'][ $index ]['margin'][2] ) ) {
			$css .= sprintf( 'margin-bottom: %spx;', $attrs['title'][ $index ]['margin'][2] );
		}
		if ( isset( $attrs['title'][ $index ]['margin'][3] ) ) {
			$css .= sprintf( 'margin-left: %spx;', $attrs['title'][ $index ]['margin'][3] );
		}
		$css .= '}';
	}

	if ( ! empty( $attrs['title'][ $index ]['fontSize'] ) ) {
		$css .= sprintf( '#%s .title {', $attrs['uniqueID'] );
		$css .= sprintf( 'font-size: %spx;', $attrs['title'][ $index ]['fontSize'] );
		$css .= sprintf( 'line-height: %spx;', $attrs['title'][ $index ]['lineHeight'] );
		$css .= '}';
	}

	return $css;
}

function content( $attrs, $index = 0 ) {
	$css = '';

	if ( $index === 2 && ! empty( $attrs['content'][0]['color'] ) ) {
		$css .= sprintf( '#%s .content {', $attrs['uniqueID'] );
		$css .= sprintf( 'color: %s;', $attrs['content'][0]['color'] );
		$css .= '}';
	}

	if ( $index === 2 && ! empty( $attrs['content'][0]['highlightColor'] ) ) {
		$css .= sprintf( '#%s .content mark {', $attrs['uniqueID'] );
		$css .= sprintf( 'color: %s;', $attrs['content'][0]['highlightColor'] );
		$css .= '}';
	}

	if ( $index === 2 && ! empty( $attrs['content'][0]['fontWeight'] ) ) {
		$css .= sprintf( '#%s .content {', $attrs['uniqueID'] );
		$css .= sprintf( 'font-weight: %s;', $attrs['content'][0]['fontWeight'] );
		$css .= '}';
	}

	if ( $index === 2 && ! empty( $attrs['content'][0]['letterSpacing'] ) ) {
		$css .= sprintf( '#%s .content {', $attrs['uniqueID'] );
		$css .= sprintf( 'letter-spacing: %sem;', $attrs['content'][0]['letterSpacing'] );
		$css .= '}';
	}

	if ( isset( $attrs['content'][ $index ]['padding'][0] ) ||
	     isset( $attrs['content'][ $index ]['padding'][1] ) ||
	     isset( $attrs['content'][ $index ]['padding'][2] ) ||
	     isset( $attrs['content'][ $index ]['padding'][3] )
	) {
		$css .= sprintf( '#%s .content {', $attrs['uniqueID'] );
		if ( isset( $attrs['content'][ $index ]['padding'][0] ) ) {
			$css .= sprintf( 'padding-top: %spx;', $attrs['content'][ $index ]['padding'][0] );
		}
		if ( isset( $attrs['content'][ $index ]['padding'][1] ) ) {
			$css .= sprintf( 'padding-right: %spx;', $attrs['content'][ $index ]['padding'][1] );
		}
		if ( isset( $attrs['content'][ $index ]['padding'][2] ) ) {
			$css .= sprintf( 'padding-bottom: %spx;', $attrs['content'][ $index ]['padding'][2] );
		}
		if ( isset( $attrs['content'][ $index ]['padding'][3] ) ) {
			$css .= sprintf( 'padding-left: %spx;', $attrs['content'][ $index ]['padding'][3] );
		}
		$css .= '}';
	}

	if ( isset( $attrs['content'][ $index ]['margin'][0] ) ||
	     isset( $attrs['content'][ $index ]['margin'][1] ) ||
	     isset( $attrs['content'][ $index ]['margin'][2] ) ||
	     isset( $attrs['content'][ $index ]['margin'][3] )
	) {
		$css .= sprintf( '#%s .content {', $attrs['uniqueID'] );
		if ( isset( $attrs['content'][ $index ]['margin'][0] ) ) {
			$css .= sprintf( 'margin-top: %spx;', $attrs['content'][ $index ]['margin'][0] );
		}
		if ( isset( $attrs['content'][ $index ]['margin'][1] ) ) {
			$css .= sprintf( 'margin-right: %spx;', $attrs['content'][ $index ]['margin'][1] );
		}
		if ( isset( $attrs['content'][ $index ]['margin'][2] ) ) {
			$css .= sprintf( 'margin-bottom: %spx;', $attrs['content'][ $index ]['margin'][2] );
		}
		if ( isset( $attrs['content'][ $index ]['margin'][3] ) ) {
			$css .= sprintf( 'margin-left: %spx;', $attrs['content'][ $index ]['margin'][3] );
		}
		$css .= '}';
	}

	if ( ! empty( $attrs['content'][ $index ]['fontSize'] ) ) {
		$css .= sprintf( '#%s .content {', $attrs['uniqueID'] );
		$css .= sprintf( 'font-size: %spx;', $attrs['content'][ $index ]['fontSize'] );
		$css .= sprintf( 'line-height: %spx;', $attrs['content'][ $index ]['lineHeight'] );
		$css .= '}';
	}

	return $css;
}

function button( $attrs, $index = 0 ) {
	$css = '';

	if ( ! empty( $attrs['primaryLayout'][ $index ]['textAlign'] ) ) {
		$css .= sprintf( '#%s .button-wrapper {', $attrs['uniqueID'] );
		$css .= sprintf( 'justify-content: %s;', $attrs['primaryLayout'][ $index ]['textAlign'] !== 'right' ? $attrs['primaryLayout'][ $index ]['textAlign'] : 'flex-end' );
		$css .= '}';
	}

	if ( $index === 2 && ! empty( $attrs['layout'][0]['buttons'] ) ) {
		$i = 0;
		while ( $i <= $attrs['layout'][0]['buttons'] ) {
			$i++;
			if ( ! empty( $attrs['button'][ $i ]['fontSize'] ) ||
			     ! empty( $attrs['button'][ $i ]['letterSpacing'] ) ||
			     ! empty( $attrs['button'][ $i ]['letterWeight'] ) ||
			     ! empty( $attrs['button'][ $i ]['color'] ) ||
			     ! empty( $attrs['button'][ $i ]['bgColor'] ) ||
			     ! empty( $attrs['button'][ $i ]['borderColor'] )
			) {
				$css .= sprintf( '#%s .master-blocks-button.is-button-%s {', $attrs['uniqueID'], $i + 1 );
				$css .= ! empty( $attrs['button'][ $i ]['fontSize'] ) ? sprintf( 'font-size: %spx;', $attrs['button'][ $i ]['fontSize'] ) : null;
				$css .= ! empty( $attrs['button'][ $i ]['fontWeight'] ) ? sprintf( 'font-weight: %s;', $attrs['button'][ $i ]['fontWeight'] ) : null;
				$css .= ! empty( $attrs['button'][ $i ]['letterSpacing'] ) ? sprintf( 'letter-spacing: %sem;', $attrs['button'][ $i ]['letterSpacing'] ) : null;
				$css .= ! empty( $attrs['button'][ $i ]['color'] ) ? sprintf( 'color: %s;', $attrs['button'][ $i ]['color'] ) : null;
				$css .= ! empty( $attrs['button'][ $i ]['bgColor'] ) ? sprintf( 'background-color: %s;', $attrs['button'][ $i ]['bgColor'] ) : null;
				$css .= ! empty( $attrs['button'][ $i ]['borderColor'] ) ? sprintf( 'border-color: %s;', $attrs['button'][ $i ]['borderColor'] ) : null;
				$css .= '}';
			}

			if (
				! empty( $attrs['button'][ $i ]['hoverColor'] ) ||
				! empty( $attrs['button'][ $i ]['bgHoverColor'] ) ||
				! empty( $attrs['button'][ $i ]['borderHoverColor'] )
			) {
				$css .= sprintf( '#%s .master-blocks-button.is-button-%s:hover {', $attrs['uniqueID'], $i + 1 );
				$css .= ! empty( $attrs['button'][ $i ]['hoverColor'] ) ? sprintf( 'color: %s;', $attrs['button'][ $i ]['hoverColor'] ) : null;
				$css .= ! empty( $attrs['button'][ $i ]['bgHoverColor'] ) ? sprintf( 'background-color: %s;', $attrs['button'][ $i ]['bgHoverColor'] ) : null;
				$css .= ! empty( $attrs['button'][ $i ]['borderHoverColor'] ) ? sprintf( 'border-color: %s;', $attrs['button'][ $i ]['borderHoverColor'] ) : null;
				$css .= '}';
			}
		}
	}

	return $css;
}

function primary_layout( $attrs, $index = 0 ) {
	$css = '';
	if ( ! empty( $attrs['primaryLayout'][ $index ] ) ) {
		$css .= sprintf( '#%s .primary {', $attrs['uniqueID'] );
		if ( ! empty( $attrs['primaryLayout'][ $index ]['width'] ) ) {
			$css .= sprintf( 'width: %s;', $attrs['primaryLayout'][ $index ]['width'] . '%' );
		}
		if ( ! empty( $attrs['primaryLayout'][ $index ]['horizonAlign'] ) ) {
			$css .= sprintf( 'justify-self: %s;', $attrs['primaryLayout'][ $index ]['horizonAlign'] );
		}
		if ( ! empty( $attrs['primaryLayout'][ $index ]['verticalAlign'] ) ) {
			if ( $attrs['primaryLayout'][ $index ]['verticalAlign'] === 'hot' ) {
				$css .= sprintf( 'align-self: %s;', 'normal' );
				$css .= 'display: flex;flex-flow: column; justify-content: center;';
			} else {
				$css .= sprintf( 'align-self: %s;', $attrs['primaryLayout'][ $index ]['verticalAlign'] );
			}
		}
		if ( ! empty( $attrs['primaryLayout'][ $index ]['textAlign'] ) ) {
			$css .= sprintf( 'text-align: %s;', $attrs['primaryLayout'][ $index ]['textAlign'] );
		}
		if ( ! empty( $attrs['primaryLayout'][ $index ]['padding'] ) ) {
			$css .= sprintf(
				'padding: %s %s %s %s;',
				! empty( $attrs['primaryLayout'][ $index ]['padding'][0] ) ? $attrs['primaryLayout'][ $index ]['padding'][0] . 'px' : 0,
				! empty( $attrs['primaryLayout'][ $index ]['padding'][1] ) ? $attrs['primaryLayout'][ $index ]['padding'][1] . 'px' : 0,
				! empty( $attrs['primaryLayout'][ $index ]['padding'][2] ) ? $attrs['primaryLayout'][ $index ]['padding'][2] . 'px' : 0,
				! empty( $attrs['primaryLayout'][ $index ]['padding'][3] ) ? $attrs['primaryLayout'][ $index ]['padding'][3] . 'px' : 0
			);
		}
		$css .= '}';
		if ( $index === 2 && ! empty( $attrs['primaryLayout'][0]['bgColor'] ) && ! empty( $attrs['primaryLayout'][0]['bgColor'][0] ) ) {
			$css .= sprintf( '#%s .primary {', $attrs['uniqueID'] );
			$css .= 'position:relative';
			$css .= '}';
			$css .= sprintf( '#%s .primary::before {', $attrs['uniqueID'] );
			$css .= 'content:""; position: absolute; top: 0; right: 0; bottom: 0; left: 0;z-index:-1;';
			$css .= sprintf( 'background-color: %s;', $attrs['primaryLayout'][0]['bgColor'][0] );
			if ( ! empty( $attrs['primaryLayout'][0]['bgColor'][0] ) ) {
				$css .= sprintf( 'opacity: %s;', $attrs['primaryLayout'][0]['bgColor'][1] );
			}
			$css .= '}';
		}
	}

	return $css;
}

function secondary_layout( $attrs, $index = 0 ) {
	$css = '';
	if ( ! empty( $attrs['secondaryLayout'][ $index ] ) ) {
		$css .= sprintf( '#%s .secondary {', $attrs['uniqueID'] );
		if ( ! empty( $attrs['secondaryLayout'][ $index ]['width'] ) ) {
			$css .= sprintf( 'width: %s;', $attrs['secondaryLayout'][ $index ]['width'] . '%' );
		}
		if ( ! empty( $attrs['secondaryLayout'][ $index ]['horizonAlign'] ) ) {
			$css .= sprintf( 'justify-self: %s;', $attrs['secondaryLayout'][ $index ]['horizonAlign'] );
		}
		if ( ! empty( $attrs['secondaryLayout'][ $index ]['verticalAlign'] ) ) {
			$css .= sprintf( 'align-self: %s;', $attrs['secondaryLayout'][ $index ]['verticalAlign'] );
		}
		if ( ! empty( $attrs['secondaryLayout'][ $index ]['textAlign'] ) ) {
			$css .= sprintf( 'text-align: %s;', $attrs['secondaryLayout'][ $index ]['textAlign'] );
		}
		if ( $index === 2 && ! empty( $attrs['secondaryLayout'][0]['position'] ) ) {
			$css .= sprintf( 'order: %s;', $attrs['secondaryLayout'][0]['position'] );
		}
		$css .= '}';
	}

	return $css;
}

function layout( $attrs, $index = 0 ) {
	$css = '';
	if (
		! empty( $attrs['layout'][0]['ratio'] ) &&
		! empty( $attrs['layout'][0]['columns'] ) &&
		$attrs['layout'][0]['columns'] === 2
	) {
		$css .= sprintf( '#%s .wrapper {', $attrs['uniqueID'] );
		$css .= sprintf( 'grid-template-columns: %s;', $attrs['layout'][0]['ratio'] );
		$css .= '}';
	}

	return $css;
}

function features( $attrs ) {
	$css = '';
	if ( ! empty( $attrs['features'][0]['textAlign'] ) ) {
		$css .= sprintf( '#%s.master-blocks-features .item {', $attrs['uniqueID'] );
		$css .= sprintf( 'text-align: %s;', $attrs['features'][0]['textAlign'] );
		$css .= '}';
	}

	if ( ! empty( $attrs['features'][0]['contentFontSize'] ) || ! empty( $attrs['features'][0]['contentColor'] ) ) {
		$css .= sprintf( '#%s.master-blocks-features .item p {', $attrs['uniqueID'] );
		if ( ! empty( $attrs['features'][0]['contentFontSize'] ) ) {
			$css .= sprintf( 'font-size: %spx;', $attrs['features'][0]['contentFontSize'] );
		}
		if ( ! empty( $attrs['features'][0]['contentLineHeight'] ) ) {
			$css .= sprintf( 'line-height: %spx;', $attrs['features'][0]['contentLineHeight'] );
		}
		if ( ! empty( $attrs['features'][0]['contentColor'] ) ) {
			$css .= sprintf( 'color: %s;', $attrs['features'][0]['contentColor'] );
		}
		$css .= '}';
	}

	if ( ! empty( $attrs['features'][0]['iconSize'] ) ) {
		$css .= sprintf( '#%s.master-blocks-features .item i {', $attrs['uniqueID'] );
		$css .= sprintf( 'font-size: %spx;', $attrs['features'][0]['iconSize'] );
		$css .= '}';
	}

	if ( ! empty( $attrs['features'][0]['titleFontSize'] ) ) {
		$css .= sprintf( '#%s.master-blocks-features .item h3 {', $attrs['uniqueID'] );
		$css .= sprintf( 'font-size: %spx;', $attrs['features'][0]['titleFontSize'] );
		if ( ! empty( $attrs['features'][0]['titleLineHeight'] ) ) {
			$css .= sprintf( 'line-height: %spx;', $attrs['features'][0]['titleLineHeight'] );
		}
		$css .= '}';
	}

	if ( ! empty( $attrs['features'][0]['linkFontSize'] ) ) {
		$css .= sprintf( '#%s.master-blocks-features .item a.more {', $attrs['uniqueID'] );
		$css .= sprintf( 'font-size: %spx;', $attrs['features'][0]['linkFontSize'] );
		$css .= '}';
	}

	return $css;
}

class Helpers_Frontend {
}
