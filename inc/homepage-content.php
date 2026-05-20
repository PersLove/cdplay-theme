<?php
/**
 * Homepage content options and helpers.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Normalize section/card identifiers for option names.
 *
 * @param string $value Raw identifier.
 * @return string
 */
function cdplay_homepage_option_slug(string $value): string {
	return str_replace('-', '_', sanitize_key($value));
}

/**
 * Build a homepage option key.
 *
 * @param string $key Short key.
 * @return string
 */
function cdplay_homepage_option_key(string $key): string {
	return 'cdplay_homepage_' . cdplay_homepage_option_slug($key);
}

/**
 * Build a homepage card option key.
 *
 * @param string $section Section slug.
 * @param string $card Card slug.
 * @param string $field Field slug.
 * @return string
 */
function cdplay_homepage_card_option_key(string $section, string $card, string $field): string {
	return 'cdplay_homepage_' . cdplay_homepage_option_slug($section) . '_' . cdplay_homepage_option_slug($card) . '_' . cdplay_homepage_option_slug($field);
}

/**
 * Get homepage option with fallback.
 *
 * @param string $key Option key without prefix.
 * @param string $fallback Fallback value.
 * @return string
 */
function cdplay_get_homepage_option(string $key, string $fallback = ''): string {
	$value = get_option(cdplay_homepage_option_key($key), '');

	if (!is_string($value) || '' === trim($value)) {
		return $fallback;
	}

	return $value;
}

/**
 * Get homepage card field with fallback.
 *
 * @param string $section Section slug.
 * @param string $card Card slug.
 * @param string $field Field slug.
 * @param string $fallback Fallback value.
 * @return string
 */
function cdplay_get_homepage_card_field(string $section, string $card, string $field, string $fallback = ''): string {
	$value = get_option(cdplay_homepage_card_option_key($section, $card, $field), '');

	if (!is_string($value) || '' === trim($value)) {
		return $fallback;
	}

	return $value;
}

/**
 * Check whether a homepage card is enabled.
 *
 * @param string $section Section slug.
 * @param string $card Card slug.
 * @return bool
 */
function cdplay_is_homepage_card_enabled(string $section, string $card): bool {
	$value = get_option(cdplay_homepage_card_option_key($section, $card, 'enabled'), null);

	if (null === $value) {
		return true;
	}

	return !empty($value);
}

/**
 * Get homepage card attachment ID.
 *
 * @param string $section Section slug.
 * @param string $card Card slug.
 * @param string $field Field slug.
 * @return int
 */
function cdplay_get_homepage_card_media_id(string $section, string $card, string $field): int {
	return absint(get_option(cdplay_homepage_card_option_key($section, $card, $field), 0));
}

/**
 * Build an inline CSS variable style for an attachment image.
 *
 * @param string $css_variable CSS custom property name.
 * @param int    $attachment_id Attachment ID.
 * @return string
 */
function cdplay_get_homepage_card_media_style(string $css_variable, int $attachment_id): string {
	$image_url = $attachment_id ? wp_get_attachment_image_url($attachment_id, 'full') : '';

	if (!$image_url) {
		return '';
	}

	return sprintf('%1$s: url("%2$s");', $css_variable, esc_url_raw($image_url));
}

/**
 * Build inline CSS variable styles for card media fields.
 *
 * @param string               $section Section slug.
 * @param string               $card Card slug.
 * @param array<string,string> $media_map Field-to-CSS-variable map.
 * @return string
 */
function cdplay_get_homepage_card_media_styles(string $section, string $card, array $media_map): string {
	$styles = array();

	foreach ($media_map as $field => $css_variable) {
		$style = cdplay_get_homepage_card_media_style(
			$css_variable,
			cdplay_get_homepage_card_media_id($section, $card, $field)
		);

		if ($style) {
			$styles[] = $style;
		}
	}

	return implode(' ', $styles);
}

/**
 * Return inline styles that keep linked cards visually unchanged.
 *
 * @param string $extra_style Additional inline CSS.
 * @return string
 */
function cdplay_get_homepage_linked_card_style(string $extra_style = ''): string {
	return trim('display: block; color: inherit; text-decoration: none; ' . $extra_style);
}

/**
 * Return remaining editable homepage sections.
 *
 * @return array<string, array<string, mixed>>
 */
