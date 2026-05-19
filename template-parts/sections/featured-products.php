<?php
/**
 * Featured products foundation section.
 *
 * @package CDPLAY
 */

if (!defined('ABSPATH')) {
	exit;
}

$cdplay_featured_products = array(
	array(
		'slug'        => 'ps5-slim',
		'title'       => __('PlayStation 5 Slim', 'cdplay'),
		'tags'        => array(
			__('Новое', 'cdplay'),
			__('Готово к игре', 'cdplay'),
		),
		'description' => __('Тихая, быстрая и созданная для вечеров, которые хочется продолжать.', 'cdplay'),
		'price'       => __('от 54 990 ₽', 'cdplay'),
		'url'         => home_url('/product/playstation-5-slim/'),
	),
	array(
		'slug'        => 'xbox-series-x',
		'title'       => __('Xbox Series X', 'cdplay'),
		'tags'        => array(
			__('Game Pass', 'cdplay'),
			__('4K Gaming', 'cdplay'),
		),
		'description' => __('Мощная консоль для кооператива, подписки и больших игровых миров.', 'cdplay'),
		'price'       => __('от 49 990 ₽', 'cdplay'),
		'url'         => home_url('/product/xbox-series-x/'),
	),
	array(
		'slug'        => 'nintendo-switch-oled',
		'title'       => __('Nintendo Switch OLED', 'cdplay'),
		'tags'        => array(
			__('Portable', 'cdplay'),
			__('Family Gaming', 'cdplay'),
		),
		'description' => __('Играй дома, в дороге или вместе с друзьями на одном диване.', 'cdplay'),
		'price'       => __('от 29 990 ₽', 'cdplay'),
		'url'         => home_url('/product/nintendo-switch-oled/'),
	),
	array(
		'slug'        => 'ps4-pro',
		'title'       => __('PlayStation 4 Pro', 'cdplay'),
		'tags'        => array(
			__('Trade-In', 'cdplay'),
			__('Проверено CDPLAY', 'cdplay'),
		),
		'description' => __('Отличный способ вернуться в игры без больших вложений.', 'cdplay'),
		'price'       => __('от 34 990 ₽', 'cdplay'),
		'url'         => home_url('/product/playstation-4-pro/'),
	),
);
?>

<section class="cdplay-featured-products" aria-labelledby="cdplay-featured-products-title">
	<div class="cdplay-featured-products__inner cdplay-container">
		<header class="cdplay-featured-products__header">
			<p class="cdplay-featured-products__eyebrow">
				<?php esc_html_e('Подобрать консоль', 'cdplay'); ?>
			</p>

			<h2 id="cdplay-featured-products-title" class="cdplay-featured-products__title">
				<?php esc_html_e('Игровые платформы для разного настроения', 'cdplay'); ?>
			</h2>

			<p class="cdplay-featured-products__text">
				<?php esc_html_e('От спокойных вечерних игр до кооператива с друзьями — выбирай платформу под свой стиль игры.', 'cdplay'); ?>
			</p>
		</header>

		<div class="cdplay-featured-products__grid">
			<?php foreach ($cdplay_featured_products as $cdplay_featured_product) : ?>
				<?php get_template_part('template-parts/cards/product-card', null, $cdplay_featured_product); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
