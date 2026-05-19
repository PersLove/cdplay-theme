<?php
/**
 * CDPLAY 2.0 theme functions.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

define('CDPLAY_VERSION', '2.0.0');
define('CDPLAY_THEME_DIR', get_template_directory());
define('CDPLAY_THEME_URI', get_template_directory_uri());

$cdplay_includes = array(
	'/inc/theme-setup.php',
	'/inc/enqueue.php',
);

foreach ($cdplay_includes as $cdplay_file) {
	require_once CDPLAY_THEME_DIR . $cdplay_file;
}
