<?php
/**
 * Find your console section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_console_scenarios = array(
	array(
		'slug'     => 'after-work',
		'title'    => __('Играть вечером после работы', 'cdplay'),
		'text'     => __('Расслабиться, пройти пару миссий и отключиться от суеты.', 'cdplay'),
		'platform' => __('PlayStation 5', 'cdplay'),
	),
	array(
		'slug'     => 'with-friends',
		'title'    => __('Играть вместе с друзьями', 'cdplay'),
		'text'     => __('Кооператив, вечеринки, Game Pass и игры, в которые весело возвращаться.', 'cdplay'),
		'platform' => __('Xbox Series', 'cdplay'),
	),
	array(
		'slug'     => 'anywhere',
		'title'    => __('Играть где угодно', 'cdplay'),
		'text'     => __('Дорога, диван, отпуск или кровать — игры всегда рядом.', 'cdplay'),
		'platform' => __('Nintendo Switch', 'cdplay'),
	),
	array(
		'slug'     => 'childhood',
		'title'    => __('Вернуться в детство', 'cdplay'),
		'text'     => __('Те самые приставки, знакомые звуки и игры, которые помнишь до сих пор.', 'cdplay'),
		'platform' => __('Retro', 'cdplay'),
	),
);
?>

<section class="cdplay-find-console" aria-labelledby="cdplay-find-console-title">
	<div class="cdplay-find-console__inner cdplay-container">
		<header class="cdplay-find-console__header">
			<p class="cdplay-find-console__eyebrow">
				<?php esc_html_e('Подобрать себе', 'cdplay'); ?>
			</p>

			<h2 id="cdplay-find-console-title" class="cdplay-find-console__title">
				<?php esc_html_e('Играть снова стало проще', 'cdplay'); ?>
			</h2>

			<p class="cdplay-find-console__text">
				<?php esc_html_e('Не нужно разбираться в характеристиках. Просто выбери, как ты хочешь проводить время — а мы подскажем подходящую платформу.', 'cdplay'); ?>
			</p>
		</header>

		<div class="cdplay-find-console__grid">
			<?php foreach ($cdplay_console_scenarios as $cdplay_console_scenario) : ?>
				<article class="cdplay-scenario-card cdplay-scenario-card--<?php echo esc_attr(sanitize_html_class($cdplay_console_scenario['slug'])); ?>">
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
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
