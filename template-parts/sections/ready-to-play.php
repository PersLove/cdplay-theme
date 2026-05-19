<?php
/**
 * Ready to play setups section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_ready_setups = array(
	array(
		'slug'  => 'playstation-evening',
		'title' => __('PlayStation Evening', 'cdplay'),
		'text'  => __('PlayStation 5, второй DualSense и игры, в которые хочется возвращаться после работы.', 'cdplay'),
		'kit'   => __('PS5 • 2 геймпада • подписка • игры', 'cdplay'),
	),
	array(
		'slug'  => 'xbox-game-pass',
		'title' => __('Xbox Game Pass Setup', 'cdplay'),
		'text'  => __('Game Pass, кооператив и сотни игр, которые уже ждут тебя с первого запуска.', 'cdplay'),
		'kit'   => __('Xbox Series • Game Pass • кооперативные игры', 'cdplay'),
	),
	array(
		'slug'  => 'nintendo-family',
		'title' => __('Nintendo Family Pack', 'cdplay'),
		'text'  => __('Игры для семьи, друзей и уютных вечеров на диване или в дороге.', 'cdplay'),
		'kit'   => __('Nintendo Switch • Mario • Party games', 'cdplay'),
	),
);
?>

<section class="cdplay-ready-play" aria-labelledby="cdplay-ready-play-title">
	<div class="cdplay-ready-play__inner cdplay-container">
		<header class="cdplay-ready-play__header">
			<p class="cdplay-ready-play__eyebrow">
				<?php esc_html_e('Готово к игре', 'cdplay'); ?>
			</p>

			<h2 id="cdplay-ready-play-title" class="cdplay-ready-play__title">
				<?php esc_html_e('Можно просто включить и начать играть', 'cdplay'); ?>
			</h2>

			<p class="cdplay-ready-play__text">
				<?php esc_html_e('Без сложных настроек, сборок и бесконечных выборов. Всё уже готово для хорошего вечера.', 'cdplay'); ?>
			</p>
		</header>

		<div class="cdplay-ready-play__grid">
			<?php foreach ($cdplay_ready_setups as $cdplay_ready_setup) : ?>
				<article class="cdplay-ready-setup-card cdplay-ready-setup-card--<?php echo esc_attr(sanitize_html_class($cdplay_ready_setup['slug'])); ?>">
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
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
