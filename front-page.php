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
	<?php foreach (cdplay_get_homepage_sections() as $cdplay_homepage_section) : ?>
		<?php if (cdplay_is_homepage_section_enabled($cdplay_homepage_section['slug'])) : ?>
			<?php get_template_part($cdplay_homepage_section['template']); ?>
		<?php endif; ?>
	<?php endforeach; ?>
</main>

<?php
get_footer();
