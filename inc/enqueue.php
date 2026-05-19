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
	wp_enqueue_style(
		'cdplay-main',
		CDPLAY_THEME_URI . '/assets/css/main.css',
		array(),
		CDPLAY_VERSION
	);

	wp_enqueue_script(
		'cdplay-main',
		CDPLAY_THEME_URI . '/assets/js/main.js',
		array(),
		CDPLAY_VERSION,
		true
	);
}
add_action('wp_enqueue_scripts', 'cdplay_enqueue_assets');
