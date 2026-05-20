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
 * Return editable hero content fields.
 *
 * @return array<string, array{label: string, option: string, type: string}>
 */
function cdplay_get_hero_content_fields(): array {
	return array(
		'eyebrow'           => array(
			'label'  => __('Hero Eyebrow', 'cdplay'),
			'option' => 'cdplay_hero_eyebrow',
			'type'   => 'text',
		),
		'title'             => array(
			'label'  => __('Hero Title', 'cdplay'),
			'option' => 'cdplay_hero_title',
			'type'   => 'textarea',
		),
		'description'       => array(
			'label'  => __('Hero Description', 'cdplay'),
			'option' => 'cdplay_hero_description',
			'type'   => 'textarea',
		),
		'primary_cta_text'  => array(
			'label'  => __('Hero Primary CTA Text', 'cdplay'),
			'option' => 'cdplay_hero_primary_cta_text',
			'type'   => 'text',
		),
		'primary_cta_url'   => array(
			'label'  => __('Hero Primary CTA URL', 'cdplay'),
			'option' => 'cdplay_hero_primary_cta_url',
			'type'   => 'url',
		),
		'secondary_cta_text' => array(
			'label'  => __('Hero Secondary CTA Text', 'cdplay'),
			'option' => 'cdplay_hero_secondary_cta_text',
			'type'   => 'text',
		),
		'secondary_cta_url'  => array(
			'label'  => __('Hero Secondary CTA URL', 'cdplay'),
			'option' => 'cdplay_hero_secondary_cta_url',
			'type'   => 'url',
		),
	);
}

/**
 * Return editable hero image fields.
 *
 * @return array<string, array{label: string, option: string, recommendation: string}>
 */
function cdplay_get_hero_image_fields(): array {
	return array(
		'desktop' => array(
			'label'          => __('Hero Desktop Image', 'cdplay'),
			'option'         => 'cdplay_hero_desktop_image_id',
			'recommendation' => __('Desktop recommended: 2560x1200 WebP', 'cdplay'),
		),
		'mobile'  => array(
			'label'          => __('Hero Mobile Image', 'cdplay'),
			'option'         => 'cdplay_hero_mobile_image_id',
			'recommendation' => __('Mobile recommended: 1080x1440 WebP', 'cdplay'),
		),
	);
}

/**
 * Get an editable hero field value.
 *
 * @param string $field Field key.
 * @param string $fallback Fallback value.
 * @return string
 */
function cdplay_get_hero_field(string $field, string $fallback = ''): string {
	$fields = cdplay_get_hero_content_fields();

	if (!isset($fields[$field])) {
		return $fallback;
	}

	$value = get_option($fields[$field]['option'], '');

	if (!is_string($value) || '' === trim($value)) {
		return $fallback;
	}

	return $value;
}

/**
 * Get a hero image attachment ID.
 *
 * @param string $type Image type.
 * @return int
 */
function cdplay_get_hero_image_id(string $type): int {
	$fields = cdplay_get_hero_image_fields();

	if (!isset($fields[$type])) {
		return 0;
	}

	return absint(get_option($fields[$type]['option'], 0));
}

/**
 * Sanitize hero content fields.
 *
 * @param mixed $input Raw option input.
 * @return string
 */
function cdplay_sanitize_hero_field($input): string {
	return is_string($input) ? sanitize_text_field($input) : '';
}

/**
 * Sanitize hero textarea fields.
 *
 * @param mixed $input Raw option input.
 * @return string
 */
function cdplay_sanitize_hero_textarea($input): string {
	return is_string($input) ? sanitize_textarea_field($input) : '';
}

/**
 * Sanitize hero URL fields.
 *
 * @param mixed $input Raw option input.
 * @return string
 */
function cdplay_sanitize_hero_url($input): string {
	return is_string($input) ? esc_url_raw($input) : '';
}

/**
 * Sanitize hero image attachment IDs.
 *
 * @param mixed $input Raw option input.
 * @return int
 */
