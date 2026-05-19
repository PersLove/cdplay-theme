<?php
/**
 * Front page template.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>

<main id="primary" class="cdplay-site-main">
	<?php get_template_part('template-parts/sections/hero'); ?>
	<?php get_template_part('template-parts/sections/platform-hubs'); ?>
	<?php get_template_part('template-parts/sections/find-your-console'); ?>
	<?php get_template_part('template-parts/sections/what-to-play'); ?>
	<?php get_template_part('template-parts/sections/ready-to-play'); ?>
	<?php get_template_part('template-parts/sections/services'); ?>
	<?php get_template_part('template-parts/sections/cdplay-experience'); ?>
	<?php get_template_part('template-parts/sections/guides'); ?>
</main>

<?php
get_footer();
