<?php
/**
 * Guides and blog section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_guides = array(
	array(
		'slug'     => 'console-choice',
		'category' => __('Выбор консоли', 'cdplay'),
		'title'    => __('PlayStation, Xbox или Nintendo — что выбрать для себя?', 'cdplay'),
		'text'     => __('Разбираем не по характеристикам, а по тому, как ты хочешь играть.', 'cdplay'),
	),
	array(
		'slug'     => 'after-work-games',
		'category' => __('Во что поиграть', 'cdplay'),
		'title'    => __('Игры для вечера после работы', 'cdplay'),
		'text'     => __('Спокойные, красивые и атмосферные игры, которые помогают выдохнуть.', 'cdplay'),
	),
	array(
		'slug'     => 'family-gaming',
		'category' => __('Семейный gaming', 'cdplay'),
		'title'    => __('Во что играть с детьми и друзьями', 'cdplay'),
		'text'     => __('Подборка игр для дивана, смеха и нормального вечера без споров за пульт.', 'cdplay'),
	),
);
?>

<section class="cdplay-guides" aria-labelledby="cdplay-guides-title">
	<div class="cdplay-guides__inner cdplay-container">
		<header class="cdplay-guides__header">
			<p class="cdplay-guides__eyebrow">
				<?php esc_html_e('Блог и гайды', 'cdplay'); ?>
			</p>

			<h2 id="cdplay-guides-title" class="cdplay-guides__title">
				<?php esc_html_e('Разобраться в играх стало проще', 'cdplay'); ?>
			</h2>

			<p class="cdplay-guides__text">
				<?php esc_html_e('Гайды, подборки и спокойные объяснения без технической душноты — чтобы выбрать приставку, игру или подписку было легче.', 'cdplay'); ?>
			</p>
		</header>

		<div class="cdplay-guides__grid">
			<?php foreach ($cdplay_guides as $cdplay_guide) : ?>
				<article class="cdplay-guide-card cdplay-guide-card--<?php echo esc_attr(sanitize_html_class($cdplay_guide['slug'])); ?>">
					<div class="cdplay-guide-card__media" aria-hidden="true">
						<div class="cdplay-guide-card__image-slot"></div>
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
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