function cdplay_sanitize_hero_image_id($input): int {
	return absint($input);
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

	foreach (cdplay_get_hero_content_fields() as $field) {
		$sanitize_callback = 'cdplay_sanitize_hero_field';

		if ('textarea' === $field['type']) {
			$sanitize_callback = 'cdplay_sanitize_hero_textarea';
		}

		if ('url' === $field['type']) {
			$sanitize_callback = 'cdplay_sanitize_hero_url';
		}

		register_setting(
			'cdplay_homepage_sections',
			$field['option'],
			array(
				'type'              => 'string',
				'sanitize_callback' => $sanitize_callback,
				'default'           => '',
			)
		);
	}

	foreach (cdplay_get_hero_image_fields() as $field) {
		register_setting(
			'cdplay_homepage_sections',
			$field['option'],
			array(
				'type'              => 'integer',
				'sanitize_callback' => 'cdplay_sanitize_hero_image_id',
				'default'           => 0,
			)
		);
	}
}
add_action('admin_init', 'cdplay_register_homepage_sections_setting');

/**
 * Enqueue assets for the CDPLAY Homepage admin page.
 *
 * @param string $hook_suffix Current admin page hook.
 */
function cdplay_enqueue_homepage_admin_assets(string $hook_suffix): void {
	if ('appearance_page_cdplay-homepage' !== $hook_suffix) {
		return;
	}

	wp_enqueue_media();

	wp_enqueue_script(
		'cdplay-admin-homepage',
		CDPLAY_THEME_URI . '/assets/js/admin-homepage.js',
		array(),
		CDPLAY_VERSION,
		true
	);
}
add_action('admin_enqueue_scripts', 'cdplay_enqueue_homepage_admin_assets');

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
	$hero_fields      = cdplay_get_hero_content_fields();
	$hero_image_fields = cdplay_get_hero_image_fields();
	$section_settings = get_option('cdplay_homepage_sections', null);
	$section_settings = is_array($section_settings) ? $section_settings : array();
	?>
	<div class="wrap">
		<h1><?php esc_html_e('CDPLAY Homepage', 'cdplay'); ?></h1>

		<form method="post" action="options.php">
			<?php settings_fields('cdplay_homepage_sections'); ?>

			<h2><?php esc_html_e('Hero Content', 'cdplay'); ?></h2>

			<table class="form-table" role="presentation">
				<tbody>
					<?php foreach ($hero_fields as $field) : ?>
						<?php $value = get_option($field['option'], ''); ?>
						<tr>
							<th scope="row">
								<label for="<?php echo esc_attr($field['option']); ?>">
									<?php echo esc_html($field['label']); ?>
								</label>
							</th>
							<td>
								<?php if ('textarea' === $field['type']) : ?>
									<textarea
										id="<?php echo esc_attr($field['option']); ?>"
										name="<?php echo esc_attr($field['option']); ?>"
										class="large-text"
										rows="3"
									><?php echo esc_textarea(is_string($value) ? $value : ''); ?></textarea>
								<?php else : ?>
									<input
										type="<?php echo 'url' === $field['type'] ? 'url' : 'text'; ?>"
										id="<?php echo esc_attr($field['option']); ?>"
										name="<?php echo esc_attr($field['option']); ?>"
										value="<?php echo esc_attr(is_string($value) ? $value : ''); ?>"
										class="regular-text"
									/>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>

					<?php foreach ($hero_image_fields as $field) : ?>
						<?php
						$image_id  = absint(get_option($field['option'], 0));
						$image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
						?>
						<tr>
							<th scope="row">
								<?php echo esc_html($field['label']); ?>
							</th>
							<td>
								<div class="cdplay-admin-media-field" data-cdplay-media-field>
									<input
										type="hidden"
										id="<?php echo esc_attr($field['option']); ?>"
										name="<?php echo esc_attr($field['option']); ?>"
										value="<?php echo esc_attr((string) $image_id); ?>"
										data-cdplay-media-input
									/>

									<p>
										<button type="button" class="button" data-cdplay-media-select>
											<?php esc_html_e('Select image', 'cdplay'); ?>
										</button>
										<button type="button" class="button" data-cdplay-media-remove>
											<?php esc_html_e('Remove', 'cdplay'); ?>
										</button>
									</p>

									<p class="description">
										<?php echo esc_html($field['recommendation']); ?>
									</p>

									<img
										src="<?php echo esc_url($image_url ? $image_url : ''); ?>"
										alt=""
										style="<?php echo esc_attr($image_url ? 'display:block;max-width:320px;height:auto;margin-top:12px;' : 'display:none;max-width:320px;height:auto;margin-top:12px;'); ?>"
										data-cdplay-media-preview
									/>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<h2><?php esc_html_e('Sections Manager', 'cdplay'); ?></h2>

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
