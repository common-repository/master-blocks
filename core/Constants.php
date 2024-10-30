<?php

namespace Master_Blocks\core;

define( __NAMESPACE__ . '\DEV_MODE', 'disable' );
define( __NAMESPACE__ . '\PLUGIN_BASE', Plugin::$cached_plugin['base'] );
define( __NAMESPACE__ . '\PLUGIN_NAME', Plugin::$cached_plugin['name'] );
define( __NAMESPACE__ . '\PLUGIN_SLUG', Plugin::$cached_plugin['slug'] );
define( __NAMESPACE__ . '\PLUGIN_SNAKE_SLUG', Plugin::$cached_plugin['snake_slug'] );
define( __NAMESPACE__ . '\PLUGIN_DESC', Plugin::$cached_plugin['description'] );
define( __NAMESPACE__ . '\PLUGIN_URI', Plugin::$cached_plugin['uri'] );
define( __NAMESPACE__ . '\PLUGIN_DOCUMENT_URI', Plugin::$cached_plugin['document_uri'] );
define( __NAMESPACE__ . '\PLUGIN_VERSION', Plugin::$cached_plugin['version'] );
define( __NAMESPACE__ . '\PLUGIN_AUTHOR_NAME', Plugin::$cached_plugin['author_name'] );
define( __NAMESPACE__ . '\PLUGIN_AUTHOR_URI', Plugin::$cached_plugin['author_uri'] );
define( __NAMESPACE__ . '\PLUGIN_TEXT_DOMAIN', Plugin::$cached_plugin['text_domain'] );
define( __NAMESPACE__ . '\PLUGIN_AUTHOR', Plugin::$cached_plugin['author'] );
define( __NAMESPACE__ . '\PLUGIN_TITLE', Plugin::$cached_plugin['title'] );

const DS = DIRECTORY_SEPARATOR;

const ASSETS_DIR   = 'assets/';
const LIBS_DIR     = ASSETS_DIR . 'libs/';
const PATTERNS_DIR = ASSETS_DIR . 'svg/patterns/';
const MARKERS_DIR  = ASSETS_DIR . 'svg/markers/';

class Constants {
}
