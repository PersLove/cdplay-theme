<?php
/**
 * What to play mood section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_what_to_play_eyebrow = cdplay_get_homepage_option(
	'what-to-play_eyebrow',
	__('Во что поиграть', 'cdplay')
);

$cdplay_what_to_play_title = cdplay_get_homepage_option(
	'what-to-play_title',
	__('Игры, ради которых хочется включить приставку', 'cdplay')
);

$cdplay_what_to_play_description = cdplay_get_homepage_option(
	'what-to-play_description',
	__('Спокойный вечер, кооператив с друзьями или та самая игра, в которую снова хочется вернуться.', 'cdplay')
);

$cdplay_game_moods = array(
	array(
		'slug'     => 'quiet-evening',
		'category' => cdplay_get_homepage_card_field('what-to-play', 'quiet-evening', 'category', __('Для вечера после работы', 'cdplay')),
		'title'    => cdplay_get_homepage_card_field('what-to-play', 'quiet-evening', 'title', __('Ghost of Tsushima', 'cdplay')),
		'text'     => cdplay_get_homepage_card_field('what-to-play', 'quiet-evening', 'text', __('Медитативные прогулки, красивый мир и редкое чувство спокойствия после тяжелого дня.', 'cdplay')),
		'platform' => cdplay_get_homepage_card_field('what-to-play', 'quiet-evening', 'platform', __('PlayStation', 'cdplay')),
		'url'      => cdplay_get_homepage_card_field('what-to-play', 'quiet-evening', 'url', ''),
	),
	array(
		'slug'     => 'together',
		'category' => cdplay_get_homepage_card_field('what-to-play', 'together', 'category', __('Играть вместе', 'cdplay')),
		'title'    => cdplay_get_homepage_card_field('what-to-play', 'together', 'title', __('It Takes Two', 'cdplay')),
		'text'     => cdplay_get_homepage_card_field('what-to-play', 'together', 'text', __('Одна из лучших игр для совместного прохождения и вечеров вдвоём.', 'cdplay')),
		'platform' => cdplay_get_homepage_card_field('what-to-play', 'together', 'platform', __('Xbox / PlayStation', 'cdplay')),
		'url'      => cdplay_get_homepage_card_field('what-to-play', 'together', 'url', ''),
	),
	array(
		'slug'     => 'portable',
		'category' => cdplay_get_homepage_card_field('what-to-play', 'portable', 'category', __('Уютный portable gaming', 'cdplay')),
		'title'    => cdplay_get_homepage_card_field('what-to-play', 'portable', 'title', __('Animal Crossing', 'cdplay')),
		'text'     => cdplay_get_homepage_card_field('what-to-play', 'portable', 'text', __('Остров, на который хочется возвращаться каждый день хотя бы на полчаса.', 'cdplay')),
		'platform' => cdplay_get_homepage_card_field('what-to-play', 'portable', 'platform', __('Nintendo Switch', 'cdplay')),
		'url'      => cdplay_get_homepage_card_field('what-to-play', 'portable', 'url', ''),
	),
	array(
		'slug'     => 'nostalgia',
		'category' => cdplay_get_homepage_card_field('what-to-play', 'nostalgia', 'category', __('Вернуться в детство', 'cdplay')),
		'title'    => cdplay_get_homepage_card_field('what-to-play', 'nostalgia', 'title', __('Crash Bandicoot', 'cdplay')),
		'text'     => cdplay_get_homepage_card_field('what-to-play', 'nostalgia', 'text', __('Те самые эмоции из детства, только теперь на большом телевизоре.', 'cdplay')),
		'platform' => cdplay_get_homepage_card_field('what-to-play', 'nostalgia', 'platform', __('Retro / PlayStation', 'cdplay')),
		'url'      => cdplay_get_homepage_card_field('what-to-play', 'nostalgia', 'url', ''),
	),
);

$cdplay_game_moods = array_filter(
	$cdplay_game_moods,
	static function ($cdplay_game_mood): bool {
		return cdplay_is_homepage_card_enabled('what-to-play', $cdplay_game_mood['slug']);
	}
);

if (empty($cdplay_game_moods)) {
	return;
}
?>

<section class="cdplay-what-to-play" aria-labelledby="cdplay-what-to-play-title">
	<div class="cdplay-what-to-play__inner cdplay-container">
		<header class="cdplay-what-to-play__header">
			<p class="cdplay-what-to-play__eyebrow">
				<?php echo esc_html($cdplay_what_to_play_eyebrow); ?>
			</p>

			<h2 id="cdplay-what-to-play-title" class="cdplay-what-to-play__title">
				<?php echo esc_html($cdplay_what_to_play_title); ?>
			</h2>

			<p class="cdplay-what-to-play__text">
				<?php echo esc_html($cdplay_what_to_play_description); ?>
			</p>
		</header>

		<div class="cdplay-game-mood-grid">
			<?php foreach ($cdplay_game_moods as $cdplay_game_mood) : ?>
				<?php
				$cdplay_game_mood_style = cdplay_get_homepage_card_media_styles(
					'what-to-play',
					$cdplay_game_mood['slug'],
					array(
						'background_image_id' => '--cdplay-game-mood-card-background',
						'cover_image_id'      => '--cdplay-game-mood-card-cover',
					)
				);
				$cdplay_game_mood_tag   = $cdplay_game_mood['url'] ? 'a' : 'article';
				$cdplay_game_mood_attrs = $cdplay_game_mood['url'] ? ' href="' . esc_url($cdplay_game_mood['url']) . '" aria-label="' . esc_attr($cdplay_game_mood['title']) . '"' : '';
				$cdplay_game_mood_style = $cdplay_game_mood['url'] ? cdplay_get_homepage_linked_card_style($cdplay_game_mood_style) : $cdplay_game_mood_style;
				?>
				<<?php echo esc_html($cdplay_game_mood_tag); ?> class="cdplay-game-mood-card cdplay-game-mood-card--<?php echo esc_attr(sanitize_html_class($cdplay_game_mood['slug'])); ?>"<?php echo $cdplay_game_mood_attrs; ?><?php echo $cdplay_game_mood_style ? ' style="' . esc_attr($cdplay_game_mood_style) . '"' : ''; ?>>
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
				</<?php echo esc_html($cdplay_game_mood_tag); ?>>
			<?php endforeach; ?>
		</div>
	</div>
</section>