function cdplay_get_homepage_content_sections(): array {
	return array(
		'find-your-console' => array(
			'tab'    => 'find-your-console',
			'label'  => __('Подобрать себе', 'cdplay'),
			'cards'  => array(
				'after-work'   => array('label' => __('After Work', 'cdplay')),
				'with-friends' => array('label' => __('With Friends', 'cdplay')),
				'anywhere'     => array('label' => __('Anywhere', 'cdplay')),
				'childhood'    => array('label' => __('Childhood', 'cdplay')),
			),
			'fields' => array(
				'platform' => array('label' => __('Платформа', 'cdplay'), 'type' => 'text'),
				'title'    => array('label' => __('Заголовок', 'cdplay'), 'type' => 'text'),
				'text'     => array('label' => __('Описание', 'cdplay'), 'type' => 'textarea'),
				'image_id' => array('label' => __('Изображение', 'cdplay'), 'type' => 'media', 'recommendation' => __('Рекомендуемый размер: 900×700 WebP', 'cdplay')),
				'icon_id'  => array('label' => __('Иконка', 'cdplay'), 'type' => 'media', 'recommendation' => __('Рекомендуемый размер: SVG или PNG 256×256', 'cdplay')),
				'cta'      => array('label' => __('Текст кнопки', 'cdplay'), 'type' => 'text'),
				'url'      => array('label' => __('Ссылка карточки', 'cdplay'), 'type' => 'url'),
			),
		),
		'what-to-play'      => array(
			'tab'    => 'what-to-play',
			'label'  => __('Во что поиграть', 'cdplay'),
			'cards'  => array(
				'quiet-evening' => array('label' => __('Quiet Evening', 'cdplay')),
				'together'      => array('label' => __('Together', 'cdplay')),
				'portable'      => array('label' => __('Portable', 'cdplay')),
				'nostalgia'     => array('label' => __('Nostalgia', 'cdplay')),
			),
			'fields' => array(
				'category'            => array('label' => __('Категория', 'cdplay'), 'type' => 'text'),
				'title'               => array('label' => __('Заголовок', 'cdplay'), 'type' => 'text'),
				'text'                => array('label' => __('Описание', 'cdplay'), 'type' => 'textarea'),
				'platform'            => array('label' => __('Платформа', 'cdplay'), 'type' => 'text'),
				'background_image_id' => array('label' => __('Фоновое изображение', 'cdplay'), 'type' => 'media', 'recommendation' => __('Рекомендуемый размер: 1000×700 WebP', 'cdplay')),
				'cover_image_id'      => array('label' => __('Иконка / обложка', 'cdplay'), 'type' => 'media', 'recommendation' => __('Рекомендуемый размер: 700×900 WebP или PNG 512×512', 'cdplay')),
				'url'                 => array('label' => __('Ссылка карточки', 'cdplay'), 'type' => 'url'),
			),
		),
		'ready-to-play'     => array(
			'tab'    => 'ready-to-play',
			'label'  => __('Готово к игре', 'cdplay'),
			'cards'  => array(
				'playstation-evening' => array('label' => __('PlayStation Evening', 'cdplay')),
				'xbox-game-pass'      => array('label' => __('Xbox Game Pass Setup', 'cdplay')),
				'nintendo-family'     => array('label' => __('Nintendo Family Pack', 'cdplay')),
			),
			'fields' => array(
				'title'           => array('label' => __('Заголовок', 'cdplay'), 'type' => 'text'),
				'text'            => array('label' => __('Описание', 'cdplay'), 'type' => 'textarea'),
				'kit'             => array('label' => __('Комплект', 'cdplay'), 'type' => 'text'),
				'photo_image_id'  => array('label' => __('Изображение', 'cdplay'), 'type' => 'media', 'recommendation' => __('Рекомендуемый размер: 1000×800 WebP', 'cdplay')),
				'device_image_id' => array('label' => __('Иконка / устройство', 'cdplay'), 'type' => 'media', 'recommendation' => __('Рекомендуемый размер: 1000×800 WebP или PNG 512×512', 'cdplay')),
				'cta'             => array('label' => __('Текст кнопки', 'cdplay'), 'type' => 'text'),
				'url'             => array('label' => __('Ссылка карточки', 'cdplay'), 'type' => 'url'),
			),
		),
		'services'          => array(
			'tab'    => 'services',
			'label'  => __('Услуги', 'cdplay'),
			'cards'  => array(
				'trade-in' => array('label' => __('Trade-In', 'cdplay')),
				'rental'   => array('label' => __('Rental', 'cdplay')),
			),
			'fields' => array(
				'label'          => array('label' => __('Метка', 'cdplay'), 'type' => 'text'),
				'title'          => array('label' => __('Заголовок', 'cdplay'), 'type' => 'text'),
				'text'           => array('label' => __('Описание', 'cdplay'), 'type' => 'textarea'),
				'point_1'        => array('label' => __('Пункт 1', 'cdplay'), 'type' => 'text'),
				'point_2'        => array('label' => __('Пункт 2', 'cdplay'), 'type' => 'text'),
				'point_3'        => array('label' => __('Пункт 3', 'cdplay'), 'type' => 'text'),
				'cta'            => array('label' => __('Текст кнопки', 'cdplay'), 'type' => 'text'),
				'url'            => array('label' => __('Ссылка кнопки', 'cdplay'), 'type' => 'url'),
				'photo_image_id' => array('label' => __('Изображение', 'cdplay'), 'type' => 'media', 'recommendation' => __('Рекомендуемый размер: 1000×700 WebP', 'cdplay')),
				'icon_id'        => array('label' => __('Иконка', 'cdplay'), 'type' => 'media', 'recommendation' => __('Рекомендуемый размер: SVG или PNG 256×256', 'cdplay')),
			),
		),
		'cdplay-experience' => array(
			'tab'    => 'experience',
			'label'  => __('CDPLAY Experience', 'cdplay'),
			'cards'  => array(
				'try'  => array('label' => __('Try', 'cdplay')),
				'help' => array('label' => __('Help', 'cdplay')),
				'rest' => array('label' => __('Rest', 'cdplay')),
			),
			'fields' => array(
				'title'    => array('label' => __('Заголовок', 'cdplay'), 'type' => 'text'),
				'text'     => array('label' => __('Описание', 'cdplay'), 'type' => 'textarea'),
				'image_id' => array('label' => __('Изображение', 'cdplay'), 'type' => 'media', 'recommendation' => __('Рекомендуемый размер: 900×700 WebP', 'cdplay')),
				'icon_id'  => array('label' => __('Иконка', 'cdplay'), 'type' => 'media', 'recommendation' => __('Рекомендуемый размер: SVG или PNG 256×256', 'cdplay')),
				'url'      => array('label' => __('Ссылка карточки', 'cdplay'), 'type' => 'url'),
			),
		),
		'guides'            => array(
			'tab'    => 'guides',
			'label'  => __('Блог и гайды', 'cdplay'),
			'cards'  => array(
				'console-choice'   => array('label' => __('Console Choice', 'cdplay')),
				'after-work-games' => array('label' => __('After Work Games', 'cdplay')),
				'family-gaming'    => array('label' => __('Family Gaming', 'cdplay')),
			),
			'fields' => array(
				'category' => array('label' => __('Категория', 'cdplay'), 'type' => 'text'),
				'title'    => array('label' => __('Заголовок', 'cdplay'), 'type' => 'text'),
				'text'     => array('label' => __('Описание', 'cdplay'), 'type' => 'textarea'),
				'image_id' => array('label' => __('Изображение', 'cdplay'), 'type' => 'media', 'recommendation' => __('Рекомендуемый размер: 1000×700 WebP', 'cdplay')),
				'icon_id'  => array('label' => __('Иконка', 'cdplay'), 'type' => 'media', 'recommendation' => __('Рекомендуемый размер: SVG или PNG 256×256', 'cdplay')),
				'url'      => array('label' => __('Ссылка карточки', 'cdplay'), 'type' => 'url'),
			),
		),
	);
}

