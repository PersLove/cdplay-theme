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
			'label'    => __('Платформы', 'cdplay'),
			'template' => 'template-parts/sections/platform-hubs',
		),
		'find-your-console' => array(
			'slug'     => 'find-your-console',
			'label'    => __('Подобрать себе', 'cdplay'),
			'template' => 'template-parts/sections/find-your-console',
		),
		'what-to-play'      => array(
			'slug'     => 'what-to-play',
			'label'    => __('Во что поиграть', 'cdplay'),
			'template' => 'template-parts/sections/what-to-play',
		),
		'ready-to-play'     => array(
			'slug'     => 'ready-to-play',
			'label'    => __('Готово к игре', 'cdplay'),
			'template' => 'template-parts/sections/ready-to-play',
		),
		'services'          => array(
			'slug'     => 'services',
			'label'    => __('Услуги', 'cdplay'),
			'template' => 'template-parts/sections/services',
		),
		'cdplay-experience' => array(
			'slug'     => 'cdplay-experience',
			'label'    => __('CDPLAY Experience', 'cdplay'),
			'template' => 'template-parts/sections/cdplay-experience',
		),
		'guides'            => array(
			'slug'     => 'guides',
			'label'    => __('Блог и гайды', 'cdplay'),
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
 * Return editable Platform Hubs header fields.
 *
 * @return array<string, array{label: string, option: string, type: string}>
 */
function cdplay_get_platform_hubs_header_fields(): array {
	return array(
		'eyebrow'     => array(
			'label'  => __('Надзаголовок', 'cdplay'),
			'option' => 'cdplay_platform_hubs_eyebrow',
			'type'   => 'text',
		),
		'title'       => array(
			'label'  => __('Заголовок', 'cdplay'),
			'option' => 'cdplay_platform_hubs_title',
			'type'   => 'text',
		),
		'description' => array(
			'label'  => __('Описание', 'cdplay'),
			'option' => 'cdplay_platform_hubs_description',
			'type'   => 'textarea',
		),
	);
}

/**
 * Return editable Platform Hubs card fields.
 *
 * @return array<string, array{label: string, options: array<string, string>}>
 */
function cdplay_get_platform_hub_items(): array {
	return array(
		'playstation' => array(
			'label'   => __('PlayStation', 'cdplay'),
			'options' => array(
				'enabled'     => 'cdplay_platform_hub_playstation_enabled',
				'title'       => 'cdplay_platform_hub_playstation_title',
				'description' => 'cdplay_platform_hub_playstation_description',
				'cta_text'    => 'cdplay_platform_hub_playstation_cta_text',
				'cta_url'     => 'cdplay_platform_hub_playstation_cta_url',
			),
		),
		'xbox'        => array(
			'label'   => __('Xbox', 'cdplay'),
			'options' => array(
				'enabled'     => 'cdplay_platform_hub_xbox_enabled',
				'title'       => 'cdplay_platform_hub_xbox_title',
				'description' => 'cdplay_platform_hub_xbox_description',
				'cta_text'    => 'cdplay_platform_hub_xbox_cta_text',
				'cta_url'     => 'cdplay_platform_hub_xbox_cta_url',
			),
		),
		'nintendo'    => array(
			'label'   => __('Nintendo', 'cdplay'),
			'options' => array(
				'enabled'     => 'cdplay_platform_hub_nintendo_enabled',
				'title'       => 'cdplay_platform_hub_nintendo_title',
				'description' => 'cdplay_platform_hub_nintendo_description',
				'cta_text'    => 'cdplay_platform_hub_nintendo_cta_text',
				'cta_url'     => 'cdplay_platform_hub_nintendo_cta_url',
			),
		),
		'retro'       => array(
			'label'   => __('Retro', 'cdplay'),
			'options' => array(
				'enabled'     => 'cdplay_platform_hub_retro_enabled',
				'title'       => 'cdplay_platform_hub_retro_title',
				'description' => 'cdplay_platform_hub_retro_description',
				'cta_text'    => 'cdplay_platform_hub_retro_cta_text',
				'cta_url'     => 'cdplay_platform_hub_retro_cta_url',
			),
		),
	);
}

/**
 * Get an editable Platform Hubs header field value.
 *
 * @param string $field Field key.
 * @param string $fallback Fallback value.
 * @return string
 */
function cdplay_get_platform_hubs_field(string $field, string $fallback = ''): string {
	$fields = cdplay_get_platform_hubs_header_fields();

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
 * Get an editable Platform Hub card field value.
 *
 * @param string $slug Platform slug.
 * @param string $field Field key.
 * @param string $fallback Fallback value.
 * @return string
 */
function cdplay_get_platform_hub_field(string $slug, string $field, string $fallback = ''): string {
	$items = cdplay_get_platform_hub_items();

	if (!isset($items[$slug]['options'][$field])) {
		return $fallback;
	}

	$value = get_option($items[$slug]['options'][$field], '');

	if (!is_string($value) || '' === trim($value)) {
		return $fallback;
	}

	return $value;
}

/**
 * Check whether a Platform Hub card is enabled.
 *
 * @param string $slug Platform slug.
 * @return bool
 */
function cdplay_is_platform_hub_enabled(string $slug): bool {
	$items = cdplay_get_platform_hub_items();

	if (!isset($items[$slug]['options']['enabled'])) {
		return false;
	}

	$value = get_option($items[$slug]['options']['enabled'], null);

	if (null === $value) {
		return true;
	}

	return !empty($value);
}

/**
 * Return editable hero content fields.
 *
 * @return array<string, array{label: string, option: string, type: string}>
 */
function cdplay_get_hero_content_fields(): array {
	return array(
		'eyebrow'           => array(
			'label'  => __('Надзаголовок', 'cdplay'),
			'option' => 'cdplay_hero_eyebrow',
			'type'   => 'text',
		),
		'title'             => array(
			'label'  => __('Заголовок', 'cdplay'),
			'option' => 'cdplay_hero_title',
			'type'   => 'textarea',
		),
		'description'       => array(
			'label'  => __('Описание', 'cdplay'),
			'option' => 'cdplay_hero_description',
			'type'   => 'textarea',
		),
		'primary_cta_text'  => array(
			'label'  => __('Текст основной кнопки', 'cdplay'),
			'option' => 'cdplay_hero_primary_cta_text',
			'type'   => 'text',
		),
		'primary_cta_url'   => array(
			'label'  => __('Ссылка основной кнопки', 'cdplay'),
			'option' => 'cdplay_hero_primary_cta_url',
			'type'   => 'url',
		),
		'secondary_cta_text' => array(
			'label'  => __('Текст второй кнопки', 'cdplay'),
			'option' => 'cdplay_hero_secondary_cta_text',
			'type'   => 'text',
		),
		'secondary_cta_url'  => array(
			'label'  => __('Ссылка второй кнопки', 'cdplay'),
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
			'label'          => __('Изображение Hero desktop', 'cdplay'),
			'option'         => 'cdplay_hero_desktop_image_id',
			'recommendation' => __('Рекомендуемый размер: 2560×1200 WebP', 'cdplay'),
		),
		'mobile'  => array(
			'label'          => __('Изображение Hero mobile', 'cdplay'),
			'option'         => 'cdplay_hero_mobile_image_id',
			'recommendation' => __('Рекомендуемый размер: 1080×1440 WebP', 'cdplay'),
		),
	);
}

/**
 * Return editable hero media position fields.
 *
 * @return array<string, array{label: string, option: string, help: string}>
 */
function cdplay_get_hero_media_position_fields(): array {
	return array(
		'desktop' => array(
			'label'  => __('Фокус desktop-изображения', 'cdplay'),
			'option' => 'cdplay_hero_desktop_image_position',
			'help'   => __('Например: center center, right center, 60% center, 70% 45%', 'cdplay'),
		),
		'mobile'  => array(
			'label'  => __('Фокус mobile-изображения', 'cdplay'),
			'option' => 'cdplay_hero_mobile_image_position',
			'help'   => __('Например: center center, center top, 55% center', 'cdplay'),
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
 * Get a safe hero media object-position value.
 *
 * @param string $type Position type.
 * @return string
 */
function cdplay_get_hero_media_position(string $type): string {
	$fields = cdplay_get_hero_media_position_fields();

	if (!isset($fields[$type])) {
		return 'center center';
	}

	$value = get_option($fields[$type]['option'], '');

	if (!is_string($value) || '' === trim($value)) {
		return 'center center';
	}

	return cdplay_sanitize_hero_media_position($value);
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
 * Sanitize CSS object-position values for hero media.
 *
 * @param mixed $input Raw option input.
 * @return string
 */
function cdplay_sanitize_hero_media_position($input): string {
	if (!is_string($input)) {
		return 'center center';
	}

	$value = strtolower(sanitize_text_field($input));
	$value = preg_replace('/[^a-z0-9%.\-\s]/', '', $value);
	$value = is_string($value) ? trim(preg_replace('/\s+/', ' ', $value)) : '';

	return '' === $value ? 'center center' : $value;
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

	foreach (cdplay_get_platform_hubs_header_fields() as $field) {
		$sanitize_callback = 'textarea' === $field['type'] ? 'cdplay_sanitize_hero_textarea' : 'cdplay_sanitize_hero_field';

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

	foreach (cdplay_get_platform_hub_items() as $item) {
		foreach ($item['options'] as $field_key => $option_name) {
			$sanitize_callback = 'cdplay_sanitize_hero_field';
			$default           = '';
			$type              = 'string';

			if ('description' === $field_key) {
				$sanitize_callback = 'cdplay_sanitize_hero_textarea';
			}

			if ('cta_url' === $field_key) {
				$sanitize_callback = 'cdplay_sanitize_hero_url';
			}

			if ('enabled' === $field_key) {
				$sanitize_callback = 'absint';
				$default           = 1;
				$type              = 'integer';
			}

			register_setting(
				'cdplay_homepage_sections',
				$option_name,
				array(
					'type'              => $type,
					'sanitize_callback' => $sanitize_callback,
					'default'           => $default,
				)
			);
		}
	}

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

	foreach (cdplay_get_hero_media_position_fields() as $field) {
		register_setting(
			'cdplay_homepage_sections',
			$field['option'],
			array(
				'type'              => 'string',
				'sanitize_callback' => 'cdplay_sanitize_hero_media_position',
				'default'           => 'center center',
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

	wp_enqueue_style(
		'cdplay-admin-homepage',
		CDPLAY_THEME_URI . '/assets/css/admin-homepage.css',
		array(),
		CDPLAY_VERSION
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

	$current_tab = cdplay_get_current_homepage_admin_tab();
	?>
	<div class="wrap cdplay-homepage-admin">
		<h1><?php esc_html_e('CDPLAY Homepage', 'cdplay'); ?></h1>
		<?php cdplay_render_homepage_admin_tabs($current_tab); ?>

		<form method="post" action="options.php">
			<?php settings_fields('cdplay_homepage_sections'); ?>

			<?php
			if ('sections' === $current_tab) {
				cdplay_render_homepage_sections_tab();
			} elseif ('hero' === $current_tab) {
				cdplay_render_homepage_hero_tab();
			} elseif ('platform-hubs' === $current_tab) {
				cdplay_render_homepage_platform_hubs_tab();
			} else {
				foreach (cdplay_get_homepage_content_sections() as $section_slug => $section) {
					if ($section['tab'] === $current_tab) {
						cdplay_render_homepage_content_section_tab($section_slug);
						break;
					}
				}
			}
			?>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
