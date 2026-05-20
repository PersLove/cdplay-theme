<?php
/**
 * Find your console section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_find_console_eyebrow = cdplay_get_homepage_option(
	'find-your-console_eyebrow',
	__('Подобрать себе', 'cdplay')
);

$cdplay_find_console_title = cdplay_get_homepage_option(
	'find-your-console_title',
	__('Играть снова стало проще', 'cdplay')
);

$cdplay_find_console_description = cdplay_get_homepage_option(
	'find-your-console_description',
	__('Не нужно разбираться в характеристиках. Просто выбери, как ты хочешь проводить время — а мы подскажем подходящую платформу.', 'cdplay')
);

$cdplay_console_scenarios = array(
	array(
		'slug'     => 'after-work',
		'title'    => cdplay_get_homepage_card_field('find-your-console', 'after-work', 'title', __('Играть вечером после работы', 'cdplay')),
		'text'     => cdplay_get_homepage_card_field('find-your-console', 'after-work', 'text', __('Расслабиться, пройти пару миссий и отключиться от суеты.', 'cdplay')),
		'platform' => cdplay_get_homepage_card_field('find-your-console', 'after-work', 'platform', __('PlayStation 5', 'cdplay')),
		'cta'      => cdplay_get_homepage_card_field('find-your-console', 'after-work', 'cta', ''),
		'url'      => cdplay_get_homepage_card_field('find-your-console', 'after-work', 'url', ''),
	),
	array(
		'slug'     => 'with-friends',
		'title'    => cdplay_get_homepage_card_field('find-your-console', 'with-friends', 'title', __('Играть вместе с друзьями', 'cdplay')),
		'text'     => cdplay_get_homepage_card_field('find-your-console', 'with-friends', 'text', __('Кооператив, вечеринки, Game Pass и игры, в которые весело возвращаться.', 'cdplay')),
		'platform' => cdplay_get_homepage_card_field('find-your-console', 'with-friends', 'platform', __('Xbox Series', 'cdplay')),
		'cta'      => cdplay_get_homepage_card_field('find-your-console', 'with-friends', 'cta', ''),
		'url'      => cdplay_get_homepage_card_field('find-your-console', 'with-friends', 'url', ''),
	),
	array(
		'slug'     => 'anywhere',
		'title'    => cdplay_get_homepage_card_field('find-your-console', 'anywhere', 'title', __('Играть где угодно', 'cdplay')),
		'text'     => cdplay_get_homepage_card_field('find-your-console', 'anywhere', 'text', __('Дорога, диван, отпуск или кровать — игры всегда рядом.', 'cdplay')),
		'platform' => cdplay_get_homepage_card_field('find-your-console', 'anywhere', 'platform', __('Nintendo Switch', 'cdplay')),
		'cta'      => cdplay_get_homepage_card_field('find-your-console', 'anywhere', 'cta', ''),
		'url'      => cdplay_get_homepage_card_field('find-your-console', 'anywhere', 'url', ''),
	),
	array(
		'slug'     => 'childhood',
		'title'    => cdplay_get_homepage_card_field('find-your-console', 'childhood', 'title', __('Вернуться в детство', 'cdplay')),
		'text'     => cdplay_get_homepage_card_field('find-your-console', 'childhood', 'text', __('Те самые приставки, знакомые звуки и игры, которые помнишь до сих пор.', 'cdplay')),
		'platform' => cdplay_get_homepage_card_field('find-your-console', 'childhood', 'platform', __('Retro', 'cdplay')),
		'cta'      => cdplay_get_homepage_card_field('find-your-console', 'childhood', 'cta', ''),
		'url'      => cdplay_get_homepage_card_field('find-your-console', 'childhood', 'url', ''),
	),
);

$cdplay_console_scenarios = array_filter(
	$cdplay_console_scenarios,
	static function ($cdplay_console_scenario): bool {
		return cdplay_is_homepage_card_enabled('find-your-console', $cdplay_console_scenario['slug']);
	}
);

if (empty($cdplay_console_scenarios)) {
	return;
}
?>

<section class="cdplay-find-console" aria-labelledby="cdplay-find-console-title">
	<div class="cdplay-find-console__inner cdplay-container">
		<header class="cdplay-find-console__header">
			<p class="cdplay-find-console__eyebrow">
				<?php echo esc_html($cdplay_find_console_eyebrow); ?>
			</p>

			<h2 id="cdplay-find-console-title" class="cdplay-find-console__title">
				<?php echo esc_html($cdplay_find_console_title); ?>
			</h2>

			<p class="cdplay-find-console__text">
				<?php echo esc_html($cdplay_find_console_description); ?>
			</p>
		</header>

		<div class="cdplay-find-console__grid">
			<?php foreach ($cdplay_console_scenarios as $cdplay_console_scenario) : ?>
				<?php
				$cdplay_console_scenario_style = cdplay_get_homepage_card_media_styles(
					'find-your-console',
					$cdplay_console_scenario['slug'],
					array(
						'image_id' => '--cdplay-scenario-card-image',
						'icon_id'  => '--cdplay-scenario-card-icon',
					)
				);
				$cdplay_console_scenario_tag   = $cdplay_console_scenario['url'] ? 'a' : 'article';
				$cdplay_console_scenario_attrs = $cdplay_console_scenario['url'] ? ' href="' . esc_url($cdplay_console_scenario['url']) . '" aria-label="' . esc_attr($cdplay_console_scenario['cta'] ? $cdplay_console_scenario['cta'] : $cdplay_console_scenario['title']) . '"' : '';
				$cdplay_console_scenario_style = $cdplay_console_scenario['url'] ? cdplay_get_homepage_linked_card_style($cdplay_console_scenario_style) : $cdplay_console_scenario_style;
				?>
				<<?php echo esc_html($cdplay_console_scenario_tag); ?> class="cdplay-scenario-card cdplay-scenario-card--<?php echo esc_attr(sanitize_html_class($cdplay_console_scenario['slug'])); ?>"<?php echo $cdplay_console_scenario_attrs; ?><?php echo $cdplay_console_scenario_style ? ' style="' . esc_attr($cdplay_console_scenario_style) . '"' : ''; ?>>
					<div class="cdplay-scenario-card__media" aria-hidden="true">
						<div class="cdplay-scenario-card__image-slot"></div>
						<div class="cdplay-scenario-card__icon-slot"></div>
					</div>

					<div class="cdplay-scenario-card__content">
						<p class="cdplay-scenario-card__platform">
							<?php echo esc_html($cdplay_console_scenario['platform']); ?>
						</p>

						<h3 class="cdplay-scenario-card__title">
							<?php echo esc_html($cdplay_console_scenario['title']); ?>
						</h3>

						<p class="cdplay-scenario-card__text">
							<?php echo esc_html($cdplay_console_scenario['text']); ?>
						</p>
					</div>
				</<?php echo esc_html($cdplay_console_scenario_tag); ?>>
			<?php endforeach; ?>
		</div>
	</div>
</section>
