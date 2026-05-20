<?php
/**
 * CDPLAY experience section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_experience_eyebrow = cdplay_get_homepage_option(
	'cdplay-experience_eyebrow',
	__('CDPLAY Experience', 'cdplay')
);

$cdplay_experience_title = cdplay_get_homepage_option(
	'cdplay-experience_title',
	__('Игры должны приносить удовольствие, а не стресс', 'cdplay')
);

$cdplay_experience_description = cdplay_get_homepage_option(
	'cdplay-experience_description',
	__('Мы помогаем выбрать приставку, разобраться без сложных терминов и просто начать играть с удовольствием.', 'cdplay')
);

$cdplay_experience_cards = array(
	array(
		'slug'  => 'try',
		'title' => cdplay_get_homepage_card_field('cdplay-experience', 'try', 'title', __('Можно прийти и попробовать', 'cdplay')),
		'text'  => cdplay_get_homepage_card_field('cdplay-experience', 'try', 'text', __('Не обязательно покупать вслепую. Можно посмотреть, подержать геймпад и спокойно выбрать свою платформу.', 'cdplay')),
		'url'   => cdplay_get_homepage_card_field('cdplay-experience', 'try', 'url', ''),
	),
	array(
		'slug'  => 'help',
		'title' => cdplay_get_homepage_card_field('cdplay-experience', 'help', 'title', __('Поможем разобраться', 'cdplay')),
		'text'  => cdplay_get_homepage_card_field('cdplay-experience', 'help', 'text', __('Подскажем по подпискам, играм, аккаунтам и настройке без технической душноты.', 'cdplay')),
		'url'   => cdplay_get_homepage_card_field('cdplay-experience', 'help', 'url', ''),
	),
	array(
		'slug'  => 'rest',
		'title' => cdplay_get_homepage_card_field('cdplay-experience', 'rest', 'title', __('Игры — это отдых', 'cdplay')),
		'text'  => cdplay_get_homepage_card_field('cdplay-experience', 'rest', 'text', __('CDPLAY — не про гонку за железом. Это про вечер, когда наконец получилось расслабиться.', 'cdplay')),
		'url'   => cdplay_get_homepage_card_field('cdplay-experience', 'rest', 'url', ''),
	),
);

$cdplay_experience_cards = array_filter(
	$cdplay_experience_cards,
	static function ($cdplay_experience_card): bool {
		return cdplay_is_homepage_card_enabled('cdplay-experience', $cdplay_experience_card['slug']);
	}
);

if (empty($cdplay_experience_cards)) {
	return;
}
?>

<section class="cdplay-experience" aria-labelledby="cdplay-experience-title">
	<div class="cdplay-experience__inner cdplay-container">
		<header class="cdplay-experience__header">
			<p class="cdplay-experience__eyebrow">
				<?php echo esc_html($cdplay_experience_eyebrow); ?>
			</p>

			<h2 id="cdplay-experience-title" class="cdplay-experience__title">
				<?php echo esc_html($cdplay_experience_title); ?>
			</h2>

			<p class="cdplay-experience__text">
				<?php echo esc_html($cdplay_experience_description); ?>
			</p>
		</header>

		<div class="cdplay-experience__grid">
			<?php foreach ($cdplay_experience_cards as $cdplay_experience_card) : ?>
				<?php
				$cdplay_experience_card_style = cdplay_get_homepage_card_media_styles(
					'cdplay-experience',
					$cdplay_experience_card['slug'],
					array(
						'image_id' => '--cdplay-experience-card-image',
						'icon_id'  => '--cdplay-experience-card-icon',
					)
				);
				$cdplay_experience_card_tag   = $cdplay_experience_card['url'] ? 'a' : 'article';
				$cdplay_experience_card_attrs = $cdplay_experience_card['url'] ? ' href="' . esc_url($cdplay_experience_card['url']) . '" aria-label="' . esc_attr($cdplay_experience_card['title']) . '"' : '';
				$cdplay_experience_card_style = $cdplay_experience_card['url'] ? cdplay_get_homepage_linked_card_style($cdplay_experience_card_style) : $cdplay_experience_card_style;
				?>
				<<?php echo esc_html($cdplay_experience_card_tag); ?> class="cdplay-experience-card cdplay-experience-card--<?php echo esc_attr(sanitize_html_class($cdplay_experience_card['slug'])); ?>"<?php echo $cdplay_experience_card_attrs; ?><?php echo $cdplay_experience_card_style ? ' style="' . esc_attr($cdplay_experience_card_style) . '"' : ''; ?>>
					<div class="cdplay-experience-card__media" aria-hidden="true">
						<div class="cdplay-experience-card__image-slot"></div>
						<div class="cdplay-experience-card__icon-slot"></div>
					</div>

					<div class="cdplay-experience-card__content">
						<h3 class="cdplay-experience-card__title">
							<?php echo esc_html($cdplay_experience_card['title']); ?>
						</h3>

						<p class="cdplay-experience-card__text">
							<?php echo esc_html($cdplay_experience_card['text']); ?>
						</p>
					</div>
				</<?php echo esc_html($cdplay_experience_card_tag); ?>>
			<?php endforeach; ?>
		</div>
	</div>
</section>
