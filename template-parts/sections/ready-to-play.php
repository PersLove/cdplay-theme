<?php
/**
 * Ready to play setups section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_ready_play_eyebrow = cdplay_get_homepage_option(
	'ready-to-play_eyebrow',
	__('Готово к игре', 'cdplay')
);

$cdplay_ready_play_title = cdplay_get_homepage_option(
	'ready-to-play_title',
	__('Можно просто включить и начать играть', 'cdplay')
);

$cdplay_ready_play_description = cdplay_get_homepage_option(
	'ready-to-play_description',
	__('Без сложных настроек, сборок и бесконечных выборов. Всё уже готово для хорошего вечера.', 'cdplay')
);

$cdplay_ready_setups = array(
	array(
		'slug'  => 'playstation-evening',
		'title' => cdplay_get_homepage_card_field('ready-to-play', 'playstation-evening', 'title', __('PlayStation Evening', 'cdplay')),
		'text'  => cdplay_get_homepage_card_field('ready-to-play', 'playstation-evening', 'text', __('PlayStation 5, второй DualSense и игры, в которые хочется возвращаться после работы.', 'cdplay')),
		'kit'   => cdplay_get_homepage_card_field('ready-to-play', 'playstation-evening', 'kit', __('PS5 • 2 геймпада • подписка • игры', 'cdplay')),
		'cta'   => cdplay_get_homepage_card_field('ready-to-play', 'playstation-evening', 'cta', ''),
		'url'   => cdplay_get_homepage_card_field('ready-to-play', 'playstation-evening', 'url', ''),
	),
	array(
		'slug'  => 'xbox-game-pass',
		'title' => cdplay_get_homepage_card_field('ready-to-play', 'xbox-game-pass', 'title', __('Xbox Game Pass Setup', 'cdplay')),
		'text'  => cdplay_get_homepage_card_field('ready-to-play', 'xbox-game-pass', 'text', __('Game Pass, кооператив и сотни игр, которые уже ждут тебя с первого запуска.', 'cdplay')),
		'kit'   => cdplay_get_homepage_card_field('ready-to-play', 'xbox-game-pass', 'kit', __('Xbox Series • Game Pass • кооперативные игры', 'cdplay')),
		'cta'   => cdplay_get_homepage_card_field('ready-to-play', 'xbox-game-pass', 'cta', ''),
		'url'   => cdplay_get_homepage_card_field('ready-to-play', 'xbox-game-pass', 'url', ''),
	),
	array(
		'slug'  => 'nintendo-family',
		'title' => cdplay_get_homepage_card_field('ready-to-play', 'nintendo-family', 'title', __('Nintendo Family Pack', 'cdplay')),
		'text'  => cdplay_get_homepage_card_field('ready-to-play', 'nintendo-family', 'text', __('Игры для семьи, друзей и уютных вечеров на диване или в дороге.', 'cdplay')),
		'kit'   => cdplay_get_homepage_card_field('ready-to-play', 'nintendo-family', 'kit', __('Nintendo Switch • Mario • Party games', 'cdplay')),
		'cta'   => cdplay_get_homepage_card_field('ready-to-play', 'nintendo-family', 'cta', ''),
		'url'   => cdplay_get_homepage_card_field('ready-to-play', 'nintendo-family', 'url', ''),
	),
);

$cdplay_ready_setups = array_filter(
	$cdplay_ready_setups,
	static function ($cdplay_ready_setup): bool {
		return cdplay_is_homepage_card_enabled('ready-to-play', $cdplay_ready_setup['slug']);
	}
);

if (empty($cdplay_ready_setups)) {
	return;
}
?>

<section class="cdplay-ready-play" aria-labelledby="cdplay-ready-play-title">
	<div class="cdplay-ready-play__inner cdplay-container">
		<header class="cdplay-ready-play__header">
			<p class="cdplay-ready-play__eyebrow">
				<?php echo esc_html($cdplay_ready_play_eyebrow); ?>
			</p>

			<h2 id="cdplay-ready-play-title" class="cdplay-ready-play__title">
				<?php echo esc_html($cdplay_ready_play_title); ?>
			</h2>

			<p class="cdplay-ready-play__text">
				<?php echo esc_html($cdplay_ready_play_description); ?>
			</p>
		</header>

		<div class="cdplay-ready-play__grid">
			<?php foreach ($cdplay_ready_setups as $cdplay_ready_setup) : ?>
				<?php
				$cdplay_ready_setup_style = cdplay_get_homepage_card_media_styles(
					'ready-to-play',
					$cdplay_ready_setup['slug'],
					array(
						'photo_image_id'  => '--cdplay-ready-setup-photo',
						'device_image_id' => '--cdplay-ready-setup-device',
					)
				);
				$cdplay_ready_setup_tag   = $cdplay_ready_setup['url'] ? 'a' : 'article';
				$cdplay_ready_setup_attrs = $cdplay_ready_setup['url'] ? ' href="' . esc_url($cdplay_ready_setup['url']) . '" aria-label="' . esc_attr($cdplay_ready_setup['cta'] ? $cdplay_ready_setup['cta'] : $cdplay_ready_setup['title']) . '"' : '';
				$cdplay_ready_setup_style = $cdplay_ready_setup['url'] ? cdplay_get_homepage_linked_card_style($cdplay_ready_setup_style) : $cdplay_ready_setup_style;
				?>
				<<?php echo esc_html($cdplay_ready_setup_tag); ?> class="cdplay-ready-setup-card cdplay-ready-setup-card--<?php echo esc_attr(sanitize_html_class($cdplay_ready_setup['slug'])); ?>"<?php echo $cdplay_ready_setup_attrs; ?><?php echo $cdplay_ready_setup_style ? ' style="' . esc_attr($cdplay_ready_setup_style) . '"' : ''; ?>>
					<div class="cdplay-ready-setup-card__media" aria-hidden="true">
						<div class="cdplay-ready-setup-card__photo-slot"></div>
						<div class="cdplay-ready-setup-card__device-slot"></div>
					</div>

					<div class="cdplay-ready-setup-card__content">
						<h3 class="cdplay-ready-setup-card__title">
							<?php echo esc_html($cdplay_ready_setup['title']); ?>
						</h3>

						<p class="cdplay-ready-setup-card__text">
							<?php echo esc_html($cdplay_ready_setup['text']); ?>
						</p>

						<p class="cdplay-ready-setup-card__kit">
							<?php echo esc_html($cdplay_ready_setup['kit']); ?>
						</p>

						<div class="cdplay-ready-setup-card__cta-slot" aria-hidden="true"></div>
					</div>
				</<?php echo esc_html($cdplay_ready_setup_tag); ?>>
			<?php endforeach; ?>
		</div>
	</div>
</section>
