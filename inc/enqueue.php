<?php
/**
 * Theme assets.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Enqueue frontend styles and scripts.
 */
function cdplay_enqueue_assets() {
	$cdplay_theme_version = wp_get_theme()->get('Version');
	$cdplay_main_css_path = CDPLAY_THEME_DIR . '/assets/css/main.css';
	$cdplay_main_js_path  = CDPLAY_THEME_DIR . '/assets/js/main.js';
	$cdplay_main_css_ver  = file_exists($cdplay_main_css_path) ? filemtime($cdplay_main_css_path) : $cdplay_theme_version;
	$cdplay_main_js_ver   = file_exists($cdplay_main_js_path) ? filemtime($cdplay_main_js_path) : $cdplay_theme_version;

	wp_enqueue_style(
		'cdplay-main',
		CDPLAY_THEME_URI . '/assets/css/main.css',
		array(),
		$cdplay_main_css_ver
	);

	wp_enqueue_script(
		'cdplay-main',
		CDPLAY_THEME_URI . '/assets/js/main.js',
		array(),
		$cdplay_main_js_ver,
		true
	);
}
add_action('wp_enqueue_scripts', 'cdplay_enqueue_assets');
