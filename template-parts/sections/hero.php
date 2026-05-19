<?php
/**
 * Cinematic front page hero section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}
?>

<section class="cdplay-hero" aria-labelledby="cdplay-hero-title" data-cdplay-hero>
	<div class="cdplay-hero__media" aria-hidden="true">
		<div class="cdplay-hero__atmosphere"></div>
	</div>

	<div class="cdplay-hero__overlay" aria-hidden="true"></div>

	<div class="cdplay-hero__inner cdplay-container">
		<div class="cdplay-hero__content">
			<p class="cdplay-hero__eyebrow">
				<?php esc_html_e('Premium gaming platform', 'cdplay'); ?>
			</p>

			<h1 id="cdplay-hero-title" class="cdplay-hero__title">
				<?php esc_html_e('Игры, консоли и настроение для идеального вечера', 'cdplay'); ?>
			</h1>

			<p class="cdplay-hero__text">
				<?php esc_html_e('CDPLAY помогает выбрать консоль, найти игру под настроение и собрать спокойный игровой ритуал без суеты.', 'cdplay'); ?>
			</p>

			<div class="cdplay-hero__actions" role="group" aria-label="<?php esc_attr_e('Hero actions', 'cdplay'); ?>">
				<a class="cdplay-button" href="<?php echo esc_url(home_url('/podbor-konsoli/')); ?>">
					<?php esc_html_e('Подобрать консоль', 'cdplay'); ?>
				</a>
				<a class="cdplay-button cdplay-button--secondary" href="<?php echo esc_url(home_url('/vo-chto-poigrat/')); ?>">
					<?php esc_html_e('Во что поиграть', 'cdplay'); ?>
				</a>
			</div>
		</div>
	</div>
</section>
