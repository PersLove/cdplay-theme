<?php
/**
 * Platform hubs section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_platform_hubs_eyebrow = cdplay_get_platform_hubs_field(
	'eyebrow',
	__('Platform hubs', 'cdplay')
);

$cdplay_platform_hubs_title = cdplay_get_platform_hubs_field(
	'title',
	__('Выберите настроение вечера', 'cdplay')
);

$cdplay_platform_hubs_description = cdplay_get_platform_hubs_field(
	'description',
	__('Четыре игровых направления CDPLAY: от кинематографичных эксклюзивов до теплой ретро-ностальгии.', 'cdplay')
);

$cdplay_platform_hubs = array(
	array(
		'slug'  => 'playstation',
		'title' => cdplay_get_platform_hub_field('playstation', 'title', __('PlayStation', 'cdplay')),
		'text'  => cdplay_get_platform_hub_field('playstation', 'description', __('Эксклюзивы, сюжетные приключения и вечер, который хочется продолжить.', 'cdplay')),
		'cta'   => cdplay_get_platform_hub_field('playstation', 'cta_text', __('Перейти в PlayStation', 'cdplay')),
		'url'   => cdplay_get_platform_hub_field('playstation', 'cta_url', home_url('/platform/playstation/')),
		'style' => trim(
			cdplay_get_homepage_card_media_style('--cdplay-platform-card-image', absint(get_option('cdplay_platform_hub_playstation_image_id', 0))) . ' ' .
			cdplay_get_homepage_card_media_style('--cdplay-platform-card-icon', absint(get_option('cdplay_platform_hub_playstation_icon_id', 0)))
		),
	),
	array(
		'slug'  => 'xbox',
		'title' => cdplay_get_platform_hub_field('xbox', 'title', __('Xbox', 'cdplay')),
		'text'  => cdplay_get_platform_hub_field('xbox', 'description', __('Game Pass, кооператив и игры, в которые удобно возвращаться каждый день.', 'cdplay')),
		'cta'   => cdplay_get_platform_hub_field('xbox', 'cta_text', __('Перейти в Xbox', 'cdplay')),
		'url'   => cdplay_get_platform_hub_field('xbox', 'cta_url', home_url('/platform/xbox/')),
		'style' => trim(
			cdplay_get_homepage_card_media_style('--cdplay-platform-card-image', absint(get_option('cdplay_platform_hub_xbox_image_id', 0))) . ' ' .
			cdplay_get_homepage_card_media_style('--cdplay-platform-card-icon', absint(get_option('cdplay_platform_hub_xbox_icon_id', 0)))
		),
	),
	array(
		'slug'  => 'nintendo',
		'title' => cdplay_get_platform_hub_field('nintendo', 'title', __('Nintendo', 'cdplay')),
		'text'  => cdplay_get_platform_hub_field('nintendo', 'description', __('Семейный гейминг, портативность и игры, которые улыбаются первыми.', 'cdplay')),
		'cta'   => cdplay_get_platform_hub_field('nintendo', 'cta_text', __('Перейти в Nintendo', 'cdplay')),
		'url'   => cdplay_get_platform_hub_field('nintendo', 'cta_url', home_url('/platform/nintendo/')),
		'style' => trim(
			cdplay_get_homepage_card_media_style('--cdplay-platform-card-image', absint(get_option('cdplay_platform_hub_nintendo_image_id', 0))) . ' ' .
			cdplay_get_homepage_card_media_style('--cdplay-platform-card-icon', absint(get_option('cdplay_platform_hub_nintendo_icon_id', 0)))
		),
	),
	array(
		'slug'  => 'retro',
		'title' => cdplay_get_platform_hub_field('retro', 'title', __('Retro', 'cdplay')),
		'text'  => cdplay_get_platform_hub_field('retro', 'description', __('Та самая ностальгия, пиксели и приставки, с которых всё началось.', 'cdplay')),
		'cta'   => cdplay_get_platform_hub_field('retro', 'cta_text', __('Перейти в Retro', 'cdplay')),
		'url'   => cdplay_get_platform_hub_field('retro', 'cta_url', home_url('/platform/retro/')),
		'style' => trim(
			cdplay_get_homepage_card_media_style('--cdplay-platform-card-image', absint(get_option('cdplay_platform_hub_retro_image_id', 0))) . ' ' .
			cdplay_get_homepage_card_media_style('--cdplay-platform-card-icon', absint(get_option('cdplay_platform_hub_retro_icon_id', 0)))
		),
	),
);

$cdplay_platform_hubs = array_filter(
	$cdplay_platform_hubs,
	static function ($cdplay_platform_hub): bool {
		return cdplay_is_platform_hub_enabled($cdplay_platform_hub['slug']);
	}
);

if (empty($cdplay_platform_hubs)) {
	return;
}
?>

<section class="cdplay-platform-hubs" aria-labelledby="cdplay-platform-hubs-title">
	<div class="cdplay-platform-hubs__inner cdplay-container">
		<header class="cdplay-platform-hubs__header">
			<p class="cdplay-platform-hubs__eyebrow">
				<?php echo esc_html($cdplay_platform_hubs_eyebrow); ?>
			</p>

			<h2 id="cdplay-platform-hubs-title" class="cdplay-platform-hubs__title">
				<?php echo esc_html($cdplay_platform_hubs_title); ?>
			</h2>

			<p class="cdplay-platform-hubs__text">
				<?php echo esc_html($cdplay_platform_hubs_description); ?>
			</p>
		</header>

		<div class="cdplay-platform-hubs__grid">
			<?php foreach ($cdplay_platform_hubs as $cdplay_platform_hub) : ?>
				<article class="cdplay-platform-card cdplay-platform-card--<?php echo esc_attr(sanitize_html_class($cdplay_platform_hub['slug'])); ?>"<?php echo $cdplay_platform_hub['style'] ? ' style="' . esc_attr($cdplay_platform_hub['style']) . '"' : ''; ?>>
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
