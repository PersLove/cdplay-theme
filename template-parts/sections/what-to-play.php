<?php
/**
 * What to play mood section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_game_moods = array(
	array(
		'slug'     => 'quiet-evening',
		'category' => __('Для вечера после работы', 'cdplay'),
		'title'    => __('Ghost of Tsushima', 'cdplay'),
		'text'     => __('Медитативные прогулки, красивый мир и редкое чувство спокойствия после тяжелого дня.', 'cdplay'),
		'platform' => __('PlayStation', 'cdplay'),
	),
	array(
		'slug'     => 'together',
		'category' => __('Играть вместе', 'cdplay'),
		'title'    => __('It Takes Two', 'cdplay'),
		'text'     => __('Одна из лучших игр для совместного прохождения и вечеров вдвоём.', 'cdplay'),
		'platform' => __('Xbox / PlayStation', 'cdplay'),
	),
	array(
		'slug'     => 'portable',
		'category' => __('Уютный portable gaming', 'cdplay'),
		'title'    => __('Animal Crossing', 'cdplay'),
		'text'     => __('Остров, на который хочется возвращаться каждый день хотя бы на полчаса.', 'cdplay'),
		'platform' => __('Nintendo Switch', 'cdplay'),
	),
	array(
		'slug'     => 'nostalgia',
		'category' => __('Вернуться в детство', 'cdplay'),
		'title'    => __('Crash Bandicoot', 'cdplay'),
		'text'     => __('Те самые эмоции из детства, только теперь на большом телевизоре.', 'cdplay'),
		'platform' => __('Retro / PlayStation', 'cdplay'),
	),
);
?>

<section class="cdplay-what-to-play" aria-labelledby="cdplay-what-to-play-title">
	<div class="cdplay-what-to-play__inner cdplay-container">
		<header class="cdplay-what-to-play__header">
			<p class="cdplay-what-to-play__eyebrow">
				<?php esc_html_e('Во что поиграть', 'cdplay'); ?>
			</p>

			<h2 id="cdplay-what-to-play-title" class="cdplay-what-to-play__title">
				<?php esc_html_e('Игры, ради которых хочется включить приставку', 'cdplay'); ?>
			</h2>

			<p class="cdplay-what-to-play__text">
				<?php esc_html_e('Спокойный вечер, кооператив с друзьями или та самая игра, в которую снова хочется вернуться.', 'cdplay'); ?>
			</p>
		</header>

		<div class="cdplay-game-mood-grid">
			<?php foreach ($cdplay_game_moods as $cdplay_game_mood) : ?>
				<article class="cdplay-game-mood-card cdplay-game-mood-card--<?php echo esc_attr(sanitize_html_class($cdplay_game_mood['slug'])); ?>">
					<div class="cdplay-game-mood-card__media" aria-hidden="true">
						<div class="cdplay-game-mood-card__background-slot"></div>
						<div class="cdplay-game-mood-card__cover-slot"></div>
					</div>

					<div class="cdplay-game-mood-card__content">
						<p class="cdplay-game-mood-card__category">
							<?php echo esc_html($cdplay_game_mood['category']); ?>
						</p>

						<h3 class="cdplay-game-mood-card__title">
							<?php echo esc_html($cdplay_game_mood['title']); ?>
						</h3>

						<p class="cdplay-game-mood-card__text">
							<?php echo esc_html($cdplay_game_mood['text']); ?>
						</p>

						<p class="cdplay-game-mood-card__platform">
							<?php echo esc_html($cdplay_game_mood['platform']); ?>
						</p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
