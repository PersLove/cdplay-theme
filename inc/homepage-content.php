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
 * Return remaining editable homepage sections.
 *
 * @return array<string, array<string, mixed>>
 */
function cdplay_get_homepage_content_sections(): array {
	return array(
		'find-your-console' => array(
			'tab'    => 'find-your-console',
			'label'  => __('Find Your Console', 'cdplay'),
			'cards'  => array(
				'after-work'   => array('label' => __('After Work', 'cdplay')),
				'with-friends' => array('label' => __('With Friends', 'cdplay')),
				'anywhere'     => array('label' => __('Anywhere', 'cdplay')),
				'childhood'    => array('label' => __('Childhood', 'cdplay')),
			),
			'fields' => array(
				'platform' => array('label' => __('Platform', 'cdplay'), 'type' => 'text'),
				'title'    => array('label' => __('Title', 'cdplay'), 'type' => 'text'),
				'text'     => array('label' => __('Description', 'cdplay'), 'type' => 'textarea'),
				'image_id' => array('label' => __('Image', 'cdplay'), 'type' => 'media'),
				'icon_id'  => array('label' => __('Icon', 'cdplay'), 'type' => 'media'),
			),
		),
		'what-to-play'      => array(
			'tab'    => 'what-to-play',
			'label'  => __('What To Play', 'cdplay'),
			'cards'  => array(
				'quiet-evening' => array('label' => __('Quiet Evening', 'cdplay')),
				'together'      => array('label' => __('Together', 'cdplay')),
				'portable'      => array('label' => __('Portable', 'cdplay')),
				'nostalgia'     => array('label' => __('Nostalgia', 'cdplay')),
			),
			'fields' => array(
				'category'            => array('label' => __('Category', 'cdplay'), 'type' => 'text'),
				'title'               => array('label' => __('Title', 'cdplay'), 'type' => 'text'),
				'text'                => array('label' => __('Description', 'cdplay'), 'type' => 'textarea'),
				'platform'            => array('label' => __('Platform', 'cdplay'), 'type' => 'text'),
				'background_image_id' => array('label' => __('Background Image', 'cdplay'), 'type' => 'media'),
				'cover_image_id'      => array('label' => __('Cover Image', 'cdplay'), 'type' => 'media'),
			),
		),
		'ready-to-play'     => array(
			'tab'    => 'ready-to-play',
			'label'  => __('Ready To Play', 'cdplay'),
			'cards'  => array(
				'playstation-evening' => array('label' => __('PlayStation Evening', 'cdplay')),
				'xbox-game-pass'      => array('label' => __('Xbox Game Pass Setup', 'cdplay')),
				'nintendo-family'     => array('label' => __('Nintendo Family Pack', 'cdplay')),
			),
			'fields' => array(
				'title'           => array('label' => __('Title', 'cdplay'), 'type' => 'text'),
				'text'            => array('label' => __('Description', 'cdplay'), 'type' => 'textarea'),
				'kit'             => array('label' => __('Kit', 'cdplay'), 'type' => 'text'),
				'photo_image_id'  => array('label' => __('Photo Image', 'cdplay'), 'type' => 'media'),
				'device_image_id' => array('label' => __('Device Image', 'cdplay'), 'type' => 'media'),
			),
		),
		'services'          => array(
			'tab'    => 'services',
			'label'  => __('Services', 'cdplay'),
			'cards'  => array(
				'trade-in' => array('label' => __('Trade-In', 'cdplay')),
				'rental'   => array('label' => __('Rental', 'cdplay')),
			),
			'fields' => array(
				'label'          => array('label' => __('Label', 'cdplay'), 'type' => 'text'),
				'title'          => array('label' => __('Title', 'cdplay'), 'type' => 'text'),
				'text'           => array('label' => __('Description', 'cdplay'), 'type' => 'textarea'),
				'point_1'        => array('label' => __('Point 1', 'cdplay'), 'type' => 'text'),
				'point_2'        => array('label' => __('Point 2', 'cdplay'), 'type' => 'text'),
				'point_3'        => array('label' => __('Point 3', 'cdplay'), 'type' => 'text'),
				'cta'            => array('label' => __('CTA text', 'cdplay'), 'type' => 'text'),
				'url'            => array('label' => __('CTA URL', 'cdplay'), 'type' => 'url'),
				'photo_image_id' => array('label' => __('Photo Image', 'cdplay'), 'type' => 'media'),
				'icon_id'        => array('label' => __('Icon', 'cdplay'), 'type' => 'media'),
			),
		),
		'cdplay-experience' => array(
			'tab'    => 'experience',
			'label'  => __('Experience', 'cdplay'),
			'cards'  => array(
				'try'  => array('label' => __('Try', 'cdplay')),
				'help' => array('label' => __('Help', 'cdplay')),
				'rest' => array('label' => __('Rest', 'cdplay')),
			),
			'fields' => array(
				'title'    => array('label' => __('Title', 'cdplay'), 'type' => 'text'),
				'text'     => array('label' => __('Description', 'cdplay'), 'type' => 'textarea'),
				'image_id' => array('label' => __('Image', 'cdplay'), 'type' => 'media'),
				'icon_id'  => array('label' => __('Icon', 'cdplay'), 'type' => 'media'),
			),
		),
		'guides'            => array(
			'tab'    => 'guides',
			'label'  => __('Guides', 'cdplay'),
			'cards'  => array(
				'console-choice'   => array('label' => __('Console Choice', 'cdplay')),
				'after-work-games' => array('label' => __('After Work Games', 'cdplay')),
				'family-gaming'    => array('label' => __('Family Gaming', 'cdplay')),
			),
			'fields' => array(
				'category' => array('label' => __('Category', 'cdplay'), 'type' => 'text'),
				'title'    => array('label' => __('Title', 'cdplay'), 'type' => 'text'),
				'text'     => array('label' => __('Description', 'cdplay'), 'type' => 'textarea'),
				'image_id' => array('label' => __('Image', 'cdplay'), 'type' => 'media'),
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
		'sections'      => __('Sections', 'cdplay'),
		'hero'          => __('Hero', 'cdplay'),
		'platform-hubs' => __('Platform Hubs', 'cdplay'),
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
	<nav class="nav-tab-wrapper" aria-label="<?php esc_attr_e('Homepage settings tabs', 'cdplay'); ?>">
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
				<textarea id="<?php echo esc_attr($option); ?>" name="<?php echo esc_attr($option); ?>" class="large-text" rows="3"><?php echo esc_textarea(is_string($value) ? $value : ''); ?></textarea>
			<?php else : ?>
				<input type="<?php echo 'url' === $type ? 'url' : 'text'; ?>" id="<?php echo esc_attr($option); ?>" name="<?php echo esc_attr($option); ?>" value="<?php echo esc_attr(is_string($value) ? $value : ''); ?>" class="regular-text" />
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
					<button type="button" class="button" data-cdplay-media-select><?php esc_html_e('Select image', 'cdplay'); ?></button>
					<button type="button" class="button" data-cdplay-media-remove><?php esc_html_e('Remove', 'cdplay'); ?></button>
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
	<h2><?php esc_html_e('Sections', 'cdplay'); ?></h2>
	<table class="form-table" role="presentation">
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
							<?php esc_html_e('Enabled', 'cdplay'); ?>
						</label>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php
}

/**
 * Render Hero tab.
 */
function cdplay_render_homepage_hero_tab(): void {
	?>
	<h2><?php esc_html_e('Hero Content', 'cdplay'); ?></h2>
	<table class="form-table" role="presentation">
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
						<input type="text" id="<?php echo esc_attr($field['option']); ?>" name="<?php echo esc_attr($field['option']); ?>" value="<?php echo esc_attr(is_string($value) && '' !== trim($value) ? $value : 'center center'); ?>" class="regular-text" />
						<p class="description"><?php echo esc_html($field['help']); ?></p>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php
}

/**
 * Render Platform Hubs tab.
 */
function cdplay_render_homepage_platform_hubs_tab(): void {
	?>
	<h2><?php esc_html_e('Platform Hubs Content', 'cdplay'); ?></h2>
	<table class="form-table" role="presentation">
		<tbody>
			<?php foreach (cdplay_get_platform_hubs_header_fields() as $field) : ?>
				<?php cdplay_render_homepage_admin_text_field($field['option'], $field['label'], $field['type']); ?>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php foreach (cdplay_get_platform_hub_items() as $item) : ?>
		<h3><?php echo esc_html($item['label']); ?></h3>
		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><?php esc_html_e('Enabled', 'cdplay'); ?></th>
					<td>
						<?php $enabled = get_option($item['options']['enabled'], null); ?>
						<input type="hidden" name="<?php echo esc_attr($item['options']['enabled']); ?>" value="0" />
						<label for="<?php echo esc_attr($item['options']['enabled']); ?>">
							<input type="checkbox" id="<?php echo esc_attr($item['options']['enabled']); ?>" name="<?php echo esc_attr($item['options']['enabled']); ?>" value="1" <?php checked(null === $enabled || !empty($enabled)); ?> />
							<?php esc_html_e('Enabled', 'cdplay'); ?>
						</label>
					</td>
				</tr>
				<?php
				$platform_fields = array(
					'title'       => array('label' => __('Title', 'cdplay'), 'type' => 'text'),
					'description' => array('label' => __('Description', 'cdplay'), 'type' => 'textarea'),
					'cta_text'    => array('label' => __('CTA text', 'cdplay'), 'type' => 'text'),
					'cta_url'     => array('label' => __('CTA URL', 'cdplay'), 'type' => 'url'),
				);
				?>
				<?php foreach ($platform_fields as $field_key => $field) : ?>
					<?php cdplay_render_homepage_admin_text_field($item['options'][$field_key], $field['label'], $field['type']); ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endforeach; ?>
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
	<h2><?php echo esc_html($section['label']); ?></h2>
	<table class="form-table" role="presentation">
		<tbody>
			<?php cdplay_render_homepage_admin_text_field(cdplay_homepage_option_key($section_slug . '_eyebrow'), __('Eyebrow', 'cdplay'), 'text'); ?>
			<?php cdplay_render_homepage_admin_text_field(cdplay_homepage_option_key($section_slug . '_title'), __('Title', 'cdplay'), 'text'); ?>
			<?php cdplay_render_homepage_admin_text_field(cdplay_homepage_option_key($section_slug . '_description'), __('Description', 'cdplay'), 'textarea'); ?>
		</tbody>
	</table>

	<?php foreach ($section['cards'] as $card_slug => $card) : ?>
		<h3><?php echo esc_html($card['label']); ?></h3>
		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><?php esc_html_e('Enabled', 'cdplay'); ?></th>
					<td>
						<?php
						$enabled_option = cdplay_homepage_card_option_key($section_slug, $card_slug, 'enabled');
						$enabled        = get_option($enabled_option, null);
						?>
						<input type="hidden" name="<?php echo esc_attr($enabled_option); ?>" value="0" />
						<label for="<?php echo esc_attr($enabled_option); ?>">
							<input type="checkbox" id="<?php echo esc_attr($enabled_option); ?>" name="<?php echo esc_attr($enabled_option); ?>" value="1" <?php checked(null === $enabled || !empty($enabled)); ?> />
							<?php esc_html_e('Enabled', 'cdplay'); ?>
						</label>
					</td>
				</tr>

				<?php foreach ($section['fields'] as $field_slug => $field) : ?>
					<?php $option = cdplay_homepage_card_option_key($section_slug, $card_slug, $field_slug); ?>
					<?php if ('media' === $field['type']) : ?>
						<?php cdplay_render_homepage_admin_media_field($option, $field['label']); ?>
					<?php else : ?>
						<?php cdplay_render_homepage_admin_text_field($option, $field['label'], $field['type']); ?>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endforeach; ?>
	<?php
}