/**
 * Register generic homepage content settings.
 */
function cdplay_register_homepage_content_settings(): void {
	foreach (cdplay_get_homepage_content_sections() as $section_slug => $section) {
		foreach (array('eyebrow', 'title', 'description') as $field) {
			register_setting(
				'cdplay_homepage_sections',
				cdplay_homepage_option_key($section_slug . '_' . $field),
				array(
					'type'              => 'string',
					'sanitize_callback' => 'description' === $field ? 'cdplay_sanitize_hero_textarea' : 'cdplay_sanitize_hero_field',
					'default'           => '',
				)
			);
		}

		foreach ($section['cards'] as $card_slug => $card) {
			register_setting(
				'cdplay_homepage_sections',
				cdplay_homepage_card_option_key($section_slug, $card_slug, 'enabled'),
				array(
					'type'              => 'integer',
					'sanitize_callback' => 'absint',
					'default'           => 1,
				)
			);

			foreach ($section['fields'] as $field_slug => $field) {
				$type              = 'media' === $field['type'] ? 'integer' : 'string';
				$sanitize_callback = 'cdplay_sanitize_hero_field';

				if ('textarea' === $field['type']) {
					$sanitize_callback = 'cdplay_sanitize_hero_textarea';
				}

				if ('url' === $field['type']) {
					$sanitize_callback = 'cdplay_sanitize_hero_url';
				}

				if ('media' === $field['type']) {
					$sanitize_callback = 'cdplay_sanitize_hero_image_id';
				}

				register_setting(
					'cdplay_homepage_sections',
					cdplay_homepage_card_option_key($section_slug, $card_slug, $field_slug),
					array(
						'type'              => $type,
						'sanitize_callback' => $sanitize_callback,
						'default'           => 'media' === $field['type'] ? 0 : '',
					)
				);
			}
		}
	}
}
add_action('admin_init', 'cdplay_register_homepage_content_settings');

