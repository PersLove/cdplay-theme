<?php
/**
 * Homepage sections manager.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Return homepage sections in display order.
 *
 * @return array<string, array{slug: string, label: string, template: string}>
 */
function cdplay_get_homepage_sections(): array {
	return array(
		'hero'              => array(
			'slug'     => 'hero',
			'label'    => __('Hero', 'cdplay'),
			'template' => 'template-parts/sections/hero',
		),
		'platform-hubs'     => array(
			'slug'     => 'platform-hubs',
			'label'    => __('Platform Hubs', 'cdplay'),
			'template' => 'template-parts/sections/platform-hubs',
		),
		'find-your-console' => array(
			'slug'     => 'find-your-console',
			'label'    => __('Find Your Console', 'cdplay'),
			'template' => 'template-parts/sections/find-your-console',
		),
		'what-to-play'      => array(
			'slug'     => 'what-to-play',
			'label'    => __('What To Play', 'cdplay'),
			'template' => 'template-parts/sections/what-to-play',
		),
		'ready-to-play'     => array(
			'slug'     => 'ready-to-play',
			'label'    => __('Ready To Play', 'cdplay'),
			'template' => 'template-parts/sections/ready-to-play',
		),
		'services'          => array(
			'slug'     => 'services',
			'label'    => __('Services', 'cdplay'),
			'template' => 'template-parts/sections/services',
		),
		'cdplay-experience' => array(
			'slug'     => 'cdplay-experience',
			'label'    => __('CDPLAY Experience', 'cdplay'),
			'template' => 'template-parts/sections/cdplay-experience',
		),
		'guides'            => array(
			'slug'     => 'guides',
			'label'    => __('Guides', 'cdplay'),
			'template' => 'template-parts/sections/guides',
		),
	);
}

/**
 * Check whether a homepage section is enabled.
 *
 * @param string $slug Section slug.
 * @return bool
 */
function cdplay_is_homepage_section_enabled(string $slug): bool {
	$section_settings = get_option('cdplay_homepage_sections', null);

	if (!is_array($section_settings)) {
		return true;
	}

	if (!array_key_exists($slug, $section_settings)) {
		return true;
	}

	return !empty($section_settings[$slug]);
}

/**
 * Sanitize homepage sections settings.
 *
 * @param mixed $input Raw option input.
 * @return array<string, int>
 */
function cdplay_sanitize_homepage_sections($input): array {
	$input             = is_array($input) ? $input : array();
	$sections          = cdplay_get_homepage_sections();
	$sanitized_options = array();

	foreach ($sections as $section) {
		$slug                     = $section['slug'];
		$sanitized_options[$slug] = !empty($input[$slug]) ? 1 : 0;
	}

	return $sanitized_options;
}

/**
 * Register homepage sections setting.
 */
function cdplay_register_homepage_sections_setting(): void {
	register_setting(
		'cdplay_homepage_sections',
		'cdplay_homepage_sections',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'cdplay_sanitize_homepage_sections',
			'default'           => array(),
		)
	);
}
add_action('admin_init', 'cdplay_register_homepage_sections_setting');

/**
 * Add homepage sections admin page.
 */
function cdplay_add_homepage_sections_page(): void {
	add_theme_page(
		__('CDPLAY Homepage', 'cdplay'),
		__('CDPLAY Homepage', 'cdplay'),
		'manage_options',
		'cdplay-homepage',
		'cdplay_render_homepage_sections_page'
	);
}
add_action('admin_menu', 'cdplay_add_homepage_sections_page');

/**
 * Render homepage sections admin page.
 */
function cdplay_render_homepage_sections_page(): void {
	if (!current_user_can('manage_options')) {
		return;
	}

	$sections         = cdplay_get_homepage_sections();
	$section_settings = get_option('cdplay_homepage_sections', null);
	$section_settings = is_array($section_settings) ? $section_settings : array();
	?>
	<div class="wrap">
		<h1><?php esc_html_e('CDPLAY Homepage', 'cdplay'); ?></h1>

		<form method="post" action="options.php">
			<?php settings_fields('cdplay_homepage_sections'); ?>

			<table class="form-table" role="presentation">
				<tbody>
					<?php foreach ($sections as $section) : ?>
						<?php
						$slug    = $section['slug'];
						$enabled = !array_key_exists($slug, $section_settings) || !empty($section_settings[$slug]);
						?>
						<tr>
							<th scope="row">
								<?php echo esc_html($section['label']); ?>
							</th>
							<td>
								<label for="cdplay-homepage-section-<?php echo esc_attr($slug); ?>">
									<input
										type="checkbox"
										id="cdplay-homepage-section-<?php echo esc_attr($slug); ?>"
										name="cdplay_homepage_sections[<?php echo esc_attr($slug); ?>]"
										value="1"
										<?php checked($enabled); ?>
									/>
									<?php esc_html_e('Enabled', 'cdplay'); ?>
								</label>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
