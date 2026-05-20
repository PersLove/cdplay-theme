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

$cdplay_rendered_homepage_sections = 0;
?>

<main id="primary" class="cdplay-site-main">
	<?php foreach (cdplay_get_homepage_sections() as $cdplay_homepage_section) : ?>
		<?php if (cdplay_is_homepage_section_enabled($cdplay_homepage_section['slug'])) : ?>
			<?php ob_start(); ?>
			<?php get_template_part($cdplay_homepage_section['template']); ?>
			<?php $cdplay_homepage_section_output = ob_get_clean(); ?>
			<?php if ('' !== trim($cdplay_homepage_section_output)) : ?>
				<?php ++$cdplay_rendered_homepage_sections; ?>
				<?php echo $cdplay_homepage_section_output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; ?>
	<?php echo "\n" . '<!-- CDPLAY homepage rendered sections: ' . esc_html((string) $cdplay_rendered_homepage_sections) . ' -->' . "\n"; ?>
</main>

<?php
get_footer();