/**
 * Return homepage admin tabs.
 *
 * @return array<string, string>
 */
function cdplay_get_homepage_admin_tabs(): array {
	$tabs = array(
		'sections'      => __('Секции', 'cdplay'),
		'hero'          => __('Hero', 'cdplay'),
		'platform-hubs' => __('Платформы', 'cdplay'),
	);

	foreach (cdplay_get_homepage_content_sections() as $section) {
		$tabs[$section['tab']] = $section['label'];
	}

	return $tabs;
}

/**
 * Return current homepage admin tab.
 *
 * @return string
 */
function cdplay_get_current_homepage_admin_tab(): string {
	$tabs = cdplay_get_homepage_admin_tabs();
	$tab  = isset($_GET['tab']) ? sanitize_key(wp_unslash($_GET['tab'])) : 'sections';

	return isset($tabs[$tab]) ? $tab : 'sections';
}

/**
 * Render homepage admin tab navigation.
 *
 * @param string $current_tab Current tab.
 */
function cdplay_render_homepage_admin_tabs(string $current_tab): void {
	$tabs = cdplay_get_homepage_admin_tabs();
	?>
	<nav class="nav-tab-wrapper cdplay-homepage-admin__tabs" aria-label="<?php esc_attr_e('Вкладки настроек главной', 'cdplay'); ?>">
		<?php foreach ($tabs as $tab => $label) : ?>
			<a class="nav-tab <?php echo $current_tab === $tab ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url(add_query_arg(array('page' => 'cdplay-homepage', 'tab' => $tab), admin_url('themes.php'))); ?>">
				<?php echo esc_html($label); ?>
			</a>
		<?php endforeach; ?>
	</nav>
	<?php
}

/**
 * Render a text-like admin field.
 *
 * @param string $option Option name.
 * @param string $label Field label.
 * @param string $type Field type.
 */
function cdplay_render_homepage_admin_text_field(string $option, string $label, string $type = 'text'): void {
	$value = get_option($option, '');
	?>
	<tr>
		<th scope="row">
			<label for="<?php echo esc_attr($option); ?>"><?php echo esc_html($label); ?></label>
		</th>
		<td>
			<?php if ('textarea' === $type) : ?>
				<textarea id="<?php echo esc_attr($option); ?>" name="<?php echo esc_attr($option); ?>" class="large-text cdplay-homepage-admin__textarea" rows="3"><?php echo esc_textarea(is_string($value) ? $value : ''); ?></textarea>
			<?php else : ?>
				<input type="<?php echo 'url' === $type ? 'url' : 'text'; ?>" id="<?php echo esc_attr($option); ?>" name="<?php echo esc_attr($option); ?>" value="<?php echo esc_attr(is_string($value) ? $value : ''); ?>" class="regular-text cdplay-homepage-admin__input" />
			<?php endif; ?>
		</td>
	</tr>
	<?php
}

/**
 * Render a media admin field.
 *
 * @param string $option Option name.
 * @param string $label Field label.
 * @param string $description Optional description.
 */
