<?php
/**
 * CDPLAY experience section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_experience_cards = array(
	array(
		'slug'  => 'try',
		'title' => __('Можно прийти и попробовать', 'cdplay'),
		'text'  => __('Не обязательно покупать вслепую. Можно посмотреть, подержать геймпад и спокойно выбрать свою платформу.', 'cdplay'),
	),
	array(
		'slug'  => 'help',
		'title' => __('Поможем разобраться', 'cdplay'),
		'text'  => __('Подскажем по подпискам, играм, аккаунтам и настройке без технической душноты.', 'cdplay'),
	),
	array(
		'slug'  => 'rest',
		'title' => __('Игры — это отдых', 'cdplay'),
		'text'  => __('CDPLAY — не про гонку за железом. Это про вечер, когда наконец получилось расслабиться.', 'cdplay'),
	),
);
?>

<section class="cdplay-experience" aria-labelledby="cdplay-experience-title">
	<div class="cdplay-experience__inner cdplay-container">
		<header class="cdplay-experience__header">
			<p class="cdplay-experience__eyebrow">
				<?php esc_html_e('CDPLAY Experience', 'cdplay'); ?>
			</p>

			<h2 id="cdplay-experience-title" class="cdplay-experience__title">
				<?php esc_html_e('Игры должны приносить удовольствие, а не стресс', 'cdplay'); ?>
			</h2>

			<p class="cdplay-experience__text">
				<?php esc_html_e('Мы помогаем выбрать приставку, разобраться без сложных терминов и просто начать играть с удовольствием.', 'cdplay'); ?>
			</p>
		</header>

		<div class="cdplay-experience__grid">
			<?php foreach ($cdplay_experience_cards as $cdplay_experience_card) : ?>
				<article class="cdplay-experience-card cdplay-experience-card--<?php echo esc_attr(sanitize_html_class($cdplay_experience_card['slug'])); ?>">
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
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
