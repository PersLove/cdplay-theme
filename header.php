<?php
/**
 * The header for the theme.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="cdplay-site">
	<a class="cdplay-skip-link" href="#primary">
		<?php esc_html_e('Skip to content', 'cdplay'); ?>
	</a>

	<?php get_template_part('template-parts/layout/site-header'); ?>