function cdplay_render_homepage_admin_media_field(string $option, string $label, string $description = ''): void {
	$image_id  = absint(get_option($option, 0));
	$image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
	?>
	<tr>
		<th scope="row"><?php echo esc_html($label); ?></th>
		<td>
			<div class="cdplay-admin-media-field" data-cdplay-media-field>
				<input type="hidden" id="<?php echo esc_attr($option); ?>" name="<?php echo esc_attr($option); ?>" value="<?php echo esc_attr((string) $image_id); ?>" data-cdplay-media-input />
				<p>
					<button type="button" class="button" data-cdplay-media-select><?php esc_html_e('Выбрать', 'cdplay'); ?></button>
					<button type="button" class="button" data-cdplay-media-remove><?php esc_html_e('Удалить', 'cdplay'); ?></button>
				</p>
				<?php if ($description) : ?>
					<p class="description"><?php echo esc_html($description); ?></p>
				<?php endif; ?>
				<img src="<?php echo esc_url($image_url ? $image_url : ''); ?>" alt="" style="<?php echo esc_attr($image_url ? 'display:block;max-width:320px;height:auto;margin-top:12px;' : 'display:none;max-width:320px;height:auto;margin-top:12px;'); ?>" data-cdplay-media-preview />
			</div>
		</td>
	</tr>
	<?php
}

/**
 * Render sections visibility tab.
 */
function cdplay_render_homepage_sections_tab(): void {
	$sections         = cdplay_get_homepage_sections();
	$section_settings = get_option('cdplay_homepage_sections', null);
	$section_settings = is_array($section_settings) ? $section_settings : array();
	?>
	<div class="cdplay-homepage-admin__panel">
	<h2><?php esc_html_e('Секции', 'cdplay'); ?></h2>
	<table class="form-table cdplay-homepage-admin__table" role="presentation">
		<tbody>
			<?php foreach ($sections as $section) : ?>
				<?php
				$slug    = $section['slug'];
				$enabled = !array_key_exists($slug, $section_settings) || !empty($section_settings[$slug]);
				?>
				<tr>
					<th scope="row"><?php echo esc_html($section['label']); ?></th>
					<td>
						<label for="cdplay-homepage-section-<?php echo esc_attr($slug); ?>">
							<input type="checkbox" id="cdplay-homepage-section-<?php echo esc_attr($slug); ?>" name="cdplay_homepage_sections[<?php echo esc_attr($slug); ?>]" value="1" <?php checked($enabled); ?> />
							<?php esc_html_e('Включено', 'cdplay'); ?>
						</label>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	</div>
	<?php
}

/**
 * Render Hero tab.
 */
function cdplay_render_homepage_hero_tab(): void {
	?>
	<div class="cdplay-homepage-admin__panel">
	<h2><?php esc_html_e('Hero', 'cdplay'); ?></h2>
	<table class="form-table cdplay-homepage-admin__table" role="presentation">
		<tbody>
			<?php foreach (cdplay_get_hero_content_fields() as $field) : ?>
				<?php cdplay_render_homepage_admin_text_field($field['option'], $field['label'], $field['type']); ?>
			<?php endforeach; ?>

			<?php foreach (cdplay_get_hero_image_fields() as $field) : ?>
				<?php cdplay_render_homepage_admin_media_field($field['option'], $field['label'], $field['recommendation']); ?>
			<?php endforeach; ?>

			<?php foreach (cdplay_get_hero_media_position_fields() as $field) : ?>
				<?php
				$value = get_option($field['option'], 'center center');
				?>
				<tr>
					<th scope="row">
						<label for="<?php echo esc_attr($field['option']); ?>"><?php echo esc_html($field['label']); ?></label>
					</th>
					<td>
						<input type="text" id="<?php echo esc_attr($field['option']); ?>" name="<?php echo esc_attr($field['option']); ?>" value="<?php echo esc_attr(is_string($value) && '' !== trim($value) ? $value : 'center center'); ?>" class="regular-text cdplay-homepage-admin__input" />
						<p class="description"><?php echo esc_html($field['help']); ?></p>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	</div>
	<?php
}

/**
 * Render Platform Hubs tab.
 */
