<?php
/**
 * Guides and blog section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_guides_eyebrow = cdplay_get_homepage_option(
	'guides_eyebrow',
	__('Блог и гайды', 'cdplay')
);

$cdplay_guides_title = cdplay_get_homepage_option(
	'guides_title',
	__('Разобраться в играх стало проще', 'cdplay')
);

$cdplay_guides_description = cdplay_get_homepage_option(
	'guides_description',
	__('Гайды, подборки и спокойные объяснения без технической душноты — чтобы выбрать приставку, игру или подписку было легче.', 'cdplay')
);

$cdplay_guides = array(
	array(
		'slug'     => 'console-choice',
		'category' => cdplay_get_homepage_card_field('guides', 'console-choice', 'category', __('Выбор консоли', 'cdplay')),
		'title'    => cdplay_get_homepage_card_field('guides', 'console-choice', 'title', __('PlayStation, Xbox или Nintendo — что выбрать для себя?', 'cdplay')),
		'text'     => cdplay_get_homepage_card_field('guides', 'console-choice', 'text', __('Разбираем не по характеристикам, а по тому, как ты хочешь играть.', 'cdplay')),
		'url'      => cdplay_get_homepage_card_field('guides', 'console-choice', 'url', ''),
	),
	array(
		'slug'     => 'after-work-games',
		'category' => cdplay_get_homepage_card_field('guides', 'after-work-games', 'category', __('Во что поиграть', 'cdplay')),
		'title'    => cdplay_get_homepage_card_field('guides', 'after-work-games', 'title', __('Игры для вечера после работы', 'cdplay')),
		'text'     => cdplay_get_homepage_card_field('guides', 'after-work-games', 'text', __('Спокойные, красивые и атмосферные игры, которые помогают выдохнуть.', 'cdplay')),
		'url'      => cdplay_get_homepage_card_field('guides', 'after-work-games', 'url', ''),
	),
	array(
		'slug'     => 'family-gaming',
		'category' => cdplay_get_homepage_card_field('guides', 'family-gaming', 'category', __('Семейный gaming', 'cdplay')),
		'title'    => cdplay_get_homepage_card_field('guides', 'family-gaming', 'title', __('Во что играть с детьми и друзьями', 'cdplay')),
		'text'     => cdplay_get_homepage_card_field('guides', 'family-gaming', 'text', __('Подборка игр для дивана, смеха и нормального вечера без споров за пульт.', 'cdplay')),
		'url'      => cdplay_get_homepage_card_field('guides', 'family-gaming', 'url', ''),
	),
);

$cdplay_guides = array_filter(
	$cdplay_guides,
	static function ($cdplay_guide): bool {
		return cdplay_is_homepage_card_enabled('guides', $cdplay_guide['slug']);
	}
);

if (empty($cdplay_guides)) {
	return;
}
?>

<section class="cdplay-guides" aria-labelledby="cdplay-guides-title">
	<div class="cdplay-guides__inner cdplay-container">
		<header class="cdplay-guides__header">
			<p class="cdplay-guides__eyebrow">
				<?php echo esc_html($cdplay_guides_eyebrow); ?>
			</p>

			<h2 id="cdplay-guides-title" class="cdplay-guides__title">
				<?php echo esc_html($cdplay_guides_title); ?>
			</h2>

			<p class="cdplay-guides__text">
				<?php echo esc_html($cdplay_guides_description); ?>
			</p>
		</header>

		<div class="cdplay-guides__grid">
			<?php foreach ($cdplay_guides as $cdplay_guide) : ?>
				<?php
				$cdplay_guide_style = cdplay_get_homepage_card_media_styles(
					'guides',
					$cdplay_guide['slug'],
					array(
						'image_id' => '--cdplay-guide-card-image',
					)
				);
				$cdplay_guide_icon_url = wp_get_attachment_image_url(cdplay_get_homepage_card_media_id('guides', $cdplay_guide['slug'], 'icon_id'), 'full');
				$cdplay_guide_tag   = $cdplay_guide['url'] ? 'a' : 'article';
				$cdplay_guide_attrs = $cdplay_guide['url'] ? ' href="' . esc_url($cdplay_guide['url']) . '" aria-label="' . esc_attr($cdplay_guide['title']) . '"' : '';
				$cdplay_guide_style = $cdplay_guide['url'] ? cdplay_get_homepage_linked_card_style($cdplay_guide_style) : $cdplay_guide_style;
				?>
				<<?php echo esc_html($cdplay_guide_tag); ?> class="cdplay-guide-card cdplay-guide-card--<?php echo esc_attr(sanitize_html_class($cdplay_guide['slug'])); ?>"<?php echo $cdplay_guide_attrs; ?><?php echo $cdplay_guide_style ? ' style="' . esc_attr($cdplay_guide_style) . '"' : ''; ?>>
					<div class="cdplay-guide-card__media" aria-hidden="true">
						<div class="cdplay-guide-card__image-slot"></div>
						<?php if ($cdplay_guide_icon_url) : ?>
							<div class="cdplay-guide-card__icon-slot" style="<?php echo esc_attr('position:absolute;inset-block-start:var(--cdplay-space-lg);inset-inline-end:var(--cdplay-space-lg);width:min(4.75rem,18vw);aspect-ratio:1;border-radius:50%;background:url(' . esc_url_raw($cdplay_guide_icon_url) . ') center / 52% no-repeat;background-color:color-mix(in srgb,var(--cdplay-color-surface-elevated),transparent 24%);'); ?>"></div>
						<?php endif; ?>
					</div>

					<div class="cdplay-guide-card__content">
						<p class="cdplay-guide-card__category">
							<?php echo esc_html($cdplay_guide['category']); ?>
						</p>

						<h3 class="cdplay-guide-card__title">
							<?php echo esc_html($cdplay_guide['title']); ?>
						</h3>

						<p class="cdplay-guide-card__text">
							<?php echo esc_html($cdplay_guide['text']); ?>
						</p>
					</div>
				</<?php echo esc_html($cdplay_guide_tag); ?>>
			<?php endforeach; ?>
		</div>
	</div>
</section>
