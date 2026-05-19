<?php
/**
 * Theme setup and feature support.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Register theme supports and navigation locations.
 */
function cdplay_theme_setup() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');

	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 600,
			'single_image_width'    => 900,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'max_rows'        => 6,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);

	register_nav_menus(
		array(
			'primary' => esc_html__('Primary Menu', 'cdplay'),
			'footer'  => esc_html__('Footer Menu', 'cdplay'),
		)
	);
}
add_action('after_setup_theme', 'cdplay_theme_setup');