function cdplay_render_homepage_platform_hubs_tab(): void {
	?>
	<div class="cdplay-homepage-admin__panel">
	<h2><?php esc_html_e('Платформы', 'cdplay'); ?></h2>
	<table class="form-table cdplay-homepage-admin__table" role="presentation">
		<tbody>
			<?php foreach (cdplay_get_platform_hubs_header_fields() as $field) : ?>
				<?php cdplay_render_homepage_admin_text_field($field['option'], $field['label'], $field['type']); ?>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php foreach (cdplay_get_platform_hub_items() as $item) : ?>
		<div class="cdplay-homepage-admin__card">
		<h3><?php echo esc_html($item['label']); ?></h3>
		<table class="form-table cdplay-homepage-admin__table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><?php esc_html_e('Включено', 'cdplay'); ?></th>
					<td>
						<?php $enabled = get_option($item['options']['enabled'], null); ?>
						<input type="hidden" name="<?php echo esc_attr($item['options']['enabled']); ?>" value="0" />
						<label for="<?php echo esc_attr($item['options']['enabled']); ?>">
							<input type="checkbox" id="<?php echo esc_attr($item['options']['enabled']); ?>" name="<?php echo esc_attr($item['options']['enabled']); ?>" value="1" <?php checked(null === $enabled || !empty($enabled)); ?> />
							<?php esc_html_e('Включено', 'cdplay'); ?>
						</label>
					</td>
				</tr>
				<?php
				$platform_fields = array(
					'title'       => array('label' => __('Заголовок', 'cdplay'), 'type' => 'text'),
					'description' => array('label' => __('Описание', 'cdplay'), 'type' => 'textarea'),
					'cta_text'    => array('label' => __('Текст кнопки', 'cdplay'), 'type' => 'text'),
					'cta_url'     => array('label' => __('Ссылка кнопки', 'cdplay'), 'type' => 'url'),
					'image_id'    => array('label' => __('Изображение', 'cdplay'), 'type' => 'media', 'recommendation' => __('Рекомендуемый размер: 900×700 WebP', 'cdplay')),
					'icon_id'     => array('label' => __('Иконка', 'cdplay'), 'type' => 'media', 'recommendation' => __('Рекомендуемый размер: SVG или PNG 256×256', 'cdplay')),
				);
				?>
				<?php foreach ($platform_fields as $field_key => $field) : ?>
					<?php if ('media' === $field['type']) : ?>
						<?php cdplay_render_homepage_admin_media_field($item['options'][$field_key], $field['label'], $field['recommendation']); ?>
					<?php else : ?>
						<?php cdplay_render_homepage_admin_text_field($item['options'][$field_key], $field['label'], $field['type']); ?>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		</div>
	<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Render a generic content section tab.
 *
 * @param string $section_slug Section slug.
 */
function cdplay_render_homepage_content_section_tab(string $section_slug): void {
	$sections = cdplay_get_homepage_content_sections();

	if (!isset($sections[$section_slug])) {
		return;
	}

	$section = $sections[$section_slug];
	?>
	<div class="cdplay-homepage-admin__panel">
	<h2><?php echo esc_html($section['label']); ?></h2>
	<table class="form-table cdplay-homepage-admin__table" role="presentation">
		<tbody>
			<?php cdplay_render_homepage_admin_text_field(cdplay_homepage_option_key($section_slug . '_eyebrow'), __('Надзаголовок', 'cdplay'), 'text'); ?>
			<?php cdplay_render_homepage_admin_text_field(cdplay_homepage_option_key($section_slug . '_title'), __('Заголовок', 'cdplay'), 'text'); ?>
			<?php cdplay_render_homepage_admin_text_field(cdplay_homepage_option_key($section_slug . '_description'), __('Описание', 'cdplay'), 'textarea'); ?>
		</tbody>
	</table>

	<?php foreach ($section['cards'] as $card_slug => $card) : ?>
		<div class="cdplay-homepage-admin__card">
		<h3><?php echo esc_html($card['label']); ?></h3>
		<table class="form-table cdplay-homepage-admin__table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><?php esc_html_e('Включено', 'cdplay'); ?></th>
					<td>
						<?php
						$enabled_option = cdplay_homepage_card_option_key($section_slug, $card_slug, 'enabled');
						$enabled        = get_option($enabled_option, null);
						?>
						<input type="hidden" name="<?php echo esc_attr($enabled_option); ?>" value="0" />
						<label for="<?php echo esc_attr($enabled_option); ?>">
							<input type="checkbox" id="<?php echo esc_attr($enabled_option); ?>" name="<?php echo esc_attr($enabled_option); ?>" value="1" <?php checked(null === $enabled || !empty($enabled)); ?> />
							<?php esc_html_e('Включено', 'cdplay'); ?>
						</label>
					</td>
				</tr>

				<?php foreach ($section['fields'] as $field_slug => $field) : ?>
					<?php $option = cdplay_homepage_card_option_key($section_slug, $card_slug, $field_slug); ?>
					<?php if ('media' === $field['type']) : ?>
						<?php cdplay_render_homepage_admin_media_field($option, $field['label'], $field['recommendation'] ?? ''); ?>
					<?php else : ?>
						<?php cdplay_render_homepage_admin_text_field($option, $field['label'], $field['type']); ?>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		</div>
	<?php endforeach; ?>
	</div>
	<?php
}
