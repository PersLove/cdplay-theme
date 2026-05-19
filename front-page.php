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

	<section class="cdplay-front-section cdplay-front-section--platforms" aria-labelledby="cdplay-platforms-title">
		<div class="cdplay-container">
			<h2 id="cdplay-platforms-title"><?php esc_html_e('Platform hubs', 'cdplay'); ?></h2>
		</div>
	</section>

	<section class="cdplay-front-section cdplay-front-section--selection" aria-labelledby="cdplay-selection-title">
		<div class="cdplay-container">
			<h2 id="cdplay-selection-title"><?php esc_html_e('Selection', 'cdplay'); ?></h2>
		</div>
	</section>

	<section class="cdplay-front-section cdplay-front-section--releases" aria-labelledby="cdplay-releases-title">
		<div class="cdplay-container">
			<h2 id="cdplay-releases-title"><?php esc_html_e('Releases', 'cdplay'); ?></h2>
		</div>
	</section>

	<section class="cdplay-front-section cdplay-front-section--trade-in" aria-labelledby="cdplay-trade-in-title">
		<div class="cdplay-container">
			<h2 id="cdplay-trade-in-title"><?php esc_html_e('Trade-in', 'cdplay'); ?></h2>
		</div>
	</section>

	<section class="cdplay-front-section cdplay-front-section--blog" aria-labelledby="cdplay-blog-title">
		<div class="cdplay-container">
			<h2 id="cdplay-blog-title"><?php esc_html_e('Blog', 'cdplay'); ?></h2>
		</div>
	</section>
</main>

<?php
get_footer();
