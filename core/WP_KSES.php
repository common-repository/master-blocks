<?php

namespace Master_Blocks\core;

class WP_KSES {
	public $context_defaults = [
		'default'      => [
			'h1'      => [
				'id'    => true,
				'class' => true,
			],
			'h2'      => [
				'id'    => true,
				'class' => true,
			],
			'h3'      => [
				'id'    => true,
				'class' => true,
			],
			'h4'      => [
				'id'    => true,
				'class' => true,
			],
			'div'     => [
				'id'    => true,
				'class' => true,
			],
			'b'     => [
				'id'    => true,
				'class' => true,
			],
			'section' => [
				'id'    => true,
				'class' => true,
			],
			'canvas'  => [
				'id'     => true,
				'class'  => true,
				'width'  => true,
				'height' => true,
			],
			'button'  => [
				'id'         => true,
				'class'      => true,
				'aria-label' => true,
				'onclick'    => true,
			],
			'ul'      => [
				'id'    => true,
				'class' => true,
			],
			'li'      => [
				'id'    => true,
				'class' => true,
			],
			'time'    => [
				'id'       => true,
				'class'    => true,
				'datetime' => true,
			],
			'span'    => [
				'id'         => true,
				'class'      => true,
				'aria-label' => true,
			],
			'a'       => [
				'id'        => true,
				'data-slug' => true,
				'class'     => true,
				'href'      => true,
				'target'    => true,
				'rel'       => true,
				'title'     => true,
			],
			'p'       => [
				'id'    => true,
				'class' => true,
			],
			'strong'  => [],
			'picture' => [
				'id'    => true,
				'class' => true,
			],
			'source'  => [
				'data-srcset' => true,
				'media'       => true,
				'srcset'      => true,
			],
			'img'     => [
				'data-src' => true,
				'src'      => true,
				'alt'      => true,
				'id'       => true,
				'class'    => true,
				'width'    => true,
				'height'   => true,
			],
			'svg'     => [
				'class'       => true,
				'aria-hidden' => true,
				'role'        => true,
			],
			'use'     => [
				'xlink:href' => true,
			],
		],
		'image'        => [
			'div'        => [
				'id'    => true,
				'class' => true,
			],
			'figure'     => [
				'align'     => true,
				'dir'       => true,
				'lang'      => true,
				'xml:lang'  => true,
				'itemprop'  => true,
				'itemscope' => true,
				'itemtype'  => true,
			],
			'figcaption' => [
				'align'     => true,
				'dir'       => true,
				'lang'      => true,
				'xml:lang'  => true,
				'itemprop'  => true,
				'itemscope' => true,
				'itemtype'  => true,
			],
			'picture'    => [
				'id'    => true,
				'class' => true,
			],
			'source'     => [
				'data-srcset' => true,
				'media'       => true,
				'srcset'      => true,
			],
			'img'        => [
				'data-src' => true,
				'src'      => true,
				'alt'      => true,
				'id'       => true,
				'class'    => true,
				'width'    => true,
				'height'   => true,
			],
		],
		'widget_field' => [
			'label'  => [
				'id'    => true,
				'class' => true,
				'for'   => true,
			],
			'input'  => [
				'type'       => true,
				'id'         => true,
				'class'      => true,
				'field_name' => true,
				'name'       => true,
				'value'      => true,
				'onclick'    => true,
				'style'      => true,
			],
			'select' => [
				'id'            => true,
				'class'         => true,
				'field_name'    => true,
				'name'          => true,
				'multiple'      => true,
				'data-multiple' => true,
			],
			'option' => [
				'selected' => true,
				'value'    => true,
			],
			'img'    => [
				'src'   => true,
				'alt'   => true,
				'id'    => true,
				'class' => true,
			],
			'p'      => [
				'id'    => true,
				'class' => true,
			],
			'br'     => [],
			'span'   => [
				'id'         => true,
				'class'      => true,
				'field_name' => true,
			],
		],
		'svg'          => [
			'svg' => [
				'class'       => true,
				'aria-hidden' => true,
				'role'        => true,
			],
			'use' => [
				'xlink:href' => true,
			],
		],
		'svg_content'  => [
			'svg'    => [
				'xmlns'       => true,
				'xmlns:xlink' => true,
			],
			'symbol' => [
				'id'      => true,
				'viewBox' => true,
				'xmlns'   => true,
			],
			'path'   => [
				'd' => true,
			],
		],
		'breadcrumb'   => [
			'div'  => [
				'id'        => true,
				'class'     => true,
				'itemscope' => true,
				'itemtype'  => true,
			],
			'ul'   => [
				'id'    => true,
				'class' => true,
			],
			'span' => [
				'id'         => true,
				'class'      => true,
				'aria-label' => true,
				'itemprop'   => true,
				'itemscope'  => true,
			],
			'li'   => [
				'id'    => true,
				'class' => true,
			],
			'a'    => [
				'id'        => true,
				'class'     => true,
				'href'      => true,
				'target'    => true,
				'rel'       => true,
				'title'     => true,
				'itemprop'  => true,
				'itemscope' => true,
			],
		],
		'title'        => [
			'h1'     => [
				'id'    => true,
				'class' => true,
			],
			'h2'     => [
				'id'    => true,
				'class' => true,
			],
			'h3'     => [
				'id'    => true,
				'class' => true,
			],
			'a'      => [
				'id'     => true,
				'class'  => true,
				'href'   => true,
				'target' => true,
				'rel'    => true,
				'title'  => true,
			],
			'span'   => [
				'id'    => true,
				'class' => true,
			],
			'strong' => true,
		],
		'price'        => [
			'span' => [
				'id'    => true,
				'class' => true,
			],
			'ins'  => true,
			'del'  => true,
		],
		'span'         => [
			'span' => [
				'id'    => true,
				'class' => true,
			],
		],
		'icon'         => [
			'i' => [
				'id'    => true,
				'class' => true,
			],
		],
		'link'         => [
			'a' => [
				'id'     => true,
				'class'  => true,
				'href'   => true,
				'target' => true,
				'rel'    => true,
				'title'  => true,
			],
		],
		'heading'      => [
			'h1'     => [
				'id'    => true,
				'class' => true,
			],
			'h2'     => [
				'id'    => true,
				'class' => true,
			],
			'h3'     => [
				'id'    => true,
				'class' => true,
			],
			'h4'     => [
				'id'    => true,
				'class' => true,
			],
			'h5'     => [
				'id'    => true,
				'class' => true,
			],
			'h6'     => [
				'id'    => true,
				'class' => true,
			],
			'p'      => [
				'id'    => true,
				'class' => true,
			],
			'div'    => [
				'id'    => true,
				'class' => true,
			],
			'span'   => [
				'id'    => true,
				'class' => true,
			],
			'a'      => [
				'id'     => true,
				'class'  => true,
				'href'   => true,
				'target' => true,
				'rel'    => true,
				'title'  => true,
			],
			'strong' => [],
		],
		'iframe'       => [
			'data-src'        => true,
			'src'             => true,
			'height'          => true,
			'width'           => true,
			'frameborder'     => true,
			'allowfullscreen' => true,
		],
	];

	public function __construct() {
		add_filter( 'wp_kses_allowed_html', [ $this, 'allowed_html' ], 2, 99 );
	}

	public function allowed_html( $allowed_tags, $context ) {
		$contexts = ! empty( get_theme_support( 'kses_contexts' )[0] ) ? get_theme_support( 'kses_contexts' )[0] : [];
		$contexts = wp_parse_args( $contexts, $this->context_defaults );

		foreach ( $contexts as $name => $tags ) {
			if ( $context === $name ) {
				$allowed_tags = $tags;
			}
		}

		return $allowed_tags;
	}
}
