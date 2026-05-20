<?php
/**
 * Cinematic front page hero section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_hero_eyebrow = cdplay_get_hero_field(
	'eyebrow',
	__('Premium gaming platform', 'cdplay')
);

$cdplay_hero_title = cdplay_get_hero_field(
	'title',
	__('Игры, консоли и настроение для идеального вечера', 'cdplay')
);

$cdplay_hero_description = cdplay_get_hero_field(
	'description',
	__('CDPLAY помогает выбрать консоль, найти игру под настроение и собрать спокойный игровой ритуал без суеты.', 'cdplay')
);

$cdplay_hero_primary_cta_text = cdplay_get_hero_field(
	'primary_cta_text',
	__('Подобрать консоль', 'cdplay')
);

$cdplay_hero_primary_cta_url = cdplay_get_hero_field(
	'primary_cta_url',
	home_url('/podbor-konsoli/')
);

$cdplay_hero_secondary_cta_text = cdplay_get_hero_field(
	'secondary_cta_text',
	__('Во что поиграть', 'cdplay')
);

$cdplay_hero_secondary_cta_url = cdplay_get_hero_field(
	'secondary_cta_url',
	home_url('/vo-chto-poigrat/')
);
?>

<section class="cdplay-hero" aria-labelledby="cdplay-hero-title" data-cdplay-hero>
	<div class="cdplay-hero__media" aria-hidden="true">
		<div class="cdplay-hero__atmosphere"></div>
	</div>

	<div class="cdplay-hero__overlay" aria-hidden="true"></div>

	<div class="cdplay-hero__inner cdplay-container">
		<div class="cdplay-hero__content">
			<p class="cdplay-hero__eyebrow">
				<?php echo esc_html($cdplay_hero_eyebrow); ?>
			</p>

			<h1 id="cdplay-hero-title" class="cdplay-hero__title">
				<?php echo esc_html($cdplay_hero_title); ?>
			</h1>

			<p class="cdplay-hero__text">
				<?php echo esc_html($cdplay_hero_description); ?>
			</p>

			<div class="cdplay-hero__actions" role="group" aria-label="<?php esc_attr_e('Hero actions', 'cdplay'); ?>">
				<a class="cdplay-button" href="<?php echo esc_url($cdplay_hero_primary_cta_url); ?>">
					<?php echo esc_html($cdplay_hero_primary_cta_text); ?>
				</a>
				<a class="cdplay-button cdplay-button--secondary" href="<?php echo esc_url($cdplay_hero_secondary_cta_url); ?>">
					<?php echo esc_html($cdplay_hero_secondary_cta_text); ?>
				</a>
			</div>
		</div>
	</div>
</section>
