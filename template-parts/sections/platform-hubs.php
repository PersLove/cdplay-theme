<?php
/**
 * Platform hubs section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_platform_hubs = array(
	array(
		'slug'  => 'playstation',
		'title' => __('PlayStation', 'cdplay'),
		'text'  => __('Эксклюзивы, сюжетные приключения и вечер, который хочется продолжить.', 'cdplay'),
		'cta'   => __('Перейти в PlayStation', 'cdplay'),
		'url'   => home_url('/platform/playstation/'),
	),
	array(
		'slug'  => 'xbox',
		'title' => __('Xbox', 'cdplay'),
		'text'  => __('Game Pass, кооператив и игры, в которые удобно возвращаться каждый день.', 'cdplay'),
		'cta'   => __('Перейти в Xbox', 'cdplay'),
		'url'   => home_url('/platform/xbox/'),
	),
	array(
		'slug'  => 'nintendo',
		'title' => __('Nintendo', 'cdplay'),
		'text'  => __('Семейный гейминг, портативность и игры, которые улыбаются первыми.', 'cdplay'),
		'cta'   => __('Перейти в Nintendo', 'cdplay'),
		'url'   => home_url('/platform/nintendo/'),
	),
	array(
		'slug'  => 'retro',
		'title' => __('Retro', 'cdplay'),
		'text'  => __('Та самая ностальгия, пиксели и приставки, с которых всё началось.', 'cdplay'),
		'cta'   => __('Перейти в Retro', 'cdplay'),
		'url'   => home_url('/platform/retro/'),
	),
);
?>

<section class="cdplay-platform-hubs" aria-labelledby="cdplay-platform-hubs-title">
	<div class="cdplay-platform-hubs__inner cdplay-container">
		<header class="cdplay-platform-hubs__header">
			<p class="cdplay-platform-hubs__eyebrow">
				<?php esc_html_e('Platform hubs', 'cdplay'); ?>
			</p>

			<h2 id="cdplay-platform-hubs-title" class="cdplay-platform-hubs__title">
				<?php esc_html_e('Выберите настроение вечера', 'cdplay'); ?>
			</h2>

			<p class="cdplay-platform-hubs__text">
				<?php esc_html_e('Четыре игровых направления CDPLAY: от кинематографичных эксклюзивов до теплой ретро-ностальгии.', 'cdplay'); ?>
			</p>
		</header>

		<div class="cdplay-platform-hubs__grid">
			<?php foreach ($cdplay_platform_hubs as $cdplay_platform_hub) : ?>
				<article class="cdplay-platform-card cdplay-platform-card--<?php echo esc_attr(sanitize_html_class($cdplay_platform_hub['slug'])); ?>">
					<div class="cdplay-platform-card__media" aria-hidden="true">
						<div class="cdplay-platform-card__image-slot"></div>
						<div class="cdplay-platform-card__icon-slot"></div>
					</div>

					<div class="cdplay-platform-card__content">
						<h3 class="cdplay-platform-card__title">
							<?php echo esc_html($cdplay_platform_hub['title']); ?>
						</h3>

						<p class="cdplay-platform-card__text">
							<?php echo esc_html($cdplay_platform_hub['text']); ?>
						</p>

						<a class="cdplay-platform-card__cta" href="<?php echo esc_url($cdplay_platform_hub['url']); ?>">
							<?php echo esc_html($cdplay_platform_hub['cta']); ?>
						</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
